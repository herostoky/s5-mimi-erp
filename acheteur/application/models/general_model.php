<?php
class General_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}

	public function fill_zeroes ($zeroes, $str) {
		$left = $zeroes - strlen($str.'');
		$out = $str;
		if ($left > 0)
			while ($left--)
				$out = '0' . $out;
		return $out;
	}

	public function get_generated_id ($idfournisseur) {
		$fournisseur = $this->db->get_where('Fournisseur', ['idfournisseur' => $idfournisseur])->row_array();

		// add seq
		$last_seq = $this->db->get_where('SequenceBonFournisseur', ['idfournisseur' => $idfournisseur])->row_array();
		$current  = $last_seq['value'] + 1;
		$this->db->update('SequenceBonFournisseur', ['value' => $current], ['idfournisseur' => $idfournisseur]);

		$f_name  = $fournisseur['nom_fournisseur'];
		$date    = getdate();
		$day     = $this->fill_zeroes(2, $date['mday']);
		$mon     = $this->fill_zeroes(2, $date['mon']);
		$year    = $date['year'];
		$current = $this->fill_zeroes(3, $current);
		return $day.'/'.$mon.'/'.$year.'-'.$f_name.'-'.$current;
	}   
}
?>
