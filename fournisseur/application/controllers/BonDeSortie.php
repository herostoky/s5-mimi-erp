<?php
class BonDeSortie extends CI_Controller  {
    public function __construct() {
        parent::__construct();
        // some useful stuffs
        $this->load->helper("url_helper");
        $this->load->helper("tool_helper");
        $this->load->helper("formater_helper");
        $this->load->helper("view_helper");

        $this->load->database();
        $this->load->model("bondesortie_model");
        $this->load->model("produit_model");
    }

    public function liste() {
      $bondesortie = $this->bondesortie_model->liste_bondesorties();
      $options = [
          'menu'    => [],
          'current' => [
              "bondesortie" =>$bondesortie
          ]
    ];

        load_view_set($this, "liste_bon_de_sortie_view", $options);
    }
    public function details(){
        $input = $this->input->get();
        $bondesortie = $this->bondesortie_model->bondesortie($input["ref"]);
        $details =$this->bondesortie_model->details_bondesortie($bondesortie->idbondesortie);
        $devise =  $this->db->get_where('Devise', ['iddevise' => $bondesortie->iddevise ] )->result()[0];
        $message ="";
        $tva = 20;
        $produits =  $this->produit_model->getAllProduitRestant ();
        $options = [
            'menu'    => [],
            'current' => [
                "bondesortie" =>$bondesortie,
                "details"=>$details,
                "devise"=>$devise,
                "produits"=>$produits,
                "message" =>$message,
                "tva" =>$tva
            ]
      ];

      load_view_set($this, "details_bon_de_sorite_view", $options);
    }
    public function nouveau_detail(){
        $input = $this->input->post();
        $bondesortie=$this->bondesortie_model->bondesortie($input["bon_de_sortie"]);

        $produit=$this->produit_model->getAllProduitRestant ()[$input["produit"]];
        var_dump($produit);
        $temp = [
            'idbondesortie'=>$bondesortie->idbondesortie,
            'idproduit'=>$input["produit"],
            'designation'=>$produit["name"],
            'quantite'=>$input["quantite"],
            'prix'=>$produit["stock_value"]
        ];
        $this->bondesortie_model->insert_details_bondesortie($temp);
        redirect(absolute_url("BonDeSortie/details?ref=".$bondesortie->idbondesortie));
    }
    public function enlever_detail(){
        $input = $this->input->get();
        $this->bondesortie_model->deletedetails_bondesortie($input["ref"]);
        redirect(absolute_url("BonDeSortie/details?ref=".$input["bon"]));
    }

}
?>
