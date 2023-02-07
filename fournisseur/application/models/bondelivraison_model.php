<?php defined('BASEPATH') OR exit('No direct script access allowed');

  class Bondelivraison_model extends CI_Model {

    public function insert_bondelivraison($bonDeLivraison){
      $this->db->insert('BonDeLivraison', $bonDeLivraison);
      //return $this->db->insert_id();
    }

    public function liste_bondelivraison(){
      return $this->db->get('BonDeLivraison')->result();
    }

    public function details_bondelivraison($idBonDeLivraison){
      return $this->db->get_where('DetailBonDeLivraison', ['idbondelivraison' => $idBonDeLivraison])->result();
    }

    public function insert_detailbondelivraison($detailBonDeLivraison){
      $this->db->insert('DetailBonDeLivraison', $detailBonDeLivraison);
    }

    public function delete_detailbondelivraison($idDetailBonDeLivraison){
      $this->db->delete('DetailBonDeLivraison', ['iddetailbondelivraison' => $idDetailBonDeLivraison]);
    }

  }

?>
