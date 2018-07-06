<?php
	session_start();
	session_regenerate_id();
	require_once("../bo/BlogBusiness.php");
	require_once("../util/utils.php");
	
	$usuarioLogueado = isset($_SESSION['idUsuario']) && isset($_SESSION['nickUsuario']) && $_SESSION['idUsuario']!= "" && $_SESSION['nickUsuario']!= ""? true: false;
	if($usuarioLogueado){
		$blogBusiness = new BlogBusiness();
?>
<html>
	<head>
	<title>Blog</title>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO 8859-1" />
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
			});
			
			function cerrarSesion(){
				$.ajax({
					type: "POST",
					url: "../app/BlogAplication.php",
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
		   
		  
		</script>
	</head>
	<body>
		<div id="contenido">
			<div id ="cabecera"> <?php include_once("cabecera.php"); ?> </div>
			<div id="contenidoCentral">
				<?php
					
				?>
			</div>
			<div id="columnaSecundaria">
			</div>
			<div id="pie"> <?php include_once("pie.php"); ?></div>
		</div>
	</body>
</html>
	
<?php
	}else{
		header("Location: .");
	}
?>