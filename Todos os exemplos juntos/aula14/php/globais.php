<?php
//
// Constantes globais de configuração do sistema
//

define ("DIAS_POR_EMPRESTIMO", 1); // Numero de dias que um livro é emprestado
define ("MULTA_POR_DIA", 1.00); // Valor da multa por dia de atraso na entrega

// Define local como português/Brasil
setlocale(LC_TIME, "pt_BR");
// Define o local como Brasil e fuso horário como brasilia
date_default_timezone_set("America/Sao_Paulo");



?>