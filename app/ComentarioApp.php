<?php
	require_once("../bo/ComentarioBO.php");
	require_once("../util/utils.php");
	
	//require_once("../php/JsonUtil.php");
	session_start();
	session_regenerate_id();
	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
		$accion =  $_POST["accion"];
		$comentario = isset($_POST["comentario"]) ? $_POST["comentario"]: "";
		echo(execute($accion, $comentario));
	}else{
		header('Location: ../vista/index.php');
	}
	
	function execute($accion, $comentario){
		$variableRetorno['error'] = false;
		switch($accion){
			case "eliminar" :{
				$variableRetorno['exito'] = eliminarComentario($comentario);
			}break;
			default: {
				$variableRetorno['msg'] = 'Error grave';
			}break;
		}
		return json_encode($variableRetorno);
	}
	
	function eliminarComentario($comentario){
		$exito = true;
		$comentarioBO = new ComentarioBO();
		$exito = $comentarioBO -> eliminarComentario($comentario);
		return $exito;
	}
?>