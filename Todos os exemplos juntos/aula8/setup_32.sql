-- Recreate table
drop table cliente_saldo;
create table cliente_saldo (nome varchar(50), saldo decimal(16,2));

-- Populate table
insert into cliente_saldo(nome,saldo)
    select nome, avg(saldo)
    from cliente, possui, conta
    where id = idcliente and numconta=numero
    group by nome;
