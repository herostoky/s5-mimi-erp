<?php
class DetailProforma_model extends CI_Model {
	public function __construct() {
		parent::__construct();
    }
	
	public function checkValues ($detail_proforma) {
		if ($detail_proforma['quantite'] <= 0) {
			throw new Exception ("Erreur. Quantite nulle ou negative!");
		}
		if ($detail_proforma['remise'] < 0 || $detail_proforma['remise'] > 100) {
			throw new Exception ("Erreur. Remise negative ou depassant 100%");
		}
	}
	
    public function getAllDetailsByIdProforma($id){        
		$result_rows = $this->db->get_where("DetailProforma", ['idproforma' => $id])->result();
		return $result_rows;
    }
}
?>