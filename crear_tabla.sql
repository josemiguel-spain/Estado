drop table if exists usuarios;
create table usuarios (

	usuario varchar(100) primary key not null,
	password varchar(255) not null,
	sesion varchar(100),
	estado varchar(150),
	ultima_actualizacion date

);

drop table if exists favoritos;
create table favoritos (

	usuario_origen varchar(100),
	usuario_destino varchar(100),
	constraint primary key (usuario_origen, usuario_destino)

)