<?php

   //Session
   session_start();

   if(!isset($_SESSION['login']))
      if(isset($_COOKIE['login'])){
         $_SESSION['login'] = 'ok';
      }
      else
         header("Location: login.php");


   //
 /*  if(isset($_SESSION['login']) && ($_SESSION['timeout']+1*60) < time())
      header('Location: lockscreen.php');
*/
   //Logout
   if(isset($_POST['logout'])){
      session_destroy();
      header('Location: login.php');
      if(isset($_COOKIE['login']))
         setcookie("login", "", time() - 3600);
      header('Location: login.php');
   }


?>
