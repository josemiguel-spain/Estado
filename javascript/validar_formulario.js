/**

Comprueba que el nombre de usuario no esté en uso. En caso de estarlo
muestra un mensaje en el elemento "pista" y establece el valor del elemento
oculto "nombre_comprobado" en 1 si está libre y 0 si no lo está.

**/
function comprobarUsuario(usuario) {

	lbl_pista = document.getElementById("pista");
	//chk_nombre_comprobado = document.getElementById("nombre_comprobado");
	chk_nombre_comprobado = document.registro.nombre_comprobado;

	// Si el nombre de usuario no tiene al menos cuatro carácteres no nos molestamos.
	if (usuario.length < 4) { 

		lbl_pista.innerHTML = "Nombre de usuario demasiado corto";		
		
	} else {

		var xmlhttp = new XMLHttpRequest();
		var texto  = "";
		document.registro.nombre_comprobado.value = "-1";

		// Creamos el 'escuchador' que recibirá el resultado de buscar_usuario.php.
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

				// Si la respuesta es "0" el usuario está disponible. En caso contrario está en uso.
				respuesta = xmlhttp.responseText;
				if (respuesta == "0") {
					texto = "Nombre de usuario disponible!";
					chk_nombre_comprobado.value = "1";
				} else {
					texto = "Nombre de usuario no disponible.";
					chk_nombre_comprobado.value = "0";
				}
				// Mostramos el resultado al usuario y establecemos el valor del control.
				// document.registro.nombre_comprobado.value = respuesta;
				//document.getElementById("nombre_comprobado").value = respuesta;			
				lbl_pista.innerHTML = texto;
			} else {
				lbl_pista.innerHTML = "ERROR: status:" + xmlhttp.status + "<br>" + "readyState: " + xmlhttp.readyState;
			}
		}

		// Mostramos un mensaje de espera y lanzamos la solicitud.
		lbl_pista.innerHTML = "Validando usuario...";
		xmlhttp.open("GET", "buscar_usuario.php?usuario=" + usuario, true);
		xmlhttp.send();

	}

}

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
 function validarFormulario(formulario, esRegistro) {

 	"use strict";

	// Recogemos los datos introducidos por el usuario.
	var usuario = document.forms[formulario]["usuario"].value;
	var password = document.forms[formulario]["password"].value;
	var usuario_comprobado = document.registro.nombre_comprobado.value;

	/* La confirmación de contraseña solo la leeremos si 
	estamos tratando con el formulario de registro. */
	if (esRegistro === true) {
		var password2 = document.forms[formulario]["password2"].value;
	}

	var error = false;
	var descripcionError = "";
	// Expresión para buscar carácteres alfanuméricos en una cadena.
	// var exp = /\w+/g;
	var exp = /^[a-zA-Z0-9-_]+$/;

	// Si estamos con un formulario de registro haremos unas comprobaciones adicionales.
	if (esRegistro === true) {

		// Comprobamos el resultado de la comprobación del nombre de usuario por AJAX.
		if (usuario_comprobado == "0") {
			error = true;
			descripcionError = "El nombre de usuario está en uso."
		} else if (usuario_comprobado = "-1") {
			error = true;
			descripcionError = "Aún no se ha comprobado el nombre de usuario."
		}

		// Comprobamos que el nombre de usuario sea alfanumérico.
		if (!usuario.match(exp)) {
			error = true;
			descripcionError = "El nombre de usuario solo puede contener carácteres alfanuméricos."
		}

		// Comprobamos que el nombre de usuario tenga como mínimo cuatro carácteres.
		if (usuario.length < 4) {
			error = true;
			descripcionError = "El nombre de usuario debe tener como mínimo cuatro carácteres.";
		}

		// Comprobamos que el nombre de usuario tenga como máximo quince carácteres.
		if (usuario.length > 15) {
			error = true;
			descripcionError = "El nombre de usuario debe tener como máximo quince carácteres.";
		}

		// Comprobamos que la contraseña y la confirmación coincidan.
		if (password != password2) {
			error = true;
			descripcionError = "La contraseña y la verificación no coinciden.";
		}

		// Comprobamos que la contraseña tenga como mínimo ocho carácteres.
		if (password.length < 8) {
			error = true;
			descripcionError = "La contraseña debe tener como mínimo ocho carácteres.";
		}

	}

	// Comprobamos que se haya introducido un nombre de usuario.
	if (password.length < 1) {
		error = true;
		descripcionError = "Has olvidado escribir la contraseña";
	}

	// Comprobamos que se haya introducido una contraseña.
	if (usuario.length < 1) {
		error = true;
		descripcionError = "Has olvidado escribir el nombre de usuario";
	}

	// Si hemos detectado algún error lo mostramos, en caso contrario ¡luz verde!
	if (error === true) {
		alert(descripcionError);
		return false;
	} else {
		return true;
	}

}

/**

Validamos que el mensaje cumpla con los requisitos establecidos. Debe tener entre 1 y 140 carácteres.

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
	if (mensaje.length > 140) {
		error = true;
		descripcionError = "El mensaje puede tener como máximo 140 carácteres.";
	}

	// Comprobamos que se haya escrito un mensaje.
	if (mensaje.length < 1) {
		error = true;
		descripcionError = "¿Se te ha comido la lengua el gato? Si quieres publicar algo deberías... escribir algo.";
	}

	// Si hemos detectado algún error lo mostramos, en caso contrario ¡luz verde!
	if (error === true) {
		alert(descripcionError);
		return false;
	} else {
		return true;
	}

}














/*

                                             ▄▄████████▄
                                           ▄█▓▓▓█▓▓▓▓▓▓██▄
                                           █▓▓▓▓▓██▓▓▓▓▓▓▓█▄
                                ▄█████▄ █▓▓▓▓▓▓▓▓█▓▓▓▓▓▓▓█
                ▄▄██████████▓▓▓▓▓▓▓██▓▓▓▓▓▓▓█▓▓▓▓▓▓▓██
             ▄█▓▓▓▓▓▓▓▓▓▓█▓██▓▓▓▓▓▓▓█▓▓▓▓▓█▓▓▓▓▓▓▓█▓█
          ▄█▓▓▓▓▓▓▓▓▓▓▓▓█▓▓▓█▓▓▓▓▓▓▓▓▓▓▓█▓▓▓▓▓▓▓▓█▓▓█
        ▄█▓▓▓▓▓▓▓▓▓▓▓▓▓▓████▓▓▓▓▓▓▓▓▓▓█▓▓▓▓▓▓▓▓██▓▓█
       █▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓█▓▓▓███▓▓▓▓█
      █▓▓▓▓▓▓▓▓▓▓▓▓███▀▀▀▀██▓▓▓▓▓▓▓▓▓▓▓▓█▓▓▓▓█▓▓▓▓█  ▄████████▄
     █▓▓▓▓▓▓▓▓▓▓█▀▀           ▀█▓▓▓▓▓▓▓▓▓▓█▓▓▓▓▓█▓▓▓███▓▓▓▓▓▓▓▓▓▓█▄
    █▓▓▓▓▓▓▓▓▓█▀               ▓▓█▓▓▓▓███████▓███▓▓▓▓▓▓▓░░░▓▓▓▓▓▓▓▓▓█
    █▓▓▓▓▓▓▓▓█             ▓▓▓░░░█▓██░░░░░░░███▓▓▓▓▓▓░░░░░░▓▓▓▓▓▓▓▓▓▓█
     █▓▓▓▓▓▓█            ▓▓░░░░░░██░░░░░░░░░░░░███▓░░░░░░░░░▓▓▓▓▓▓▓▓▓▓█
  █▌ █▓▓▓▓▓█           ▓░░░░░░░░░░░░░░░░░░░░░░░░▓░░░░░░░▓░░▓▓▓▓▓▓▓▓▓▓▓█
 █▓█ █▓▓▓▓█          ▓▄▄░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░▓░░░▓▓▓▓▓▓▓▓▓▓▓█
█▓▓▓██▓▓▓█         ▓█░░▐░░░░░░░░░▄█████▄░░░░░░░░░░░░░▓░░░░▓▓▓▓▓▓▓▓▓▓▓█
█▓▓▓▓▓▓▓█        ▀▄█░░░▐░░░░░░▄█▀░░░░░░▀█░░░░░░░░░░░▓░░░░▓▓▓▓█▓▓▓▓████
 ██▓▓▓██        ▀▀▄▌░░░▐░░░░░░█░░░░░░░░░░█░░░░░░░░░▓░░░░░▓▓▓▓█▓███▓▓▓█
   ▀▀▀▀          ▀▄█░░░░▐░░░░░█░░░░░░░░░░░▐▌░░░░░░░▓░░░░░▓▓▓▓█▓▓▓▓▓▓▓█
                  ▓░░▓▓▓▓░░░░░░█░░░░░░░░░░░░▐▄▄▄▅░░░░░░░░░▓████▓▓▓▓▓▓▓█
                 ▓░░▀░░░░░░░░░░▀░░░░░░░░░░░░▐▀▄▄▅░░░░░░░░▓▓▓▓▓▓▓▓▓▓▓▓█
                  ▓░░░░░░░░░░░░░░░░░░░░░░░░░░▀▄▄░░░░░░░░█▓▓▓▓▓▓▓▓▓▓▓█
                   ▓░░░░░▓▓▓░░░░░░░░░░░░░░░░░░░░░███████▓▓▓▓▓▓▓▓▓▓▓█
                    ▓▓▓▓▓▓▓▓░░░░░░░░░░░░░░░░░░░██▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓██
                       ▓▓▓▓▓░░░░░░░░░░░░░░░░░░█▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓██████
                       ▓▓▓▓▓░░░░░░░░░░░░░░░░░█▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓█▓█
                       ▓▓▓▓▓░░░░░░░░░░░░░░░░░█▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓█▓▓█
                       ▓▒▒▓░░░░░░░░░░░░░░░░░░░█▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓█▓▓█
                     ▓▓▒▓░░░░░░░░░░░░░░░░░░░████████▓▓▓▓▓▓▓▓▓▓▓▓▓▓█▓▓█
                      ▓▓▓▓▓░░░░░░░░░░░░░░███▓▓▓▓█▓▓▓██▓▓▓▓██▓▓▓▓▓█▓▓▓█
                             ▓▓▓▓▓▓▓▓▓▓▓▓█▓▓▓▓▓▓▓▓▓█▓▓█▓▓▓▓█▓█████▓▓▓▓█
                                           █▓▓▓▓▓▓▓▓▓▓▓███▓▓▓▓█▓▓▓▓▓▓▓▓▓▓█
                                          █▓▓▓▓▓▓▓▓████▓▓▓▓▓▓█▓▓▓▓▓▓▓▓▓▓█
                                         █▓▓▓▓▓▓▓▓▓▓█▓▓██████▓▓▓▓▓▓▓▓▓█
                                         █▓▓▓▓▓▓▓▓▓▓▓█▓▓▓▓▓▓▓▓▓▓▓▓███
                                          █▓▓▓▓▓▓▓▓▓▓▓█▓▓▓▓███████
                                           █▓▓▓▓▓▓▓▓▓▓▓█▓▓▓▓▓█
                                            █▓▓▓▓▓▓▓▓▓█▓▓▓▓▓▓▓█
                                          ███████████▓▓▓▓▓▓▓▓█
                                         █▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓█
                                        █▓▓▓▓▓██▓▓▓▓▓▓▓▓██
                                         █▓▓▓▓▓▓█▀▀▀▀▀▀▀
                                           ██▓▓▓▓███▄▄
                                              ▀▀▀▀▀

*/