# Estado
Pequeña aplicación web social.

#Guía de instalación
Para instalar esta aplicación se deben seguir los siguientes pasos:

##1. Crear la base de datos.

Ya sea desde PhpMyAdmin, MySQL Workbench o cualquier otra herramienta creamos una base de datos y ejecutamos el contenido
del archivo crear_tablas.sql sobre ella para crear las tablas necesarias.

##2. Escribir la configuración de la base de datos en el archivo "configuracion.ini":

En este archivo se deben cumplimentar los siguientes campos:
- servidor: nombre o IP del servidor de base de datos.
- base_datos: nombre de la base de datos donde almacenaremos las tablas de la aplicación.
- usuario: nombre de usuario con el que se accederá a la base de datos.
- password: contraseña del anterior usuario.

Después copiaremos este archivo **fuera del directorio raiz** de forma que quede de la siguiente manera:

+ web
  |- configuracion.ini
  |+ public_html 
   | - index.php
   | ...

##3. Copiar los archivos necesarios.

En el directorio donde queramos albergar la aplicación copiamos todos los archivos del proyecto **excepto configuracion.ini** (que ya hemos copiado en el paso anterior fuera del directorio público del servidor web) y el archivo crear_tablas.sql.
