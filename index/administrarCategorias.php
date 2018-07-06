<?php
	session_start();
	session_regenerate_id();
	require_once("../bo/CategoriaBO.php");
	require_once("../bo/ModuloBO.php");
	require_once("../util/utils.php");
	
	$categoriaBO = new CategoriaBO();
	
	$usuarioLogueado = isset($_SESSION['idUsuario']) && isset($_SESSION['nickUsuario']) && $_SESSION['idUsuario']!= "" && $_SESSION['nickUsuario']!= ""? true: false;
	if($usuarioLogueado){
		$moduloActual = basename($_SERVER['REQUEST_URI']);
		$moduloBO = new ModuloBO();
		$listaModulos = $moduloBO -> obtenModulosPrivilegios($_SESSION['idUsuario']);
		//Comparar archivo de url con el permiso que tenga el usuario logueado
		$moduloEncontrado = false;
		foreach($listaModulos as $modulo)
			if($modulo -> getNombreUrlModulo() == $moduloActual)
				$moduloEncontrado = true;
		if($moduloEncontrado){
			/*Nos traemos todas las categorias y las presentamos para crear un grid en el que se incluya el abc*/
			$listaCategorias = $categoriaBO -> obtenCategorias();
?>
<html>
	<head>
	<title>Blog</title>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO 8859-1" />
		<link  rel="shortcut icon" href="../img/favicon.ico"/>
		<link type = "text/css" rel = "stylesheet" href = "../libs/jPaginate/css/style.css"/>
		<link type = "text/css" rel = "stylesheet" href = "../css/estilos.css"/>
		<script type = "text/javascript" src="../libs/jquery/jquery-1.6.2.min.js"> </script>
		<script type = "text/javascript" src="../libs/jPaginate/jquery.paginate.js"> </script>
		<script type = "text/javascript" src="../libs/jquery-ui-1.8.15.custom/development-bundle/ui/minified/jquery.effects.core.min.js"></script>
		<script type = "text/javascript" src="../libs/jquery-ui-1.8.15.custom/development-bundle/ui/minified/jquery.effects.bounce.min.js"></script>
		<script type = "text/javascript" src="../libs/jquery-ui-1.8.15.custom/development-bundle/ui/minified/jquery.effects.pulsate.min.js"></script>
		<!--
		<script src="../libs/jquery-ui-1.8.15.custom/development-bundle/ui/minified/jquery.effects.drop.min.js"></script>
		<script src="../libs/jquery-ui-1.8.15.custom/development-bundle/ui/minified/jquery.effects.slide.min.js"></script>
		<script src="../libs/jquery-ui-1.8.15.custom/development-bundle/ui/minified/jquery.effects.blind.min.js"></script>
		<script src="../libs/jquery-ui-1.8.15.custom/development-bundle/ui/minified/jquery.effects.clip.min.js"></script>
		<script src="../libs/jquery-ui-1.8.15.custom/development-bundle/ui/minified/jquery.effects.fold.min.js"></script>
		<script src="../libs/jquery-ui-1.8.15.custom/development-bundle/ui/minified/jquery.effects.highlight.min.js"></script>
		<script src="../libs/jquery-ui-1.8.15.custom/development-bundle/ui/minified/jquery.effects.scale.min.js"></script>
		<script src="../libs/jquery-ui-1.8.15.custom/development-bundle/ui/minified/jquery.effects.shake.min.js"></script>-->	
		
		<script language ="Javascript" type = "text/javascript"> 
			$(document).ready(function(){
				$(".menu li").hover(function(){
					$(this).find('ul:first:hidden').css({visibility: "visible",display: "none"}).slideDown(400);
				},function(){
					$(this).find('ul:first').slideUp(400);
				});
				$(".menu ul.submenu ").css({display: "none"});
				$(".menu li").click(function(){
					if($(this).find('ul:first').css("display") === "block") $(this).find('ul:first').slideUp(400);
					else $(this).find('ul:first:hidden').css({visibility: "visible",display: "none"}).slideDown(400);
				});
				
				
				$(".formulario").css("display","none");
			});
			
			function cerrarSesion(){
				$.ajax({
					type: "POST",
					url: "../app/LoginApp.php",
					dataType: "json",
					data: { accion : "logout" },
					success:function(resultado){
						if(resultado.error != true){
							if(resultado.exito == true){ document.location = '.';}
							else{ alert("Error: No se pudo cerrar la sesion");}
						}
					},
					error:function(){}
				});
			}
			
			function cancelar(){
				$(".formulario").slideUp();
				$("#nueva").show();
			}
			
			function guardar(){
				//nos preguntamos primero si es modificar o crear
			}
			
			function eliminarCategoria(){
			
			}
			
			function nuevaCategoria(){
				$("#tituloFormulario").html("Crear categoria");
				$("#guardar").html("Generar");
				$("#nueva").hide();
				$(".formulario").slideDown();
			}
			
			function editarCategoria(){
				$("#tituloFormulario").html("Modifcar categoria");
				$("#guardar").html("Modificar");
				$("#nueva").hide();
				$(".formulario").slideDown();
			}
		   
		</script>
		<style>
			#nueva{
				width: 200px;
				color: #fff;
				text-decoration: overline;
				
			}
			.tablaABC *{
				font-size: 15px;
			}
			
		</style>
	</head>
	<body>
		<div id="contenido">
			<div id ="cabecera"> <?php include_once("cabecera.php"); ?> </div>
			<div id="contenidoCentral">
				
				<?php
					echo("<table class=\"tablaABC\">");
					echo("<tr><th>Categoria</th><th>Descripcion</th><th>Acciones</th></tr>");
					foreach($listaCategorias as $categoria){
						echo("<tr>");
						echo("<td>". $categoria -> getNombreCategoria() ."</td>");
						echo("<td>". $categoria -> getDescripcionCategoria()."</td>");
						echo("<td>");
						if($categoria -> getEditableCategoria()){
							echo("<span><a href =\"javascript:editarCategoria(".$categoria ->getIdCategoria().")\">Editar</a></span>");
							echo("<span><a href =\"javascript:eliminarCategoria()\">Borrar</a></span>");
						}
						echo("</td>");
						echo("</tr>");
					}
					echo("</table>");
				?>
			</div>
			<div id="columnaSecundaria">
				<span><a id="nueva" href= "javascript:nuevaCategoria()">Nueva categoria</a></span>
				<div class="formulario">
					<h3 id="tituloFormulario">Nueva categoria</h3>
					<table>
						<tr><td>Nombre categoria</td><td><input type="text"/></td></tr>
						<tr><td>Descripcion</td><td><textarea></textarea></td></tr>
						<tr>
							<td><a class="boton" href="javascript:cancelar()">Cancelar</a></td>
							<td><a id="guardar" class="boton" href = "javascript:guardar()">Generar</a></td>
						</tr>
					</table>
				</div>
			</div>
			<div id="pie"> <?php include_once("pie.php"); ?></div>
		</div>
	</body>
</html>
<?php
		}else
			header("Location: .");
	}else
		header("Location: .");
?>