<?php
function getIp() {
	$ip;
	if (isset($_SERVER)) {
		if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else
			$ip = $_SERVER['REMOTE_ADDR'];
	}else{
		if(isset($GLOBALS['HTTP_SERVER_VARS']['HTTP_X_FORWARDER_FOR']))
			$ip = $GLOBALS['HTTP_SERVER_VARS']['HTTP_X_FORWARDED_FOR'];
		else
			$ip = $GLOBALS['HTTP_SERVER_VARS']['REMOTE_ADDR'];
	}
	return $ip;
}

function correoValido($correo){
	$expresion = "/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/";
	return preg_match($expresion, $correo);
}

function webValida($web){
	$expresion = "/((\s+(http[s]?:\/\/)|(www\.))?(([a-z][-a-z0-9]+\.)?[a-z][-a-z0-9]+\.(([a-zA-Z]{2}|aero|asia|biz|cat|com|coop|edu|gov|info|int|jobs|mil|mobi|museum|name|net|org|pro|tel|travel)(\.[a-z]{2,2})?))\/?[a-z0-9._\/~#&=;%+?-]+[a-z0-9\/#=?]{1,1})/is";
	return preg_match($expresion, $web);
}

function nickValido($nick){
	$expresion = "/[a-zA-Z0-9]+/";
	return preg_match($expresion, $nick);
}

?>