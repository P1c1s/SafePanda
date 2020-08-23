<?php

   //<!-- Sidebar -->
   echo '<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">';
   //<!-- Sidebar - Brand -->
   echo '<div class="sidebar-brand d-flex align-items-center justify-content-center">';
   echo '<div class="sidebar-brand-icon">';
   echo '<img src="img/safePanda.png" alt="Girl in a jacket" height="50">';
   echo '</div>';
   echo '<div class="sidebar-brand-text mx-3">Safe Panda <sup><i class="fas fa-laugh-winks"></i></sup></div>';
   echo '</div>';
   //<!-- Divider -->
   echo '<hr class="sidebar-divider my-0">';
   //<!-- Nav Item - Dashboard -->
   echo '<li class="nav-item active">';
   echo '<a class="nav-link" href="dashboard.php">';
   echo '<i class="fas fa-fw fa-tachometer-alt"></i>';
   echo '<span>Dashboard</span></a>';
   echo '</li>';
   //<!-- Divider -->
   echo '<hr class="sidebar-divider">';
   echo '<!-- Heading -->';
   echo '<div class="sidebar-heading">Strumenti</div>';
   //<!-- Nav Item - Utilities Collapse Menu -->
   echo '<li class="nav-item">';
   echo '<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">';
   echo '<i class="fas fa-fw fa-wrench"></i>';
   echo '<span>Backup</span>';
   echo '</a>';
   echo '<div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">';
   echo '<div class="bg-white py-2 collapse-inner rounded">';
   echo '<h6 class="collapse-header">Esporta:</h6>';
   echo '<form action="components/backup.php" method="POST" id="myform">';
   echo '<div class="collapse-item">';
   echo '<input type="submit" name="decrypted" value="File non criptato" class="btn btn-sm">';
   echo '</div>';
   echo '</form>';
   echo '<form action="components/backup.php" method="POST">';
   echo '<div class="collapse-item">';
   echo '<input type="submit" name="encrypted" value="File criptato" class="btn btn-sm">';
   echo '</div>';
   echo '</form>';
   echo '<form action="components/backup.php" method="POST">';
   echo '<div class="collapse-item">';
   echo '<input type="submit" name="zip" value="File zip" class="btn btn-sm">';
   echo '</div>';
   echo '</form>';
   echo '<form action="components/backup.php" method="POST">';
   echo '<div class="collapse-item">';
   echo '<input type="submit" name="mysqldump" value="File sql" class="btn btn-sm">';
   echo '</div>';
   echo '</form>';
   echo '</div>';
   echo '</div>';
   echo '</li>';
   //<!-- Divider -->
   echo '<hr class="sidebar-divider">';
   //<!-- Heading -->
   echo '<div class="sidebar-heading">Addons</div>';
   //<!-- Nav Item - Charts -->
   echo '<li class="nav-item">';
   echo '<a class="nav-link" href="charts.php">';
   echo '<i class="fas fa-fw fa-chart-area"></i>';
   echo '<span>Grafici</span></a>';
   echo '</li>';
   //<!-- Divider -->
   echo '<hr class="sidebar-divider d-none d-md-block">';
   //<!-- Sidebar Toggler (Sidebar) -->
   echo '<div class="text-center d-none d-md-inline">';
   echo '<button class="rounded-circle border-0" id="sidebarToggle"></button>';
   echo '</div>';
   echo '</ul>';
   //<!-- End of Sidebar -->

?>
