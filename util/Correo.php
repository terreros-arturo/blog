<?php

class Correo{
	
	private $dia;// = date("d - M - y");
	private $hora;// = date("H:i");
	private $para;
	private $asunto;
	private $desde = "webtra.net63.net";
	private $contenido;
	private $encabezado;
	
	function __construct(){
		$this -> encabezado = 'MIME-Version: 1.0'. "\r\n" .'Content-type: text/html; charset=iso-8859-1'."\r\n"."From: $this->desde\r\n". "Reply-To: $this->desde\r\n";
	}
	
	public function setDia($dia){
		$this -> dia = $dia;
	}
	
	public function getDia(){
		return $this -> dia;
	}
	
	public function setHora($hora){
		$this -> hora; 
	}
	
	public function getHora(){
		return $this -> hora;
	}
	
	public function setPara($para){
		$this -> para = $para;
	}
	
	public function getPara(){
		return $this -> para;
	}
	
	public function setAsunto($asunto){
		$this -> asunto = $asunto;
	}
	
	public function getAsunto(){
		return $this -> asunto;
	}
	
	public function setDesde($desde){
		$this -> desde = $desde;
	}
	
	public function getDesde(){
		return $this -> desde;
	}
	
	public function setContenido($contenido){
		$this -> contenido = $contenido;
	}
	
	public function getContenido(){
		return $this -> contenido;
	}
	
	public function enviaCorreoColaboradorComentario($correoComentador, $comentario, $tituloEntrada){
		$this -> asunto = "Han comentado una entrada";
		$this -> contenido = "<html><head><title></title></head>
								<body>
								<center>
								<div style=\"width: 854px; background-color: #04B486; color:#000; font-weight: bold; border-style: double; border-width: 3px;\">
									<img src=\"http://webtra.net63.net/blog-logo3.png\"/><br/>
									$correoComentador ha comentado:
									<div style=\"width: 688px; background-color: #eee; display: block; margin: 15px 80px; padding: 5px; border-style: ridge; border-width: 3px; border-color: #fff;\">
										$comentario
									</div>
									con respecto a la entrada: 
									<div style=\"width: 688px; background-color: #eee; display: block; margin: 15px 80px; padding: 5px; border-style: dashed; border-width: 3px; border-color: #fff;\">
										$tituloEntrada
									</div>
								</div>
								</center>
								</body></html>";
		return @mail($this -> para, $this -> asunto, $this -> contenido, $this -> encabezado);
	}
	
	public function enviaCorreoComentadorComentario($comentario){
		$this -> asunto = "Hemos recibido tu comentario";
		$this -> contenido = "<html> <head> <title></title> </head>
								<body >
								<center>
								<div style=\"width: 854px; background-color: #04B486; color:#000; font-weight: bold; border-style: double; border-width: 3px;\">
									<img src=\"http://webtra.net63.net/blog-logo3.png\"/><br/>
									Gracias por participar en nuestro sitio; tu comentario: 
									<div style=\"width: 688px; background-color: #eee; display: block; margin: 15px 80px; padding: 5px; border-style: ridge; border-width: 3px; border-color: #fff;\">
									$comentario
									</div>
									ha sido recibido. Intentaremos contestar cuanto antes.
								</div>
								</center>
								</body></html>";
		return @mail($this -> para, $this -> asunto, $this -> contenido, $this -> encabezado);
	}
}

?>