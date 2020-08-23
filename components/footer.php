<?php
   setlocale(LC_TIME, 'ita', 'it_IT.utf8');
   $time=time();
   $date = strftime("%Y",$time);

   echo '<footer class="sticky-footer bg-white">';
   echo '<div class="container my-auto">';
   echo '<div class="copyright text-center my-auto">';
   echo '<span>Safe Panda di <b>Lorenzo Ricciardi</b> '.$date.' <img src="img/safePanda.png" height="15"></span>';
   echo '</div>';
   echo '</div>';
   echo '</footer>';

?>
