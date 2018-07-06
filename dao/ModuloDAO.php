<?php

require_once("DaoFactory.php");
require_once("../vo/Modulo.php");

class ModuloDAO extends DaoFactory{
	
	function __construct(){
		parent::__construct();
	}
	
	public function obtenModulosPrivilegios($idUsuario){
		$conexion = parent:: abrirConexionBaseDatos();
		$strQuery = "SELECT modu.id_mod, modu.nom_mod, modu.des_mod, modu.nom_url_mod ".
					"FROM usuario usu INNER JOIN ( ".
						"tipo_usuario tipo_usu INNER JOIN ( ".
							"privilegio pri INNER JOIN modulo modu ON pri.id_mod_pri = modu.id_mod ".
						") ON tipo_usu.id_tip_usu = pri.id_tip_usu_pri ".
					") ON usu.id_tip_usu_usu = tipo_usu.id_tip_usu ". 
					"WHERE usu.id_usu = ". $idUsuario . " AND usu.act_usu = 1 AND usu.nue_usu = 0";
		$resultado = parent::select($conexion, $strQuery);
		$arrayModulos = array();
		while(($registro = parent:: getRegistro($resultado)) != null){
			$modulo = new Modulo();
			$modulo -> setIdModulo($registro[0]);
			$modulo -> setNombreModulo($registro[1]);
			$modulo -> setDescripcionModulo($registro[2]);
			$modulo -> setNombreUrlModulo($registro[3]);
			array_push($arrayModulos, $modulo);
		}
		parent:: cerrarConexionBaseDatos($conexion);
		return $arrayModulos;
	}
}
?>