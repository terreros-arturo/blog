<?php
session_start();
session_regenerate_id();
function textoAleatorio($longitud) {
	$clave = "";
	$patron = "1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
	for($i = 0; $i < $longitud; $i++) 
	$clave .= $patron{rand(0, strlen($patron) - 1)};
	return $clave;
}
$fuente = "../fonts/VeraMoBd.ttf";
$claveSecreta = textoAleatorio(5);
$_SESSION['clave'] = md5($claveSecreta);
$fondoCaptcha = imagecreatefrompng("../img/fondoCaptcha.png");
$colorTexto = imagecolorallocate($fondoCaptcha, 255, 255, 255);
$colorLinea = imagecolorallocate($fondoCaptcha,220,220,220);
$imageInfo = getimagesize("../img/fondoCaptcha.png"); 
$numLineas = mt_rand(2,4);
for( $i = 0; $i < $numLineas; $i++ ) {
	$xInicial = mt_rand( 0, $imageInfo[0] );
	$xFinal = mt_rand( 0, $imageInfo[0] );
	imageline($fondoCaptcha, $xInicial, 0, $xFinal, $imageInfo[1], $colorLinea);
}
//aqui posicionamos el origen (x0,y0)a partir de donde escribiremos la palabra secreta
//el eje x en la primera decima parte de la imagen (1/10 = .1)
$xInicial = $imageInfo[0] * 0.1;
//el eje y por debajo de la mitad de la imagen (1/2 = .5)
$yInicial = $imageInfo[1] * .7;
$tamFuente = 15;
$maximo_angulo = 30;
for($i = 0; $i < strlen($claveSecreta); $i++){
	$angulo = rand(-100 * $maximo_angulo, 100 * $maximo_angulo) / 100.0;
	$caja_texto = imagettfbbox($tamFuente, $angulo, $fuente, $claveSecreta{$i});
	imagettftext($fondoCaptcha, $tamFuente, $angulo, $xInicial ++, $yInicial, $colorTexto , $fuente, $claveSecreta{$i});
	$xInicial += 17; //desplazamos 17 lugares a la derecha para colocar el siguiente caracter
}
Header("Content-type: image/png");
imagepng($fondoCaptcha);
imagedestroy($fondoCaptcha);
?>