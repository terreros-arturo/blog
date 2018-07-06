<?php

class Comentario{
	
	private $idComentario;
	private $idEntradaComentario;
	private $contenidoComentario;
	private $nombreComenta;
	private $correoComenta;
	private $webComenta;
	private $fechaComentario;
	private $ipComenta;
	
	
	function setIdComentario($idComentario){
		$this->idComentario = $idComentario;
	}
	
	function getIdComentario(){
		return $this->idComentario;
	}
	
	function setIdEntradaComentario($idEntradaComentario){
		$this->idEntradaComentario = $idEntradaComentario;
	}
	
	function getIdEntradaComentario(){
		return $this->idEntradaComentario;
	}
	
	function setFechaComentario($fechaComentario){
		$this->fechaComentario = $fechaComentario;
	}
	
	function getFechaComentario(){
		return $this->fechaComentario;
	}
	
	function setContenidoComentario($contenidoComentario){
		$this->contenidoComentario = $contenidoComentario;
	}
	
	function getContenidoComentario(){
		return $this->contenidoComentario;
	}
	
	function setNombreComenta($nombreComenta){
		$this->nombreComenta = $nombreComenta;
	}
	
	function getNombreComenta(){
		return $this->nombreComenta;
	}
	
	function setCorreoComenta($correoComenta){
		$this->correoComenta = $correoComenta;
	}
	
	function getCorreoComenta(){
		return $this->correoComenta;
	}
	
	function setWebComenta($webComenta){
		$this->webComenta = $webComenta;
	}
	
	function getWebComenta(){
		return $this->webComenta;
	}
	
	function setIpComenta($ipComenta){
		$this->ipComenta = $ipComenta;
	}
	
	function getIpComenta(){
		return $this->ipComenta;
	}
	
}

?>