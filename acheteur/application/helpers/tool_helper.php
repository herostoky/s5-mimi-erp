<?php
// juste des tas de fonctions qui evitent de reecrire l url
function absolute_url($nom) {
	return base_url() . $nom;
}

function asset_url($path) {
	return absolute_url("assets/$path");
}

function truncate_text ($text, $n) {
	$retain = 50;
	$text_size = strlen($text);
	if ($text_size == 0 )
		return "-- Aucune --";

	if ($n != 'default')
		$retain = $n;
	return substr($text, 0, $retain) . ($retain < $text_size ? "..." : "");
}

function groupByDate($transaction_arr) {
	$arr = $transaction_arr;
	$dates = array();
	foreach ($arr as $item) {
		$date = $item->date_transac;
		$dates[$date] = array();
	}
	foreach ($arr as $item) {
		$date = $item->date_transac;
		$dates[$date][] = $item;
	}
	return $dates;
}

function getDateNow( $db ) {
    $sql = "SELECT DATE_FORMAT(now(), '%d/%m/%Y') cdate";
	$query = $db->query($sql);
	$result = $query->result();
	return $result[0]->cdate;   
}


function getTimeNow( $db ) {
    $sql = "SELECT now() cdate";
	$query = $db->query($sql);
	$result = $query->result();
	return $result[0]->cdate;   
}

?>
