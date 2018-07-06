
function getParameter(strParametro){
	var valorParametro = "";
	var strUrl = document.location.href + "";
	if(strUrl.indexOf("&" + strParametro + "=") > -1 || strUrl.indexOf("?" + strParametro + "=") > -1){
		var indice = strUrl.indexOf("&" + strParametro + "=") != -1 ? strUrl.indexOf("&" + strParametro +"=") + ("&" + strParametro + "=").length : strUrl.indexOf("?" + strParametro +"=") + ("?" + strParametro + "=").length;
		while(indice < strUrl.length && strUrl.charAt(indice) != '&')
			valorParametro += strUrl.charAt(indice++)
	}
	return valorParametro;
}

function validaCorreoElectronico(strCorreo){
	var expesionCorreo = /[\w-\.]{3,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
	return expesionCorreo.test(strCorreo);
}


function validaWeb(strWeb){
	var expresionWeb = /^(ht|f)tp(s?)\:\/\/[0-9a-zA-Z]([-.\w]*[0-9a-zA-Z])*(:(0-9)*)*(\/?)( [a-zA-Z0-9\-\.\?\,\’\/\\\+&%\$#_]*)?$/;
	return expresionWeb.test(strWeb);
}


function validaNick(strUsuario){
	var expresionUsuario = /^[a-zA-Z0-9]+$/;
	return expresionUsuario.test(strUsuario);
}


//para usarlo, colocar en la etiqueta de textarea:
//onkeyup=\"return maxLongitud(event,'campoContenidoComentario', 5)\"
function maxLongitud(e, idCampo, longitud){
	var contenido = $("#"+ idCampo).val();
	var keynum;
	if(window.event){ // IE8 and earlier
		keynum = e.keyCode;
	}else if(e.which){// IE9/Firefox/Chrome/Opera/Safari
		keynum = e.which;
	}
	//keynum entre 35 y 40 son caracteres de navegacion (flechas, inicio y fin), 8 y 46 son backspace y del respectivamente
	if(contenido.length >= longitud ) {//&& !((keynum >= 35 && keynum <= 40) || keynum == 8 || keynum == 46)){
		//if(contenido.length > longitud)
			$("#"+ idCampo).val(contenido.substring(0,longitud));
		//return false;
	}else{
		;//return true;
	}
}