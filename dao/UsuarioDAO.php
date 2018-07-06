<?php
require_once("../vo/Usuario.php");

class UsuarioDAO extends DaoFactory{
	function __construct(){
		parent::__construct();
	}
	
	public function obtenUsuarioId($idUsuario){
		$conexion = parent::abrirConexionBaseDatos();
		$strQuery = "SELECT id_usu, id_tip_usu_usu, nom_usu, ape_usu, nic_usu, " .
					" pas_usu, cor_usu, pai_usu, eli_usu, nue_usu, act_usu FROM usuario ".
					" WHERE id_usu = ". $idUsuario;
		$resultado = parent::select($conexion, $strQuery);
		$registro = parent:: getRegistro($resultado);
		$usuario = new Usuario();
		$usuario -> setIdUsuario($registro[0]);
		$usuario -> setIdTipoUsuario($registro[1]);
		$usuario -> setNomUsuario($registro[2]);
		$usuario -> setApellidosUsuario($registro[3]);
		$usuario -> setNickUsuario($registro[4]);
		$usuario -> setPasswordUsuario($registro[5]);
		$usuario -> setCorreoUsuario($registro[6]);
		$usuario -> setPaisUsuario($registro[7]);
		$usuario -> setEliminarUsuario($registro[8]);
		$usuario -> setNuevoUsuario($registro[9]);
		$usuario -> setActivoUsuario($registro[10]);

		parent::cerrarConexionBaseDatos($conexion);
		return($usuario);
	}
	
	public function obtenUsuarioNick($nick){
		$conexion = parent::abrirConexionBaseDatos();
		$strQuery = "SELECT id_usu, id_tip_usu_usu, nom_usu, ape_usu, nic_usu, " .
					" pas_usu, cor_usu, pai_usu, eli_usu, nue_usu, act_usu FROM usuario ".
					" WHERE nic_usu = '". $nick . "' AND act_usu = 1";
		$resultado = parent::select($conexion, $strQuery);
		$arrayUsuarios = array();
		while(($registro = parent:: getRegistro($resultado)) != null){
			$usuario = new Usuario();
			$usuario -> setIdUsuario($registro[0]);
			$usuario -> setIdTipoUsuario($registro[1]);
			$usuario -> setNomUsuario($registro[2]);
			$usuario -> setApellidosUsuario($registro[3]);
			$usuario -> setNickUsuario($registro[4]);
			$usuario -> setPasswordUsuario($registro[5]);
			$usuario -> setCorreoUsuario($registro[6]);
			$usuario -> setPaisUsuario($registro[7]);
			$usuario -> setEliminarUsuario($registro[8]);
			$usuario -> setNuevoUsuario($registro[9]);
			$usuario -> setActivoUsuario($registro[10]);
			array_push($arrayUsuarios, $usuario);
		}
		parent::cerrarConexionBaseDatos($conexion);
		return($arrayUsuarios);
	}
	
	public function obtenTodosUsuarios(){
		$conexion = parent::abrirConexionBaseDatos();
		$strQuery = "SELECT id_usu, id_tip_usu_usu, nom_usu, ape_usu, nic_usu, " .
					" pas_usu, cor_usu, pai_usu, eli_usu, nue_usu, act_usu FROM usuario";
		$resultado = parent::select($conexion, $strQuery);
		$arrayUsuarios = array();
		while(($registro = parent:: getRegistro($resultado)) != null){
			$usuario = new Usuario();
			$usuario -> setIdUsuario($registro[0]);
			$usuario -> setIdTipoUsuario($registro[1]);
			$usuario -> setNomUsuario($registro[2]);
			$usuario -> setApellidosUsuario($registro[3]);
			$usuario -> setNickUsuario($registro[4]);
			$usuario -> setPasswordUsuario($registro[5]);
			$usuario -> setCorreoUsuario($registro[6]);
			$usuario -> setPaisUsuario($registro[7]);
			$usuario -> setEliminarUsuario($registro[8]);
			$usuario -> setNuevoUsuario($registro[9]);
			$usuario -> setActivoUsuario($registro[10]);
			array_push($arrayUsuarios, $usuario);
		}
		parent::cerrarConexionBaseDatos($conexion);
		return($arrayUsuarios);
	}
	
	public function actualizaPassword($idUsuario, $nuevoPassword){
		$exito = false;
		$conexion = parent:: abrirConexionBaseDatos();
		$strQuery = "UPDATE usuario SET pas_usu = '" . $nuevoPassword . "'". 
					" WHERE id_usu = ". $idUsuario;
		$exito = parent::insertOrUpdate($conexion, $strQuery);
		if($exito)
			$exito = parent::commit($conexion);
		parent:: cerrarConexionBaseDatos($conexion);
		return $exito;
	}

}
?>