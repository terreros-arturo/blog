<?php

require_once("DaoFactory.php");
require_once("../vo/Categoria.php");

class CategoriaDAO extends DaoFactory{
	function __construct(){
		parent::__construct();
	}

	public function obtenCategorias(){
		$conexion = parent:: abrirConexionBaseDatos();
		$strQuery = "SELECT id_cat, nom_cat, des_cat, if(edi_cat = 1, true, false) as edi_cat FROM categoria;";
		$resultado = parent::select($conexion, $strQuery);
		$arrayCategorias = array();
		while(($registro = parent::getRegistro($resultado)) != null){
			$categoria = new Categoria();
			$categoria -> setIdCategoria($registro[0]);
			$categoria -> setNombreCategoria($registro[1]);
			$categoria -> setDescripcionCategoria($registro[2]);
			$categoria -> setEditableCategoria($registro[3]);
			array_push($arrayCategorias, $categoria);
		}
		parent::cerrarConexionBaseDatos($conexion);
		return($arrayCategorias);
	}
}
?>