<?php
class Proforma_model extends CI_Model {
	public function __construct() {
        parent::__construct();
        $this->load->model("detailproforma_model");
        $this->load->model("produit_model");

    }
	
	public function checkValues ($proforma) {
		if ($proforma['remise'] < 0 || $proforma['remise'] > 100) {
			throw new Exception ("Erreur. Remise globale negative ou depassant 100%");
		}
	}
	
    public function insert ($datas) {
		$proforma = [
			'acheteur' => $datas["acheteur"],
			'ref_demande_proforma' => $datas["refdemandeproforma"],
			'remise' => $datas["remiseg"],
			'iddevise' => 'DEVISE_1' // ???
		];

		$this->checkValues($proforma);
		$data_details = $datas["details"];	
		// var_dump($data_details);

        try{
			$this->db->trans_begin();            
			$this->db->insert('Proforma', $proforma);

            $produitRestant =$this->produit_model->getAllProduitRestant() ;
            $idproforma = $this->getIdByReference($proforma['ref_demande_proforma'], $proforma['acheteur']);

            foreach ($data_details as $data_detail) {
				$idproduit = $data_detail['produit'];
				$produit_temp = $produitRestant[$idproduit];

				$detail = [
					'idproforma' => $idproforma,
					'idproduit' => $idproduit,
					'quantite' => min($data_detail["quantite"], $produit_temp["count"]),
					'prix' => $produit_temp["stock_value"],
					'remise' => $data_detail["remise"],
				];
				
				$this->detailproforma_model->checkValues($detail);
				$this->db->insert('DetailProforma', $detail);
            }
			
            $this->db->trans_commit();
        } catch (Exception $e){
            $this->db->trans_rollback();
			throw $e;
        }
    }
	
    public function getIdByReference($ref,$acheteur){
        $sql = "SELECT idproforma FROM \"Proforma\" where ref_demande_proforma='%s' and acheteur= '%s' ";
        $sql = sprintf($sql,$ref,$acheteur);
		$query = $this->db->query($sql);
		foreach ($query->result_array() as $row) {
			$ret = $row["idproforma"];
			return $ret ;
		}
		return null;
    }
	
    public static function getDemandeProformat($url){
        if( $url == null){
            return null;
        }
        // var_dump($url);
        $data = file_get_contents(trim($url));
        if(empty($data) ){
            return null;
        }
        return $proFormat = json_decode($data, true);
    }
	
    public function getAllProforma() {        
		$result_rows = $this->db->get("Proforma")->result();
		$detailed = [];
		foreach ($result_rows as $proforma) {
			$detailed[] = array (
				'idproforma' => $proforma->idproforma,
				'acheteur' => $proforma->acheteur,
				'ref_demande_proforma' => $proforma->ref_demande_proforma,
				'remise' => $proforma->remise,
				'iddevise' => $proforma->iddevise,
				'details' => $this->getAllDetailsByIdProforma($proforma->idproforma)
			);
		}
		return $detailed;
    }
	
	public function getAllDetailsByIdProforma ($id) {
		return $this->db->get_where("DetailProforma", ["idproforma" => $id])->result();
	}
	
    public function findIdByReference ($idref){
		$result_rows = $this->db->get_where("Proforma", ["ref_demande_proforma" => $idref])->result();
		foreach ($result_rows as $proforma) {
			$detailed[] = array (
				'idproforma' => $proforma->idproforma,
				'acheteur' => $proforma->acheteur,
				'ref_demande_proforma' => $proforma->ref_demande_proforma,
				'remise' => $proforma->remise,
				'iddevise' => $proforma->iddevise,
				'details' => $this->getAllDetailsByIdProforma($proforma->idproforma)
			);
		}
		return null;
    }
}
?>