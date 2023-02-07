<?php defined('BASEPATH') OR exit('No direct script access allowed');

  class Bondereception_model extends CI_Model {

    public function insert_bondereception($bonDeReception){
      $this->db->insert('BonDeReception', $bonDeReception);
    }

    public function liste_bondereception(){
      return $this->db->get('BonDeReception')->result();
    }

    public function details_bondereception($idBonDeReception){
      return $this->db->get_where('DetailBonDeReception', ['iddebonreception' => $idBonDeReception])->result();
    }

    public function insert_detailbondereception($detailBonDeReception){
      $this->db->insert('DetailBonDeReception', $detailBonDeReception);
    }

    public function delete_detailbondereception($idDetailBonDeReception){
      $this->db->delete('DetailBonDeReception', ['iddetailbonreception' => $idDetailBonDeReception]);
    }

  }

?>
