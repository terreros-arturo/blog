<?php

class Modulo{
	
	private $idModulo;
	private $nombreModulo;
	private $descripcionModulo;
	private $nombreUrlModulo;
	
	function setIdModulo($idModulo){
		$this->idModulo = $idModulo;
	}
	
	function getIdModulo(){
		return $this->idModulo;
	}
	
	function setNombreModulo($nombreModulo){
		$this->nombreModulo = $nombreModulo;
	}
	
	function getNombreModulo(){
		return $this->nombreModulo;
	}
	
	function setDescripcionModulo($descripcionModulo){
		$this->descripcionModulo = $descripcionModulo;
	}
	
	function getDescripcionModulo(){
		return $this->descripcionModulo;
	}
	
	function setNombreUrlModulo($nombreUrlModulo){
		$this->nombreUrlModulo = $nombreUrlModulo;
	}
	
	function getNombreUrlModulo(){
		return $this->nombreUrlModulo;
	}
}
?>