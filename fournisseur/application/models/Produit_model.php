<?php 
class Produit_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}
	
	public function computeNombreRestant ($rows) {
		$left = 0;
		foreach ($rows as $row)
			$left += ($row->type * $row->quantite);
		return $left;
	}

	public function getProduitsMap() {
		$produits = $this->db->get('Produit')->result();
		$map = [];
		foreach ($produits as $produit) {
			$map[$produit->idproduit] = $produit;
		}
		return $map;
	}

	public function peutSortir ($stock_rows, $quantite) {
		$left = $this->computeNombreRestant($stock_rows);
		$left -= $quantite;		
		if ($left < 0)
			throw new Exception("Ne peut plus faire sortir ".$quantite. " :: " . ($left + $quantite) . " restant");
	}


	public function getAllProduitRestant ($methode = 'CMUP') {
		$produits = $this->db->get("Produit")->result();
		$map = array();

		foreach ($produits as $produit) {
			$idproduit = $produit->idproduit;
			if (empty($map[$idproduit])) {
				$map[$idproduit] = [
					'count' => 0,
					'name' => $produit->designation,
					'stock_value' => $this->getStockValueFor($idproduit, $methode)
				];
			}
		}

		$stocks = $this->db->get("Stock")->result();
		foreach($stocks as $stock) {
			$map[$stock->idproduit]['count'] += $stock->type * $stock->quantite;
		}

		return $map;
	}


	/**
	 * @return a set of row [produit, type, qte, price, ]
	 */
	public function getDetailsCMUPFor ($idproduit) {
		$stocks = $this->db->get_where("Stock", ["idproduit" => $idproduit])->result();

		$result = [
			'CMUP' => 0,
			'methode' => 'CMUP',
			'total_quantite' => 0,
			'details' => array()
		];


		$current_cmup = 0;
		$numerateur = 0;
		$denominateur = 0;
		foreach($stocks as $stock) {
			$type = $stock->type;
			$prix = $stock->prix;
			$quantite = $stock->quantite;
			if ($type < 0) {
				$last = count($result['details']) - 1;
				if ($last < 0)
					throw new Exception("La premiere ligne est une sortie, veuillez changer le mettre a jour");
				$prix = $result['details'][$last]['stock_value'];
			}
			$numerateur  += $type * $quantite * $prix;
			$denominateur += $type * $quantite;

			$current_cmup = round($numerateur / $denominateur, 2);

			$result['total_quantite'] += $type * $quantite;
			$result['details'][] = [
				'idproduit' => $stock->idproduit,
				'date' => $stock->date,
				'quantite' => $stock->quantite,
				'prix' => $type > 0 ? $stock->prix : $current_cmup, // unit price
				'type' => $type,
				'stock_value' => $current_cmup,
				'total' => $quantite * $current_cmup
			];
		}

		$result['CMUP'] = $current_cmup;

		return $result;
	}

	public function getStockValueFor ($idproduit, $methode = 'CMUP') {
		return $this->getDetailsCMUPFor($idproduit) [$methode];
	}

	/**
	 * @return CMUP value of the specified product
	 */
	public function computeCMUPValueFor ($idproduit) {
		return $this->getStockValueFor ($idproduit, 'CMUP');
	}

}
?>