<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class bondesortie_model extends CI_Model {
    public function liste_bondesorties(){
        return $this->db->get_where('BonDeSortie', ['valided' => 0])->result();
    }
    public function bondesortie($id){
        return ($this->db->get_where('BonDeSortie', ['idbondesortie' => $id])->result())[0];
    }
    public function details_bondesortie($id){
        return $this->db->get_where('DetailBonDeSortie', ['idbondesortie' => $id])->result();
    }
    public function insert_details_bondesortie($DetailBonDeSortie){
        $this->db->insert('DetailBonDeSortie', $DetailBonDeSortie);
    }
    public function deletedetails_bondesortie($idDetailBonDeSortie){
        $this->db->delete('DetailBonDeSortie', ['iddetailbondesortie' => $idDetailBonDeSortie]);
    }
  }
?>