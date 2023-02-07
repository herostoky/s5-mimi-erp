<?php
class BonDeLivraison extends CI_Controller  {
    public function __construct() {
        parent::__construct();
        // some useful stuffs
        $this->load->helper("url_helper");
        $this->load->helper("tool_helper");
        $this->load->helper("formater_helper");
        $this->load->helper("view_helper");

        $this->load->database();

        $this->load->model("bondelivraison_model");
    }

    public function formulaire() {
      $acheteur = '';
      $idBonDeSortie = '';
      if(isset($_GET['acheteur']) && isset($_GET['idBonDeSortie'])){
        $acheteur = $_GET['acheteur'];
        $idBonDeSortie = $_GET['idBonDeSortie'];
      }

      $options = [
          'menu'    => [],
          'current' => [
            'acheteur' => $acheteur,
            'idBonDeSortie' => $idBonDeSortie
          ]
      ];

      load_view_set($this, "saisie_bon_de_livraison_view.php", $options);
    }

    public function create() {
      $bonDeLivraison = [
        'acheteur' => $_GET['acheteur'],
        'idbondesortie' => $_GET['idBonDeSortie']
      ];

      $this->bondelivraison_model->insert_bondelivraison($bonDeLivraison);

      redirect('BonDeLivraison/');
    }

    public function index() {
      $bonDeLivraisons = $this->bondelivraison_model->liste_bondelivraison();

      $options = [
          'menu'    => [],
          'current' => [
            'bonDeLivraisons' => $bonDeLivraisons
          ]
      ];

      load_view_set($this, "liste_bon_de_livraison_view.php", $options);
    }

    public function detailsBonDeLivraison($idBonDeLivraison){
      $detailsBonDeLivraison = $this->bondelivraison_model->details_bondelivraison($idBonDeLivraison);
      $produits = $this->db->get('Produit')->result();

      $options = [
          'menu'    => [],
          'current' => [
            'idBonDeLivraison' => $idBonDeLivraison,
            'detailsBonDeLivraison' => $detailsBonDeLivraison,
            'produits' => $produits
          ]
      ];

      load_view_set($this, "details_bon_de_livraison_view.php", $options);
    }

    public function ajout_ligne_bondelivraison(){
      $detailBonDeLivraison = [
        'idbondelivraison' => $_GET['idBonDeLivraison'],
        'idproduit' => $_GET['idProduit'],
        'designation' => $_GET['designation'],
        'quantite' => $_GET['quantite'],
      ];

      $this->bondelivraison_model->insert_detailbondelivraison($detailBonDeLivraison);

      redirect('BonDeLivraison/detailsBonDeLivraison/'.$detailBonDeLivraison['idbondelivraison']);
    }

    public function delete_detail($idDetailBonDeLivraison, $idBonDeLivraison){
      $this->bondelivraison_model->delete_detailbondelivraison($idDetailBonDeLivraison);

      redirect('BonDeLivraison/detailsBonDeLivraison/'.$idBonDeLivraison);
    }

}
?>
