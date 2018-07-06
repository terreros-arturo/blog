<?php
	require_once("../bo/EntradaBO.php");
	require_once("../bo/UsuarioBO.php");
	require_once("../util/utils.php");
	
	//require_once("../php/JsonUtil.php");
	session_start();
	session_regenerate_id();
	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
		$accion =  $_POST["accion"];
		$nick = isset($_POST["nick"]) ? $_POST["nick"]: "";
		$password = isset($_POST["password"]) ? $_POST["password"]: "";
		$nuevoPassword = isset($_POST["nuevoPassword"])? $_POST["nuevoPassword"]: "";
		echo(execute($accion, $nick, $password, $nuevoPassword));
	}else{
		header('Location: ../vista/index.php');
	}
	
	function execute($accion, $nick, $password, $nuevoPassword){
		$variableRetorno['error'] = false;
		switch($accion){
			case "login" :{
				$variableRetorno['exito'] = loginUsuario($nick, $password);
			}break;
			case "logout":{
				$variableRetorno['exito'] = logoutUsuario();
			}break;
			case "cambioPassword":{
				$variableRetorno['exito'] = cambiarPassword($nick, $password, $nuevoPassword);
			}break;
			default: {
				$variableRetorno['msg'] = 'Error grave';
			}break;
		}
		return json_encode($variableRetorno);
	}
	
	function loginUsuario($nick, $password){
		$exito = false;
		$usuarioBO = new UsuarioBO();
		if(nickValido($nick)){
			$usuario = $usuarioBO -> loginUsuario($nick, $password);
			if($usuario != null){
				$_SESSION['idUsuario'] = $usuario -> getIdUsuario();
				$_SESSION['nickUsuario'] = $usuario ->getNickUsuario();
				$exito = true;
			}
		}
		return $exito;
	}
	
	function logoutUsuario(){
		return session_destroy();
	}
	
	function cambiarPassword($nick, $password, $nuevoPassword){
		$idUsuario = $nick;
		$exito = false;
		$usuarioBO = new UsuarioBO();
		$exito = $usuarioBO -> cambiaPassword($idUsuario, $password, $nuevoPassword);
		return $exito;
	}
?>