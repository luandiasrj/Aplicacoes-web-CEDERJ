-- Drop table test
drop table test;

-- Recreate table test
create table test ( a int not null, 
                    b varchar(20) default '**' );

-- Populate table test
insert into test values( 1, 'a' );
insert into test values( 2, 'b' );
insert into test values( 3, 'c' );
