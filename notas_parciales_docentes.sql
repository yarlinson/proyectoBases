CREATE DATABASE notas;
DROP TABLE docentes, estudiantes, cursos, inscripciones, notas, calificaciones, eventosestudiantes, eventosnotas;
DROP SEQUENCE  cursos_cod_cur_seq, doc_seq, est_seq;
DROP FUNCTION  grabar_eventosestudiantes(), grabar_eventosnotas() ;
DROP TRIGGER grabar_eventosestudiantes
create table docentes(
	
	cod_doc varchar(12) not null,
	nomb_doc varchar(50),
	clave bytea,
	constraint pk_cod_doc primary key (cod_doc)

);

create sequence doc_seq 
start with 1000
increment by 1
maxvalue 99999
minvalue 1000;

alter table docentes alter cod_doc set default nextval('doc_seq');

alter table docentes
   add constraint PK_docentes_nomb_doc
   unique (nomb_doc);

create table estudiantes(
	
	cod_est varchar(10) not null,
	nomb_est varchar(50),
	constraint pk_cod_est primary key (cod_est)

);
create sequence est_seq 
start with 4501
increment by 1
maxvalue 99999
minvalue 4501;

alter table estudiantes alter cod_est set default nextval('est_seq');

create table cursos(

	cod_cur varchar(15) not null,
	nomb_cur varchar(50),
	cod_doc varchar(12),
	constraint pk_cod_cur primary key (cod_cur),
	constraint fk_cod_doc foreign key (cod_doc) references docentes(cod_doc)
);

create sequence cursos_cod_cur_seq
start with 10
increment by 1
maxvalue 99999
minvalue 10;

alter table cursos alter cod_cur set default nextval('cursos_cod_cur_seq');

create table inscripciones (

	cod_cur varchar(15) not null,
	cod_est varchar(10) not null,
	year varchar(4) not null,
	periodo varchar(2) not null,
	constraint pk_inscrip primary key(cod_cur, cod_est, year, periodo),
	constraint fk_cod_cur1 foreign key (cod_cur) references cursos (cod_cur),
	constraint fk_cod_est1 foreign key (cod_est) references estudiantes (cod_est) ON DELETE CASCADE		
);

create table notas(

	nota serial not null,
	desc_nota varchar(30),
	porcentaje int default 0,
	posicion int default 0,
	cod_cur varchar(15),
	constraint pk_nota primary key(nota),
	constraint fk_cod_cur2 foreign key(cod_cur) references cursos(cod_cur)

);

create table calificaciones (

	cod_cal serial not null,
	nota int,
	valor float default 0,
	fecha date,
	cod_cur varchar(15),
	cod_est varchar(10),
	year varchar(4),
	periodo varchar(2),
	constraint pk_califica primary key (cod_cal),
	constraint fk_cur_est_year foreign key (cod_cur, cod_est, year, periodo) references inscripciones (cod_cur, cod_est, year, periodo) ON DELETE CASCADE,
	constraint fk_nota foreign key (nota) references notas(nota)

);



CREATE TABLE eventosestudiantes(
timestamp_ TIMESTAMP WITH TIME ZONE default NOW(),
cod_est varchar(10),
nomb_est varchar(50),
comando text
);

CREATE OR REPLACE FUNCTION grabar_eventosestudiantes() RETURNS TRIGGER AS $$
DECLARE
BEGIN
INSERT INTO eventosestudiantes(
cod_est, 
nomb_est, 
comando 
)
VALUES (
new.cod_est,
new.nomb_est,
TG_OP
);
RETURN NULL;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER grabar_eventosestudiantes AFTER INSERT OR UPDATE OR DELETE
ON estudiantes FOR EACH row
EXECUTE PROCEDURE grabar_eventosestudiantes();


CREATE TABLE eventosnotas(
timestamp_ TIMESTAMP WITH TIME ZONE default NOW(),
nota serial not null,
desc_nota varchar(30),
porcentaje int default 0,
posicion int default 0,
comando text
);

CREATE OR REPLACE FUNCTION grabar_eventosnotas() RETURNS TRIGGER AS $$
DECLARE
BEGIN
INSERT INTO eventosnotas(
nota,
desc_nota,
porcentaje,
posicion,
comando 
)
VALUES (
new.nota,
new.desc_nota,
new.porcentaje,
new.posicion,
TG_OP
);
RETURN NULL;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER grabar_eventosnotas AFTER INSERT OR UPDATE OR DELETE
ON notas FOR EACH row
EXECUTE PROCEDURE grabar_eventosnotas();



INSERT INTO docentes(nomb_doc, clave) VALUES('YAR','123');
INSERT INTO cursos(nomb_cur, cod_doc) VALUES('BASES DE DATOS','1000');
INSERT INTO estudiantes(nomb_est) VALUES('Yarlinson Barranco Bastilla');
INSERT INTO estudiantes(nomb_est)  VALUES('Edwin Fabian Barranco Bastilla');
INSERT INTO estudiantes(nomb_est)  VALUES('Julian Sebantian Jordan');
INSERT INTO inscripciones VALUES('10','4501','2022','1'); 
INSERT INTO inscripciones VALUES('10','4502','2022','1');
INSERT INTO inscripciones VALUES('10','4503','2022','2'); 
INSERT INTO notas (desc_nota, porcentaje, posicion,cod_cur)VALUES('Parcial uno', 30,1,10 );
INSERT INTO notas (desc_nota, porcentaje, posicion,cod_cur)VALUES('Parcial dos', 30,2,10 );
INSERT INTO notas (desc_nota, porcentaje, posicion,cod_cur)VALUES('Examen Final', 40,3,10 );


PARA SELECCION.PHP
SELECT distinct  i.year FROM cursos c, docentes d, inscripciones i, estudiantes e WHERE c.cod_doc=d.cod_doc AND c.cod_cur=i.cod_cur AND i.cod_est=e.cod_est AND d.nomb_doc='YAR';

SELECT  i.year, c.nomb_cur, i.periodo FROM cursos c 
JOIN docentes d ON c.cod_doc=d.cod_doc JOIN inscripciones i ON c.cod_cur=i.cod_cur JOIN estudiantes e ON i.cod_est=e.cod_est WHERE  d.nomb_doc='YAR';

SELECT i.year, c.nomb_cur, i.periodo FROM cursos c, docentes d, inscripciones i, estudiantes e WHERE c.cod_doc=d.cod_doc AND c.cod_cur=i.cod_cur AND i.cod_est=e.cod_est AND d.nomb_doc='$user';

mostrar
  foreach ($consulta as $proyecto) {
     echo $proyecto['year']; 
  }

PARA LISTADO .php

SELECT e.cod_est, e.nomb_est FROM cursos c, docentes d, inscripciones i, estudiantes e WHERE c.cod_doc=d.cod_doc AND c.cod_cur=i.cod_cur AND i.cod_est=e.cod_est AND d.nomb_doc='YAR' AND i.year='2022' AND i.periodo='1' AND c.nomb_cur='BASES DE DATOS';

como no hay notas todavia no se relaciona las calificaciones

DELETE   FROM estudiantes WHERE cod_est='4501';


