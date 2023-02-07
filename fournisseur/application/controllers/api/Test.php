<?php
require APPPATH . '/libraries/REST_controller.php';
use Restserver\Libraries\REST_controller;
	 
class Test extends REST_Controller {
	   
	public function __construct() {
	   parent::__construct();
	   $this->load->database();
	   $this->load->helper('function_helper');
	}

	public function index_get () {
		$data = [
			['num' => 1, 'nom' => 'Rakoto'],
			['num' => 2, 'nom' => 'Rabe'],
			['num' => 3, 'nom' => 'Razafy'],
		];

		$this->response(res_success($data), REST_Controller::HTTP_OK);
	}
}

?>