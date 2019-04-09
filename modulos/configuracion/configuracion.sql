INSERT INTO modulo (modulo, nombre, activo, orden, sistema, add_usuario, add_fecha) VALUES ('configuracion_s', 'Configuración', 'Y', 2, 'SAC', 1, now());

INSERT INTO pantalla (pantalla, pantalla_padre, modulo, nombre, link, activo, orden, add_usuario, add_fecha) VALUES
('configuracion_delito_s', NULL, 'configuracion_s', 'Delitos', 'configuracion_delito.php', 'Y', 1, 1, now());

CREATE TABLE delito (
  delito int(11) NOT NULL AUTO_INCREMENT,
  nombre varchar(75) NOT NULL,
  descripcion text NULL,
  activo enum('Y','N') NOT NULL DEFAULT 'Y',
  add_usuario int(11) NOT NULL,
  add_fecha datetime NOT NULL,
  mod_usuario int(11) NULL,
  mod_fecha datetime NULL,
  PRIMARY KEY (delito),
  CONSTRAINT delito_add_use_f FOREIGN KEY (add_usuario) REFERENCES usuario_sac (usuario_sac) ON UPDATE RESTRICT ON DELETE RESTRICT,
  CONSTRAINT delito_mod_use_f FOREIGN KEY (mod_usuario) REFERENCES usuario_sac (usuario_sac) ON UPDATE RESTRICT ON DELETE RESTRICT
) ENGINE=InnoDB;

/*hasta aqui prueba*/

INSERT INTO pantalla (pantalla, pantalla_padre, modulo, nombre, link, activo, orden, add_usuario, add_fecha) VALUES
('configuracion_comisaria_s', NULL, 'configuracion_s', 'Comisarías', 'configuracion_comisaria.php', 'Y', 2, 1, now());

CREATE TABLE comisaria(
  comisaria int(11) NOT NULL AUTO_INCREMENT,
  nombre varchar(255) NOT NULL,
  descripcion TEXT NULL,
  activo enum('Y','N') NOT NULL DEFAULT 'Y',
  add_usuario int(11) NOT NULL,
  add_fecha datetime NOT NULL,
  mod_usuario int(11) NULL,
  mod_fecha datetime NULL,
  PRIMARY KEY (comisaria),
  CONSTRAINT comisaria_add_use_f FOREIGN KEY (add_usuario) REFERENCES usuario_sac (usuario_sac) ON UPDATE RESTRICT ON DELETE RESTRICT,
  CONSTRAINT comisaria_mod_use_f FOREIGN KEY (mod_usuario) REFERENCES usuario_sac (usuario_sac) ON UPDATE RESTRICT ON DELETE RESTRICT
)ENGINE=InnoDB;

INSERT INTO pantalla (pantalla, pantalla_padre, modulo, nombre, link, activo, orden, add_usuario, add_fecha) VALUES
('configuracion_estacion_s', NULL, 'configuracion_s', 'Estaciones', 'configuracion_estacion.php', 'Y', 3, 1, now());

CREATE TABLE estacion(
  estacion int(11) NOT NULL AUTO_INCREMENT,
  comisaria int(11) NOT NULL, 
  nombre varchar(255) NOT NULL,
  descripcion TEXT NULL,
  activo enum('Y','N') NOT NULL DEFAULT 'Y',
  add_usuario int(11) NOT NULL,
  add_fecha datetime NOT NULL,
  mod_usuario int(11) NULL,
  mod_fecha datetime NULL,
  PRIMARY KEY (estacion),
  CONSTRAINT estacion_com_f FOREIGN KEY (comisaria) REFERENCES comisaria (comisaria) ON UPDATE RESTRICT  ON DELETE RESTRICT,
  CONSTRAINT estacion_add_use_f FOREIGN KEY (add_usuario) REFERENCES usuario_sac (usuario_sac) ON UPDATE RESTRICT ON DELETE RESTRICT,
  CONSTRAINT estacion_mod_use_f FOREIGN KEY (mod_usuario) REFERENCES usuario_sac (usuario_sac) ON UPDATE RESTRICT ON DELETE RESTRICT
)ENGINE=InnoDB;

INSERT INTO pantalla (pantalla, pantalla_padre, modulo, nombre, link, activo, orden, add_usuario, add_fecha) VALUES
  ('configuracion_subestacion_s', NULL, 'configuracion_s', 'Subestaciones', 'configuracion_subestacion.php', 'Y', 4, 1, now());

CREATE TABLE subestacion(
  subestacion int(11) NOT NULL AUTO_INCREMENT,
  comisaria int(11) NOT NULL,
  estacion int(11) NOT NULL,
  nombre varchar(255) NOT NULL,
  descripcion TEXT NULL,
  activo enum('Y','N') NOT NULL DEFAULT 'Y',
  add_usuario int(11) NOT NULL,
  add_fecha datetime NOT NULL,
  mod_usuario int(11) NULL,
  mod_fecha datetime NULL,
  PRIMARY KEY (subestacion),
  CONSTRAINT subestacion_com_f FOREIGN KEY (comisaria) REFERENCES comisaria (comisaria) ON UPDATE RESTRICT  ON DELETE RESTRICT,
  CONSTRAINT subestacion_est_f FOREIGN KEY (estacion) REFERENCES estacion (estacion) ON UPDATE RESTRICT  ON DELETE RESTRICT,
  CONSTRAINT subestacion_add_use_f FOREIGN KEY (add_usuario) REFERENCES usuario_sac (usuario_sac) ON UPDATE RESTRICT ON DELETE RESTRICT,
  CONSTRAINT subestacion_mod_use_f FOREIGN KEY (mod_usuario) REFERENCES usuario_sac (usuario_sac) ON UPDATE RESTRICT ON DELETE RESTRICT
)ENGINE=InnoDB;

INSERT INTO pantalla (pantalla, pantalla_padre, modulo, nombre, link, activo, orden, add_usuario, add_fecha) VALUES
  ('configuracion_nacionalidad_s', NULL, 'configuracion_s', 'Nacionalidad', 'configuracion_nacionalidad.php', 'Y', 5, 1, now());

CREATE TABLE nacionalidad(
  nacionalidad int(11) NOT NULL AUTO_INCREMENT,
  nombre varchar(255) NOT NULL,
  descripcion text NULL,
  activo enum('Y','N') NOT NULL DEFAULT 'Y',
  add_usuario int(11) NOT NULL,
  add_fecha datetime NOT NULL,
  mod_usuario int(11) NULL,
  mod_fecha datetime NULL,
  PRIMARY KEY (nacionalidad),
  CONSTRAINT nacionalidad_add_use_f FOREIGN KEY (add_usuario) REFERENCES usuario_sac (usuario_sac) ON UPDATE RESTRICT ON DELETE RESTRICT,
  CONSTRAINT nacionalidad_mod_use_f FOREIGN KEY (mod_usuario) REFERENCES usuario_sac (usuario_sac) ON UPDATE RESTRICT ON DELETE RESTRICT
)ENGINE=InnoDB;

INSERT INTO pantalla (pantalla, pantalla_padre, modulo, nombre, link, activo, orden, add_usuario, add_fecha) VALUES
  ('configuracion_profesion_s', NULL, 'configuracion_s', 'Profesión', 'configuracion_profesion.php', 'Y', 6, 1, now());

CREATE TABLE profesion(
  profesion int(11) NOT NULL AUTO_INCREMENT,
  nombre varchar(255) NOT NULL,
  descripcion text NULL,
  activo enum('Y','N') NOT NULL DEFAULT 'Y',
  add_usuario int(11) NOT NULL,
  add_fecha datetime NOT NULL,
  mod_usuario int(11) NULL,
  mod_fecha datetime NULL,
  PRIMARY KEY (profesion),
  CONSTRAINT profesion_add_use_f FOREIGN KEY (add_usuario) REFERENCES usuario_sac (usuario_sac) ON UPDATE RESTRICT ON DELETE RESTRICT,
  CONSTRAINT profesion_mod_use_f FOREIGN KEY (mod_usuario) REFERENCES usuario_sac (usuario_sac) ON UPDATE RESTRICT ON DELETE RESTRICT
)ENGINE=InnoDB;

INSERT INTO pantalla (pantalla, pantalla_padre, modulo, nombre, link, activo, orden, add_usuario, add_fecha) VALUES
  ('configuracion_tipo_autor_s', NULL, 'configuracion_s', 'Tipo de autor', 'configuracion_tipo_autor.php', 'Y', 7, 1, now());

CREATE TABLE tipo_autor(
  tipo_autor int(11) NOT NULL AUTO_INCREMENT,
  nombre varchar(255) NOT NULL,
  descripcion text NULL,
  activo enum('Y','N') NOT NULL DEFAULT 'Y',
  add_usuario int(11) NOT NULL,
  add_fecha datetime NOT NULL,
  mod_usuario int(11) NULL,
  mod_fecha datetime NULL,
  PRIMARY KEY (tipo_autor),
  CONSTRAINT tipo_autor_add_use_f FOREIGN KEY (add_usuario) REFERENCES usuario_sac (usuario_sac) ON UPDATE RESTRICT ON DELETE RESTRICT,
  CONSTRAINT tipo_autor_mod_use_f FOREIGN KEY (mod_usuario) REFERENCES usuario_sac (usuario_sac) ON UPDATE RESTRICT ON DELETE RESTRICT
)ENGINE=InnoDB;

INSERT INTO pantalla (pantalla, pantalla_padre, modulo, nombre, link, activo, orden, add_usuario, add_fecha) VALUES
  ('configuracion_tipo_solicitud_secuestrador_s', NULL, 'configuracion_s', 'Tipo de solicitud secuestrador', 'configuracion_tipo_solicitud_secuestrador.php', 'Y', 8, 1, now());

CREATE TABLE tipo_solicitud_secuestrador(
  tipo_solicitud_secuestrador int(11) NOT NULL AUTO_INCREMENT,
  nombre varchar(255) NOT NULL,
  descripcion text NULL,
  activo enum('Y','N') NOT NULL DEFAULT 'Y',
  add_usuario int(11) NOT NULL,
  add_fecha datetime NOT NULL,
  mod_usuario int(11) NULL,
  mod_fecha datetime NULL,
  PRIMARY KEY (tipo_solicitud_secuestrador),
  CONSTRAINT tipo_solicitud_secuestrador_add_use_f FOREIGN KEY (add_usuario) REFERENCES usuario_sac (usuario_sac) ON UPDATE RESTRICT ON DELETE RESTRICT,
  CONSTRAINT tipo_solicitud_secuestrador_mod_use_f FOREIGN KEY (mod_usuario) REFERENCES usuario_sac (usuario_sac) ON UPDATE RESTRICT ON DELETE RESTRICT
)ENGINE=InnoDB;

INSERT INTO pantalla (pantalla, pantalla_padre, modulo, nombre, link, activo, orden, add_usuario, add_fecha) VALUES
  ('configuracion_objeto_incautado_s', NULL, 'configuracion_s', 'Objetos Incautados', 'configuracion_objeto_incautado.php', 'Y', 9, 1, now());

CREATE TABLE objeto_incautado(
  objeto_incautado int(11) NOT NULL AUTO_INCREMENT,
  nombre varchar(255) NOT NULL,
  descripcion text NULL,
  activo enum('Y','N') NOT NULL DEFAULT 'Y',
  add_usuario int(11) NOT NULL,
  add_fecha datetime NOT NULL,
  mod_usuario int(11) NULL,
  mod_fecha datetime NULL,
  PRIMARY KEY (objeto_incautado),
  CONSTRAINT objeto_incautado_add_use_f FOREIGN KEY (add_usuario) REFERENCES usuario_sac (usuario_sac) ON UPDATE RESTRICT ON DELETE RESTRICT,
  CONSTRAINT objeto_incautado_mod_use_f FOREIGN KEY (mod_usuario) REFERENCES usuario_sac (usuario_sac) ON UPDATE RESTRICT ON DELETE RESTRICT
)ENGINE=InnoDB;

INSERT INTO pantalla (pantalla, pantalla_padre, modulo, nombre, link, activo, orden, add_usuario, add_fecha) VALUES
  ('configuracion_causa_s', NULL, 'configuracion_s', 'Causa', 'configuracion_causa.php', 'Y', 10, 1, now());

CREATE TABLE causa(
  causa int(11) NOT NULL AUTO_INCREMENT,
  nombre varchar(255) NOT NULL,
  descripcion text NULL,
  activo enum('Y','N') NOT NULL DEFAULT 'Y',
  add_usuario int(11) NOT NULL,
  add_fecha datetime NOT NULL,
  mod_usuario int(11) NULL,
  mod_fecha datetime NULL,
  PRIMARY KEY (causa),
  CONSTRAINT causa_add_use_f FOREIGN KEY (add_usuario) REFERENCES usuario_sac (usuario_sac) ON UPDATE RESTRICT ON DELETE RESTRICT,
  CONSTRAINT causa_mod_use_f FOREIGN KEY (mod_usuario) REFERENCES usuario_sac (usuario_sac) ON UPDATE RESTRICT ON DELETE RESTRICT
)ENGINE=InnoDB;

INSERT INTO pantalla (pantalla, pantalla_padre, modulo, nombre, link, activo, orden, add_usuario, add_fecha) VALUES
  ('configuracion_movil_hecho_s', NULL, 'configuracion_s', 'Móvil de hecho', 'configuracion_movil_hecho.php', 'Y', 11, 1, now());

CREATE TABLE movil_hecho(
  movil_hecho int(11) NOT NULL AUTO_INCREMENT,
  nombre varchar(255) NOT NULL,
  descripcion text NULL,
  activo enum('Y','N') NOT NULL DEFAULT 'Y',
  add_usuario int(11) NOT NULL,
  add_fecha datetime NOT NULL,
  mod_usuario int(11) NULL,
  mod_fecha datetime NULL,
  PRIMARY KEY (movil_hecho),
  CONSTRAINT movil_hecho_add_use_f FOREIGN KEY (add_usuario) REFERENCES usuario_sac (usuario_sac) ON UPDATE RESTRICT ON DELETE RESTRICT,
  CONSTRAINT movil_hecho_mod_use_f FOREIGN KEY (mod_usuario) REFERENCES usuario_sac (usuario_sac) ON UPDATE RESTRICT ON DELETE RESTRICT
)ENGINE=InnoDB;

INSERT INTO pantalla (pantalla, pantalla_padre, modulo, nombre, link, activo, orden, add_usuario, add_fecha) VALUES
  ('configuracion_mara_s', NULL, 'configuracion_s', 'Mara', 'configuracion_mara.php', 'Y', 12, 1, now());

CREATE TABLE mara(
  mara int(11) NOT NULL AUTO_INCREMENT,
  nombre varchar(255) NOT NULL,
  descripcion text NULL,
  activo enum('Y','N') NOT NULL DEFAULT 'Y',
  add_usuario int(11) NOT NULL,
  add_fecha datetime NOT NULL,
  mod_usuario int(11) NULL,
  mod_fecha datetime NULL,
  PRIMARY KEY (mara),
  CONSTRAINT mara_add_use_f FOREIGN KEY (add_usuario) REFERENCES usuario_sac (usuario_sac) ON UPDATE RESTRICT ON DELETE RESTRICT,
  CONSTRAINT mara_mod_use_f FOREIGN KEY (mod_usuario) REFERENCES usuario_sac (usuario_sac) ON UPDATE RESTRICT ON DELETE RESTRICT
)ENGINE=InnoDB;

CREATE TABLE pais(
  pais int(11) NOT NULL AUTO_INCREMENT,
  nombre varchar(50) NOT NULL,
  PRIMARY KEY (pais)
)ENGINE=InnoDB;

CREATE TABLE departamento(
  departamento int(11) NOT NULL AUTO_INCREMENT,
  nombre varchar(55) NOT NULL,
  pais int(11) NOT NULL,
  PRIMARY KEY (departamento),
  CONSTRAINT departamento_pai_f FOREIGN KEY (pais) REFERENCES pais (pais) ON UPDATE RESTRICT ON DELETE RESTRICT
)ENGINE=InnoDB;

CREATE TABLE municipio(
  municipio int(11) NOT NULL AUTO_INCREMENT,
  nombre varchar(55) NOT NULL,
  pais int(11) NOT NULL,
  departamento int(11) NOT NULL,
  PRIMARY KEY (municipio),
  CONSTRAINT municipio_pai_f FOREIGN KEY (pais) REFERENCES pais (pais) ON UPDATE RESTRICT ON DELETE RESTRICT,
  CONSTRAINT municipio_dep_f FOREIGN KEY (departamento) REFERENCES departamento (departamento) ON UPDATE RESTRICT ON DELETE RESTRICT
)ENGINE=InnoDB;

/*hasta aqui local*/





