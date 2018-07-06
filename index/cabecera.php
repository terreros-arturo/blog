<div id="logo">
	<a href="."></a>
</div>
<div id="barra">
	<ul class="menu">
		<li><a href=".">Inicio</a></li>
		<li id="menuCategorias">
			<a href="javascript:void(0)">Categoria</a>
			<?php
			$categoriaBO = new CategoriaBO();
			$listaCategorias = $categoriaBO -> obtenCategorias();
			if(count($listaCategorias) > 0){
			echo("<ul class=\"submenu\">");
			foreach($listaCategorias as $categoria)
				echo("<li><a href=\".?accion=entradasCategoria&categoria=". $categoria ->getIdCategoria() ."\">" . $categoria -> getNombreCategoria() ."</a></li>");
			echo("</ul>");
			}?>
		</li>
		<?php
		if($usuarioLogueado){
		    $idUsuario = $_SESSION['idUsuario'];
			$moduloBO = new ModuloBO();
			$listaModulos = $moduloBO -> obtenModulosPrivilegios($idUsuario);
			if(count($listaModulos) > 0){
				echo("<li id=\"menuAdministracion\">");
					echo("<a href=\"javascript:void(0);\">Administraci&oacute;n</a>");
					echo("<ul class=\"submenu\">");
						foreach($listaModulos as $modulo){
						   echo("<li><a href=\"".$modulo->getNombreUrlModulo()."\">".$modulo->getNombreModulo()."</a></li>");
						}
					echo("</ul>");
				echo("</li>");
			}else{
				;
			  //echo("<script type=\"text/javascript\">alert(\"Aun no tienes permisos. Los tendras cuando modifiques tus datos personales\")</script>");
			}
		}
		echo("<li><a href=\".\">Contacto</a></li>");
		?>
	</ul>
	<?php
	echo("<div id=\"sesion\">");
		if($usuarioLogueado){
			echo("<ul class=\"menu\">");
				echo("<li>");
					echo("<a href=\"javascript:void(0);\">Modificar</a>");
					echo("<ul class=\"submenu\">");
						echo("<li><a href=\"cambiaPassword.php\">Contrase&ntilde;a</a></li>");
						echo("<li><a href=\"cambiaPassword.php\">Datos personales</a></li>");
					echo("</ul>");
				echo("</li>");
			echo("</ul>");
		}
		echo($usuarioLogueado ? "<a class =\"boton\" href = \"javascript:cerrarSesion()\">Cerrar sesion [". $_SESSION['nickUsuario']. "]</a>" : "<a class =\"boton\" href = \"javascript:mostrarVentana('#login','#nick' );\">Iniciar sesi&oacute;n</a>");
	echo("</div>");
	?>
</div>