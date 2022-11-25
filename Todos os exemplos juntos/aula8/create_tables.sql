
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
