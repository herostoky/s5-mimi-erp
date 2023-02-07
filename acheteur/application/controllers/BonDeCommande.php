<?php

require APPPATH . '/libraries/REST_controller.php';
use Restserver\Libraries\REST_controller;
	 
class BonDeCommande extends REST_Controller {
	   
	public function __construct() {
	   parent::__construct();
	   $this->load->database();
	   $this->load->helper('function_helper');
	}

	public function index_get () {
		$data = array();
		$data = $this->db->get("BonDeCommande")->result();
		$this->response(res_success($data), REST_Controller::HTTP_OK);
	}
}

?>