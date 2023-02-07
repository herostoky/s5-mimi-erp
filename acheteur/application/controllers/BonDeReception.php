<?php
class BonDeReception extends CI_Controller  {
    public function __construct() {
        parent::__construct();
        // some useful stuffs
        $this->load->helper("url_helper");
        $this->load->helper("tool_helper");
        $this->load->helper("formater_helper");
        $this->load->helper("view_helper");

        $this->load->database();

        $this->load->model("bondereception_model");
    }

    public function formulaire() {
      $ref_bon_livraison = '';
      if(isset($_GET['ref_bon_livraison'])){
        $ref_bon_livraison = $_GET['ref_bon_livraison'];
      }

      $options = [
          'menu'    => [],
          'current' => [
            'ref_bon_livraison' => $ref_bon_livraison
          ]
      ];

      load_view_set($this, "saisie_bon_de_reception_view.php", $options);
    }

    public function create() {
      $bonDeReception = [
        'ref_bon_livraison' => $_GET['ref_bon_livraison']
      ];

      $this->bondereception_model->insert_bondereception($bonDeReception);

      redirect('BonDeReception/');
    }

    public function index() {
      $bonDeReceptions = $this->bondereception_model->liste_bondereception();

      $options = [
          'menu'    => [],
          'current' => [
            'bonDeReceptions' => $bonDeReceptions
          ]
      ];

      load_view_set($this, "liste_bon_de_reception_view.php", $options);
    }

    public function detailsBonDeReception($idBonDeReception){
      $detailsBonDeReception = $this->bondereception_model->details_bondereception($idBonDeReception);

      $options = [
          'menu'    => [],
          'current' => [
            'idBonDeReception' => $idBonDeReception,
            'detailsBonDeReception' => $detailsBonDeReception
          ]
      ];

      load_view_set($this, "details_bon_de_reception_view.php", $options);
    }

    public function ajout_ligne_bondereception(){
      $detailBonDeReception = [
        'iddebonreception' => $_GET['idBonDeReception'],
        'designation' => $_GET['designation'],
        'quantite' => $_GET['quantite'],
      ];

      $this->bondereception_model->insert_detailbondereception($detailBonDeReception);

      redirect('BonDeReception/detailsBonDeReception/'.$detailBonDeReception['iddebonreception']);
    }

    public function delete_detail($idDetailBonDeReception, $idBonDeReception){
      $this->bondereception_model->delete_detailbondereception($idDetailBonDeReception);

      redirect('BonDeReception/detailsBonDeReception/'.$idBonDeReception);
    }

}
?>
