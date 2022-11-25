
-- Create tables
create table cliente (
    id int not null auto_increment,
    nome varchar(50) not null,
    endereco varchar(80),
    primary key (id),
    key nomecliente(nome)
);

create table conta (
    numero int not null auto_increment,
    saldo decimal(16,2) default 0.0,
    primary key (numero)
);

create table possui (
    idcliente int not null,
    numconta int,
    primary key (idcliente,numconta)
);

create table livros (
    idlivro int not null auto_increment, 
    titulo varchar(80), 
    descricao varchar(100), 
    fotocapa longblob,
    primary key (idlivro)
);

create table itens 
(
    IdItem int not null auto_increment, 
    descricao varchar(100),
    primary key (IdItem)
);

create table compras 
(
    idCliente int, 
    IdItem int, 
    preco float, 
    qtde int, 
    desconto float
);
