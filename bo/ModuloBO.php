<?php
require_once("../dao/ModuloDAO.php");

class ModuloBO{
	private $moduloDAO;
	
	public function __construct(){
		$this -> moduloDAO = new ModuloDAO();
	}
	
	public function obtenModulosPrivilegios($idUsuario){
		$listaModulos = $this-> moduloDAO -> obtenModulosPrivilegios($idUsuario);
		return $listaModulos;
	}
}
?>