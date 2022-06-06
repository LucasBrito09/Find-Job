CREATE DATABASE findjob;

CREATE TABLE usuario(
    id INT NOT NULL AUTO_INCREMENT,
    nome varchar(255),
    email varchar(100),
    senha varchar(255),
    hash varchar(255),
    PRIMARY KEY (id)
);

CREATE TABLE vaga(
    id INT NOT NULL AUTO_INCREMENT,
    idDono INT NOT NULL,
    titulo varchar(200),
    empresa varchar(200),
    salario varchar(200),
    descricao longtext,
    pais varchar(250),
    estado varchar(250),
    cidade varchar(250),
    tipo_contrato varchar(200),
    nivel varchar(200)
    forma_trabalho varchar(200), 
    PRIMARY KEY (id)
);

CREATE TABLE curriculo(
    id INT NOT NULL AUTO_INCREMENT,
    idVaga INT NOT NULL,
    idEnviou INT NOT NULL,
    path varchar(250),
    filename varchar(250),
    PRIMARY KEY (id)
);
