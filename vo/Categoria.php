<?php

class Categoria{
	
	private $idCategoria;
	private $nombreCategoria;
	private $descripcionCategoria;
	private $editableCategoria;
	
	function setIdCategoria($idCategoria){
		$this->idCategoria = $idCategoria;
	}
	
	function getIdCategoria(){
		return $this->idCategoria;
	}
	
	
	function setNombreCategoria($nombreCategoria){
		$this->nombreCategoria = $nombreCategoria;
	}
	
	function getNombreCategoria(){
		return $this->nombreCategoria;
	}
	
	function setDescripcionCategoria($descripcionCategoria){
		$this->descripcionCategoria = $descripcionCategoria;
	}
	
	function getDescripcionCategoria(){
		return $this->descripcionCategoria;
	}
	
	function setEditableCategoria($editableCategoria){
		$this -> editableCategoria = $editableCategoria;
	}
	
	function getEditableCategoria(){
		return $this -> editableCategoria;
	}
}
?>