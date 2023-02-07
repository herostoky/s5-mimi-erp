<?php
require APPPATH . '/libraries/REST_controller.php';
use Restserver\Libraries\REST_controller;

class Demande_proforma extends REST_Controller {

	public function __construct() {
	   parent::__construct();
	   $this->load->database();
	   $this->load->helper('function_helper');

     $this->load->model("demandeproforma_model");
	}

	public function index_get () {
    $data = array();
    $demandesProforma = $this->demandeproforma_model->get_demandesproforma();
    for($i=0; $i<count($demandesProforma); $i++){
      $demandeproforma = array();
      $demandeproforma['iddemandeproforma'] = $demandesProforma[$i]['iddemandeproforma'];

      $detailsDemandeProforma = $this->demandeproforma_model->get_detaildemandeproforma($demandeproforma['iddemandeproforma']);
      $demandeproforma['detail'] = array();
      for($j=0; $j<count($detailsDemandeProforma); $j++){
        $demandeproforma['detail'] [] = ['produit' => $detailsDemandeProforma[$j]['designation'], 'qte' => $detailsDemandeProforma[$j]['quantite']];
      }

      $data [] = $demandeproforma;
    }

    $this->response(res_success($data), REST_Controller::HTTP_OK);
	}
}

?>
