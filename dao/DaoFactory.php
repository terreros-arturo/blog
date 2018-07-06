<?php

class DaoFactory{
	private $strServidor;
	private $strUsuarioMysql;
	private $strPasswordMysql;
	private $strBaseDatos;
	private $numPuerto;
	
	function __construct(){
		$this->strServidor = "localhost";
		$this->strUsuarioMysql = "root";
		$this->strPasswordMysql = "arturo";
		$this->strBaseDatos = "blog";
		$this->numPuerto = 3306;
	}
	
	function abrirConexionBaseDatos(){
		$conexion = @mysqli_connect($this->strServidor, 
									$this->strUsuarioMysql, 
									$this->strPasswordMysql, 
									$this->strBaseDatos, 
									$this->numPuerto)
					or die ("Error: no se pudo conectar a la base de datos");
		@mysqli_set_charset($conexion, "ISO 8859-1");
		return ($conexion);
	}
	
	function cerrarConexionBaseDatos($conexion){
		return @mysqli_close($conexion);
	}
	
	function select($conexion, $strQuery){
		//echo("$strQuery<br/>");
		$resultado = null;
		$registros = Array();
		$resultado = @mysqli_query($conexion, $strQuery);
		return $resultado;
	}
	
	function getRegistro($resultado){
		$registro = null;
		if($resultado != null){
			$registro = @mysqli_fetch_array($resultado, MYSQLI_NUM);
		}
		return $registro;
	}
	
	function insertOrUpdate($conexion, $strQuery){
		//echo($strQuery);
		return @mysqli_query($conexion, $strQuery);
	}
	
	function commit($conexion){
		return @mysqli_commit($conexion);
	}
	
	
	function setStrServidor($strServidor){
		$this->strServidor = $strServidor;
	}
	
	function setStrUsuarioMysql($strUsuarioMysql){
		$this->strUsuarioMysql = $strUsuarioMysql;
	}
	
	function setStrPasswordMysql($strPasswordMysql){
		$this->strPasswordMysql = $strPasswordMysql;
	}
	
	function setStrBaseDatos($strBaseDatos){
		$this->strBaseDatos = $strBaseDatos;
	}
	
	function setNumPuerto($numPuerto){
		$this->numPuerto = $numPuerto;
	}
	
	function getStrServidor(){
		return($this->strServidor);
	}
	
	function getStrUsuarioMysql(){
		return($this->strUsuarioMysql);
	}
	
	function getStrPasswordMysql(){
		return($this->strPasswordMysql);
	}
	
	function getStrBaseDatos(){
		return($this->strBaseDatos);
	}
	
	function getNumPuerto(){
		return($this->numPuerto);
	}
}
?>