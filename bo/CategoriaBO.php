<?php
require_once("../dao/CategoriaDAO.php");

class CategoriaBO {
	private $categoriaDAO;
	
	public function __construct(){
		$this -> categoriaDAO = new CategoriaDAO();
	}
	
	public function obtenCategorias(){
		return $this -> categoriaDAO -> obtenCategorias();
	}
}
?>