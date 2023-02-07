<?php
class DemandeProforma extends CI_Controller  {
    public function __construct() {
        parent::__construct();
        // some useful stuffs
        $this->load->helper("url_helper");
        $this->load->helper("tool_helper");
        $this->load->helper("formater_helper");
        $this->load->helper("view_helper");

        $this->load->database();

        $this->load->model("fournisseur_model");
        $this->load->model("demandeproforma_model");
    }

    public function index() {
      session_start();
      // var_dump($this->session->userdata());
      // $produits = (!$this->session->userdata('produits')) ? array() : $this->session->userdata('produits');
      $produits = isset($_SESSION['produits']) ? $_SESSION['produits'] : array();
      $fournisseurs = $this->fournisseur_model->get_fournisseurs();
      $options = [
          'menu'    => [],
          'current' => [
              'produits' => $produits,
              'fournisseurs' => $fournisseurs
          ]
      ];
      load_view_set($this, "SaisieDemandeProforma_view.php", $options);
    }

    public function ajout_ligne_demandeproforma() {
      session_start();
      $produit = array();
      $produit['designation'] = $this->input->get('designation');
      $produit['quantite'] = $this->input->get('quantite');

      // $produits = (!$this->session->userdata('produits')) ? array() : $this->session->userdata('produits');
      $produits = isset($_SESSION['produits']) ? $_SESSION['produits'] : array();
      array_push($produits, $produit);

      // $this->session->set_userdata('produits', $produits);
      $_SESSION['produits'] = $produits;
      redirect("/DemandeProforma");
    }

    public function validation_demandeproforma() {
      session_start();
      $produits = isset($_SESSION['produits']) ? $_SESSION['produits'] : array();
      // $produits = $this->session->userdata('produits');
      if(count($produits) == 0){
        redirect("/DemandeProforma");
      }

      $demandeproforma['idfournisseur'] = $this->input->get("idFournisseur");
      $iddemandeproforma = $this->demandeproforma_model->insert_demandeproforma($demandeproforma);

      foreach($produits as $produit){
        $this->demandeproforma_model->insert_detaildemandeproforma($iddemandeproforma, $produit);
      }

      unset($_SESSION['produits']);
      // $this->session->unset_userdata('produits');

      redirect("/DemandeProforma");
    }

    public function annulation_demandeproforma(){
      $this->session->unset_userdata('produits');
      redirect("/DemandeProforma");
    }


    public function liste () {
      $fournisseurs = $this->db->get('Fournisseur')->result();
      $map = [];
      
      foreach ($fournisseurs as $fournisseur)
        $map[$fournisseur->idfournisseur] = $fournisseur->nom_fournisseur;
      
      $options = [
          'menu'    => [],
          'current' => [
            'fournisseur_map' => $map
          ]
      ];

      $ref_demande = $this->input->get('ref_demande');
      
      if (empty($ref_demande)) {
        $dem_proformas = $this->db->get('DemandeProforma')->result();
        $options['current']['dem_proformas'] = $dem_proformas;
        load_view_set($this, "liste_demande_proforma_view.php", $options);  
      } else {
        $details = $this->db
                              ->get_where('DetailDemandeProforma', ['iddemandeproforma' => $ref_demande])
                              ->result();
        $dem_proforma = $this->db->get_where('DemandeProforma', ['iddemandeproforma' => $ref_demande])->result();
        $options['current']['details'] = $details;
        $options['current']['dem_proforma'] = $dem_proforma[0];

        load_view_set($this, "details_demande_proforma_view.php", $options);         
      }
    
    }

}
?>
