<?php defined('BASEPATH') OR exit('No direct script access allowed');

  class Demandeproforma_model extends CI_Model {

    public function insert_demandeproforma($demandeproforma){
      $sql = 'insert into "DemandeProforma" values (DEFAULT, \'%s\') returning iddemandeproforma';
      $sql = sprintf($sql, $demandeproforma['idfournisseur']);
      $query = $this->db->query($sql);
      $row = $query->row_array();
      return $row['iddemandeproforma'];
    }

    public function insert_detaildemandeproforma($iddemandeproforma, $detail){
      $sql = 'insert into "DetailDemandeProforma" values (DEFAULT, \'%s\', %s, %s)';
      $sql = sprintf($sql, $iddemandeproforma, $detail['quantite'], $this->db->escape($detail['designation']));
      $this->db->query($sql);
    }

    public function get_demandesproforma() {
      $sql = 'SELECt * FROM "DemandeProforma"';
      $query = $this->db->query($sql);
      $demandesproforma = array();
      foreach($query->result_array() as $row){
        $demandesproforma [] = $row;
      }

      return $demandesproforma;
    }

    public function get_detaildemandeproforma($iddemandeproforma) {
      $sql = 'SELECt * FROM "DetailDemandeProforma" WHERE iddemandeproforma=\'%s\'';
      $sql = sprintf($sql, $iddemandeproforma);
      $query = $this->db->query($sql);
      $detailsDemandeProforma = array();
      foreach($query->result_array() as $row){
        $detailsDemandeProforma [] = $row;
      }

      return $detailsDemandeProforma;
    }

  }

?>
