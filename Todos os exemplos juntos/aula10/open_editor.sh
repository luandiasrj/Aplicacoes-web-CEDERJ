#!/bin/bash

# Abre o editor kate com o arquivo dado

directory=$1
file=$2

mkdir -p ~/public_html/${directory} 2> /dev/null;

\cp -f php/${file} ~/public_html/${directory};
chmod +w ~/public_html/${directory}/${file};

kate ~/public_html/${directory}/${file}
