<?php assegura_privilegio ('M'); ?>

<h2> Login OK </h2>
<p> Bem vindo ao sistema de bibliotecas, <?=$_SESSION['login']?>. </p>

<?php
link_pagina_principal ();
?>
