<?php 
class Immobilisation_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}

	public function getListImmo ($nom) {
		if (empty($nom))
			$this->db->get('Immobilisation')->result();
		return $this->db
			->query('SELECT * FROM "Immobilisation" WHERE "nom" LIKE ?', [$nom])
			->result();
	}

	public function diff_jours ($str_t1, $str_t2) {
		$date1 = date_create($str_t1);
		$date2 = date_create($str_t2);
		$diff = date_diff($date1, $date2, TRUE );
		return min(365, $diff->days);
	}

	public function pad ($n) {
		return $n < 10 ? '0'.$n : $n;
	}
	public function makeTimestamp ($year, $month, $day) {
		return $year.'-'.$this->pad($month).'-'.$this->pad($day);
	}

	public function extractYear ($timestamp_str) {
		return explode('-', $timestamp_str) [ 0 ];
	}

	public function compare ($str_t1, $str_t2) {
		$date1 = date_create($str_t1);
		$date2 = date_create($str_t2);
		$diff = date_diff($date1, $date2, FALSE);
		$delta = $diff->days;
		if ($delta == 0) 
			return $delta;
		return $diff->invert == 1 ? -1 : 1;	
	}

	public function computeTaux ($duree) {
		return 100 / $duree;
	}

	public function computeImmoLinearFor ($idimmo, $query_date = null) {

		$immo = $this->db->get_where('Immobilisation', ['idimmobilisation' => $idimmo])->row();
		$last_month = $immo->mois_fin_exo;
		$last_day = $immo->jour_fin_exo;

		$result = [
			'nom' => $immo->nom, 
			'id' => $immo->idimmobilisation,
			'methode' => 'Lineaire',
			'debut_usage' => $immo->debut_usage,
			'valeur_init' => $immo->valeur,
			'total_annee' => $immo->duree_amortissement,
			'taux' => $this->computeTaux($immo->duree_amortissement),
			'taux_deg' => '0',
			'coef_deg' => $immo->coef_deg,
			'error_message' => '',

			'query_date' => $query_date,
			'rows' => []
		];

		if (!empty($query_date) && $this->compare($result['debut_usage'], $query_date) <= 0) {
			$result['error_message'] = $query_date." doit etre superieur strict a " . $result['debut_usage'];
			return $result;
		}
		

		$current_date = $result['debut_usage'];
		$year = $this->extractYear($current_date);
		$last_date_of_the_year = $this->makeTimestamp($year, $last_month, $last_day);
		if ($this->compare($current_date, $last_date_of_the_year) == 0) {
			// occurs when we set current = 01-03-2012 and fin exo = 01-03
			$year++;
			$last_date_of_the_year = $this->makeTimestamp($year, $last_month, $last_day);
		}

		$curr_amort_cumule = 0;
		$curr_val_nette = 0;
		$curr_year = 1;
		while ($curr_year <= $result['total_annee']) {
			$nb_jours = $this->diff_jours($current_date, $last_date_of_the_year);
			$taux_lin = $result['taux'] / 100;

			$should_stop = FALSE;
			if (!empty($query_date)) {
				// last date <= query_date
				if ($this->compare($last_date_of_the_year, $query_date) <= 0) {
					$last_date_of_the_year = $query_date;
					$nb_jours = $this->diff_jours($current_date, $last_date_of_the_year);
					$should_stop = TRUE;
				}
			}

			$va = $result['valeur_init'];
			$row = [
				'annee' => $curr_year,
				'VA' => $va,
				'debut_exo' => $current_date,
				'fin_exo' => $last_date_of_the_year,
				'nb_jours' => $nb_jours,
				'amort_cumul_debut' => $curr_amort_cumule,
				'dotation' => 0, // valeur a retirer de la valeur init
				'amortissement' => 0,
				'valeur_nette' => 0, // valeur init - dotation

				'taux' => $result['taux'],
				'taux_deg' => '----',
			];

			$row['dotation'] = $result['valeur_init'] * $taux_lin * ( $nb_jours / 365);
			$row['amortissement'] = $row['dotation'] + $row['amort_cumul_debut'];
			$left = $row['VA'] - $row['amortissement'];


			$curr_amort_cumule = $row['amortissement'];
			$row['valeur_nette'] = $left;
			$curr_val_nette = $row['valeur_nette'];
			$current_date = $row['fin_exo'];
			$year = 1 + $this->extractYear($current_date);
			$last_date_of_the_year = $this->makeTimestamp($year, $last_month, $last_day);

			$result['total_annee'];
			$result['rows'][] = $row;
			$curr_year++;

			if ($should_stop)
				break;
		}

		$last_index = count($result['rows']) - 1;
		if ($last_index >= 0) {
			$previous = $result['rows'][$last_index];
			$v_nette = $previous['valeur_nette'];
			if ($previous['valeur_nette'] > 0) {
				// $vnette = va - va * taux * (nb_jour / 365)
				// ($vnette / $va) * (1 / taux) * 365 = nb_jour
				$taux = $result['taux'] / 100;
				$nb_jours = ($v_nette / $va) * (1 / $taux) * 365;
				$row = [
					'annee' => '----',
					'VA' => $va,
					'debut_exo' => $current_date,
					'fin_exo' => '---',// $last_date_of_the_year,
					'nb_jours' => $nb_jours .' (restant)',
					'amort_cumul_debut' => $curr_amort_cumule,
					'dotation' => $v_nette, // valeur a retirer de la valeur init
					'amortissement' => $va,
					'valeur_nette' => 0, // valeur init - dotation

					'taux' => $result['taux'],
					'taux_deg' => '----'
				];
				$result['rows'][] = $row;
			}
		}


		return $result;
	}

	public function computeImmoDegressifFor ($idimmo, $query_date = null) {

		$immo = $this->db->get_where('Immobilisation', ['idimmobilisation' => $idimmo])->row();
		$last_month = $immo->mois_fin_exo;
		$last_day = $immo->jour_fin_exo;
		$taux_en_100pc = $this->computeTaux($immo->duree_amortissement);
		
		$result = [
			'nom' => $immo->nom, 
			'id' => $immo->idimmobilisation,
			'methode' => 'Degressif',
			'debut_usage' => $immo->debut_usage,
			'valeur_init' => $immo->valeur,
			'total_annee' => $immo->duree_amortissement,
			'taux' => $taux_en_100pc,
			'taux_deg' => $taux_en_100pc * $immo->coef_deg,
			'coef_deg' => $immo->coef_deg,
			'error_message' => '',

			'query_date' => $query_date,
			'rows' => []
		];

		if (!empty($query_date) && $this->compare($result['debut_usage'], $query_date) <= 0) {
			$result['error_message'] = $query_date." doit etre superieur strict a " . $result['debut_usage'];
			return $result;
		}
		

		$current_date = $result['debut_usage'];
		$year = $this->extractYear($current_date);
		$last_date_of_the_year = $this->makeTimestamp($year, $last_month, $last_day);
		if ($this->compare($current_date, $last_date_of_the_year) == 0) {
			// occurs when we set current = 01-03-2012 and fin exo = 01-03
			$year++;
			$last_date_of_the_year = $this->makeTimestamp($year, $last_month, $last_day);
		}

		$curr_amort_cumule = 0;
		$curr_val_nette = 0;
		$curr_year = 1;

		$curr_taux_lin = $result['taux'] / 100;
		$curr_coef_deg = $result['coef_deg'];
		$va = $result['valeur_init'];
		while ($curr_year <= $result['total_annee']) {
			$nb_jours = $this->diff_jours($current_date, $last_date_of_the_year);
			$taux_deg = $result['taux_deg'] / 100;
			// echo $taux_deg;

			$should_stop = FALSE;
			if (!empty($query_date)) {
				// last date <= query_date
				if ($this->compare($last_date_of_the_year, $query_date) <= 0) {
					$last_date_of_the_year = $query_date;
					$nb_jours = $this->diff_jours($current_date, $last_date_of_the_year);
					$should_stop = TRUE;
				}
			}

			$row = [
				'annee' => $curr_year,
				'VA' => $va,
				'debut_exo' => $current_date,
				'fin_exo' => $last_date_of_the_year,
				'nb_jours' => $nb_jours,
				'amort_cumul_debut' => $curr_amort_cumule,
				'dotation' => 0, // valeur a retirer de la valeur init
				'amortissement' => 0,
				'valeur_nette' => 0, // valeur init - dotation

				'taux' => 0, // taux lineaire pour cette periode
				'taux_deg' => $result['taux_deg'],
			];

			// taux_lin(n) = taux_deg / coef_deg(n) (avec taux_deg = taux_init * coef_deg_init) 
			// ou encore taux_lin(n) = taux_deg /  (coef_deg_init - coef_deg_init * n)
			// ou encore taux_lin(n) = taux_deg / (1 - n) * coef_deg_init
			$curr_taux_lin = $taux_deg / $curr_coef_deg;
			$row['taux'] = round($curr_taux_lin * 100, 2);
			$taux = max($curr_taux_lin, $taux_deg);


			// echo $taux."|";
			$row['dotation'] = $va * $taux * ( $nb_jours / 365);
			$row['amortissement'] = $row['dotation'] + $row['amort_cumul_debut'];
			$left = $va - $row['dotation'];


			$curr_coef_deg -= $taux_deg; // apres chaque periode

			$curr_amort_cumule = $row['amortissement'];
			$row['valeur_nette'] = $left;
			$curr_val_nette = $row['valeur_nette'];
			$current_date = $row['fin_exo'];
			$year = 1 + $this->extractYear($current_date);
			$last_date_of_the_year = $this->makeTimestamp($year, $last_month, $last_day);

			// diff avec meth lineaire
			$va = $row['valeur_nette'];

			$result['total_annee'];
			$result['rows'][] = $row;
			$curr_year++;

			if ($should_stop)
				break;
		}

		return $result;
	}
}
?>