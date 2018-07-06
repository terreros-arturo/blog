<?php
require_once("../dao/UsuarioDAO.php");

class UsuarioBO{
	private $usuarioDAO;
	
	public function __construct(){
		$this -> usuarioDAO = new UsuarioDAO();
	}
	
	public function loginUsuario($nick, $password){
		$arrayUsuarios = $this -> usuarioDAO -> obtenUsuarioNick($nick);
		$usuario = null;
		if(count($arrayUsuarios) == 1){
			if(md5($password) == $arrayUsuarios[0] -> getPasswordUsuario()){
				$usuario = new Usuario();
				$usuario = $arrayUsuarios[0];
			}
		}
		return $usuario;
	}
	
	public function obtenUsuarioId($idUsuario){
		$usuario = $this -> usuarioDAO -> obtenUsuarioId($idUsuario);
		return $usuario;
	}
	
	public function obtenNickUsuarioId($idUsuario){
		$nickUsuario = "";
		$usuario = $this -> usuarioDAO -> obtenUsuarioId($idUsuario);
		$nickUsuario = $usuario -> getNickUsuario();
		return $nickUsuario;
	}
	
	public function obtenTodosUsuarios(){
		return $this -> usuarioDAO -> obtenTodosUsuarios();
	}
	
	/*Persistencia*/
	public function cambiaPassword($idUsuario, $password, $nuevoPassword){
		$exito = false;
		$usuario = $this -> usuarioDAO -> obtenUsuarioId($idUsuario);
		if(md5($password) == $usuario -> getPasswordUsuario()){
			$exito = $this -> usuarioDAO -> actualizaPassword($idUsuario, md5($nuevoPassword));
		}
		return $exito;
	}
}
?>