<?php
class Accueil extends CI_Controller  {
    public function __construct() {
        parent::__construct();
        // some useful stuffs
        $this->load->helper("url_helper");
        $this->load->helper("tool_helper");
        $this->load->helper("formater_helper");
        $this->load->helper("view_helper");

        $this->load->model("produit_model");
        $this->load->database();
    }

    public function index() {
        $idproduit = $this->input->get('idproduit');
        $libelle = $this->input->get('libelle');
        $message = $this->input->get('message');
        if (!empty($idproduit) && !empty($libelle)) {
            $computed = $this->produit_model->getDetailsCMUPFor($idproduit);
            $options = [
                'menu'    => [],
                'current' => [
                    'idproduit' => $idproduit,
                    'libelle' => $libelle,
                    'computed' => $computed,
                    'now' => getTimeNow($this->db),
                    'message' => !empty($message) ? $message : ''
                ]
            ];

            load_view_set($this, "stock_calcul_view", $options);
        } else {
            $options = [
                'menu'    => [],
                'current' => [
                    'produits_restant' => $this->produit_model->getAllProduitRestant()
                ]
            ];

            load_view_set($this, "accueil_view", $options);
        }
    }

    public function inserer_stock () {
        $temp = $this->input->get();
        $idproduit = $temp['idproduit'];
        $libelle = $temp['libelle'];
        $stock = $this->input->post();
        $message = 'Ok';
        try {
            $all_stocks = $this->db->get_where('Stock', ['idproduit' => $idproduit])->result();
            if ( $stock['type'] < 0 ) {
                $this->produit_model->peutSortir($all_stocks, $stock['quantite']);
            }
            if ( $stock['quantite'] <= 0)
                throw new Exception('Quantite negative ou nulle');
            if ( $stock['prix'] < 0) // peut etre nulle (si CMUP et -1 par exemple)
                throw new Exception('Prix negative ou nulle');
            $this->db->insert('Stock', $stock);
        } catch(Exception $ex) {
            $message = $ex->getMessage();
        } finally {
            redirect(absolute_url("accueil?idproduit=$idproduit&libelle=$libelle&message=$message"));
        }
    }
}
?>