<?php
class Formulaire_proforma extends CI_Controller  {
    private $_urlrefDemandePF = 'http://localhost:99/acheteur/api/demande_proforma';

    public function __construct() {
        parent::__construct();
        // some useful stuffs
        $this->load->helper("url_helper");
        $this->load->helper("tool_helper");
        $this->load->helper("formater_helper");
        $this->load->helper("view_helper");

        $this->load->database();
        $this->load->model('proforma_model');
        $this->load->model('produit_model');
    }

    public function index() {
        $temp = $this->proforma_model->getDemandeProformat($this->_urlrefDemandePF);
        $demandesProforma = $temp['datas'];
        $tva =20;
        $produits =  $this->produit_model->getAllProduitRestant ();
        $options = [
            'menu'    => [],
            'current' => [
                'refsDemandeProforma' => $demandesProforma ,
                'tva' => $tva,
                'produits' =>  $produits
            ]
        ];

        load_view_set($this, "Formulaire_proforma_view", $options);
    }
    public function Enregistrer(){
		$data = json_decode($_POST['data'], true);
		$message = "Ok.";
		try {
			// var_dump($data);
			$this->proforma_model->insert($data);

		} catch(Exception $ex){
			$message = $ex->getMessage();
		} finally {
			redirect(absolute_url("Formulaire_proforma?message=$message"));
		}
    }
}

?>
