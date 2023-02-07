<?php defined('BASEPATH') OR exit('No direct script access allowed');

  class Fournisseur_model extends CI_Model {

    public function get_fournisseurs(){
      $sql = 'SELECt * FROM "Fournisseur"';
      $query = $this->db->query($sql);
      $fournisseurs = array();
      foreach($query->result_array() as $row){
        $fournisseurs [] = $row;
      }

      return $fournisseurs;
    }

  }

?>
