#!/bin/bash

# 1) Prepara o banco de dados
# 2) Copia todos os arquivos necess�rios para o diret�rio
# public_html do usu�rio
# 3) Inicia o navegador

directory=$1
file=$2
other_files=$3

mkdir -p ~/public_html/${directory} 2> /dev/null;

mysql -f -u root  -ppolocederj  < sql/setup_04.sql;
mysql -f -u aluno -paluno prog2 < sql/create_tables.sql;
mysql -f -u aluno -paluno prog2 < sql/populate_tables.sql;


for i in ${file} ${other_files}; do
    \cp -f php/$i ~/public_html/${directory};
    chmod +w ~/public_html/${directory}/$i;
done

firefox webserver/~`whoami`/${directory}/${file} &
