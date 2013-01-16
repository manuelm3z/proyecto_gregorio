<?php
/*
* Autor: @manuelm3z
* Documentación: en este documento están las configuraciones 
* de base de datos.
*/
/*
* servidor de la base de datos
*/
define("server", "direccion");

/*
* usuario de la base de datos
*/
define("user", "usuario");

/*
* password de la base de datos
*/
define("pass", "password");

/*
* base de dato donde se obtendran los valores
*/
define("bd", "amparo");
/*
*nombre del servidor
*/
define("nombre", "http://{$_SERVER['SERVER_NAME']}/proyecto_gregorio");
/*
* Defininción de tablas
*/
$usuario = "create table usuario(
	idUsuario int(4) auto_increment primary key,
	login varchar(60) not null,
	clave varchar(60) not null,
	fechaRegistro date not null,
	estado boolean not null
	)";

$representantes = "create table representante(
	idRepresentante varchar(10) primary key,
	nombresRepresentante varchar(60) not null,
	apellidosRepresentante varchar(60) not null,
	cedulaRepresentante varchar(20) not null,
	telefono varchar(20) not null,
	oficio varchar(60) not null,
	fechaNacimientoR date not null,
	estado boolean not null
	)";

$alumno = "create table alumno(
	idAlumno varchar(10) primary key,
	nombresAlumno varchar(60) not null,
	apellidosAlumno varchar(60) not null,
	cedulaAlumno varchar(20),
	fechaNacimientoA date not null,
	lugarNacimiento varchar(60) not null,
	estatura int(4) not null,
	peso int(4) not null,
	tCamisa varchar(4) not null,
	tPantalon varchar(4) not null,
	tZapatos int(4) not null,
	observacion text,
	idRepresentante varchar(10) not null,
	estado boolean not null
	)";
?>