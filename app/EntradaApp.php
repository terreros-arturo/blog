<?php
	require_once("../bo/EntradaBO.php");
	require_once("../bo/UsuarioBO.php");
	require_once("../util/utils.php");
	
	//require_once("../php/JsonUtil.php");
	session_start();
	session_regenerate_id();
	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
		$accion =  $_POST["accion"];
		$entrada = isset($_POST["entrada"]) ? $_POST["entrada"]: "";
		echo(execute($accion, $entrada));
	}else{
		header('Location: ../vista/index.php');
	}
	
	function execute($accion, $entrada){
		$variableRetorno['error'] = false;
		switch($accion){
			case "nuevaEntrada":{
				$variableRetorno['exito'] = nuevaEntrada($entrada);
			}break;
			case "modificarEntrada":{
				$variableRetorno['exito'] = modificarEntrada($entrada);
			}break;
			default: {
				$variableRetorno['msg'] = 'Error grave';
			}break;
		}
		return json_encode($variableRetorno);
	}
	
	function nuevaEntrada($entrada){
		$exito = false;
		$nuevaEntrada = new Entrada();
		$nuevaEntrada -> setIdUsuarioEntrada($entrada['idUsuarioEntrada']);
		$nuevaEntrada -> setIpPublica($entrada['ipPublica']);
		$nuevaEntrada -> setTituloEntrada($entrada['tituloEntrada']);
		$nuevaEntrada -> setContenidoEntrada($entrada['contenidoEntrada']);
		$nuevaEntrada -> setEntradaActiva($entrada['entradaActiva']);
		$nuevaEntrada -> setIdCategoriaEntrada($entrada['idCategoriaEntrada']);
		//var_dump($nuevaEntrada);
		$entradaBO = new EntradaBO();
		$exito = $entradaBO -> nuevaEntrada($nuevaEntrada);
		return $exito;
	}
	
	function modificarEntrada($entrada){
		$exito = true;
		$entradaModificar = new Entrada();
		$entradaModificar -> setIdEntrada($entrada['idEntrada']);
		$entradaModificar -> setFechaEntrada($entrada['fechaEntrada']);
		$entradaModificar -> setIdUsuarioEntrada($entrada['idUsuarioEntrada']);
		$entradaModificar -> setIpPublica($entrada['ipPublica']);
		$entradaModificar -> setTituloEntrada($entrada['tituloEntrada']);
		$entradaModificar -> setContenidoEntrada($entrada['contenidoEntrada']);
		$entradaModificar -> setEntradaActiva($entrada['entradaActiva']);
		$entradaModificar -> setIdCategoriaEntrada($entrada['idCategoriaEntrada']);
		//var_dump($entradaModificar);
		$entradaBO = new EntradaBO();
		$exito = $entradaBO -> modificarEntrada($entradaModificar);
		return $exito;
	}
?>