<?php
class Accueil extends CI_Controller  {
    public function __construct() {
        parent::__construct();
        // some useful stuffs
        $this->load->helper("url_helper");
        $this->load->helper("tool_helper");
        $this->load->helper("formater_helper");
        $this->load->helper("view_helper");

        $this->load->model("immobilisation_model");
        $this->load->database();
    }

    public function index() {
        $keyword = $this->input->get('search');
        $name_like = empty($keyword) ? '%%' : "%$keyword%"; 
        $options = [
            'menu'    => [],
            'current' => [
                'liste_immo' => $this->immobilisation_model->getListImmo($name_like),
            ]
        ];
        load_view_set($this, "Accueil_view", $options);
    }

    public function nouvel_immo () {
        $error = $this->input->get('error');
        $options = [
            'menu'    => [],
            'current' => [
                'error' => empty($error) ? '' : $error
            ]
        ];
        load_view_set($this, "AjoutImmo_view", $options);
    }

    public function add () {
        try {
            $input = $this->input->post();
            $duree = $input['duree_amortissement'];
            $coef_deg =  $input['coef_deg'];
            
            if ($duree < 0)
                throw new Exception ("Duree negative !");

            if ($coef_deg < 0 || $coef_deg > 3)
                throw new Exception("Coefficient degressif doit etre entre 0 (exclu) et 3");

            $this->db->insert('Immobilisation', $input);
            redirect(absolute_url('accueil'));
        } catch (Exception $ex) {
            redirect(absolute_url('accueil/nouvel_immo?error=' . $ex->getMessage()));
        }
    }
}
?>