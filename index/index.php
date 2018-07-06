<?php
	session_start();
	session_regenerate_id();
	require_once("../bo/EntradaBO.php");
	require_once("../bo/CategoriaBO.php");
	require_once("../bo/UsuarioBO.php");
	require_once("../bo/ComentarioBO.php");
	require_once("../bo/ModuloBO.php");
	require_once("../util/utils.php");
	require_once("../util/Googl.php");
	
	$usuarioLogueado = isset($_SESSION['idUsuario']) && isset($_SESSION['nickUsuario']) && $_SESSION['idUsuario']!= "" && $_SESSION['nickUsuario']!= ""? true: false;
		
	$entradaBO = new EntradaBO();
	$usuarioBO = new UsuarioBO();
	$comentarioBO = new ComentarioBO();
	
	$listaEntradas = array();
	$listaComentarios = array();
	$entradasTotales = 0;
	$entradasPorPagina = 5;
	$accion = isset($_GET["accion"])? $_GET["accion"]: "todasEntradas";
	$paginaSeleccionada = isset($_GET["pagina"])? $_GET["pagina"]: 1;
	$idCategoria = isset($_GET["categoria"])? $_GET["categoria"]: -1;
	$idEntrada = isset($_GET["entrada"])? $_GET["entrada"]: -1;
	
	$comentarioAlmacenado = false;
	$nombreComenta = ""; $correoComenta = ""; $webComenta = ""; $contenidoComentario = "";	
	$strErrorNombreComenta = ""; $strErrorCorreoComenta = ""; $strErrorWebComenta = ""; $strErrorContenidoComentario = ""; $strErrorCaptchaCapturado = "";
	
	if(isset($_POST['campoNombreComentario']) && isset($_POST['campoCorreoComentario']) && isset($_POST['campoWebComentario']) && isset($_POST['campoContenidoComentario']) && isset($_POST['campoCaptchaComentario'])){
		$errorNombreComenta = false; $errorCorreoComenta = false; $errorWebComenta  = false; $errorContenidoComentario = false; $errorCaptchaCapturado = false;
		$nombreComenta = $_POST['campoNombreComentario'];
		$correoComenta = $_POST['campoCorreoComentario'];
		$webComenta = $_POST['campoWebComentario'];
		$contenidoComentario = $_POST['campoContenidoComentario'];
		$captchaCapturado = $_POST['campoCaptchaComentario'];
		if($nombreComenta == ""){$errorNombreComenta = true;$strErrorNombreComenta = "Campo obligatorio";}
		if(!correoValido($correoComenta)){$errorCorreoComenta = true; $strErrorCorreoComenta = "Correo no v&aacute;lido";}
		if($webComenta != "" && !webValida($webComenta)){ $errorWebComenta = true; $strErrorWebComenta = "Url no v&aacute;lida";}
		if($contenidoComentario == ""){ $errorContenidoComentario = true; $strErrorContenidoComentario = "Campo obligatorio";}
		if(md5($captchaCapturado) != $_SESSION['clave']){ $errorCaptchaCapturado = true; $strErrorCaptchaCapturado = "C&oacute;digo incorrecto";}
		if(!$errorNombreComenta && !$errorCorreoComenta && !$errorWebComenta && !$errorContenidoComentario && !$errorCaptchaCapturado){
			$comentario = new Comentario();
			$comentario -> setIdComentario(-1);
			$comentario -> setIdEntradaComentario($idEntrada);
			$comentario -> setFechaComentario("");
			$comentario -> setContenidoComentario($contenidoComentario);
			$comentario -> setNombreComenta($nombreComenta);
			$comentario -> setCorreoComenta($correoComenta);
			$comentario -> setWebComenta($webComenta);
			$comentario -> setIpComenta(getIp());
			if($comentarioBO -> almacenaComentario($comentario)){
				$nombreComenta = ""; $correoComenta = ""; $webComenta = ""; $contenidoComentario = ""; $captchaCapturado = "";
				$comentarioAlmacenado = true;
			}
		}
	}
	if($usuarioLogueado){
		$usuario = $usuarioBO -> obtenUsuarioId($_SESSION['idUsuario']);
		$nombreComenta = $usuario -> getNickUsuario();
		$correoComenta = $usuario -> getCorreoUsuario();
	}
	switch($accion){
		case "entradaSeleccionada":{
			if(!$usuarioLogueado){
				$listaEntradas[0] = $entradaBO -> obtenEntradaIdActiva($idEntrada);
				$listaComentarios = $comentarioBO -> obtenComentariosEntradaActiva($idEntrada);
			}else{
				$listaEntradas[0] = $entradaBO -> obtenEntradaId($idEntrada);
				$listaComentarios = $comentarioBO -> obtenComentariosEntrada($idEntrada);
			}
			$entradasTotales = count($listaEntradas);
		}break;
		case "entradasCategoria":{
			if(!$usuarioLogueado){
				$entradasTotales = $entradaBO -> obtenTotalEntradasCategoriaActivas($entradasPorPagina, $idCategoria);
				if($entradasTotales > 0) $listaEntradas = $entradaBO -> obtenEntradasCategoriaActivasPagina($paginaSeleccionada, $entradasPorPagina, $idCategoria);
			}else{
				$entradasTotales = $entradaBO -> obtenTotalEntradasCategoria($entradasPorPagina, $idCategoria);
				if($entradasTotales > 0) $listaEntradas = $entradaBO -> obtenEntradasCategoriaPagina($paginaSeleccionada, $entradasPorPagina, $idCategoria);
			}
		}break;
		case "todasEntradas":
		default :{
			$accion = "todasEntradas";
			if(!$usuarioLogueado){
				$entradasTotales = $entradaBO -> obtenTotalEntradasActivas($entradasPorPagina);
				if($entradasTotales > 0) $listaEntradas = $entradaBO -> obtenEntradasActivasPagina($paginaSeleccionada, $entradasPorPagina);
			}else{
				$entradasTotales = $entradaBO -> obtenTotalEntradas($entradasPorPagina);
				if($entradasTotales > 0) $listaEntradas = $entradaBO -> obtenEntradasPagina($paginaSeleccionada, $entradasPorPagina);
			}
		}break;
	}
?>
<html>
	<head> 
		<meta http-equiv="Content-Type" content="text/html; charset=ISO 8859-1" />
		<title>Blog</title>
		<link  rel="shortcut icon" href="../img/favicon.ico"/>
		<link type = "text/css" rel = "stylesheet" href = "../libs/jPaginate/css/style.css"/>
		<link type = "text/css" rel = "stylesheet" href = "../css/estilos.css"/>
		
		<script type = "text/javascript" src="../js/util.js"></script>
		<script type = "text/javascript" src="../libs/jquery/jquery-1.6.2.min.js"> </script>
		<script type = "text/javascript" src="../libs/jPaginate/jquery.paginate.js"> </script>
		<script type = "text/javascript" src="../libs/jquery-ui-1.8.15.custom/development-bundle/ui/minified/jquery.effects.core.min.js"></script>
		<script type = "text/javascript" src="../libs/jquery-ui-1.8.15.custom/development-bundle/ui/minified/jquery.effects.bounce.min.js"></script>
		<script type = "text/javascript" src="../libs/jquery-ui-1.8.15.custom/development-bundle/ui/minified/jquery.effects.pulsate.min.js"></script>
		<!--Para resaltar codigo fuente en las entradas
		<script type = "text/javascript" src="../libs/syntaxhighlighter_3.0.83/scripts/shCore.js"></script>
		<script type = "text/javascript" src="../libs/syntaxhighlighter_3.0.83/scripts/shBrushCss.js"></script>
		<script type = "text/javascript" src="../libs/syntaxhighlighter_3.0.83/scripts/shBrushPhp.js"></script>
		<script type = "text/javascript" src="../libs/syntaxhighlighter_3.0.83/scripts/shBrushJScript.js"></script>
		<script type = "text/javascript" src="../libs/syntaxhighlighter_3.0.83/scripts/shBrushPlain.js"></script>
		<script type = "text/javascript" src="../libs/syntaxhighlighter_3.0.83/scripts/shBrushJava.js"></script>
		<script type = "text/javascript" src="../libs/syntaxhighlighter_3.0.83/scripts/shBrushSql.js"></script>
		<script type = "text/javascript" src="../libs/syntaxhighlighter_3.0.83/scripts/shBrushCpp.js"></script>
		<script type = "text/javascript" src="../libs/syntaxhighlighter_3.0.83/scripts/shBrushBash.js"></script>
		<script type = "text/javascript" src="../libs/syntaxhighlighter_3.0.83/scripts/shAutoloader.js"></script>
		
		-->
		<!--
		<script type = "text/javascript" src="../libs/syntaxhighlighter_3.0.83/scripts/shAutoloader.js"></script>
		<script type = "text/javascript" src="../libs/syntaxhighlighter_3.0.83/scripts/shCore.js"></script>
		<script type = "text/javascript" src="../libs/syntaxhighlighter_3.0.83/scripts/shBrushJScript.js"></script>
		<link rel="stylesheet" type="text/css" href="../libs/syntaxhighlighter_3.0.83/styles/shThemeDefault.css"  />
		<link rel="stylesheet" type="text/css" href="../libs/syntaxhighlighter_3.0.83/styles/shCoreEmacs.css"  />
		-->
		<!--
		<script src="../libs/jquery-ui-1.8.15.custom/development-bundle/ui/minified/jquery.effects.drop.min.js"></script>
		<script src="../libs/jquery-ui-1.8.15.custom/development-bundle/ui/minified/jquery.effects.fold.min.js"></script>
		<script src="../libs/jquery-ui-1.8.15.custom/development-bundle/ui/minified/jquery.effects.slide.min.js"></script>
		<script src="../libs/jquery-ui-1.8.15.custom/development-bundle/ui/minified/jquery.effects.blind.min.js"></script>
		<script src="../libs/jquery-ui-1.8.15.custom/development-bundle/ui/minified/jquery.effects.clip.min.js"></script>
		
		<script src="../libs/jquery-ui-1.8.15.custom/development-bundle/ui/minified/jquery.effects.highlight.min.js"></script>
		<script src="../libs/jquery-ui-1.8.15.custom/development-bundle/ui/minified/jquery.effects.scale.min.js"></script>
		<script src="../libs/jquery-ui-1.8.15.custom/development-bundle/ui/minified/jquery.effects.shake.min.js"></script>
		-->
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
				
				$("#login").css("display", "none");
				creaPagindador();
				/*
				SyntaxHighlighter.config.bloggerMode = false;
				SyntaxHighlighter.all();*/
		   });
		   
		   
		   function mostrarVentana(idVentana, idCampoFocus){
				if($(idVentana).css("display") == "none"){
					$("#nick").val("");	
					$("#password").val("");	
					$("#msgLogin").html("");
					$("#msgNick").html("");
					$("#msgPassword").html("");
					$("#msgNick").css("display", "none");
					$("#msgPassword").css("display", "none");
					if(idCampoFocus != ""){
						if($.browser.msie){
							$(idVentana).show("bounce", {}, "fast");
							$("#contenido, #paginador, .fb-like, .twtr-widget").fadeTo(200, 0.1);
						}else{
							$(idVentana).show("bounce", {}, "fast", function(){
								$(idCampoFocus).focus();
							});
							$("#contenido").fadeTo(500, 0.1);
						}
					}else{
						if($.browser.msie) {
							$(idVentana).show("bounce", {}, "fast");
							$("#contenido, #paginador, .fb-like, .twtr-widget").fadeTo(200, 0.1);
						}else {
							$(idVentana).show("bounce", {}, "fast");
							$("#contenido").fadeTo(500, 0.1);
						}
					}
				}
			}
			
			function ocultarVentana(idVentana){
				if($(idVentana).css("display") == "block"){
					if($.browser.msie)  {
						$(idVentana).hide("bounce", {}, "fast");
						$("#contenido, #paginador, .fb-like, .twtr-widget").css({"filter": "alpha(opacity=100)"});
					}else {
						$(idVentana).hide("bounce", {}, "fast");
						$("#contenido").fadeTo(500, 1.0);
					}
				}
		   }
		   
		   function creaPagindador(){
				var categoria = <?php echo($idCategoria); ?>;
				var paginasTotales = <?php echo (ceil((float)$entradasTotales /$entradasPorPagina)); ?>;
				var paginaSeleccionada = <?php echo($paginaSeleccionada); ?>;
				var accion = "<?php echo($accion);?>";
				if(paginasTotales > 1){
					$("#paginador").paginate({
						count: 					paginasTotales,
						start: 					paginaSeleccionada,
						display: 				4,
						border: 				true,
						border_color: 			'#555',
						text_color:				'#fff',
						background_color: 		'#111',
						border_hover_color: 	'#48f',
						text_hover_color: 		'#111',
						background_hover_color: '#ccc',
						images:					false,
						rotate: 				true,
						mouse: 					'press',
						onChange: 				function(page){
							if(page != paginaSeleccionada)
								document.location = ".?accion=" + accion +  (categoria != -1? "&categoria=" + categoria: "") + "&pagina="+ page; 
						}
					});
				}
		   }
		   
		   function validaUsuario(){
				var accion = "<?php echo($accion);?>";
				var categoria = <?php echo($idCategoria); ?>;
				var paginaSeleccionada = <?php echo($paginaSeleccionada); ?>;
				var idEntrada = <?php echo ($idEntrada); ?>;
				$("#msgLogin").html("");
				$("#msgNick").html("");
				$("#msgPassword").html("");
				var nick = $("#nick").val();
				var password = $("#password").val();
				if(!validaNick(nick) || password == ""){
					if(!validaNick(nick)){
						$("#msgNick").html("Usuario no v&aacute;lido");
						$("#msgNick").show("pulsate", {}, "fast");
					}
					else if(password == ""){
						$("#msgPassword").html("Introduce password");
						$("#msgPassword").show("pulsate", {}, "fast");
					}
				}
				else{
					$.ajax({
						type: "POST",
						url: "../app/LoginApp.php",
						dataType: "json",
						data: { accion : "login", nick : nick, password : password},
						beforeSend: function(xhr,opciones){ 
							$("#msgLogin").html("Validando usuario, espera...");
							$("#msgLogin").show("pulsate", {}, "fast");
							$("#btnCancelar").attr("href","javascript:void(0)");
							$("#btnSesion").attr("href","javascript:void(0)");
						},
						success:function(resultado){
							if(resultado.error != true){
								if(resultado.exito == true)
									document.location = ".?accion=" + accion +(accion == "entradaSeleccionada"? "&entrada="+idEntrada:"") + (categoria != -1? "&categoria=" + categoria: "") + (paginaSeleccionada != "" ?"&pagina="+ paginaSeleccionada: "");
								else{
									$("#btnCancelar").attr("href","javascript:ocultarVentana('#login')");
									$("#btnSesion").attr("href","javascript:validaUsuario()");
									$("#msgLogin").html("Usuario o password incorrectos");
									$("#msgLogin").show("pulsate", {}, "fast");
								}
							}
						},
						error:function(error){alert('Error: ' + error.status);}
					});
				}
		   }
		   
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
		   
		   function eliminarComentario(idComentario){
				var accion = "<?php echo($accion);?>";
				var categoria = <?php echo($idCategoria); ?>;
				var paginaSeleccionada = <?php echo($paginaSeleccionada); ?>;
				var idEntrada = <?php echo ($idEntrada); ?>;
				var confirmacion = confirm("¿Estás seguro de querer eliminar el comentario?");
				if(confirmacion){
					$.ajax({
						type: "POST",
						url: "../app/ComentarioApp.php",
						dataType: "json",
						data: { accion : "eliminar",
								comentario: idComentario
							},
						success:function(resultado){
							if(resultado.error != true){
								if(resultado.exito == true){ document.location = ".?accion=" + accion +(accion == "entradaSeleccionada"? "&entrada="+idEntrada:"") + (categoria != -1? "&categoria=" + categoria: "") + (paginaSeleccionada != "" ?"&pagina="+ paginaSeleccionada: "");}
								else{ alert("Error: No se pudo eliminar el comentario");}
							}
						},
						error:function(error){alert('Error: ' + error.status);}
					});
				}
		   }
		</script>
		<!--Para facebook-->
		<script>(function(d, s, id) {var js, fjs = d.getElementsByTagName(s)[0]; if (d.getElementById(id)) {return;} js = d.createElement(s); js.id = id; js.src = "//connect.facebook.net/es_ES/all.js#xfbml=1"; fjs.parentNode.insertBefore(js, fjs); }(document, 'script', 'facebook-jssdk'));</script>
		<!--para google +1-->
		<script type="text/javascript" src="https://apis.google.com/js/plusone.js">{lang: 'es-419'} </script>
		<!--Para Twitter-->
		<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
		<script charset="utf-8" src="http://widgets.twimg.com/j/2/widget.js"></script>
	</head>
	<body>	
	<div id="fb-root"></div><script>(function(d, s, id) {var js, fjs = d.getElementsByTagName(s)[0];if (d.getElementById(id)) return;js = d.createElement(s); js.id = id;js.src = "//connect.facebook.net/es_ES/all.js#xfbml=1";fjs.parentNode.insertBefore(js, fjs);}(document, 'script', 'facebook-jssdk'));</script>
		<div id="contenido">
			<div id ="cabecera"> <?php include_once("cabecera.php"); ?> </div>
			<div id="contenidoCentral">
				<?php
					if($usuarioLogueado && count($listaModulos) == 0){
						echo("<div id=\"msgCategoria\"><h2>¡Debes modificar tus datos personales para comenzar a publicar!</h2></div>");
					}
					else{
						$listaCategorias = $categoriaBO -> obtenCategorias();
						if($idCategoria != -1){
							echo("<div id = \"msgCategoria\">");
							foreach($listaCategorias as $categoria)
								if($idCategoria == $categoria -> getIdCategoria())
									echo("<span id=\"nombreCategoria\">Entradas de la categoria: " . $categoria -> getNombreCategoria() . "</span><span id=\"descripcionCategoria\">" . $categoria -> getDescripcionCategoria() . "</span>");
									echo("<span id=\"totalEntradasCategoria\">$entradasTotales entradas relacionadas con esta categoria</span> ");
							echo("</div>");
						}
						echo("<div id = \"entradas\">");
						if($entradasTotales > 0){
							foreach($listaEntradas as $entrada){
								//Para acortar dirección url al hacer comentario para twitter, facebook y google+ 
								$googl = new Googl("AIzaSyD1TuWa5Bqa9ynVHPkTYCrDheC8iqRoV_c");
								$url = "http://webtra.net63.net/index/?accion=entradaSeleccionada&entrada=". $entrada -> getIdEntrada();
								$urlComprimida = $googl->shorten($url);								
								$usuario = $usuarioBO -> obtenUsuarioId($entrada ->getIdUsuarioEntrada());
								echo("<div class =\"entrada\">");
								echo("<span class=\"tituloEntrada\">");
								if($accion != "entradaSeleccionada")echo("<a href= \".?accion=entradaSeleccionada&entrada=". $entrada -> getIdEntrada(). "\">". $entrada -> getTituloEntrada() . "</a>");
								else echo("<a href= \"#\">". $entrada -> getTituloEntrada() . "</a>");
								echo("</span>");
								echo("<span class = \"cabeceraEntrada\">");
									if($usuarioLogueado && $usuario -> getIdUsuario() == $_SESSION['idUsuario'])
										echo("<span class=\"modificarEntrada\"><a href=\"administrarEntradas.php?accion=modificarEntrada&entrada=". $entrada -> getIdEntrada() ."\">Modificar entrada</a></span>");
									echo("Escrito por: <span class = \"usuarioEntrada\">" . $usuario -> getNickUsuario() ."</span>");
									echo(" el: <span class = \"fechaEntrada\">". $entrada -> getFechaEntrada()."</span> " . ($usuarioLogueado?"<span class=\"statusEntrada\">". ($entrada -> getEntradaActiva() == 1 ? " Activa ": " Inactiva "). "</span>": ""));
									echo("<br/>Dentro de la categoria: <span class= \"categoriaEntrada\">");
									foreach($listaCategorias as $categoria)
										if($entrada -> getIdCategoriaEntrada() == $categoria -> getIdCategoria())
											echo("<a href=\".?accion=entradasCategoria&categoria=". $entrada -> getIdCategoriaEntrada() ."\">" . $categoria -> getNombreCategoria() . "</a>");
									echo("</span>");
									if($accion != "entradaSeleccionada")echo("<br/><span class=\"enlaceComentariosEntrada\"><a href=\".?accion=entradaSeleccionada&entrada=". $entrada -> getIdEntrada(). "#formularioComentario\">". $comentarioBO -> obtenNumeroComentariosEntrada($entrada ->getIdEntrada()) ." comentarios </a> </span>");
								echo("</span>");
								echo("<span class='contenidoEntrada'>". nl2br($entrada -> getContenidoEntrada()) ."</span>");
								echo("<br/><div class=\"social\">");
									echo("<div class=\"twitter\" ><a href=\"https://twitter.com/share\" class=\"twitter-share-button\" data-url=\"". $urlComprimida ."\" data-text=\"". $entrada -> getTituloEntrada(). "\" data-lang=\"es\" data-hashtags=\"".$entrada -> getTituloEntrada() ."\">Twittear</a></div>");
									echo("<div class=\"unoMas\"> <g:plusone size=\"medium\" href=\"".$urlComprimida."\"></g:plusone></div>");
									echo("<div class=\"fb-like\" data-send=\"true\" data-layout=\"button_count\" data-width=\"300\" data-show-faces=\"true\" data-colorscheme=\"dark\" data-href=\"". $urlComprimida."\"></div>");
								echo("</div>");
								echo("</div><br/><hr/><br/>");
							}
						}else
							echo("<h3>No hay entradas por mostrar</h3>");
						echo("</div>");
//Formulario de comentario
						if($accion == "entradaSeleccionada" && $entradasTotales > 0){ //$entradasTotales para que no se agreguen comentarios a entradas inactivas
							echo("<div id =\"formularioComentario\" class=\"formulario\">");
							echo("<h3>Deja un comentario</h3><br/><br/><form action = \"?accion=entradaSeleccionada&entrada=".$idEntrada ."#formularioComentario\" method = \"post\">");
							echo("<table>");
							echo("<tr><td>* Nombre: </td><td><input name=\"campoNombreComentario\" type=\"text\" class=\"inputTextComentario\" value=\"". $nombreComenta . "\"". ($usuarioLogueado ? "readonly=\"yes\"" : "" ). "/><span class=\"errorCampo\">$strErrorNombreComenta</span></td></tr>");
							echo("<tr><td>* Correo: </td><td><input name=\"campoCorreoComentario\" type=\"text\" class=\"inputTextComentario\" value=\"". $correoComenta ."\"". ($usuarioLogueado ? "readonly=\"yes\"" : "" ). "/><span class=\"errorCampo\">$strErrorCorreoComenta</span></td></tr>");
							echo("<tr><td>Web: </td><td><input name=\"campoWebComentario\"type=\"text\" class=\"inputTextComentario\" value=\"". $webComenta ."\" /><span class=\"errorCampo\">$strErrorWebComenta</span></td></tr>");
							echo("<tr><td>* Comentario: </td><td colspan=\"2\"><textarea maxlength = \"300\" id= \"campoContenidoComentario\" name=\"campoContenidoComentario\" class=\"textAreaComentario\" >". $contenidoComentario. "</textarea><span class=\"errorCampo\">$strErrorContenidoComentario</span></td></tr>");
							echo("<tr><td></td><td><span class=\"contCaracteres\">200 caracteres restantes</span></td></tr>");
							echo("<tr><td>* <img id =\"imgCaptcha\" width =\"100\" height=\"25\" src=\"../util/captcha.php\" /> </td><td><input name=\"campoCaptchaComentario\" type =\"text\" class=\"inputTextComentario\"/><span class=\"errorCampo\">$strErrorCaptchaCapturado</span></td></tr>");
							echo("<tr><td></td><td align=\"right\"><button class=\"btnFormulario boton\" type=\"submit\" value=\"Publicar\">Publicar</button></td></tr>");
							echo("</table>");
							echo("</form> * = Campos obligatorios<br/><br/>");
							if($comentarioAlmacenado)
								echo("<script type = \"text/javascript\" >alert(\"¡Gracias, tu comentario ha sido publicado!\");</script>");
							echo("</div>");
//Comentarios 
							if(count($listaComentarios) > 0){
								echo("<div id=\"comentarios\">Comentarios: <br/>");
								foreach($listaComentarios as $comentario){
									echo("<div class=\"comentario\">");
										$usuario = $usuarioBO -> obtenUsuarioId($entrada ->getIdUsuarioEntrada());
										if($usuarioLogueado && $usuario -> getIdUsuario() == $_SESSION['idUsuario'])
											echo("<a class =\"eliminarComentario\" href=\"javascript:eliminarComentario(".$comentario-> getIdComentario().")\"><img src =\"../img/badge-circle-cross-24-ns.png\"/></a>");
										echo("<span class=\"comenta\">". $comentario -> getNombreComenta(). "</span> comenta: <br/>");
										echo("<span class=\"contenidoComentario\">". nl2br($comentario -> getContenidoComentario()). "</span><br/>");
										echo("<span class=\"infoComentario\">Publicado el ". $comentario -> getFechaComentario() ." desde @". $comentario -> getIpComenta() ."</span>");
									echo("</div>");
								}
								echo("</div>");
							}
						}
						echo ("<div id =\"paginador\"></div><br/>");
					}
				?>
			</div>
			<div id="columnaSecundaria">
				<!--
				<div id= "twitter">
					<script>
					new TWTR.Widget({
						version: 3,
						type: 'profile',
						rpp: 10,
						interval: 10000,
						width: 'auto',
						height: 300,
						theme: {
							shell: {
								background: '#424242',
								color: '#c9c9c9'
							},
							tweets: {
								background: '#99a1a1',
								color: '#000000',
								links: '#ff0509'
							}
						},	
						features: {
							scrollbar: true,
							loop: true,
							live: true,
							behavior: 'default'
						}
					}).render().setUser('').start();
					</script>
				</div>
				-->
				<div id="contadorVisitantes">
					<object allowscriptaccess="always" type="application/x-shockwave-flash" data="http://sock.plugincontrol.info/scroller.swf?id=825034_2&ln=es" width="175" height="200" wmode="transparent"><param name="allowscriptaccess" value="always" /><param name="movie" value="http://sock.plugincontrol.info/scroller.swf?id=825034_2&ln=es" /><param name="wmode" value="transparent" /><embed src="http://sock.plugincontrol.info/scroller.swf?id=825034_2&ln=es" type="application/x-shockwave-flash" allowscriptaccess="always" wmode="transparent" width="175" height="200" /><video width="175" height="200"><a title="BANC DE BINARY" href="http://www.binaryoptioninsider.com/reviews/9-banc-de-binary" style="font-style:italic;font-weight:bold;font-size:12px;text-decoration:underline">http://www.binaryoptioninsider.com/reviews/9-banc-de-binary</a></video></object>
				</div>
			</div>
			<div id="pie"> <?php include_once("pie.php"); ?></div>
		</div>
		<?php if(!$usuarioLogueado){echo("<div id=\"login\" class=\"ventana\" >"); include_once("login.php"); echo("</div>");} ?>
	</body>
</html>