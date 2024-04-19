create database redSocial;

use redSocial;

create table usuarios(
    id int auto_increment primary key,
    correo varchar(50),
    nombre varchar(50),
    foto varchar(200) DEFAULT '../perfil_img/956070.png',
    descripcion varchar(500) DEFAULT 'Hola mundo, Hello world',
    password varchar(255)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

create table publicaciones(
    id int auto_increment primary key,
    id_usuario int,
    contenido_url varchar(2000),
    fecha timestamp,
    text_img varchar(255),
    likes int DEFAULT 0 not null
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

create table likes(
    id int auto_increment primary key,
    id_foto int,
    liked tinyint,
    cantidad_likes int,
    id_usuario int not null
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

create table mensajes(
    id int auto_increment primary key,
    id_remitente int, 
    id_destinatario int, 
    mensaje text
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

create table comentarios(
    id int auto_increment primary key,
    id_publicacion int,
    id_usuario int,
    comentario varchar(300)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

create table guardadas(
    id_usuario int,
    id_publicacion int,
    guardada varchar(5) default 'false'
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


alter table likes add FOREIGN KEY (id_foto) REFERENCES publicaciones(id);

alter table publicaciones add FOREIGN KEY (id_usuario) REFERENCES usuarios(id);

alter table likes add foreign key (id_usuario) references usuarios (id);

alter table comentarios add FOREIGN KEY (id_publicacion) REFERENCES publicaciones(id);

alter table comentarios add FOREIGN KEY(id_usuario) REFERENCES usuarios(id);

alter table guardadas add FOREIGN key(id_publicacion) references publicaciones(id);

alter table guardadas add foreign key(id_usuario) references usuarios(id);


insert into usuarios(correo, nombre, password) values('eva@gmail.com', 'Eva', '123');
insert into usuarios(correo, nombre, password) values('Lilith@gmail.com', 'Lilith', '234');
insert into usuarios(correo, nombre, password) values('Abel@gmail.com', 'Abel', '345');

