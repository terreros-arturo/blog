<?php
	session_start();
	session_regenerate_id();
	require_once("../bo/EntradaBO.php");
	require_once("../bo/CategoriaBO.php");
	require_once("../bo/ComentarioBO.php");
	require_once("../bo/ModuloBO.php");
	
	require_once("../util/utils.php");
	$usuarioLogueado = isset($_SESSION['idUsuario']) && isset($_SESSION['nickUsuario']) && $_SESSION['idUsuario']!= "" && $_SESSION['nickUsuario']!= ""? true: false;
	if($usuarioLogueado){
		$accion = isset($_GET["accion"])? $_GET["accion"]: "nuevaEntrada";
		$idEntrada = isset($_GET["entrada"])? $_GET["entrada"]: -1;
		
		$comentarioBO = new ComentarioBO();
		$entradaAlmacenada = false;
		
		switch($accion){
			case "modificarEntrada":{
				$entradaBO = new EntradaBO();
				$entrada = new Entrada();
				$entrada = $entradaBO -> obtenEntradaId($idEntrada);
				$idUsuarioEntrada = $entrada -> getIdUsuarioEntrada();
				$fechaEntrada = $entrada -> getFechaEntrada();
				$ipPublica = $entrada -> getIpPublica();
				$tituloEntrada = $entrada -> getTituloEntrada();
				$contenidoEntrada = $entrada -> getContenidoEntrada();
				$archivoEntrada = $entrada -> getArchivoEntrada();
				$entradaActiva = $entrada -> getEntradaActiva();
				$idCategoriaEntrada = $entrada ->getIdCategoriaEntrada();
				$listaComentarios = $comentarioBO ->obtenComentariosEntrada($idEntrada);
			}break;
			case "nuevaEntrada":
			default :{
				$accion = "nuevaEntrada";
				$idUsuarioEntrada = $_SESSION['idUsuario'];
				$fechaEntrada = "";
				$ipPublica = "";
				$tituloEntrada = "";
				$contenidoEntrada = "";
				$archivoEntrada = "";
				$entradaActiva = true;
				$idCategoriaEntrada = -1;
			}break;
		}
?>
<html>
	<head>
	<title>Blog</title>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO 8859-1" />
		<link  rel="shortcut icon" href="../img/favicon.ico"/>
		<link type = "text/css" rel = "stylesheet" href = "../libs/jPaginate/css/style.css"/>
		<link type = "text/css" rel = "stylesheet" href = "../css/estilos.css"/>
		<script type = "text/javascript" src="../js/util.js"></script>
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
				$("textarea[maxlength]").keyup(function(){
					var longitud = parseInt($(this).attr('maxlength'));
					var contenido = $(this).val();
					var longitudActual = contenido.length;
					var restantes = longitud - longitudActual < 0 ? 0: longitud - longitudActual;
					if(longitudActual >= longitud){
						$(this).val(contenido.substr(0, longitud));
					}
					$(".contCaracteres").html(restantes + " caracteres restantes");
				});
				
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
					url: "../app/LoginApp.php",
					dataType: "json",
					data: { accion : "logout" },
					success:function(resultado){
						if(resultado.error != true){
							if(resultado.exito == true){ document.location = '.';}
							else{ alert("Error: No se pudo cerrar la sesion");}
						}
					},
					error:function(error){alert('Error: ' + error.status);}
				});
			}
		   
			function publicarEntrada(){
				var accion = "<?php echo($accion); ?>";
				
				var campoTituloEntrada = $("#campoTituloEntrada").val();
				var campoContenidoEntrada = $("#campoContenidoEntrada").val();
				var campoEntradaActiva = $('[name="campoEntradaActiva"]:checked').val();
				var campoIdCategoriaEntrada = $("#campoIdCategoriaEntrada").val();
				
				$("#errorTituloEntrada").html("");
				$("#errorContenidoEntrada").html("");
				$("#errorEntradaActiva").html("");
				$("#errorIdCategoriaEntrada").html("");
				
				if(campoTituloEntrada == "" || campoContenidoEntrada == "" || campoEntradaActiva == "" || campoIdCategoriaEntrada == ""){
					if(campoTituloEntrada == ""){
						$("#errorTituloEntrada").html("Título esta vacio");
						$("#errorTituloEntrada").show("pulsate", {}, "fast");
					}
					if(campoContenidoEntrada == ""){
						$("#errorContenidoEntrada").html("Contenido vacio");
						$("#errorContenidoEntrada").show("pulsate", {}, "fast");
					}
					if(campoEntradaActiva == ""){
						$("#errorEntradaActiva").html("Debe estar activa o inactiva");
						$("#errorEntradaActiva").show("pulsate", {}, "fast");
					}
					if(campoIdCategoriaEntrada == ""){
						$("#errorIdCategoriaEntrada").html("Selecciona una categoria");
						$("#errorIdCategoriaEntrada").show("pulsate", {}, "fast");
					}
				}
				else{
					var entrada = {
						idEntrada: <?php echo($idEntrada); ?>,
						idUsuarioEntrada: <?php echo($idUsuarioEntrada); ?>,
						fechaEntrada: "<?php echo($fechaEntrada); ?>",
						ipPublica: "<?php echo(getIp()); ?>",
						tituloEntrada: campoTituloEntrada,
						contenidoEntrada: campoContenidoEntrada,
						entradaActiva: campoEntradaActiva,
						idCategoriaEntrada: campoIdCategoriaEntrada
					};
					$.ajax({
						type: "POST",
						url: "../app/EntradaApp.php",
						dataType: "json",
						data: { accion : accion, entrada: entrada},
						success:function(resultado){
							if(resultado.error != true){
								if(resultado.exito == true){
									alert("Entrada publicada con exito");
									document.location = ".";
								}else{
									alert("No se tuvo exito");
								}
							}
						},
						error:function(error){alert('Error: ' + error.status);}
					});
				}
			}
		</script>
	</head>
	<body>
		<div id="contenido">
			<div id ="cabecera"> <?php include_once("cabecera.php"); ?> </div>
			<div id="contenidoCentral">
				<?php
				if($accion == "nuevaEntrada" || ($accion == "modificarEntrada" && $idUsuarioEntrada == $_SESSION['idUsuario'])){
					echo("<div id=\"formularioEntrada\" class=\"formulario\">");	
						echo($accion == "nuevaEntrada"? "<h3>Nueva entrada</h3>": "<h3>Modificar entrada</h3>");
						echo("<form action = \"?accion=entradaSeleccionada&entrada=".$idEntrada ."#formularioEntrada\" method = \"post\">");
						echo("<table>");
						echo("<tr><td>* Titulo: </td><td><input id=\"campoTituloEntrada\" type=\"text\" class=\"inputTextComentario\" value=\"". $tituloEntrada . "\"". "/><span class=\"errorCampo\" id=\"errorTituloEntrada\"></span></td></tr>");
						echo("<tr><td>* Contenido: </td><td colspan=\"2\"><textarea maxlength=\"1000\" id=\"campoContenidoEntrada\" class=\"textAreaComentario\" >". $contenidoEntrada. "</textarea><span class=\"errorCampo\" id=\"errorContenidoEntrada\"></span></td></tr>");
						echo("<tr><td></td><td><span class=\"contCaracteres\">1000 caracteres restantes</span></td></tr>");
						echo("<tr><td>* Estatus: </td>");
							echo("<td>");
							echo("<label>Activa<input name=\"campoEntradaActiva\" type=\"radio\"". ($entradaActiva ? "checked = true": "\"\""). " value=\"true\"/></label>");
							echo("<label>Inactiva<input name=\"campoEntradaActiva\" type=\"radio\"". (!$entradaActiva ? "checked = true": "\"\""). " value=\"false\"/></label>");
							echo("<span class=\"errorCampo\" id=\"errorEntradaActiva\"></span>");
							echo("</td>");
						echo("</tr>");
						echo("<tr><td>* Categoria: </td>");
							echo("<td><select class=\"inputTextComentario\" id=\"campoIdCategoriaEntrada\" value=\"". $idCategoriaEntrada ."\">");
								$listaCategorias = $categoriaBO -> obtenCategorias();
								foreach($listaCategorias as $categoria)
									echo("<option value=\"". $categoria -> getIdCategoria() ."\">". $categoria -> getNombreCategoria() . "</option>");
							echo("</select><span class=\"errorCampo\" id=\"errorIdCategoriaEntrada\"></span></td></tr>");
						echo("<tr><td></td><td><a class=\"btnFormulario boton\" href=\"javascript:publicarEntrada()\">". ($accion == "nuevaEntrada"? "Guardar":"Modificar")."</a><a class=\"btnFormulario boton\" href=\"" . $_SERVER['HTTP_REFERER']. "\">Cancelar</a></td></tr>");
						echo("</table>");
						echo("</form> * = Campos obligatorios<br/><br/>");
						if($entradaAlmacenada)
							echo("¡La entrada ha sido publicada!");
					echo("</div>");
					
				}else{
					echo("<h3>Esta entrada no te pertenece</h3>");
				}
				?>
			</div>
			<div id="columnaSecundaria"></div>
			<div id="pie"> <?php include_once("pie.php"); ?></div>
		</div>
	</body>
</html>
	
<?php
	}else{
		header("Location: .");
	}
?>