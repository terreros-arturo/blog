<?php
require_once("../dao/ComentarioDAO.php");
require_once("../dao/EntradaDAO.php");
require_once("../dao/UsuarioDAO.php");
require_once("../util/Correo.php");

class ComentarioBO{
	private $comentarioDAO;
	private $entradaDAO;
	private $usuarioDAO;
	
	public function __construct(){
		$this -> comentarioDAO = new ComentarioDAO();
		$this -> entradaDAO = new EntradaDAO();
		$this -> usuarioDAO = new UsuarioDAO();
	}

	public function obtenComentarios(){
		return $this -> comentarioDAO -> obtenComentarios();
	}

	public function obtenComentariosEntradaActiva($idEntrada){
		return $this -> comentarioDAO -> obtenComentariosEntradaActiva($idEntrada);
	}
	
	public function obtenComentariosEntrada($idEntrada){
		return $this -> comentarioDAO -> obtenComentariosEntrada($idEntrada);
	}
	
	public function obtenNumeroComentariosEntrada($idEntrada){
		return $this -> comentarioDAO -> obtenNumeroComentariosEntrada($idEntrada);
	}
	
	/*Persistencia*/
	/*Allacena el comentario y también envia correo al que lo escribe y al que escribio el post*/
	public function almacenaComentario($comentario){
		$comentarioAlmacenado = false;
		$correoEnviado = false;
		
		$entrada = $this -> entradaDAO -> obtenEntradaId($comentario -> getIdEntradaComentario());
		$usuario = $this -> usuarioDAO -> obtenUsuarioId($entrada -> getIdUsuarioEntrada());
		
		if($usuario -> getCorreoUsuario() != $comentario -> getCorreoComenta()){
			//enviar correo a quien publico comentario
			$correoComenta = new Correo();
			$correoComenta -> setPara($comentario -> getCorreoComenta());
			$correoEnviado = $correoComenta -> enviaCorreoComentadorComentario($comentario -> getContenidoComentario());
			$correoComentador = $correoEnviado? $comentario -> getCorreoComenta(): "Correo desconocido";
			//enviar correo a el que publico entrada
			$correoColaborador = new Correo();
			$correoColaborador -> setPara($usuario -> getCorreoUsuario());
			$correoEnviado = $correoColaborador -> enviaCorreoColaboradorComentario($comentario -> getCorreoComenta(), $comentario -> getContenidoComentario(), $entrada -> getTituloEntrada());
			if($correoEnviado)
				$comentarioAlmacenado = $this -> comentarioDAO -> almacenaComentario($comentario);
		}
		else{
			$comentarioAlmacenado = $this -> comentarioDAO -> almacenaComentario($comentario);
		}
		return $comentarioAlmacenado;
	}
	
	public function eliminarComentario($idComentario){
		return $this -> comentarioDAO -> eliminarComentario($idComentario);
	}
}
?>