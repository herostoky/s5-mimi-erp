<?php

function build_response ($datas, $status = 200) {
	return array (
		'status' => $status,
		'datas' => $datas
	);
}

function res_error ($err_obj, $status = 400) {
	return build_response($err_obj, $status);
}

function res_success ($err_obj) {
	return build_response($err_obj);
}

function extract_token_from ($controller) {
	// writing comments like a professional
	// 'Bearer blablablabla'
	// getting the mapped header
	$auth = $controller->input->get_request_header('Authorization', true);

	$exploded = explode(' ', $auth);

	// if ($exploded[0] != 'Bearer')
		// return null;
	if (count($exploded) < 2)
		return null;

	return $exploded[1];
}


function build_token ($str_array, $use_date = true) {
	$final = '';
	foreach ($str_array as $it)
		$final .= $it;

	$date = getdate();
	foreach ($date as $key => $val)
		$final .= $val;

	return sha1($final);
}

function check_required ($required, $given, $check_extra_field = false) {

    foreach ($required as $item)
	    if (empty($given[$item]))
	        throw new Exception('Champ '.$item.' incomplete');

    if ($check_extra_field && count($required) < count($given))
		throw new Exception('Valeurs/Champs inutiles en trop');

}


function SET_CORS () {
	header('Access-Control-Allow-Origin: *');
	header("Access-Control-Allow-Credentials: true");
	header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
	header('Access-Control-Max-Age: 1000');
	// header('Access-Control-Allow-Headers: *');
	header('Access-Control-Allow-Headers: *');
	if ( "OPTIONS" === $_SERVER['REQUEST_METHOD'] ) {
		return;
	}
}

?>
