<?php
require APPPATH . '/libraries/REST_controller.php';
use Restserver\Libraries\REST_controller;

class BonDeLivraison extends REST_Controller {

	public function __construct() {
	   parent::__construct();
	   $this->load->database();
	   $this->load->helper('function_helper');

     $this->load->model("bondelivraison_model");
	}

	public function index_get () {
    $data = array();

    $bdl = $this->bondelivraison_model->liste_bondelivraison();
    for($i=0; $i<count($bdl); $i++){
      $unBdl = array();
      $unBdl['idbondelivraison'] = $bdl[$i]->idbondelivraison;
      $unBdl['acheteur'] = $bdl[$i]->acheteur;
      $unBdl['details'] = [];

      $detailsBdl = $this->bondelivraison_model->details_bondelivraison($bdl[$i]->idbondelivraison);
      for($j=0; $j<count($detailsBdl); $j++){
        $unBdl['details'] [] = [
            'iddetailbondelivraison' => $detailsBdl[$j]->iddetailbondelivraison,
            'designation' => $detailsBdl[$j]->designation,
            'quantite' => $detailsBdl[$j]->quantite
        ];
      }

      $data [] = $unBdl;
    }

    $this->response(res_success($data), REST_Controller::HTTP_OK);
	}
}

?>
