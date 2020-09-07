<?php

   include 'components/security.php';

?>

<?php
   include 'account/variables.php';
   include 'components/cripty.php';
?>

<?php

   /* EMPTY TRASH  */
   if(isset($_POST['empty'])){

      try{
          // connect to mysql
          $con = new PDO($dsn,$dbUser,$dbPassword);
          $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      }catch (Exception $ex) {
         echo 'Not Connected '.$ex->getMessage();
         }

      // mysql query
      $str="DELETE FROM accounts WHERE Deleted = 1;";

      $query = $con->prepare($str);
      $query->execute();
      mysqli_close($connection);

   }

   /* RECOVER ALL */
   if(isset($_POST['recoverAll'])){

      try{
          // connect to mysql
          $con = new PDO($dsn,$dbUser,$dbPassword);
          $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      }catch (Exception $ex) {
         echo 'Not Connected '.$ex->getMessage();
         }

      // mysql query
      $str="UPDATE accounts SET Deleted = 0 WHERE Deleted = 1;";

      $query = $con->prepare($str);
      $query->execute();
      mysqli_close($connection);

   }

   /* RECOVER ACCOUNT  */

   if(isset($_POST['recover'])){

      $id_account = $_POST['idAccount'];

      try{
          // connect to mysql
          $con = new PDO($dsn,$dbUser,$dbPassword);
          $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      }catch (Exception $ex) {
         echo 'Not Connected '.$ex->getMessage();
         }

      // mysql query
      $str="UPDATE accounts SET Deleted = '0' WHERE id_account = '$id_account';";

      $query = $con->prepare($str);
      $query->execute();
      mysqli_close($connection);

   }

   /* DELETE AN ACCOUNT */

   if(isset($_POST['delete'])){

      //POST Varibales
      $id_account = $_POST['idAccount'];

      try{
          // connect to mysql
          $con = new PDO($dsn,$dbUser,$dbPassword);
          $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      }catch (Exception $ex) {
         echo 'Not Connected '.$ex->getMessage();
         }

      // mysql query
      $str="DELETE FROM accounts WHERE id_account ='$id_account';";

      $query = $con->prepare($str);
      $query->execute();
      mysqli_close($connection);

   }

?>

<!DOCTYPE html>
<html lang="it">

<head>

<?php
   include 'components/meta.php';
   include 'components/head.php';
?>

 <title>Cestino</title>

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

<?php
   include 'components/sidebar.php';
?>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">



<?php
  include 'components/topbar.php';
?>






        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Cestino</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#empty"><i class="fas fa-dumpster fa-sm text-white-50"></i> Svuota</a>
          </div>

          <!-- Content Row -->
          <div class="row">


<?php


   try{
       // connect to mysql
       $con = new PDO($dsn,$dbUser,$dbPassword);
       $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   }catch (Exception $ex) {
      echo 'Not Connected '.$ex->getMessage();
      }

   // mysql query
   $query = $con->prepare('SELECT id_account, Title, Username, Passwd, Pin, Url, Icon, Notes, Tag, Color, KeyC, DATE_FORMAT(CreationDate,"%d/%m/%Y alle %H:%i") as CreationDate, DATE_FORMAT(UpdateDate,"%d/%m/%Y alle %H:%i") as UpdateDate FROM accounts WHERE Deleted = 1 ORDER BY Title;');
   $query->execute();
   $result = $query->fetchAll();
   mysqli_close($connection);

   $c=0; //Count the number of cards

   foreach ($result as $row){
      echo '<div id="card'.$c.'" class="col-xl-3 col-md-6 mb-4">';
      echo '<a style="text-decoration: none;" href="#" data-toggle="modal" data-target="#p'.$row['id_account'].'">';
      echo '<div class="card border-left-'.$row['Color'].' shadow h-100 py-2">';
      echo '<div class="card-body">';
      echo '<div class="row no-gutters align-items-center">';
      echo '<div class="col mr-2">';
      echo '<div id="titleCard'.$c.'" class="h3 font-weight-bold text-'.$row['Color'].' text-uppercase mb-1">'.$row['Title'].'</div>';
      echo '<div class="h5 mb-0 font-weight-bold text-gray-800">'.decry($row['Username'], $row['KeyC']).'</div>';
      echo '</div>';
      echo '<div class="col-auto">';

      if($row['Icon'] != '')
         echo '<img src="'.$row['Icon'].'" height="30px"">';
      else
         echo '<i class="btn btn-'.$row['Color'].' btn-circle btn-lg" style="text-transform: capitalize;">'.substr($row['Title'], 0, 2).'</i>';

      echo '</div>';
      echo '</div>';
      echo '<div class="text-right">';
      echo '<span class="badge badge-'.$row['Color'].'">'.$row['Tag'].'</span>';
      echo '</div>';
      echo '</div>';
      echo '</div>';
      echo '</a>';
      echo '</div>';

      $c++;

   }

   echo '<input id="elementsNumber" type="hidden" value="'.$c.'">';

?>

          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

<?php
   include 'components/footer.php';
?>

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

<?php


   function printValue($str){

      $newStr = "/";

      if($str != "")
         $newStr = $str;

      return $newStr;

   }

   foreach ($result as $row){

      echo '<div class="modal fade" id="p'.$row['id_account'].'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">';
      echo '<div class="modal-dialog" role="document">';
      echo '<form action="" method="POST">';
      echo '<div class="modal-content">';
      echo '<div class="modal-header">';
      echo '<h2 class="form-controld dform-control-user text-'.$row['Color'].' font-weight-bold" id="title'.$row['id_account'].'">'.$row['Title'].'</h2>';
      echo '<button class="close" type="button"data-dismiss="modal" aria-label="Close" onclick="closeModal('.$row['id_account'].')">';
      echo '<span aria-hidden="true">×</span>';
      echo '</button>';
      echo '</div>';
      echo '<div class="modal-body">'; //DIV
      echo '<div class="form-group" id="m'.$row['id_account'].'">';
      echo '<label class="text-'.$row['Color'].'">Username</label>';
      echo '<h3 class="form-controld dform-control-user" id="username'.$row['id_account'].'">'.decry($row['Username'], $row['KeyC']).'</h3>';
      echo '</div>';
      echo '<label class="text-'.$row['Color'].'">Password</label>';
      echo '<div class="row">';
      echo '<div class="col-md">';
      echo '<h3 class="form-controld dform-control-user" id="password*'.$row['id_account'].'">************</h3>';
      echo '<h3 class="form-controld dform-control-user" style="display:none;" id="password'.$row['id_account'].'">'.decry($row['Passwd'], $row['KeyC']).'</h3>';
      echo '</div>';
      echo '<div class="col-auto" id="eye'.$row['id_account'].'">';
      echo '<a href="javascript:showPassword('.$row['id_account'].')">';
      echo '<i class="fas fa-eye fa-2x text-gray-300"></i>';
      echo '</a>';
      echo '</div>';
      echo '</div>';
      echo '<div class="form-group" style="display:none;" id="pinRow'.$row['id_account'].'">';
      echo '<label class="text-'.$row['Color'].'">Pin</label>';
      if($row['Pin']!="/") $pin = decry($row['Pin'], $row['KeyC']);
      echo '<h5 class="form-controld dform-control-user" id="pin'.$row['id_account'].'">'.$pin.'</h5>';
      echo '</div>';
      echo '<div class="form-group" style="display:none;" id="urlRow'.$row['id_account'].'">';
      echo '<label class="text-'.$row['Color'].'">URL</label>';
      echo '<h5 class="form-controld dform-control-user" id="url'.$row['id_account'].'">'.printValue($row['Url']).'</h5>';
      echo '</div>';
      echo '<div class="form-group" style="display:none;" id="tagRow'.$row['id_account'].'">';
      echo '<label class="text-'.$row['Color'].'">Etichetta</label>';
      echo '<h5 class="form-controld dform-control-user" id="tag'.$row['id_account'].'">'.printValue($row['Tag']).'</h5>';
      echo '</div>';
      echo '<div class="form-group" style="display:none;" id="iconRow'.$row['id_account'].'">';
      echo '<label class="text-'.$row['Color'].'">Icona</label>';
      echo '<h5 class="form-controld dform-control-user" id="icon'.$row['id_account'].'">'.printValue($row['Icon']).'</h5>';
      echo '</div>';
      echo '<div class="form-group" style="display:none;" id="colorRow'.$row['id_account'].'">';
      $colorConversion = ["orange" => "arancione", "primary" => "blu", "info" => "ciano", "warning" => "giallo", "secondary" => "grigio", "dark" => "nero", "pink" => "rosa", "danger" => "rosso", "success" => "verde", "purple" => "viola"];
      echo '<label class="text-'.$row['Color'].'">Colore</label>';
      echo '<h5 class="form-controld dform-control-user" id="color'.$row['id_account'].'">'.printValue($colorConversion[$row['Color']]).'</h5>';
      echo '</div>';
      echo '<div class="form-group" style="display:none;" id="notesRow'.$row['id_account'].'">';
      echo '<label class="text-'.$row['Color'].'">Note</label>';
      echo '<h5 class="form-controld dform-control-user" id="notes'.$row['id_account'].'">'.printValue($row['Notes']).'</h5>';
      echo '</div>';
      echo '<div class="text-center" id="date'.$row['id_account'].'" style="display: none;">';
      echo '<div style="font-size: 12px;">Creata il '.$row['CreationDate'].'</div>';
      if($row['UpdateDate']!='') echo '<div style="font-size: 12px;">Modificata il '.$row['UpdateDate'].'</div>';
      echo '</div>';
      echo '</div>';
      echo '<div class="modal-footer" id="footerModal'.$row['id_account'].'">';
      echo '<input class="btn btn-danger" name="delete" type="submit" value="Elimina Definitivamente">';
      echo '<button class="btn btn-primary" type="button" id="show'.$row['id_account'].'" onclick="show('.$row['id_account'].')">Mostra</button>';
      echo '<button class="btn btn-primary" type="button" style="display:none;" id="hide'.$row['id_account'].'" onclick="hide('.$row['id_account'].')">Nascondi</button>';
      echo '<input class="btn btn-primary" name="recover" type="submit" value="Recupera">';
      echo '<input  name="idAccount" type="hidden" value="'.$row['id_account'].'">';
      echo '</form>';
      echo '</div>';
      echo '</div>';
      echo '</div>';
      echo '</div>';

   }

?>


  <!-- Empty -->
  <div class="modal fade" id="empty" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"><b>Attento</b></h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Puoi svuotare il cestino o recuperare tutti gli account.</div>
        <div class="modal-footer">
         <form action="" method="POST">
          <input type="submit" class="btn btn-danger" href="login.php" value="Svuota" name="empty">
          <input type="submit" class="btn btn-primary" href="login.php" value="Recupera" name="recoverAll">
         </form>
        </div>
      </div>
    </div>
  </div>

  <!-- DB-->
  <div class="modal fade" id="importDatabase" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Vuoi us?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-primary" type="button" data-dismiss="modal">Annulla</button>
         <form action method="POST">
          <input type="submit" class="btn btn-danger" href="login.php" value="Esci" name="logout">
         </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"><b>Sei sicuro di volere uscire?</b></h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Selezionado <b>Esci</b> dovrai rifare in futuro il login.</div>
        <div class="modal-footer">
          <button class="btn btn-primary" type="button" data-dismiss="modal">Annulla</button>
         <form action method="POST">
          <input type="submit" class="btn btn-danger" href="login.php" value="Esci" name="logout">
         </form>
        </div>
      </div>
    </div>
  </div>


<?php
   include 'components/script.php';
?>

</body>

</html>

