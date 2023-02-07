<?php

/**
 * @author afmika
 * Number formater multilang v.2
 */

function format_money_int($number) {
	$n = "" . $number;
	$res = "";
	$k=0;
	for($i = strlen($number) - 1; $i >= 0; $i--) {
		$res = substr($n, $i, 1) . $res;
		$res = ($k+1) % 3 == 0 && $i != 0 ?  " ".$res : "".$res;
		$k++;
	}
	return $res;
}

function format_money($number) {
	$number = round($number, 2);
	$parts = explode(".", $number);
	if (count($parts) > 1)
		return format_money_int($parts[0]).".".$parts[1];
	return format_money_int($number);
}

function get_min10 ($lang = 'fr') {
	$min_10 = array (
		'fr' => array('zero', 'un', 'deux', 'trois', 'quatre', 'cinq', 'six', 'sept', 'huit', 'neuf'),
		'en' => array('zero', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine')
	);
	return $min_10[$lang]; 
}

function get_single_num ($lang = 'fr') {
	$pref = array(
		'fr' => array('', 'deux', 'trois', 'quatre', 'cinq', 'six', 'sept', 'huit', 'neuf'),
		'en' => array('one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine')
	);
	return $pref[$lang];
}

function get_dizaine ($lang = 'fr') {
	$dizaine = array (
		'fr' => array('dix', 'onze', 'douze', 'treize', 'quatorze', 'quinze', 'seize', 'dix-sept', 'dix-huit', 'dix-neuf', 'vingt'),
		'en' => array('ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fiveteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen')
	);

	return $dizaine[$lang];
}

function get_sign_lang ($lang = 'fr') {
	$_sign = array ('fr' => 'moins', 'en' => 'minus');
	return $_sign[$lang];
}

function get_suffix ($lang = 'fr') {
	$fr = array ('0' => '', '2' => 'vingt', '3' => 'trente', '4' => 'quarente', '5' => 'cinquante', '6' => 'soixante', '7' => 'soixante-dix', '8' => 'quatre-vingt', '9' => 'quatre-vingt-dix');
	$en = array('0' => '', '2' => 'twenty', '3' => 'thirty', '4' => 'fourty', '5' => 'fivety', '6' => 'sixty', '7' => 'seventy', '8' => 'eighty', '9' => 'ninety');
	if ($lang == 'fr')
		return $fr;
	return $en;
}

function get_suffix_group_3 ($lang = 'fr') {
	$suff3 = array (
		'fr' => array('', 'mille', 'million', 'milliard', 'mille milliard'),
		'en' => array('', 'thousand', 'million', 'billion', 'thousand billion')
	);
	return $suff3[$lang];
}

function hundred ($lang = 'fr') {
	$_100 = array ('fr' => 'cent', 'en' => 'hundred');
	return $_100[$lang];
}

function dot ($lang = 'fr') {
	$_dot = array ('fr' => 'virgule', 'en' => 'point');
	return $_dot[$lang];
}

function to_base_10_array($number) {
	$out = array();
	while ($number > 0) {
		$reminder = $number % 10;
		$number = floor($number / 10);
		$out[] = $reminder;
	}
	return array_reverse($out);
}

function all_zeros ($number_str) {
	$number_str .= "";
	for ($i = 0; $i < strlen($number_str); $i++)
		if ($number_str[$i] != 0) return false;
	return true;
}

function clean_answer_using($prefixes, $letter_array) {
	$tokens = $letter_array;
	$ans = "";
	for ($i = 0; $i < count($tokens); $i++) {
		$token = $tokens[$i];
		$is_prefix = false;
		foreach ($prefixes as $prefixe) {
			if ($token == $prefixe) {
				$is_prefix = true;
				break;
			}
		}
		if ($is_prefix)
			if ($i + 1 < count($tokens) && $tokens[$i + 1] == 'zero')
				++$i;

		$ans .= $token.' ';
	}
	return $ans;
}

// reader

function readDizaine($number, $lang = 'fr') {
	$number += 0; // cast
	if ($number > 100)
		throw new Exception("Number must be less than 100 :(");
	$min_10 = get_min10 ($lang);
	$dizaine = get_dizaine ($lang);
	$suffix = get_suffix ($lang);
	$b10 = to_base_10_array($number);
	if ($number < 10) {
		return $min_10[$number];
	} else {
		$left = $b10[0];
		$right = $b10[1];
		$letter = "";

		if ($left == 1)
			return $dizaine[$number - 10];
		
		if ($lang == 'fr' && ($left == 9 || $left == 7)) {
			// ex : 92 = quatre vingt + [douze] = letter(9-1) + douze
			$letter = $suffix[$left - 1].' '.$dizaine[$right];
		} else {
			$letter = $suffix[$left].' '.($right == 0 ? "" : readDizaine($right, $lang));
		}
		return $letter;
	}
}

function readInferieur1000($number, $lang = 'fr') {
	$number += 0; // cast
	if ($number > 1000)
		throw new Exception("Number must be less than 1000 :(");

	if ($number < 100)
		return readDizaine($number, $lang);
	
	$pref = get_single_num($lang);
	$b10 = to_base_10_array($number);
	$dizaine_part = $b10[1] * 10 + $b10[2];

	if ($dizaine_part == 0)
		return $pref[$b10[0] - 1].' '.hundred($lang).' ';
	
	return $pref[$b10[0] - 1].' '.hundred($lang).' '.readDizaine($dizaine_part, $lang);
}


function to_letters($number, $lang = 'fr') {
	if ($number < 100)
		return readDizaine($number, $lang);

	$digits = to_base_10_array($number);
	$suffix_3 = get_suffix_group_3($lang);
	// group by 3
	$current_sum = 0;
	$current_pos = 0;
	$i = count($digits) - 1;
	$group = array();
	do {
		$current_sum += pow(10, $current_pos++) * $digits[$i--];
		if ($current_pos > 2 ) {
			$group[] = $current_sum;
			$current_sum = 0;
			$current_pos = 0;
		}
	} while($i >= 0);

	if ($current_sum > 0)
		$group[] = $current_sum;
	
	$final_array = [];
	for ($i = 0; $i < count($group); $i++) {
		$its_suffix = $suffix_3[$i];

		if ($its_suffix != '' && $group[$i] > 0)
			$final_array[] = $its_suffix;
		
		if (!($group[$i] == 1 && $i == 1)) {
			if ($group[$i] != 0)
				$final_array[] = readInferieur1000($group[$i], $lang);
		}

	}

	// ex : un million zero un mille zero => un million mille
	return clean_answer_using($suffix_3, array_reverse($final_array));
}

function format_count_zero($number, $lang = 'fr') {
	$zeros = "";
	$n = $number + 0; // cast
	if (strlen($n."") < strlen($number."")) {
		$z_count = strlen($number."") - strlen($n."");
		for ($i = 0; $i < $z_count; $i++)
			$zeros .= "zero ";
	}
	return $zeros.to_letters($number, $lang);
}

function to_letter_float($number_float, $lang = 'fr', $unit = '') {
	$sign = '';
	if ($number_float < 0)
		$sign = get_sign_lang($lang).' ';

	$number_float = abs($number_float);
	
	$parts = explode(".", $number_float);
	$output = "";

	if (count($parts) > 1) {
		if (!empty($unit))
			$output = to_letters($parts[0], $lang) . " ".$unit." " . format_count_zero($parts[1], $lang);
		else
			$output = to_letters($parts[0], $lang) . " ".dot($lang)." " . format_count_zero($parts[1], $lang);
	} else {
		$output = to_letters($number_float, $lang);
		if (!empty($unit))
			$output .= ' '.$unit;
	}

	return $sign . $output;
}
?>
