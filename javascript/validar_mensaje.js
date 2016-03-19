/**

Esta función comprueba los campos de un formulario.

Se asume que el formulario tendrá un campo 'usuario' y
'password'. En caso de ser un formulario de registro de
usuario habrá un tercer campo 'password2'.

@formulario: nombre del formulario a analizar.
@esRegistro: true si el formulario a analizar
             es un formulario de registor, false
             si es de login.
@return: true si los campos son correctos, false si 
         no lo son.           

 **/
 function validarMensaje(formulario) {

 	"use strict";

	// Recogemos los datos introducidos por el usuario.
	var mensaje = document.forms[formulario]["mensaje"].value;

	var error = false;
	var descripcionError = "";
	// Expresión para buscar carácteres alfanuméricos en una cadena.
	// var Exp = /^[0-9a-z]+$/;

	// Comprobamos que el nombre de usuario tenga como máximo 140 cuatro carácteres.
	if (usuario.length < 140) {
		error = true;
		descripcionError = "El mensaje puede tener como máximo 140 carácteres.";
	}

	// Comprobamos que se haya escrito un mensaje.
	if (usuario.length < 1) {
		error = true;
		descripcionError = "¿Se te ha comido la lengua el gato? Si quieres publicar algo deberías... escribir algo.";
	}

	// Si hemos detectado algún error lo mostramos, en caso contrario ¡luz verde!
	if (error == true) {
		alert(descripcionError);
		return false;
	} else {
		return true;
	}

}