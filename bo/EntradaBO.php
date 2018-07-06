<?php
require_once("../dao/EntradaDAO.php");

class EntradaBO{
	private $entradaDAO;
	
	public function __construct(){
		$this -> entradaDAO = new EntradaDAO();
	}

	public function obtenEntradaIdActiva($idEntrada){
		return $this -> entradaDAO -> obtenEntradaIdActiva($idEntrada);
	}
	
	public function obtenEntradaId($idEntrada){
		return $this -> entradaDAO -> obtenEntradaId($idEntrada);
	}
	
	public function obtenPaginasTotalesEntradasActivas($entradasPorPagina){
		$numeroEntradas = $this -> entradaDAO -> obtenNumeroEntradasActivas();
		$numeroPaginas = ceil((float)$numeroEntradas /$entradasPorPagina);
		return $numeroPaginas;
	}
	
	public function obtenPaginasTotalesEntradasCategoriaActivas($entradasPorPagina, $idCategoria){
		$numeroEntradas = $this -> entradaDAO -> obtenNumeroEntradasCategoriaActivas($idCategoria);
		$numeroPaginas = ceil((float)$numeroEntradas /$entradasPorPagina);
		return $numeroPaginas;
	}
	
	public function obtenTotalEntradasActivas($entradasPorPagina){
		return $this -> entradaDAO -> obtenNumeroEntradasActivas();
	}
	
	public function obtenTotalEntradas($entradasPorPagina){
		return $this -> entradaDAO -> obtenNumeroEntradas();
	}
	
	public function obtenTotalEntradasCategoriaActivas($entradasPorPagina, $idCategoria){
		return $this -> entradaDAO -> obtenNumeroEntradasCategoriaActivas($idCategoria);
	}
	
	public function obtenTotalEntradasCategoria($entradasPorPagina, $idCategoria){
		return $this -> entradaDAO -> obtenNumeroEntradasCategoria($idCategoria);
	}
	public function obtenEntradasActivasPagina($paginaSolicitada, $entradasPorPagina){
		$entradaInicial = $entradasPorPagina * ($paginaSolicitada - 1);
		$arrayEntradas = $this -> entradaDAO -> obtenRangoEntradasActivas($entradaInicial, $entradasPorPagina);
		return $arrayEntradas;
	}
	
	public function obtenEntradasPagina($paginaSolicitada, $entradasPorPagina){
		$entradaInicial = $entradasPorPagina * ($paginaSolicitada - 1);
		$arrayEntradas = $this -> entradaDAO -> obtenRangoEntradas($entradaInicial, $entradasPorPagina);
		return $arrayEntradas;
	}
	
	public function obtenEntradasCategoriaActivasPagina($paginaSeleccionada, $entradasPorPagina, $idCategoria){
		$entradaInicial = $entradasPorPagina * ($paginaSeleccionada - 1);
		$arrayEntradas = $this -> entradaDAO -> obtenRangoEntradasCategoriaActivas($entradaInicial, $entradasPorPagina, $idCategoria);
		return $arrayEntradas;
	}
	
	public function obtenEntradasCategoriaPagina($paginaSeleccionada, $entradasPorPagina, $idCategoria){
		$entradaInicial = $entradasPorPagina * ($paginaSeleccionada - 1);
		$arrayEntradas = $this -> entradaDAO -> obtenRangoEntradasCategoria($entradaInicial, $entradasPorPagina, $idCategoria);
		return $arrayEntradas;
	}
	
	/*Persistencia*/
	public function nuevaEntrada($entrada){
	   return $this -> entradaDAO -> nuevaEntrada($entrada);
	}
	
	public function modificarEntrada($entrada){
	   return $this -> entradaDAO -> modificarEntrada($entrada);
	}
}
?>