CREATE DATABASE findjob;

CREATE TABLE usuario(
    id INT NOT NULL AUTO_INCREMENT,
    nome varchar(255),
    email varchar(100),
    senha varchar(255),
    tipo varchar(20),
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
    cargo_experiencia varchar(100),	
    cidade varchar(100),
    level_ingles varchar(20),
    level_espanhol varchar(20),
    formacao varchar(300),
    telefone varchar(20),	
    genero	varchar(30),
    salario	varchar(20),
    experiencia	varchar(300),	
    apresentacao varchar(300),
    PRIMARY KEY (id)
);
