<?php
require_once("DaoFactory.php");
require_once ("../vo/Entrada.php");


class EntradaDAO extends DaoFactory{
	function __construct(){
		parent::__construct();
	}
	
	public function obtenEntradas(){
		$conexion = parent::abrirConexionBaseDatos();
		$strQuery = "SELECT * FROM entrada ORDER BY fec_ent DESC, id_ent DESC";
		$arrayEntradas = array();
		$resultado = parent::select($conexion, $strQuery);
		while(($registro = parent::getRegistro($resultado)) != null){
			$entrada = new Entrada();
			$entrada -> setIdEntrada($registro[0]);
			$entrada -> setIdUsuarioEntrada($registro[1]);
			$entrada -> setFechaEntrada($registro[2]);
			$entrada -> setIpPublica($registro[3]);
			$entrada -> setTituloEntrada($registro[4]);
			$entrada -> setContenidoEntrada($registro[5]);
			$entrada -> setArchivoEntrada($registro[6]);
			$entrada -> setEntradaActiva($registro[7]);
			$entrada -> setIdCategoriaEntrada($registro[8]);
			array_push($arrayEntradas, $entrada);
		}
		var_dump($arrayEntradas);
		parent::cerrarConexionBaseDatos($conexion);
		return($arrayEntradas);
	}
	
	public function obtenNumeroEntradasActivas(){
		$conexion = parent::abrirConexionBaseDatos();
		$strQuery = "SELECT COUNT(*) as numEnt FROM entrada WHERE act_ent = 1";
		$resultado = parent:: select($conexion, $strQuery);
		$registro = parent:: getRegistro($resultado);
		$numeroEntradas = $registro[0];
		parent::cerrarConexionBaseDatos($conexion);
		return $numeroEntradas;
	}
	
	public function obtenNumeroEntradas(){
		$conexion = parent::abrirConexionBaseDatos();
		$strQuery = "SELECT COUNT(*) as numEnt FROM entrada";
		$resultado = parent:: select($conexion, $strQuery);
		$registro = parent:: getRegistro($resultado);
		$numeroEntradas = $registro[0];
		parent::cerrarConexionBaseDatos($conexion);
		return $numeroEntradas;
	}
	
	
	public function obtenNumeroEntradasCategoriaActivas($idCategoria){
		$conexion = parent::abrirConexionBaseDatos();
		$strQuery = "SELECT COUNT(*) as numEnt FROM entrada ".
					 " WHERE id_cat_ent = ". $idCategoria .
					 " AND act_ent = 1";
		$resultado = parent:: select($conexion, $strQuery);
		$registro = parent:: getRegistro($resultado);
		$numeroEntradas = $registro[0];
		parent::cerrarConexionBaseDatos($conexion);
		return $numeroEntradas;
	}
	
	public function obtenNumeroEntradasCategoria($idCategoria){
		$conexion = parent::abrirConexionBaseDatos();
		$strQuery = "SELECT COUNT(*) as numEnt FROM entrada ".
					 " WHERE id_cat_ent = ". $idCategoria;
		$resultado = parent:: select($conexion, $strQuery);
		$registro = parent:: getRegistro($resultado);
		$numeroEntradas = $registro[0];
		parent::cerrarConexionBaseDatos($conexion);
		return $numeroEntradas;
	}
	
	public function obtenRangoEntradasActivas($entradaInicial, $numeroEntradas){
		$conexion = parent::abrirConexionBaseDatos();
		$strQuery = "SELECT id_ent, id_usu_ent, DATE_FORMAT(fec_ent, '%e-%m-%Y a las %r'), ip_ent, tit_ent, con_ent, arc_ent, act_ent, id_cat_ent FROM entrada "
					."WHERE act_ent = 1 "
					."ORDER BY fec_ent DESC, id_ent DESC "
					."LIMIT ". $entradaInicial . ", " . $numeroEntradas;
		$resultado = parent:: select($conexion, $strQuery);
		$arrayEntradas = array();
		while(($registro = parent:: getRegistro($resultado)) != null){
			$entrada = new Entrada();
			$entrada -> setIdEntrada($registro[0]);
			$entrada -> setIdUsuarioEntrada($registro[1]);
			$entrada -> setFechaEntrada($registro[2]);
			$entrada -> setIpPublica($registro[3]);
			$entrada -> setTituloEntrada($registro[4]);
			$entrada -> setContenidoEntrada($registro[5]);
			$entrada -> setArchivoEntrada($registro[6]);
			$entrada -> setEntradaActiva($registro[7]);
			$entrada -> setIdCategoriaEntrada($registro[8]);
			array_push($arrayEntradas, $entrada);
		}
		parent::cerrarConexionBaseDatos($conexion);
		return $arrayEntradas;
	}
	
	
	public function obtenRangoEntradas($entradaInicial, $numeroEntradas){
		$conexion = parent::abrirConexionBaseDatos();
		$strQuery = "SELECT id_ent, id_usu_ent, DATE_FORMAT(fec_ent, '%e-%m-%Y a las %r'), ip_ent, tit_ent, con_ent, arc_ent, act_ent, id_cat_ent FROM entrada "
					."ORDER BY fec_ent DESC, id_ent DESC "
					."LIMIT ". $entradaInicial . ", " . $numeroEntradas;
		$resultado = parent:: select($conexion, $strQuery);
		$arrayEntradas = array();
		while(($registro = parent:: getRegistro($resultado)) != null){
			$entrada = new Entrada();
			$entrada -> setIdEntrada($registro[0]);
			$entrada -> setIdUsuarioEntrada($registro[1]);
			$entrada -> setFechaEntrada($registro[2]);
			$entrada -> setIpPublica($registro[3]);
			$entrada -> setTituloEntrada($registro[4]);
			$entrada -> setContenidoEntrada($registro[5]);
			$entrada -> setArchivoEntrada($registro[6]);
			$entrada -> setEntradaActiva($registro[7]);
			$entrada -> setIdCategoriaEntrada($registro[8]);
			array_push($arrayEntradas, $entrada);
		}
		parent::cerrarConexionBaseDatos($conexion);
		return $arrayEntradas;
	}
	
	public function obtenEntradaId($idEntrada){
		$conexion = parent::abrirConexionBaseDatos();
		$strQuery = "SELECT id_ent, id_usu_ent, DATE_FORMAT(fec_ent, '%e-%m-%Y a las %r'), "
					." ip_ent, tit_ent, con_ent, arc_ent, act_ent, id_cat_ent "
					." FROM entrada "
					." WHERE id_ent = ". $idEntrada;
		$resultado = parent:: select($conexion, $strQuery);
		$registro = parent:: getRegistro($resultado);
		$entrada = new Entrada();
		$entrada -> setIdEntrada($registro[0]);
		$entrada -> setIdUsuarioEntrada($registro[1]);
		$entrada -> setFechaEntrada($registro[2]);
		$entrada -> setIpPublica($registro[3]);
		$entrada -> setTituloEntrada($registro[4]);
		$entrada -> setContenidoEntrada($registro[5]);
		$entrada -> setArchivoEntrada($registro[6]);
		$entrada -> setEntradaActiva($registro[7]);
		$entrada -> setIdCategoriaEntrada($registro[8]);
		
		parent::cerrarConexionBaseDatos($conexion);
		return $entrada;
	}
	
	public function obtenEntradaIdActiva($idEntrada){
		$conexion = parent::abrirConexionBaseDatos();
		$strQuery = "SELECT id_ent, id_usu_ent, DATE_FORMAT(fec_ent, '%e-%m-%Y a las %r'), "
					." ip_ent, tit_ent, con_ent, arc_ent, act_ent, id_cat_ent "
					." FROM entrada "
					." WHERE act_ent = 1 and id_ent = ". $idEntrada;
		$resultado = parent:: select($conexion, $strQuery);
		$registro = parent:: getRegistro($resultado);
		$entrada = new Entrada();
		$entrada -> setIdEntrada($registro[0]);
		$entrada -> setIdUsuarioEntrada($registro[1]);
		$entrada -> setFechaEntrada($registro[2]);
		$entrada -> setIpPublica($registro[3]);
		$entrada -> setTituloEntrada($registro[4]);
		$entrada -> setContenidoEntrada($registro[5]);
		$entrada -> setArchivoEntrada($registro[6]);
		$entrada -> setEntradaActiva($registro[7]);
		$entrada -> setIdCategoriaEntrada($registro[8]);

		parent::cerrarConexionBaseDatos($conexion);
		return $entrada;
	}
	
	public function obtenRangoEntradasCategoriaActivas($entradaInicial, $numeroEntradas, $idCategoria){
		$conexion = parent::abrirConexionBaseDatos();
		$strQuery = "SELECT id_ent, id_usu_ent, DATE_FORMAT(fec_ent, '%e-%m-%Y a las %r'), ip_ent, tit_ent, con_ent, arc_ent, act_ent, id_cat_ent FROM entrada"
					." WHERE act_ent = 1"
					." AND id_cat_ent = ". $idCategoria
					." ORDER BY fec_ent DESC, id_ent DESC"
					." LIMIT ". $entradaInicial . ", " . $numeroEntradas;
		$resultado = parent:: select($conexion, $strQuery);
		$arrayEntradas = array();
		while(($registro = parent:: getRegistro($resultado)) != null){
			$entrada = new Entrada();
			$entrada -> setIdEntrada($registro[0]);
			$entrada -> setIdUsuarioEntrada($registro[1]);
			$entrada -> setFechaEntrada($registro[2]);
			$entrada -> setIpPublica($registro[3]);
			$entrada -> setTituloEntrada($registro[4]);
			$entrada -> setContenidoEntrada($registro[5]);
			$entrada -> setArchivoEntrada($registro[6]);
			$entrada -> setEntradaActiva($registro[7]);
			$entrada -> setIdCategoriaEntrada($registro[8]);
			array_push($arrayEntradas, $entrada);
		}
		parent::cerrarConexionBaseDatos($conexion);
		return $arrayEntradas;
	}
	
	public function obtenRangoEntradasCategoria($entradaInicial, $numeroEntradas, $idCategoria){
		$conexion = parent::abrirConexionBaseDatos();
		$strQuery = "SELECT id_ent, id_usu_ent, DATE_FORMAT(fec_ent, '%e-%m-%Y a las %r'), ip_ent, tit_ent, con_ent, arc_ent, act_ent, id_cat_ent FROM entrada"
					." WHERE id_cat_ent = ". $idCategoria
					." ORDER BY fec_ent DESC, id_ent DESC"
					." LIMIT ". $entradaInicial . ", " . $numeroEntradas;
		$resultado = parent:: select($conexion, $strQuery);
		$arrayEntradas = array();
		while(($registro = parent:: getRegistro($resultado)) != null){
			$entrada = new Entrada();
			$entrada -> setIdEntrada($registro[0]);
			$entrada -> setIdUsuarioEntrada($registro[1]);
			$entrada -> setFechaEntrada($registro[2]);
			$entrada -> setIpPublica($registro[3]);
			$entrada -> setTituloEntrada($registro[4]);
			$entrada -> setContenidoEntrada($registro[5]);
			$entrada -> setArchivoEntrada($registro[6]);
			$entrada -> setEntradaActiva($registro[7]);
			$entrada -> setIdCategoriaEntrada($registro[8]);
			array_push($arrayEntradas, $entrada);
		}
		parent::cerrarConexionBaseDatos($conexion);
		return $arrayEntradas;
	}
	
	public function nuevaEntrada($entrada){
		$exito = false;
		$conexion = parent:: abrirConexionBaseDatos();
		$strQuery = "INSERT INTO entrada (id_ent, id_usu_ent, fec_ent, ip_ent, tit_ent, con_ent, arc_ent, act_ent, id_cat_ent)" .
					" VALUES ( ".
					" NULL, " .
					$entrada -> getIdUsuarioEntrada() . ", " .
					" CURRENT_TIMESTAMP, ".
					"'" . $entrada -> getIpPublica() . "', ".
					"'" . $entrada -> getTituloEntrada() . "', ".
					"'" . $entrada -> getContenidoEntrada(). "', ".
					"'" . $entrada -> getArchivoEntrada() . "', ".
					$entrada -> getEntradaActiva() . ", ".
					$entrada -> getIdCategoriaEntrada().
					")";
		$exito = parent::insertOrUpdate($conexion, $strQuery);
		if($exito)
			$exito = parent::commit($conexion);
		return $exito;
	}
	
	public function modificarEntrada($entrada){
		$exito = false;
		$conexion = parent:: abrirConexionBaseDatos();
		$strQuery = "UPDATE entrada ".
					" SET ip_ent ='". $entrada -> getIpPublica(). "',".
					" tit_ent = '" . $entrada -> getTituloEntrada() . "', ".
					" con_ent = '" . $entrada -> getContenidoEntrada(). "', ".
					" arc_ent = '" . $entrada -> getArchivoEntrada() . "', ".
					" act_ent = ". $entrada -> getEntradaActiva() . ", ".
					" id_cat_ent = ". $entrada -> getIdCategoriaEntrada() .
					" WHERE id_ent = ". $entrada -> getIdEntrada();
		$exito = parent::insertOrUpdate($conexion, $strQuery);
		if($exito)
			$exito = parent::commit($conexion);
		return $exito;
	}
}
?>