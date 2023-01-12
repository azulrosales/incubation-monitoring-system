CREATE DATABASE incubit;

USE incubit;

CREATE TABLE medicion(
    id_medicion INT PRIMARY KEY,
    id_gallinero INT,
    temperatura FLOAT(4),
    humedad FLOAT(4),
    fecha DATE,
    hora TIME
);

CREATE TABLE gallinero(
    id_gallinero INT PRIMARY KEY,
    n_huevos INT
);

CREATE TABLE usuario(
    id_usuario INT PRIMARY KEY,
    nombre CHAR(10),
    id_gallinero INT
);

ALTER TABLE medicion ADD FOREIGN KEY (id_gallinero) REFERENCES gallinero (id_gallinero);

ALTER TABLE usuario ADD FOREIGN KEY (id_gallinero) REFERENCES gallinero (id_gallinero);             