DROP SCHEMA IF EXISTS ANOTAHUB;

CREATE SCHEMA IF NOT EXISTS ANOTAHUB;

USE ANOTAHUB;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255),
    tel VARCHAR(255) NOT NULL,
    cpf VARCHAR(255) NOT NULL,
    nascimento VARCHAR(255) NOT NULL,
    foto VARCHAR(255),
    senha VARCHAR(255) NOT NULL
);

CREATE TABLE agenda (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    descricao VARCHAR(255) NOT NULL,
    data_publicada DATE,
    hora_publicada TIME,
    concluido TINYINT(1) DEFAULT 0,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);


CREATE TABLE caderno (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    nome VARCHAR(255) NOT NULL,
    conteudo TEXT,
    cor VARCHAR(255),
    favoritar TINYINT(1) DEFAULT 0,
    ocultar TINYINT(1) DEFAULT 0,
    ultimo_acesso DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

CREATE TABLE videos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    caderno_id INT,
    descricao VARCHAR(255) NOT NULL,
    link TEXT,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (caderno_id) REFERENCES caderno(id) ON DELETE CASCADE
);

CREATE TABLE sugestoes(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    usuario_id INT,
    curtir TINYINT(1) DEFAULT 0,
    data_publicada DATETIME DEFAULT CURRENT_TIMESTAMP,
    comentario VARCHAR(255) NOT NULL,
    id_pai INT DEFAULT NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (id_pai) REFERENCES sugestoes(id) ON DELETE CASCADE
);

INSERT INTO usuarios (nome, email, tel, cpf, nascimento, foto, senha)
VALUES
    ('Adm', 'adm@gmail.com', '(18) 99234-5354', '123.456.789-01', '1990-05-15', 'uploads/adm.jpg', SHA2('Adm.12345', 256));


CREATE TABLE IF NOT EXISTS usuario_token (
    id_usuario INT,
    token VARCHAR(255),
    data_expiracao DATETIME,
    PRIMARY KEY (id_usuario, token)
);

ALTER TABLE usuario_token
ADD CONSTRAINT FK_USUARIOS_TOKEN
FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
ON DELETE CASCADE
ON UPDATE CASCADE;