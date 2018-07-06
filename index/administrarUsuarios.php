<?php
	session_start();
	session_regenerate_id();
	require_once("../bo/ModuloBO.php");
	require_once("../bo/UsuarioBO.php");
	require_once("../bo/CategoriaBO.php");
	require_once("../util/utils.php");
	
	//$categoriaBO = new CategoriaBO();
	
	$usuarioBO = new UsuarioBO();
	
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
			/*Obtenemos lista de usuarios*/
			$listaUsuarios = $usuarioBO -> obtenTodosUsuarios();
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
			
			function nuevoUsuario(){
				$("#nombreUsuario").val("");
				$("#apellidosUsuario").val("");
				$("#nickUsuario").val("");
				$("#nombreUsuario").attr("disabled","disabled");
				$("#apellidosUsuario").attr("disabled","disabled");
				$("#nickUsuario").attr("disabled","disabled");
				$("#tituloFormulario").html("Crear Usuario");
				$("#guardar").html("Crear");
				$("#nueva").hide();
				$(".formulario").slideDown();
			}
			
			function modificarUsuario(idUsuario){
				$("#nombreUsuario").val("");
				$("#apellidosUsuario").val("");
				$("#nickUsuario").val("");
				$("#nombreUsuario").removeAttr("disabled");
				$("#apellidosUsuario").removeAttr("disabled");
				$("#nickUsuario").removeAttr("disabled");
				$("#tituloFormulario").html("Modifcar categoria");
				$("#guardar").html("Modificar");
				$("#nueva").hide();
				$(".formulario").slideDown();
			}
		   
		</script>
		<style>
			#nuevo{ width: 200px; color: #fff; text-decoration: overline;}
			.tablaABC *{ font-size: 12px; }
		</style>
	</head>
	<body>
		<div id="contenido">
			<div id ="cabecera"> <?php include_once("cabecera.php"); ?> </div>
			<div id="contenidoCentral">
				<?php
					echo("<table class=\"tablaABC\">");
					echo("<tr><th>Nombre</th><th>Apellidos</th><th>Nick</th><th>Correo</th><th>Tipo usuario</th><th>Activo</th><th>Acciones</th></tr>");
					foreach($listaUsuarios as $usuario){
						echo("<tr>");
						echo("<td>". $usuario -> getNomUsuario()."</td>");
						echo("<td>". $usuario -> getApellidosUsuario()."</td>");
						echo("<td>". $usuario -> getNickUsuario()."</td>");
						echo("<td>". $usuario -> getCorreoUsuario()."</td>");
						echo("<td>". $usuario -> getIdTipoUsuario()."</td>");
						echo("<td>". $usuario -> getActivoUsuario()."</td>");
						echo("<td>");
							echo("<span><a href =\"javascript:modificarUsuario(".$usuario ->getIdUsuario() .")\">Editar</a></span>");
						if($usuario -> getEliminarUsuario() == 1)
							echo("<span><a href =\"javascript:eliminarusuario()\">Borrar</a></span>");
						echo("</td>");
						echo("</tr>");
					}
					echo("</table>");
				?>
			</div>
			<div id="columnaSecundaria">
				<span><a id="nuevo" href= "javascript:nuevoUsuario()">Nuevo usuario</a></span>
				<div class="formulario">
					<h3 id="tituloFormulario">Nuevo usuario</h3>
					<table>
						<tr><td>Nombre</td><td><input id="nombreUsuario" type="text"/></td></tr>
						<tr><td>Apellidos</td><td><input id="apellidosUsuario" type="text"/></td></tr>
						<tr><td>Nick</td><td><input id="nickUsuario" type="text"/></td></tr>
						<tr><td>Correo</td><td><input id="correoUsuario" type="text"/></td></tr>
						<tr><td>Tipo Usuario</td>
							<td><select id="tipoUsuario">
								<option>Uno</option>
								<option>Dos</option>
								<option>Tres</option>
							</select></td></tr>
						<tr><td>Activo</td><td><input id="activoUsuario" type="checkbox"/></td></tr>
						<tr>
							<td><a class="boton" href="javascript:cancelar()">Cancelar</a></td>
							<td><a id="guardar" class="boton" href = "javascript:guardar()">Crear</a></td>
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