<?php

   include 'account/variables.php';

   try{
   // connect to mysql
   $con = new PDO($dsn,$dbUser,$dbPassword);
   $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   }catch (Exception $ex) {
   echo 'Not Connected '.$ex->getMessage();
   }

   //mysql query
   $str = "SELECT * FROM user;";
   $query = $con->prepare($str);
   $query->execute();
   $result = $query->fetch();
   mysqli_close($connection);

   echo '<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">';

   //<!-- Sidebar Toggle (Topbar) -->
   echo '<button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">';
   echo '<i class="fa fa-bars"></i>';
   echo '</button>';

   //<!-- Topbar Search -->
   echo '<form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">';
   echo '<div class="input-group">';
   echo '<input id="searchBar1" type="text" class="form-control bg-light border-0 small" placeholder="Cerca" aria-label="Search" aria-describedby="basic-addon2" onkeyup="search1()">';
   echo '<div class="input-group-append">';
   echo '<button class="btn btn-primary" type="button">';
   echo '<i class="fas fa-search fa-sm"></i>';
   echo '</button>';
   echo '</div>';
   echo '</div>';
   echo '</form>';
   // <!-- Topbar Navbar -->

   //<!-- Topbar Navbar -->
   echo '<ul class="navbar-nav ml-auto">';

   //<!-- Nav Item - Search Dropdown (Visible Only XS) -->
   echo '<li class="nav-item dropdown no-arrow d-sm-none">';
   echo '<a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
   echo '<i class="fas fa-search fa-fw"></i>';
   echo '</a>';

   //<!-- Dropdown - Messages -->
   echo '<div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">';
   echo '<form class="form-inline mr-auto w-100 navbar-search">';
   echo '<div class="input-group">';
   echo '<input type="text" class="form-control bg-light border-0 small" placeholder="Cerca" aria-label="Search" aria-describedby="basic-addon2">';
   echo '<div class="input-group-append">';
   echo '<button class="btn btn-primary" type="button">';
   echo '<i class="fas fa-search fa-sm"></i>';
   echo '</button>';
   echo '</div>';
   echo '</div>';
   echo '</form>';
   echo '</div>';
   echo '</li>';


   //<!-- Nav Item - Alerts -->
   echo '<li class="nav-item dropdown no-arrow mx-1">';
   echo '<a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
   echo '<i class="fas fa-bell fa-fw"></i>';


   $curlSES=curl_init();
   curl_setopt($curlSES,CURLOPT_URL,"https://raw.githubusercontent.com/P1c1s/SafePanda/master/version.html");
   curl_setopt($curlSES,CURLOPT_RETURNTRANSFER,true);
   curl_setopt($curlSES,CURLOPT_HEADER, false);
   $version=curl_exec($curlSES);
   curl_close($curlSES);


   //<!-- Counter - Alerts -->
   if(!preg_match("/version 1.0/", $version))
      echo '<span class="badge badge-danger badge-counter">1+</span>';

   echo '</a>';

   //<!-- Dropdown - Alerts -->
   echo '<div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">';
   echo '<h6 class="dropdown-header">Centro notifiche</h6>';
   echo '<a class="dropdown-item d-flex align-items-center" href="#">';
   echo '<div class="mr-3">';
   if(!preg_match("/version 1.0/", $version)){
      echo '<div class="icon-circle bg-primary">';
      echo '<i class="fas fa-exclamation text-white"></i>';
      echo '</div>';
   }
   echo '</div>';
   echo '<div>';

   if(!preg_match("/version 1.0/", $version)){
      //echo '<div class="small text-gray-500">December 12, 2019</div>';
      echo '<span class="font-weight-bold">È disponibile una nuova versione</span>';
      echo '</div>';
   }

   echo '</a>';

//   echo '<a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>';
   echo '</div>';
   echo '</li>';

   echo '<div class="topbar-divider d-none d-sm-block"></div>';

   //<!-- Nav Item - User Information -->
   echo '<li class="nav-item dropdown no-arrow">';
   echo '<a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
   echo '<span class="mr-2 d-none d-lg-inline text-gray-600 small">'.$result['Username'].'</span>';
   echo '<img class="img-profile rounded-circle" src="'.$result['ProfileImg'].'">';
   echo '</a>';

   //<!-- Dropdown - User Information -->
   echo '<div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">';
   echo '<a class="dropdown-item" href="profile.php">';
   echo '<i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>Profilo';
   echo '</a>';
   echo '<a class="dropdown-item" href="guide.php">';
   echo '<i class="fas fa-book fa-sm fa-fw mr-2 text-gray-400"></i>Guida';
   echo '</a>';
   echo '<div class="dropdown-divider"></div>';
   echo '<a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">';
   echo '<i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>Esci</a>';
   echo '</div>';
   echo '</li>';
   echo '</ul>';
   echo '</nav>';

?>
