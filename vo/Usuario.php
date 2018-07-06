<?php

class Usuario{
	
	private $idUsuario;
	private $idTipoUsuario;
	private $nomUsuario;
	private $apellidosUsuario;
	private $nickUsuario;
	private $passwordUsuario;
	private $correoUsuario;
	private $paisUsuario;
	private $eliminarUsuario;
	private $nuevoUsuario;
	private $activoUsuario;
	
	function setIdUsuario($idUsuario){
		$this->idUsuario = $idUsuario ;
	}
	
	function setIdTipoUsuario($idTipoUsuario){
		$this->idTipoUsuario = $idTipoUsuario;
	}
	
	function setNomUsuario($nomUsuario){
		$this->nomUsuario = $nomUsuario;
	}
	
	function setApellidosUsuario($apellidosUsuario){
		$this->apellidosUsuario = $apellidosUsuario;
	}
	
	function setNickUsuario($nickUsuario){
		$this->nickUsuario = $nickUsuario;
	}
	
	function setPasswordUsuario($passwordUsuario){
		$this->passwordUsuario = $passwordUsuario;
	}
	
	function setCorreoUsuario($correoUsuario){
		$this->correoUsuario = $correoUsuario;
	}
	
	function setPaisUsuario($paisUsuario){
		$this->paisUsuario = $paisUsuario ;
	}
	
	function setEliminarUsuario($eliminarUsuario){
		$this -> eliminarUsuario = $eliminarUsuario;
	}
	
	function setNuevoUsuario($nuevoUsuario){
		$this -> nuevoUsuario= $nuevoUsuario;
	}
	
	function setActivoUsuario($activoUsuario){
		$this -> activoUsuario = $activoUsuario;
	}
	
	function getIdUsuario(){
		return($this->idUsuario);
	}
	
	function getIdTipoUsuario(){
	   return $this->idTipoUsuario;
	}
	
	function getNomUsuario(){
		return($this->nomUsuario);
	}
	
	function getApellidosUsuario(){
		return($this->apellidosUsuario);
	}
	
	function getNickUsuario(){
		return($this->nickUsuario);
	}
	
	function getPasswordUsuario(){
		return($this->passwordUsuario);
	}
	
	function getCorreoUsuario(){
		return($this->correoUsuario);
	}
	
	function getPaisUsuario(){
		return($this->paisUsuario);
	}
	
	function getEliminarUsuario(){
		return $this -> eliminarUsuario;
	}
	
	function getNuevoUsuario(){
		return $this -> nuevoUsuario;
	}
	
	function getActivoUsuario(){
		return $this -> activoUsuario;
	}
}
?>