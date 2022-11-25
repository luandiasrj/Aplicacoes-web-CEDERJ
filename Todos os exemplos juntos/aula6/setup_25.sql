-- Drop database prog2
drop database prog2;

-- Create user aluno
use mysql;

insert into user ( Host, User, Password )
values ( 'localhost', 'aluno', password( 'aluno' ) );

flush privileges;
