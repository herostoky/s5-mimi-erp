<?php
require APPPATH . '/libraries/REST_controller.php';
use Restserver\Libraries\REST_controller;

class Proforma extends REST_Controller {
	public function __construct() {
	   parent::__construct();
	   $this->load->database();
	   $this->load->helper('function_helper');
       $this->load->model("proforma_model");
	}

	public function index_get ($id = null) {
        if ( $id != null ) {
			$data = $this->proforma_model->findIdByReference($id);
			// var_dump($data);
			$this->response(res_success($data), REST_Controller::HTTP_OK);
		} else {
			$data = $this->proforma_model->getAllProforma();
			// var_dump($data);
			$this->response(res_success($data), REST_Controller::HTTP_OK);
        }
	}
}

?>
