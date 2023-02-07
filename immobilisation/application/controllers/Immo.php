<?php
class immo extends CI_Controller  {
    public function __construct() {
        parent::__construct();
        // some useful stuffs
        $this->load->helper("url_helper");
        $this->load->helper("tool_helper");
        $this->load->helper("formater_helper");
        $this->load->helper("view_helper");

		$this->load->model('immobilisation_model');
        $this->load->database();
    }

    public function index () {
        $meth = $this->input->get('methode');
        $idimmo = $this->input->get('idimmo');
        $query_date = $this->input->post('query_date');
        $result = null;
        if ($meth == 'lineaire') {
            $result = $this->immobilisation_model->computeImmoLinearFor($idimmo, $query_date);
        } else {
            $result = $this->immobilisation_model->computeImmoDegressifFor($idimmo, $query_date);
        }

        $options = [
            'menu'    => [],
            'current' => [
                'result' => $result
            ]
        ];

       load_view_set($this, "Immo_view", $options);
    }
    
}
?>
