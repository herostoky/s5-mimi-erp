<?php
class Proforma extends CI_Controller  {
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

    public function liste () {
        $options = [
          'menu'    => [],
          'current' => []
        ];

        $ref_proforma = $this->input->get('ref_proforma');

        if (empty($ref_proforma)) {
            $proformas = $this->db->get('Proforma')->result();
            $options['current']['proformas'] = $proformas;
            load_view_set($this, "liste_proforma_view.php", $options);  
        } else {
            $details = $this->db
                          ->get_where('DetailProforma', ['idproforma' => $ref_proforma])
                          ->result();
            $proforma = $this->db->get_where('Proforma', ['idproforma' => $ref_proforma])->result();

            $options['current']['produits_map'] = $this->produit_model->getProduitsMap();
            $options['current']['details'] = $details;
            $options['current']['proforma'] = $proforma[0];

            load_view_set($this, "details_proforma_view.php", $options);         
        }
    }
}
?>