-- Drop database prog2
drop database prog2;

-- Create user aluno
use mysql;

insert into user ( Host, User, Password )
values ( 'localhost', 'aluno', password( 'aluno' ) );

flush privileges;

-- Recreate database prog
create database prog2;
grant all privileges on prog2.* to 'aluno'@'localhost' identified by 'aluno';
grant all privileges on prog2.* to 'aluno'@'%' identified by 'aluno';
