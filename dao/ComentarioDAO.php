<?php

require_once("DaoFactory.php");
require_once("../vo/Comentario.php");

class ComentarioDAO extends DaoFactory{

	function __construct(){
		parent::__construct();
	}
	
	public function obtenNumeroComentariosEntrada($idEntrada){
		$numeroComentarios;
		$conexion = parent:: abrirConexionBaseDatos();
		$strQuery = "SELECT count(*) as numCom FROM comentario WHERE id_ent_com = " . $idEntrada;
		$resultado = parent::select($conexion, $strQuery);
		$numeroComentarios = parent:: getRegistro($resultado);
		parent:: cerrarConexionBaseDatos($conexion);
		return $numeroComentarios[0];
	}
	
	public function obtenComentariosEntradaActiva($idEntrada){
		$conexion = parent:: abrirConexionBaseDatos();
		$strQuery = "SELECT comentario.id_com, comentario.id_ent_com, "
					. " DATE_FORMAT(comentario.fec_com, '%e-%m-%Y a las %r'), "
					. " comentario.con_com, comentario.nom_com, comentario.cor_com, "
					. " comentario.web_com, comentario.ip_com "
					. " FROM comentario INNER JOIN entrada ON comentario.id_ent_com = entrada.id_ent " 
					. " WHERE id_ent_com = " . $idEntrada . " AND entrada.act_ent = 1 "
					. " ORDER BY fec_com DESC";
		$resultado = parent::select($conexion, $strQuery);
		$arrayComentarios = array();
		while(($registro = parent:: getRegistro($resultado)) != null){
			$comentario = new Comentario();
			$comentario -> setIdComentario($registro[0]);
			$comentario -> setIdEntradaComentario($registro[1]);
			$comentario -> setFechaComentario($registro[2]);
			$comentario -> setContenidoComentario($registro[3]);
			$comentario -> setNombreComenta($registro[4]);
			$comentario -> setCorreoComenta($registro[5]);
			$comentario -> setWebComenta($registro[6]);
			$comentario -> setIpComenta($registro[7]);
			array_push($arrayComentarios, $comentario);
		}
		parent:: cerrarConexionBaseDatos($conexion);
		return $arrayComentarios;
	}
	
	public function obtenComentariosEntrada($idEntrada){
		$conexion = parent:: abrirConexionBaseDatos();
		$strQuery = "SELECT id_com, id_ent_com, DATE_FORMAT(fec_com, '%e-%m-%Y a las %r'), con_com, nom_com, cor_com, web_com, ip_com " . 
					" FROM comentario WHERE id_ent_com = " . $idEntrada .
					" ORDER BY fec_com DESC";
		$resultado = parent::select($conexion, $strQuery);
		$arrayComentarios = array();
		while(($registro = parent:: getRegistro($resultado)) != null){
			$comentario = new Comentario();
			$comentario -> setIdComentario($registro[0]);
			$comentario -> setIdEntradaComentario($registro[1]);
			$comentario -> setFechaComentario($registro[2]);
			$comentario -> setContenidoComentario($registro[3]);
			$comentario -> setNombreComenta($registro[4]);
			$comentario -> setCorreoComenta($registro[5]);
			$comentario -> setWebComenta($registro[6]);
			$comentario -> setIpComenta($registro[7]);
			array_push($arrayComentarios, $comentario);
		}
		parent:: cerrarConexionBaseDatos($conexion);
		return $arrayComentarios;
	}
	
	public function almacenaComentario($comentario){
		$exito = false;
		$conexion = parent:: abrirConexionBaseDatos();
		$strQuery = "INSERT INTO comentario (id_com, id_ent_com, fec_com, con_com, nom_com, cor_com, web_com, ip_com) " . 
					" VALUES( ".
					" NULL, ".
					$comentario -> getIdEntradaComentario() .", ".
					" CURRENT_TIMESTAMP, ".
					"'". $comentario -> getContenidoComentario() ."', ".
					"'". $comentario -> getNombreComenta() . "', ".
					"'". $comentario -> getCorreoComenta() ."', ".
					"'". $comentario -> getWebComenta() ."', ".
					"'". $comentario -> getIpComenta() ."'".
					" )";
		$exito = parent::insertOrUpdate($conexion, $strQuery);
		if($exito)
			$exito = parent::commit($conexion);
		parent:: cerrarConexionBaseDatos($conexion);
		return $exito;
	}
	
	public function eliminarComentario($idComentario){
		$exito = false;
		$conexion = parent:: abrirConexionBaseDatos();
		$strQuery = "DELETE from comentario " . 
					" WHERE id_com = ". $idComentario;
		$exito = parent::insertOrUpdate($conexion, $strQuery);
		if($exito)
			$exito = parent::commit($conexion);
		parent:: cerrarConexionBaseDatos($conexion);
		return $exito;
	}
}
?>