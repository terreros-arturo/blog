<form> 
	<table>
		<tr><td id = "tituloLogin" colspan ="2"><h3>Login</h3></td></tr>
		<tr>
			<td>Usuario:</td>
			<td><input class="cajaTexto" type="text" id="nick" maxlength="15" /></td>
		</tr>
		<tr><td></td><td id = "msgNick"></td></tr>
		<tr>
			<td>Password:</td>
			<td><input class="cajaTexto" type="password" id="password" maxlength="15"/></td>
		</tr>
		<tr><td></td><td id = "msgPassword"></td></tr>
		<tr><td colspan = "2" id = "msgLogin"></td></tr>
		<tr>
			<td><a id="btnCancelar" class = "boton" href="javascript:ocultarVentana('#login')">Cancelar</a></td>
			<td><a id="btnSesion" class = "boton" href="javascript:validaUsuario()">Iniciar sesi&oacute;n</a></td>
		</tr>
	</table>
</form>