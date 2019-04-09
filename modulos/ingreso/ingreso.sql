INSERT INTO modulo (modulo, nombre, activo, orden, sistema, add_usuario, add_fecha) VALUES ('ingreso_s', 'Ingreso de Información', 'Y', 3, 'SAC', 1, now());

INSERT INTO pantalla (pantalla, pantalla_padre, modulo, nombre, link, activo, orden, add_usuario, add_fecha) VALUES
('ingreso_caso', NULL, 'ingreso_s', 'Ingreso de casos', 'ingreso_caso.php', 'Y', 1, 1, now());

/*hasta aqui local*/

CREATE TABLE caso (
  caso int(11) NOT NULL AUTO_INCREMENT,
  tipo_caso enum('secuestro','trata_violaciones','extorsion','aprehendidos','allanamientos','desaparecidos','homicidios_lesionados','hurto_robo','hurto_robo_vehiculos') NOT NULL DEFAULT 'secuestro',
  no_caso varchar(75) NOT NULL,
  no_mp varchar(75) NULL,
  fecha_hecho datetime NULL,
  fecha_ingreso datetime NULL,
  fecha_denuncia datetime NULL,
  estado_caso enum('fase_investigacion','concluido','archivado','desestimado','con_sindicados','con_detenidos') NULL DEFAULT 'fase_investigacion',
  procedencia enum('pnc','deic','mp') NOT NULL DEFAULT 'pnc',
  comisaria int(11) NULL,
  estacion int(11) NULL,
  subestacion int(11) NULL,
  area_hecho enum('rural','urbana') NULL,
  observaciones text NULL,
  resenia_hecho text NULL,
  unidad_procede varchar(255) NULL,
  fecha_informe_mp datetime NULL,

  /*secuestro*/

  fecha_liberado datetime NULL,
  fecha_localizado datetime NULL,
  dirección_secuestro varchar(255) NULL,
  municipio_secuestro int(11) NULL,
  departamento_secuestro int(11) NULL,
  dirección_liberacion varchar(255) NULL,
  municipio_liberacion int(11) NULL,
  departamento_liberacion int(11) NULL,
  acceso_negociar enum('Y','N') NULL DEFAULT 'Y',
  tipo_solicitud_secuestrador int(11) NULL,
  estado_final_victima enum('muerto','liberado') NULL DEFAULT 'liberado',
  monto_solicitado decimal(10,2) NULL,
  monto_negociado decimal(10,2) NULL,
  monto_entregado decimal(10,2) NULL,
  motivo_secuestro varchar(255) NULL,

  /*datos denunciante*/

  foto_denunciante varchar(255) NULL,
  dpi_denunciante varchar(25) NULL,
  nombre_denunciante varchar(75) NULL,
  edad_denunciante SMALLINT NULL,
  direccion_denunciante varchar(255) NULL,
  municipio_denunciante int(11) NULL,
  departamento_denunciante int(11) NULL,
  parentesco_denunciante varchar(75) NULL,

  /*datos victima*/

  foto_victima varchar(255) NULL,
  dpi_victima varchar(255) NULL,
  alias_victima varchar(255) NULL,
  nombre_victima varchar(255) NULL,
  edad_victima int(10) NULL,
  sexo_victima enum('masculino','femenino') NULL DEFAULT 'masculino',
  nacionalidad_victima int(11) NULL,
  profesion_victima int(11) NULL,
  direccion_victima varchar(255) NULL,
  municipio_victima int(11) NULL,
  departamento_victima int(11) NULL,
  pernetenece_mara_victima enum('Y','N') NULL DEFAULT 'Y',
  mara_victima int(11) NULL,
  antecedentes_victima enum('Y','N') NULL DEFAULT 'Y',
  caracteristicas_victima text NULL,
  vestimenta_victima text NULL,
  add_usuario int(11) NOT NULL,
  add_fecha datetime NOT NULL,
  mod_usuario int(11) NULL,
  mod_fecha datetime NULL,
  PRIMARY KEY (caso),
  CONSTRAINT caso_com_f FOREIGN KEY (comisaria) REFERENCES comisaria (comisaria) ON UPDATE RESTRICT ON DELETE RESTRICT,
  CONSTRAINT caso_est_f FOREIGN KEY (estacion) REFERENCES estacion (estacion) ON UPDATE RESTRICT ON DELETE RESTRICT,
  CONSTRAINT caso_sub_f FOREIGN KEY (subestacion) REFERENCES subestacion (subestacion) ON UPDATE RESTRICT ON DELETE RESTRICT,
  CONSTRAINT caso_mun_sec_f FOREIGN KEY (municipio_secuestro) REFERENCES municipio (municipio) ON UPDATE RESTRICT ON DELETE RESTRICT,
  CONSTRAINT caso_dep_sec_f FOREIGN KEY (departamento_secuestro) REFERENCES departamento (departamento) ON UPDATE RESTRICT ON DELETE RESTRICT,
  CONSTRAINT caso_mun_lib_f FOREIGN KEY (municipio_liberacion) REFERENCES municipio (municipio) ON UPDATE RESTRICT ON DELETE RESTRICT,
  CONSTRAINT caso_dep_lib_f FOREIGN KEY (departamento_liberacion) REFERENCES departamento (departamento) ON UPDATE RESTRICT ON DELETE RESTRICT,
  CONSTRAINT caso_tip_sol_sec_f FOREIGN KEY (tipo_solicitud_secuestrador) REFERENCES tipo_solicitud_secuestrador (tipo_solicitud_secuestrador) ON UPDATE RESTRICT ON DELETE RESTRICT,
  CONSTRAINT caso_mun_den_f FOREIGN KEY (municipio_denunciante) REFERENCES municipio (municipio) ON UPDATE RESTRICT ON DELETE RESTRICT,
  CONSTRAINT caso_dep_den_f FOREIGN KEY (departamento_denunciante) REFERENCES departamento (departamento) ON UPDATE RESTRICT ON DELETE RESTRICT,
  CONSTRAINT caso_nac_vic_f FOREIGN KEY (nacionalidad_victima) REFERENCES nacionalidad (nacionalidad) ON UPDATE RESTRICT ON DELETE RESTRICT,
  CONSTRAINT caso_pro_vic_f FOREIGN KEY (profesion_victima) REFERENCES profesion (profesion) ON UPDATE RESTRICT ON DELETE RESTRICT,
  CONSTRAINT caso_mun_vic_f FOREIGN KEY (municipio_victima) REFERENCES municipio (municipio) ON UPDATE RESTRICT ON DELETE RESTRICT,
  CONSTRAINT caso_dep_vic_f FOREIGN KEY (departamento_victima) REFERENCES departamento (departamento) ON UPDATE RESTRICT ON DELETE RESTRICT,
  CONSTRAINT caso_add_use_f FOREIGN KEY (add_usuario) REFERENCES usuario (usuario) ON UPDATE RESTRICT ON DELETE RESTRICT,
  CONSTRAINT caso_mod_use_f FOREIGN KEY (mod_usuario) REFERENCES usuario (usuario) ON UPDATE RESTRICT ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE caso_telefono_receptor(
  caso_telefono_receptor int(11) NOT NULL AUTO_INCREMENT,
  caso int(11) NOT NULL,
  numero_telefono varchar(50) NOT NULL,
  add_usuario int(11) NOT NULL,
  add_fecha datetime NOT NULL,
  mod_usuario int(11) NULL,
  mod_fecha datetime NULL,
  PRIMARY KEY (caso_telefono_receptor),
  CONSTRAINT caso_telefono_receptor_cas_f FOREIGN KEY (caso) REFERENCES caso (caso) ON UPDATE RESTRICT ON DELETE RESTRICT,
  CONSTRAINT caso_telefono_receptor_add_use_f FOREIGN KEY (add_usuario) REFERENCES usuario (usuario) ON UPDATE RESTRICT ON DELETE RESTRICT,
  CONSTRAINT caso_telefono_receptor_mod_use_f FOREIGN KEY (mod_usuario) REFERENCES usuario (usuario) ON UPDATE RESTRICT ON DELETE RESTRICT
)ENGINE=InnoDB;

CREATE TABLE caso_telefono_emisor(
  caso_telefono_emisor int(11) NOT NULL AUTO_INCREMENT,
  caso int(11) NOT NULL,
  numero_telefono varchar(50) NOT NULL,
  add_usuario int(11) NOT NULL,
  add_fecha datetime NOT NULL,
  mod_usuario int(11) NULL,
  mod_fecha datetime NULL,
  PRIMARY KEY (caso_telefono_emisor),
  CONSTRAINT caso_telefono_emisor_cas_f FOREIGN KEY (caso) REFERENCES caso (caso) ON UPDATE RESTRICT ON DELETE RESTRICT,
  CONSTRAINT caso_telefono_emisor_add_use_f FOREIGN KEY (add_usuario) REFERENCES usuario (usuario) ON UPDATE RESTRICT ON DELETE RESTRICT,
  CONSTRAINT caso_telefono_emisor_mod_use_f FOREIGN KEY (mod_usuario) REFERENCES usuario (usuario) ON UPDATE RESTRICT ON DELETE RESTRICT
)ENGINE=InnoDB;

CREATE TABLE caso_direccion_cautiverio(
  caso_direccion_cautiverio int(11) NOT NULL AUTO_INCREMENT,
  caso int(11) NOT NULL,
  direccion varchar(255) NULL,
  municipio_cautiverio int(11) NULL,
  departamento_cautiverio int(11) NULL,
  add_usuario int(11) NOT NULL,
  add_fecha datetime NOT NULL,
  mod_usuario int(11) NULL,
  mod_fecha datetime NULL,
  PRIMARY KEY (caso_direccion_cautiverio),
  CONSTRAINT caso_direccion_cautiverio_cas_f FOREIGN KEY (caso) REFERENCES caso (caso) ON UPDATE RESTRICT ON DELETE RESTRICT,
  CONSTRAINT caso_direccion_cautiverio_mun_f FOREIGN KEY (municipio_cautiverio) REFERENCES municipio (municipio) ON UPDATE RESTRICT ON DELETE RESTRICT,
  CONSTRAINT caso_direccion_cautiverio_dep_f FOREIGN KEY (departamento_cautiverio) REFERENCES departamento (departamento) ON UPDATE RESTRICT ON DELETE RESTRICT,
  CONSTRAINT caso_direccion_cautiverio_add_use_f FOREIGN KEY (add_usuario) REFERENCES usuario (usuario) ON UPDATE RESTRICT ON DELETE RESTRICT,
  CONSTRAINT caso_direccion_cautiverio_mod_use_f FOREIGN KEY (mod_usuario) REFERENCES usuario (usuario) ON UPDATE RESTRICT ON DELETE RESTRICT
)ENGINE=InnoDB;

CREATE TABLE caso_sindicado(
  caso_sindicado int(11) NOT NULL AUTO_INCREMENT,
  caso int(11) NOT NULL,
  foto_sindicado varchar(255) NULL,
  dpi_sindicado varchar(255) NULL,
  nombre_sindicado varchar(255) NULL,
  sexo_sindicado enum('masculino','femenino') NULL DEFAULT 'masculino',
  direccion_sindicado varchar(255) NULL,
  municipio_sindicado int(11) NULL,
  departamento_sindicado int(11) NULL,
  nacionalidad_sindicado int(11) NULL,
  antecedentes_sindicado varchar(255) NULL,
  alias_sindicado varchar(255) NULL,
  organizacion_criminal_sindicado varchar(255) NULL,
  tatuajes enum('Y','N') NULL DEFAULT 'Y',
  add_usuario int(11) NOT NULL,
  add_fecha datetime NOT NULL,
  mod_usuario int(11) NULL,
  mod_fecha datetime NULL,
  PRIMARY KEY (caso_sindicado),
  CONSTRAINT caso_sindicado_cas_f FOREIGN KEY (caso) REFERENCES caso (caso) ON UPDATE RESTRICT ON DELETE RESTRICT,
  CONSTRAINT caso_sindicado_mun_det_f FOREIGN KEY (municipio_sindicado) REFERENCES municipio (municipio) ON UPDATE RESTRICT ON DELETE RESTRICT,
  CONSTRAINT caso_sindicado_dep_det_f FOREIGN KEY (departamento_sindicado) REFERENCES departamento (departamento) ON UPDATE RESTRICT ON DELETE RESTRICT,
  CONSTRAINT caso_sindicado_nac_det_f FOREIGN KEY (nacionalidad_sindicado) REFERENCES nacionalidad (nacionalidad) ON UPDATE RESTRICT ON DELETE RESTRICT,
  CONSTRAINT caso_sindicado_add_use_f FOREIGN KEY (add_usuario) REFERENCES usuario (usuario) ON UPDATE RESTRICT ON DELETE RESTRICT,
  CONSTRAINT caso_sindicado_mod_use_f FOREIGN KEY (mod_usuario) REFERENCES usuario (usuario) ON UPDATE RESTRICT ON DELETE RESTRICT
)ENGINE=InnoDB;

CREATE TABLE caso_detenido(
  caso_detenido int(11) NOT NULL AUTO_INCREMENT,
  caso int(11) NOT NULL,
  foto_detenido varchar(255) NULL,
  dpi_detenido varchar(255) NULL,
  nombre_detenido varchar(255) NULL,
  sexo_detenido enum('masculino','femenino') NULL DEFAULT 'masculino',
  direccion_detenido varchar(255) NULL,
  municipio_detenido int(11) NULL,
  departamento_detenido int(11) NULL,
  nacionalidad_detenido int(11) NULL,
  antecedentes_detenido varchar(255) NULL, 
  alias_detenido varchar(255) NULL, 
  organizacion_criminal_detenido varchar(255) NULL, 
  tatuajes enum('Y','N') NULL DEFAULT 'Y',
  add_usuario int(11) NOT NULL,
  add_fecha datetime NOT NULL,
  mod_usuario int(11) NULL,
  mod_fecha datetime NULL,
  PRIMARY KEY (caso_detenido),
  CONSTRAINT caso_detenido_cas_f FOREIGN KEY (caso) REFERENCES caso (caso) ON UPDATE RESTRICT ON DELETE RESTRICT,
  CONSTRAINT caso_detenido_mun_det_f FOREIGN KEY (municipio_detenido) REFERENCES municipio (municipio) ON UPDATE RESTRICT ON DELETE RESTRICT,
  CONSTRAINT caso_detenido_dep_det_f FOREIGN KEY (departamento_detenido) REFERENCES departamento (departamento) ON UPDATE RESTRICT ON DELETE RESTRICT,
  CONSTRAINT caso_detenido_nac_det_f FOREIGN KEY (nacionalidad_detenido) REFERENCES nacionalidad (nacionalidad) ON UPDATE RESTRICT ON DELETE RESTRICT,
  CONSTRAINT caso_detenido_add_use_f FOREIGN KEY (add_usuario) REFERENCES usuario (usuario) ON UPDATE RESTRICT ON DELETE RESTRICT,
  CONSTRAINT caso_detenido_mod_use_f FOREIGN KEY (mod_usuario) REFERENCES usuario (usuario) ON UPDATE RESTRICT ON DELETE RESTRICT
)ENGINE=InnoDB;

CREATE TABLE caso_detenido_delito(
  caso_detenido_delito int(11) NOT NULL AUTO_INCREMENT,
  caso_detenido int(11) NOT NULL,
  delito int(11) NOT NULL,
  add_usuario int(11) NOT NULL,
  add_fecha datetime NOT NULL,
  mod_usuario int(11) NULL,
  mod_fecha datetime NULL,
  PRIMARY KEY (caso_detenido_delito),
  CONSTRAINT caso_detenido_delito_cas_f FOREIGN KEY (caso_detenido) REFERENCES caso_detenido (caso_detenido) ON UPDATE RESTRICT ON DELETE RESTRICT,
  CONSTRAINT caso_detenido_delito_del_f FOREIGN KEY (delito) REFERENCES delito (delito) ON UPDATE RESTRICT ON DELETE RESTRICT,
  CONSTRAINT caso_detenido_delito_add_use_f FOREIGN KEY (add_usuario) REFERENCES usuario (usuario) ON UPDATE RESTRICT ON DELETE RESTRICT,
  CONSTRAINT caso_detenido_delito_mod_use_f FOREIGN KEY (mod_usuario) REFERENCES usuario (usuario) ON UPDATE RESTRICT ON DELETE RESTRICT
)ENGINE=InnoDB;

CREATE TABLE caso_incautacion(
  caso_incautacion int(11) NOT NULL AUTO_INCREMENT,
  caso int(11) NOT NULL,
  objeto_incautado int(11) NULL,
  descripcion text NULL,
  add_usuario int(11) NOT NULL,
  add_fecha datetime NOT NULL,
  mod_usuario int(11) NULL,
  mod_fecha datetime NULL,
  PRIMARY KEY (caso_incautacion),
  CONSTRAINT caso_incautacion_cas_f FOREIGN KEY (caso) REFERENCES caso (caso) ON UPDATE RESTRICT ON DELETE RESTRICT,
  CONSTRAINT caso_incautacion_obj_inc_f FOREIGN KEY (objeto_incautado) REFERENCES objeto_incautado (objeto_incautado) ON UPDATE RESTRICT ON DELETE RESTRICT,
  CONSTRAINT caso_incautacion_add_use_f FOREIGN KEY (add_usuario) REFERENCES usuario (usuario) ON UPDATE RESTRICT ON DELETE RESTRICT,
  CONSTRAINT caso_incautacion_mod_use_f FOREIGN KEY (mod_usuario) REFERENCES usuario (usuario) ON UPDATE RESTRICT ON DELETE RESTRICT
)ENGINE=InnoDB;

