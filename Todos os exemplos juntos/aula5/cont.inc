<?
   class contador
   {
   // variaveis
   var $cont = 0;
   var $inicio = 0;
   // Metodos
   function IniciaContadorEm($i)
   {
      $this->cont = $i;
      $this->inicio = $i;
   }
   function Incrementa()
   {
      $this->cont ++;
   }
   function reset()
   {
      $this->cont = $this->inicio;
   }
   function EscreveValor()
   {
      print $this->cont;
   }
   }
?>