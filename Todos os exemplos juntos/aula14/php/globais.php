<?php
//
// Constantes globais de configura��o do sistema
//

define ("DIAS_POR_EMPRESTIMO", 1); // Numero de dias que um livro � emprestado
define ("MULTA_POR_DIA", 1.00); // Valor da multa por dia de atraso na entrega

// Define local como portugu�s/Brasil
setlocale(LC_TIME, "pt_BR");
// Define o local como Brasil e fuso hor�rio como brasilia
date_default_timezone_set("America/Sao_Paulo");



?>