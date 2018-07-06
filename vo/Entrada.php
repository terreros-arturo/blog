<?php

class Entrada{
	private $idEntrada;
	private $idUsuarioEntrada;
	private $fechaEntrada;
	private $ipPublica;
	private $tituloEntrada;
	private $contenidoEntrada;
	private $archivoEntrada;
	private $entradaActiva;
	private $idCategoriaEntrada;
	
	public function setIdEntrada($idEntrada){
		$this->idEntrada = $idEntrada;
	}
	public function getIdEntrada(){
		return $this->idEntrada;
	}
	public function setIdUsuarioEntrada($idUsuarioEntrada){
		$this->idUsuarioEntrada = $idUsuarioEntrada;
	}
	public function getIdUsuarioEntrada(){
		return $this->idUsuarioEntrada;
	}
	public function setFechaEntrada($fechaEntrada){
		$this->fechaEntrada = $fechaEntrada;
	}
	public function getFechaEntrada(){
		return $this->fechaEntrada;
	}
	public function setIpPublica($ipPublica){
		$this->ipPublica = $ipPublica;
	}
	public function getIpPublica(){
		return $this->ipPublica;
	}
	public function setTituloEntrada($tituloEntrada){
		$this -> tituloEntrada = $tituloEntrada;
	}
	public function getTituloEntrada(){
		return $this -> tituloEntrada;
	}
	public function setContenidoEntrada($contenidoEntrada){
		$this->contenidoEntrada = $contenidoEntrada;
	}
	public function getContenidoEntrada(){
		return $this->contenidoEntrada;
	}
	public function setArchivoEntrada($archivoEntrada){
		$this->archivoEntrada = $archivoEntrada;
	}
	public function getArchivoEntrada(){
		return $this->archivoEntrada;
	}	
	public function setEntradaActiva($entradaActiva){
		$this->entradaActiva = $entradaActiva;
	}
	public function getEntradaActiva(){
		return $this->entradaActiva;
	}
	public function setIdCategoriaEntrada($idCategoriaEntrada){
		$this->idCategoriaEntrada = $idCategoriaEntrada;
	}
	public function getIdCategoriaEntrada(){
		return $this->idCategoriaEntrada;
	}
}
?>