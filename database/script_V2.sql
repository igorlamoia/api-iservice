create schema iService;
use iService;

CREATE TABLE Usuario (
    codUsuario INTEGER PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(75),
    cpf VARCHAR(11),
    email VARCHAR(75),
    numTelefone VARCHAR(11),
    dataNascimento DATE,
    linkFoto VARCHAR(255),
    idFirebase VARCHAR(255)
);

CREATE TABLE Prestador (
    codPrestador INTEGER PRIMARY KEY AUTO_INCREMENT,
    descricaoProfissional VARCHAR(255),
    horarioDisponivel VARCHAR(25),
    fk_Usuario_codUsuario INTEGER
);

CREATE TABLE DemandaEscolher (
    fk_Usuario_codUsuario INTEGER,
    fk_Prestador_codPrestador INTEGER,
    PRIMARY KEY (fk_Prestador_codPrestador, fk_Usuario_codUsuario)
);

CREATE TABLE Atendimento (
    codAtendimento INTEGER PRIMARY KEY AUTO_INCREMENT,
    data DATE,
    booleanHaveraVisita BOOLEAN,
    descricao VARCHAR(255),
    fk_DemandaEscolher_codUsuario INTEGER NOT NULL,
    fk_DemandaEscolher_codPrestador INTEGER NOT NULL
);

CREATE TABLE Especialidade (
    codEspecialidade INTEGER PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(75),
    descricao VARCHAR(255),
    fk_Categoria_codCategoria INTEGER NOT NULL
);

CREATE TABLE Chat (
    codChat INTEGER PRIMARY KEY AUTO_INCREMENT,
    texto VARCHAR(255),
    linkFoto VARCHAR(255),
    linkVideo VARCHAR(255),
    linkAudio VARCHAR(255),
    fk_DemandaEscolher_codUsuario INTEGER NOT NULL,
    fk_DemandaEscolher_codPrestador INTEGER NOT NULL
);

CREATE TABLE Endereco (
    codEnd INTEGER PRIMARY KEY AUTO_INCREMENT,
    rua VARCHAR(75),
    bairro VARCHAR(75),
    cep VARCHAR(8),
    cidade VARCHAR(75),
    estado VARCHAR(75)
);

CREATE TABLE Categoria (
    codCategoria INTEGER PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(75)
);

CREATE TABLE Cidade (
    codCidade INTEGER PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(75),
    fk_Estado_codEstado INTEGER NOT NULL
);

CREATE TABLE Estado (
    codEstado INTEGER PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(75)
);

CREATE TABLE Nota (
    codNota INTEGER PRIMARY KEY AUTO_INCREMENT,
    nota DOUBLE,
    fk_Atendimento_codAtendimento INTEGER NOT NULL
);

CREATE TABLE PrestadorEspecialidade (
    fk_Prestador_codPrestador INTEGER,
    fk_Especialidade_codEspecialidade INTEGER,
    PRIMARY KEY (fk_Prestador_codPrestador, fk_Especialidade_codEspecialidade)
);

CREATE TABLE PrestadorAvaliaAtendimento (
    fk_Prestador_codPrestador INTEGER,
    fk_Atendimento_codAtendimento INTEGER,
    data TIMESTAMP,
    texto VARCHAR(255),
    linkFoto VARCHAR(255),
    linkVideo VARCHAR(255),
    linkAudio VARCHAR(255),
    PRIMARY KEY (fk_Prestador_codPrestador, fk_Atendimento_codAtendimento)
);

CREATE TABLE UsuarioAvaliaAtendimento (
    fk_Usuario_codUsuario INTEGER,
    fk_Atendimento_codAtendimento INTEGER,
    data TIMESTAMP,
    texto VARCHAR(255),
    linkFoto VARCHAR(255),
    linkVideo VARCHAR(255),
    linkAudio VARCHAR(255),
    PRIMARY KEY (fk_Usuario_codUsuario, fk_Atendimento_codAtendimento)
);

CREATE TABLE UsuarioEndereco (
    fk_Usuario_codUsuario INTEGER,
    fk_Endereco_codEnd INTEGER,
    booleanPrincipal BOOLEAN,
    endNumero INTEGER,
    endComplemento VARCHAR(75),
    PRIMARY KEY (fk_Usuario_codUsuario, fk_Endereco_codEnd)
);

CREATE TABLE PrestadorCidade (
    fk_Prestador_codPrestador INTEGER,
    fk_Cidade_codCidade INTEGER,
    PRIMARY KEY (fk_Prestador_codPrestador, fk_Cidade_codCidade)
);

CREATE TABLE UsuarioNota (
    fk_Usuario_codUsuario INTEGER,
    fk_Nota_codNota INTEGER,
    PRIMARY KEY (fk_Usuario_codUsuario, fk_Nota_codNota)
);

CREATE TABLE PrestadorNota (
    fk_Prestador_codPrestador INTEGER,
    fk_Nota_codNota INTEGER,
    PRIMARY KEY (fk_Prestador_codPrestador, fk_Nota_codNota)
);
 
ALTER TABLE Prestador ADD CONSTRAINT FK_Prestador_2
    FOREIGN KEY (fk_Usuario_codUsuario)
    REFERENCES Usuario (codUsuario)
    ON DELETE CASCADE;
 
ALTER TABLE DemandaEscolher ADD CONSTRAINT FK_DemandaEscolher_1
    FOREIGN KEY (fk_Prestador_codPrestador)
    REFERENCES Prestador (codPrestador);
 
ALTER TABLE DemandaEscolher ADD CONSTRAINT FK_DemandaEscolher_2
    FOREIGN KEY (fk_Usuario_codUsuario)
    REFERENCES Usuario (codUsuario);
    
ALTER TABLE Atendimento ADD CONSTRAINT FK_Atendimento_1
    FOREIGN KEY (fk_DemandaEscolher_codUsuario)
    REFERENCES DemandaEscolher (fk_Usuario_codUsuario);
 
ALTER TABLE Atendimento ADD CONSTRAINT FK_Atendimento_2
    FOREIGN KEY (fk_DemandaEscolher_codPrestador)
    REFERENCES DemandaEscolher (fk_Prestador_codPrestador);
 
ALTER TABLE Especialidade ADD CONSTRAINT FK_Especialidade_2
    FOREIGN KEY (fk_Categoria_codCategoria)
    REFERENCES Categoria (codCategoria)
    ON DELETE RESTRICT;
    
ALTER TABLE Chat ADD CONSTRAINT FK_Chat_1
    FOREIGN KEY (fk_DemandaEscolher_codUsuario)
    REFERENCES DemandaEscolher (fk_Usuario_codUsuario);
 
ALTER TABLE Chat ADD CONSTRAINT FK_Chat_2
    FOREIGN KEY (fk_DemandaEscolher_codPrestador)
    REFERENCES DemandaEscolher (fk_Prestador_codPrestador);
 
ALTER TABLE Cidade ADD CONSTRAINT FK_Cidade_2
    FOREIGN KEY (fk_Estado_codEstado)
    REFERENCES Estado (codEstado)
    ON DELETE RESTRICT;
 
ALTER TABLE Nota ADD CONSTRAINT FK_Nota_2
    FOREIGN KEY (fk_Atendimento_codAtendimento)
    REFERENCES Atendimento (codAtendimento)
    ON DELETE CASCADE;
 
ALTER TABLE PrestadorEspecialidade ADD CONSTRAINT FK_PrestadorEspecialidade_1
    FOREIGN KEY (fk_Especialidade_codEspecialidade)
    REFERENCES Especialidade (codEspecialidade)
    ON DELETE RESTRICT;
 
ALTER TABLE PrestadorEspecialidade ADD CONSTRAINT FK_PrestadorEspecialidade_2
    FOREIGN KEY (fk_Prestador_codPrestador)
    REFERENCES Prestador (codPrestador)
    ON DELETE RESTRICT;
 
ALTER TABLE PrestadorAvaliaAtendimento ADD CONSTRAINT FK_PrestadorAvaliaAtendimento_1
    FOREIGN KEY (fk_Prestador_codPrestador)
    REFERENCES Prestador (codPrestador)
    ON DELETE RESTRICT;
 
ALTER TABLE PrestadorAvaliaAtendimento ADD CONSTRAINT FK_PrestadorAvaliaAtendimento_2
    FOREIGN KEY (fk_Atendimento_codAtendimento)
    REFERENCES Atendimento (codAtendimento)
    ON DELETE RESTRICT;
 
ALTER TABLE UsuarioAvaliaAtendimento ADD CONSTRAINT FK_UsuarioAvaliaAtendimento_1
    FOREIGN KEY (fk_Usuario_codUsuario)
    REFERENCES Usuario (codUsuario)
    ON DELETE RESTRICT;
 
ALTER TABLE UsuarioAvaliaAtendimento ADD CONSTRAINT FK_UsuarioAvaliaAtendimento_2
    FOREIGN KEY (fk_Atendimento_codAtendimento)
    REFERENCES Atendimento (codAtendimento)
    ON DELETE RESTRICT;
 
ALTER TABLE UsuarioEndereco ADD CONSTRAINT FK_UsuarioEndereco_1
    FOREIGN KEY (fk_Endereco_codEnd)
    REFERENCES Endereco (codEnd)
    ON DELETE RESTRICT;
 
ALTER TABLE UsuarioEndereco ADD CONSTRAINT FK_UsuarioEndereco_2
    FOREIGN KEY (fk_Usuario_codUsuario)
    REFERENCES Usuario (codUsuario)
    ON DELETE RESTRICT;
 
ALTER TABLE PrestadorCidade ADD CONSTRAINT FK_PrestadorCidade_1
    FOREIGN KEY (fk_Cidade_codCidade)
    REFERENCES Cidade (codCidade)
    ON DELETE RESTRICT;
 
ALTER TABLE PrestadorCidade ADD CONSTRAINT FK_PrestadorCidade_2
    FOREIGN KEY (fk_Prestador_codPrestador)
    REFERENCES Prestador (codPrestador)
    ON DELETE RESTRICT;
 
ALTER TABLE UsuarioNota ADD CONSTRAINT FK_UsuarioNota_1
    FOREIGN KEY (fk_Usuario_codUsuario)
    REFERENCES Usuario (codUsuario)
    ON DELETE RESTRICT;
 
ALTER TABLE UsuarioNota ADD CONSTRAINT FK_UsuarioNota_2
    FOREIGN KEY (fk_Nota_codNota)
    REFERENCES Nota (codNota)
    ON DELETE RESTRICT;
 
ALTER TABLE PrestadorNota ADD CONSTRAINT FK_PrestadorNota_1
    FOREIGN KEY (fk_Prestador_codPrestador)
    REFERENCES Prestador (codPrestador)
    ON DELETE RESTRICT;
 
ALTER TABLE PrestadorNota ADD CONSTRAINT FK_PrestadorNota_2
    FOREIGN KEY (fk_Nota_codNota)
    REFERENCES Nota (codNota)
    ON DELETE RESTRICT;
    
/* Povoando o BD */
/* Endereço */
insert into Endereco (rua, bairro, cep, cidade, estado) values ('Rua A', 'Centro', '36700000', 'Leopoldina', 'Minas
Gerais');
insert into Endereco (rua, bairro, cep, cidade, estado) values ('Rua B', 'Centro', '36700000', 'Leopoldina', 'Minas
Gerais');
insert into Endereco (rua, bairro, cep, cidade, estado) values ('Rua C', 'Centro', '36700000', 'Leopoldina', 'Minas
Gerais');
insert into Endereco (rua, bairro, cep, cidade, estado) values ('Rua D', 'Centro', '36700000', 'Leopoldina', 'Minas
Gerais');
insert into Endereco (rua, bairro, cep, cidade, estado) values ('Rua E', 'Centro', '36700000', 'Leopoldina', 'Minas
Gerais');
insert into Endereco (rua, bairro, cep, cidade, estado) values ('Rua F', 'Centro', '36700000', 'Leopoldina', 'Minas
Gerais');
insert into Endereco (rua, bairro, cep, cidade, estado) values ('Rua G', 'Centro', '36700000', 'Leopoldina', 'Minas
Gerais');
insert into Endereco (rua, bairro, cep, cidade, estado) values ('Rua H', 'Centro', '36700000', 'Leopoldina', 'Minas
Gerais');
insert into Endereco (rua, bairro, cep, cidade, estado) values ('Rua I', 'Centro', '36700000', 'Leopoldina', 'Minas
Gerais');
insert into Endereco (rua, bairro, cep, cidade, estado) values ('Rua J', 'Centro', '36700000', 'Leopoldina', 'Minas
Gerais');
insert into Endereco (rua, bairro, cep, cidade, estado) values ('Rua K', 'Centro', '36700000', 'Leopoldina', 'Minas
Gerais');
insert into Endereco (rua, bairro, cep, cidade, estado) values ('Rua L', 'Centro', '36700000', 'Leopoldina', 'Minas
Gerais');
insert into Endereco (rua, bairro, cep, cidade, estado) values ('Rua M', 'Centro', '36700000', 'Leopoldina', 'Minas
Gerais');
insert into Endereco (rua, bairro, cep, cidade, estado) values ('Rua N', 'Centro', '36700000', 'Leopoldina', 'Minas
Gerais');
insert into Endereco (rua, bairro, cep, cidade, estado) values ('Rua O', 'Centro', '36700000', 'Leopoldina', 'Minas
Gerais');

/* Usuário */
insert into Usuario (nome, cpf, email, numTelefone, dataNascimento, linkFoto, idFirebase) values ('João da Silva', '22222222233',
'joaodasilva@gmail.com', '32999221133', '1988-03-01', null, null);
insert into Usuario (nome, cpf, email, numTelefone, dataNascimento, linkFoto, idFirebase) values ('Paula Souza', '33333333322',
'paulasouza@gmail.com', '32999221133', '1990-06-07', null, null);
insert into Usuario (nome, cpf, email, numTelefone, dataNascimento, linkFoto, idFirebase) values ('Joana Macedo', '44444444444',
'joanamacedo@gmail.com', '32955331133', '2000-12-05', null, null);
insert into Usuario (nome, cpf, email, numTelefone, dataNascimento, linkFoto, idFirebase) values ('André Castro', '55555555555',
'andrecastro@gmail.com', '32911331133', '1979-01-11', null, null);
insert into Usuario (nome, cpf, email, numTelefone, dataNascimento, linkFoto, idFirebase) values ('Ana Coelho', '1111111111',
'anacoelho@gmail.com', '32999229922', '1985-12-12', null, null);
insert into Usuario (nome, cpf, email, numTelefone, dataNascimento, linkFoto, idFirebase) values ('Cásio Monique', '88888888822',
'casio@gmail.com', '32978099866', '1989-02-12', null, null);
insert into Usuario (nome, cpf, email, numTelefone, dataNascimento, linkFoto, idFirebase) values ('Casemiro de Sousa', '77777777733',
'casemiro@gmail.com', '32912344321', '1998-07-11', null, null);
insert into Usuario (nome, cpf, email, numTelefone, dataNascimento, linkFoto, idFirebase) values ('Paulo Sergio', '82112353233',
'paulosergio@gmail.com', '32990822233', '1996-06-11', null, null);

/* Usuário Endereço */
insert into UsuarioEndereco (fk_Usuario_codUsuario, fk_Endereco_codEnd, booleanPrincipal, endNumero, endComplemento) values (0001, 0008, True, 55, 'Casa');
insert into UsuarioEndereco (fk_Usuario_codUsuario, fk_Endereco_codEnd, booleanPrincipal, endNumero, endComplemento) values (0002, 0007, True, 5, 'Casa');
insert into UsuarioEndereco (fk_Usuario_codUsuario, fk_Endereco_codEnd, booleanPrincipal, endNumero, endComplemento) values (0003, 0006, True, 6, 'Casa');
insert into UsuarioEndereco (fk_Usuario_codUsuario, fk_Endereco_codEnd, booleanPrincipal, endNumero, endComplemento) values (0004, 0005, True, 1, 'Casa');
insert into UsuarioEndereco (fk_Usuario_codUsuario, fk_Endereco_codEnd, booleanPrincipal, endNumero, endComplemento) values (0005, 0004, True, 16, 'Casa');
insert into UsuarioEndereco (fk_Usuario_codUsuario, fk_Endereco_codEnd, booleanPrincipal, endNumero, endComplemento) values (0006, 0003, True, 62, 'Casa');
insert into UsuarioEndereco (fk_Usuario_codUsuario, fk_Endereco_codEnd, booleanPrincipal, endNumero, endComplemento) values (0007, 0002, True, 17, 'Casa');
insert into UsuarioEndereco (fk_Usuario_codUsuario, fk_Endereco_codEnd, booleanPrincipal, endNumero, endComplemento) values (0008, 0001, True, 91, 'Casa');
insert into UsuarioEndereco (fk_Usuario_codUsuario, fk_Endereco_codEnd, booleanPrincipal, endNumero, endComplemento) values (0002, 0009, False, 102, 'Casa');
insert into UsuarioEndereco (fk_Usuario_codUsuario, fk_Endereco_codEnd, booleanPrincipal, endNumero, endComplemento) values (0005, 0010, False, 165, 'Casa');

/* Prestador */
insert into Prestador (descricaoProfissional, horarioDisponivel, fk_Usuario_codUsuario) values ('Especialista na área há 7 dias.', '8:00 até 17:00', 0006);
insert into Prestador (descricaoProfissional, horarioDisponivel, fk_Usuario_codUsuario) values ('Acordo tarde, trabalho pouco e cobro muito.', '10:00 até 16:00', 0007);
insert into Prestador (descricaoProfissional, horarioDisponivel, fk_Usuario_codUsuario) values ('Pedreiro de obra pronta.', '9:00 até 20:00', 0008);

/* Estado */
insert into Estado (nome) values ('Minas Gerais');
insert into Estado (nome) values ('Rio de Janeiro');
insert into Estado (nome) values ('São Paulo');

/* Cidade */
insert into Cidade (nome, fk_Estado_codEstado) values ('Leopoldina', 0001);
insert into Cidade (nome, fk_Estado_codEstado) values ('Cataguases', 0001);
insert into Cidade (nome, fk_Estado_codEstado) values ('Rio de Janeiro', 0002);

/* Prestador Cidade */
insert into PrestadorCidade (fk_Prestador_codPrestador, fk_Cidade_codCidade) values (0001, 0001);
insert into PrestadorCidade (fk_Prestador_codPrestador, fk_Cidade_codCidade) values (0001, 0002);
insert into PrestadorCidade (fk_Prestador_codPrestador, fk_Cidade_codCidade) values (0002, 0001);
insert into PrestadorCidade (fk_Prestador_codPrestador, fk_Cidade_codCidade) values (0002, 0002);
insert into PrestadorCidade (fk_Prestador_codPrestador, fk_Cidade_codCidade) values (0003, 0001);

/* Categoria */
insert into Categoria (nome) values ('Serviços gerais');

/* Especialidade */
insert into Especialidade (nome, descricao, fk_Categoria_codCategoria) values ('Eletricista', 'Serviços elétricos em geral', 0001);
insert into Especialidade (nome, descricao, fk_Categoria_codCategoria) values ('Pintor', 'Serviços gerais de pintura', 0001);
insert into Especialidade (nome, descricao, fk_Categoria_codCategoria) values ('Eletricista', 'Serviços elétricos em geral', 0001);

/* Prestador Especialidade */
insert into PrestadorEspecialidade (fk_Prestador_codPrestador, fk_Especialidade_codEspecialidade) values (0001, 0001);
insert into PrestadorEspecialidade (fk_Prestador_codPrestador, fk_Especialidade_codEspecialidade) values (0002, 0002);
insert into PrestadorEspecialidade (fk_Prestador_codPrestador, fk_Especialidade_codEspecialidade) values (0003, 0003);

/* Demanda Escolher */
insert into DemandaEscolher (fk_Usuario_codUsuario, fk_Prestador_codPrestador) values (0001, 0001);
insert into DemandaEscolher (fk_Usuario_codUsuario, fk_Prestador_codPrestador) values (0001, 0002);
insert into DemandaEscolher (fk_Usuario_codUsuario, fk_Prestador_codPrestador) values (0002, 0003);
insert into DemandaEscolher (fk_Usuario_codUsuario, fk_Prestador_codPrestador) values (0002, 0002);
insert into DemandaEscolher (fk_Usuario_codUsuario, fk_Prestador_codPrestador) values (0003, 0001);

/* Atendimento */
insert into Atendimento (data, booleanHaveraVisita, descricao, fk_DemandaEscolher_codUsuario, fk_DemandaEscolher_codPrestador) values ('2022-06-06', True, 'Troca de um disjuntor', 0001, 0001);
insert into Atendimento (data, booleanHaveraVisita, descricao, fk_DemandaEscolher_codUsuario, fk_DemandaEscolher_codPrestador) values ('2022-06-07', True, 'Troca da resistência do chuveiro', 0001, 0002);
insert into Atendimento (data, booleanHaveraVisita, descricao, fk_DemandaEscolher_codUsuario, fk_DemandaEscolher_codPrestador) values ('2022-06-07', True, 'Pintura interna na casa', 0002, 0003);
insert into Atendimento (data, booleanHaveraVisita, descricao, fk_DemandaEscolher_codUsuario, fk_DemandaEscolher_codPrestador) values ('2022-06-08', True, 'Pintura de 2 portas', 0002, 0002);
insert into Atendimento (data, booleanHaveraVisita, descricao, fk_DemandaEscolher_codUsuario, fk_DemandaEscolher_codPrestador) values ('2022-06-09', True, 'Instalação de tomadas e interruptores', 0003, 0001);

/* Nota */
insert into Nota (nota, fk_Atendimento_codAtendimento) values (4.7, 0001);
insert into Nota (nota, fk_Atendimento_codAtendimento) values (4.1, 0001);
insert into Nota (nota, fk_Atendimento_codAtendimento) values (3.9, 0002);
insert into Nota (nota, fk_Atendimento_codAtendimento) values (4.0, 0002);
insert into Nota (nota, fk_Atendimento_codAtendimento) values (4.9, 0003);
insert into Nota (nota, fk_Atendimento_codAtendimento) values (5.0, 0003);
insert into Nota (nota, fk_Atendimento_codAtendimento) values (2.5, 0004);
insert into Nota (nota, fk_Atendimento_codAtendimento) values (1.0, 0004);
insert into Nota (nota, fk_Atendimento_codAtendimento) values (3.5, 0005);
insert into Nota (nota, fk_Atendimento_codAtendimento) values (4.0, 0005);

/* Prestador Nota */
insert into PrestadorNota (fk_Prestador_codPrestador, fk_Nota_codNota) values (0001, 0002);
insert into PrestadorNota (fk_Prestador_codPrestador, fk_Nota_codNota) values (0002, 0004);
insert into PrestadorNota (fk_Prestador_codPrestador, fk_Nota_codNota) values (0003, 0006);
insert into PrestadorNota (fk_Prestador_codPrestador, fk_Nota_codNota) values (0002, 0008);
insert into PrestadorNota (fk_Prestador_codPrestador, fk_Nota_codNota) values (0001, 0010);

/* Usuario Nota */
insert into UsuarioNota (fk_Usuario_codUsuario, fk_Nota_codNota) values (0001, 0001);
insert into UsuarioNota (fk_Usuario_codUsuario, fk_Nota_codNota) values (0001, 0003);
insert into UsuarioNota (fk_Usuario_codUsuario, fk_Nota_codNota) values (0002, 0005);
insert into UsuarioNota (fk_Usuario_codUsuario, fk_Nota_codNota) values (0002, 0007);
insert into UsuarioNota (fk_Usuario_codUsuario, fk_Nota_codNota) values (0003, 0009);

/* Chat */
insert into Chat (texto, linkFoto, linkVideo, linkAudio, fk_DemandaEscolher_codUsuario, fk_DemandaEscolher_codPrestador) values ('Bom dia, moro na Rua A no Centro de Leopoldina e
preciso trocar um disjuntor...', null, null, null, 0001, 0001);
insert into Chat (texto, linkFoto, linkVideo, linkAudio, fk_DemandaEscolher_codUsuario, fk_DemandaEscolher_codPrestador) values ('Bom dia, moro na Rua E no Centro de Leopoldina e
preciso trocar a resistência do chuveiro...', null, null, null, 0001, 0002);
insert into Chat (texto, linkFoto, linkVideo, linkAudio, fk_DemandaEscolher_codUsuario, fk_DemandaEscolher_codPrestador) values ('Bom dia, moro na Rua B no Centro de Leopoldina e
preciso pintar um cômodo dentro de casa...', null, null, null, 0002, 0003);
insert into Chat (texto, linkFoto, linkVideo, linkAudio, fk_DemandaEscolher_codUsuario, fk_DemandaEscolher_codPrestador) values ('Bom dia, moro na Rua D no Centro de Leopoldina e
preciso pintar 2 portas na minha casa...', null, null, null, 0002, 0002);
insert into Chat (texto, linkFoto, linkVideo, linkAudio, fk_DemandaEscolher_codUsuario, fk_DemandaEscolher_codPrestador) values ('Bom dia, moro na Rua C no Centro de Leopoldina e
preciso instalar tomadas e interruptores em casa...', null, null, null, 0003, 0001);

/* Prestador Avalia Atendimento */
insert into PrestadorAvaliaAtendimento (fk_Prestador_codPrestador, fk_Atendimento_codAtendimento, data, texto, linkFoto, linkVideo, linkAudio) values (0001, 0001, '2022-06-06 15:45:52', 'Um ótimo contratante', null, null, null);
insert into PrestadorAvaliaAtendimento (fk_Prestador_codPrestador, fk_Atendimento_codAtendimento, data, texto, linkFoto, linkVideo, linkAudio) values (0002, 0002, '2022-06-07 10:15:02', 'Um ótimo contratante', null, null, null);
insert into PrestadorAvaliaAtendimento (fk_Prestador_codPrestador, fk_Atendimento_codAtendimento, data, texto, linkFoto, linkVideo, linkAudio) values (0003, 0003, '2022-06-07 12:25:00', 'Um ótimo contratante', null, null, null);
insert into PrestadorAvaliaAtendimento (fk_Prestador_codPrestador, fk_Atendimento_codAtendimento, data, texto, linkFoto, linkVideo, linkAudio) values (0002, 0004, '2022-06-08 09:08:06', 'Um ótimo contratante', null, null, null);
insert into PrestadorAvaliaAtendimento (fk_Prestador_codPrestador, fk_Atendimento_codAtendimento, data, texto, linkFoto, linkVideo, linkAudio) values (0001, 0005, '2022-06-09 15:15:20', 'Um ótimo contratante', null, null, null);

/* Usuario Avalia Atendimento */
insert into UsuarioAvaliaAtendimento (fk_Usuario_codUsuario, fk_Atendimento_codAtendimento, data, texto, linkFoto, linkVideo, linkAudio) values (0001, 0001, '2022-06-06 15:49:52', 'Um ótimo prestador de serviço', null, null, null);
insert into UsuarioAvaliaAtendimento (fk_Usuario_codUsuario, fk_Atendimento_codAtendimento, data, texto, linkFoto, linkVideo, linkAudio) values (0001, 0002, '2022-06-07 10:05:18', 'Um ótimo prestador de serviço', null, null, null);
insert into UsuarioAvaliaAtendimento (fk_Usuario_codUsuario, fk_Atendimento_codAtendimento, data, texto, linkFoto, linkVideo, linkAudio) values (0002, 0003, '2022-06-07 11:55:00', 'Um ótimo prestador de serviço', null, null, null);
insert into UsuarioAvaliaAtendimento (fk_Usuario_codUsuario, fk_Atendimento_codAtendimento, data, texto, linkFoto, linkVideo, linkAudio) values (0002, 0004, '2022-06-08 08:25:20', 'Um ótimo prestador de serviço', null, null, null);
insert into UsuarioAvaliaAtendimento (fk_Usuario_codUsuario, fk_Atendimento_codAtendimento, data, texto, linkFoto, linkVideo, linkAudio) values (0003, 0005, '2022-06-09 13:55:05', 'Um ótimo prestador de serviço', null, null, null);
