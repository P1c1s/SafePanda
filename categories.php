<?php

   include 'components/security.php';

?>

<?php
   include 'account/variables.php';
   include 'components/cripty.php';
?>

<?php

   /* ADD NEW ACCOUNT  */
   if(isset($_POST['add'])){

      //Date
      setlocale(LC_TIME, 'ita', 'it_IT.utf8');
      $time=time();
      $date = strftime("%Y%m%d%H%M%S",$time);

      //POST Varibales
      $id_account = $_POST['idAccount'];
      $title = $_POST['title'];
      $username = $_POST['username'];
      $password = $_POST['password'];
      $pin = $_POST['pin'];
      $url = $_POST['url'];
      $tag = $_POST['tag'];
      $icon = $_POST['icon'];
      $color = $_POST['color'];
      $notes = $_POST['notes'];

      //Encrypted Data
      $encryptionKey = keyGenerator();
      $usernameEncrypted = cry($username, $encryptionKey);
      $passwordEncrypted = cry($password, $encryptionKey);
      $pinEncrypted = cry($pin, $encryptionKey);

      try{
          // connect to mysql
          $con = new PDO($dsn,$dbUser,$dbPassword);
          $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      }catch (Exception $ex) {
         echo 'Not Connected '.$ex->getMessage();
         }

      // mysql query
      $str="INSERT INTO accounts(KeyC, Title, Username, Passwd, Pin, Url, Tag, Icon, Color, Notes, CreationDate, Favorites, Deleted) VALUES('$encryptionKey', '$title', '$usernameEncrypted', '$passwordEncrypted', '$pinEncrypted', '$url' ,'$tag' ,'$icon', '$color', '$notes', '$date', 0, 0);";

      $query = $con->prepare($str);
      $query->execute();
      mysqli_close($connection);

   }


   /* UPDATE ACCOUNT  */

   if(isset($_POST['update'])){

      //Date
      setlocale(LC_TIME, 'ita', 'it_IT.utf8');
      $time=time();
      $date = strftime("%Y%m%d%H%M%S",$time);

      //POST Varibales
      $id_account = $_POST['idAccount'];
      $title = $_POST['title'];
      $username = $_POST['username'];
      $password = $_POST['password'];
      $pin = $_POST['pin'];
      $url = $_POST['url'];
      $tag = $_POST['tag'];
      $icon = $_POST['icon'];
      $color = $_POST['color'];
      $notes = $_POST['notes'];
      $favorite = $_POST['favoriteStar'];

      try{
          // connect to mysql
          $con = new PDO($dsn,$dbUser,$dbPassword);
          $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      }catch (Exception $ex) {
         echo 'Not Connected '.$ex->getMessage();
         }

      // mysqlt query
      $str="SELECT KeyC FROM accounts WHERE id_account = '$id_account';";

      $query = $con->prepare($str);
      $query->execute();
      $result = $query->fetch();
      mysqli_close($connection);

      $usernameEncrypted = cry($username, $result['KeyC']);
      $passwordEncrypted = cry($password, $result['KeyC']);

      if($pin!="")
         $pinEncrypted = cry($pin, $result['KeyC']);

      try{
          // connect to mysql
          $con = new PDO($dsn,$dbUser,$dbPassword);
          $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      }catch (Exception $ex) {
         echo 'Not Connected '.$ex->getMessage();
         }

      // mysqlt query
      $str="UPDATE accounts SET Title = '$title', Username = '$usernameEncrypted', Passwd = '$passwordEncrypted', Pin = '$pinEncrypted', Url = '$url', Tag = '$tag', Icon = '$icon', Color = '$color', Notes = '$notes', UpdateDate = '$date', Favorites = '$favorite' WHERE id_account = '$id_account';";

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
      $str="UPDATE accounts SET Deleted = 1, Favorites = 0  WHERE id_account ='$id_account';";

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

 <title>Dashboard</title>

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
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#new"><i class="fas fa-plus fa-sm text-white-50"></i> Aggiungi</a>
          </div>


          <!-- CATEGORIES -->
          <div class="col-xl-3 col-md-6 mb-4">

            <a href="javascript:f(25);" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#new"><i class="fas fa-plus fa-sm text-white-50"></i> Tutte</a>

<?php

   try{
       // connect to mysql
       $con = new PDO($dsn,$dbUser,$dbPassword);
       $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   }catch (Exception $ex) {
      echo 'Not Connected '.$ex->getMessage();
      }

   // mysql select query
   $query = $con->prepare('SELECT Tag FROM accounts GROUP BY Tag;');
   $query->execute();
   $result = $query->fetchAll();
   mysqli_close($connection);

   foreach($result as $row){

      echo '<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#new"><i class="fas fa-plus fa-sm text-white-50"></i>'.$row['Tag'].'</a>';


   }


?>

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

   // mysql select query
   $query = $con->prepare('SELECT id_account, Title, Username, Passwd, Pin, Url, Icon, Notes, Tag, Color, KeyC, DATE_FORMAT(CreationDate,"%d/%m/%Y alle %H:%i") as CreationDate, DATE_FORMAT(UpdateDate,"%d/%m/%Y alle %H:%i") as UpdateDate, Favorites FROM accounts WHERE Deleted != 1 ORDER BY Title;');
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
      if($row['Favorites']==1)
         echo '<a href="javascript:favorites('.$row['id_account'].')" style="display:none;" id="favorites'.$row['id_account'].'" class="fas fa-star text-warning"></a>';
      else
         echo '<a href="javascript:favorites('.$row['id_account'].')" style="display:none;" id="favorites'.$row['id_account'].'" class="fas fa-star text-secondary"></a>';
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
      echo '<div class="col-auto">';
      echo '<a href="javascript:passwordGenerator('.$row['id_account'].')">';
      echo '<i id="passGen'.$row['id_account'].'" class="fas fa-pen fa-2x text-gray-300" style="display:none;"></i>';
      echo '</a>';
      echo '<a href="javascript:showPassword('.$row['id_account'].')">';
      echo '<i id="eye'.$row['id_account'].'" class="fas fa-eye fa-2x text-gray-300"></i>';
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
      echo '<input class="btn btn-danger" name="delete" type="submit" value="Elimina" style="display:none;" id="delete'.$row['id_account'].'">';
      echo '<button class="btn btn-primary" type="button" id="show'.$row['id_account'].'" onclick="show('.$row['id_account'].')">Mostra</button>';
      echo '<button class="btn btn-primary" type="button" style="display:none;" id="hide'.$row['id_account'].'" onclick="hide('.$row['id_account'].')">Nascondi</button>';
      echo '<button class="btn btn-primary" type="button" id="modify'.$row['id_account'].'" onclick="modify('.$row['id_account'].')">Modifica</button>';
      echo '<button class="btn btn-primary" type="button" style="display:none;" id="cancel'.$row['id_account'].'" onclick="cancel('.$row['id_account'].')">Annulla</button>';
      echo '<input class="btn btn-primary" name="update" type="submit" value="Aggiorna" style="display:none;" id="update'.$row['id_account'].'">';
      echo '<input  name="idAccount" type="hidden" value="'.$row['id_account'].'">';
      echo '<input  id="favoriteStar'.$row['id_account'].'" name="favoriteStar" type="hidden" value="0">';
      echo '</form>';
      echo '</div>';
      echo '</div>';
      echo '</div>';
      echo '</div>';

   }

?>


      <!-- New Account Modal-->
      <div class="modal fade" id="new" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
         <form method="POST" action="">
          <div class="modal-content">
            <div class="modal-header">
               <input class="form-control form-control-user" placeholder="Titolo" name="title" required="required">
               <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
               </button>
            </div>
            <div class="modal-body">
              <div class="form-group">
               <label class="text-primary">Username</label>
               <input type="text" class="form-control form-control-user" name="username" required="required">
              </div>
              <label class="text-primary">Password</label>
              <div class="row">
                <div class="col-md">
                 <input id="password0" name="password" class="form-control form-control-user"></div>
                  <div class="col-auto">
                    <a href="javascript:passwordGenerator(0)">
                     <i id="passGen0" class="fas fa-pen fa-2x text-gray-300"></i>
                  </a>
                </div>
              </div>







           <div class="form-group">
            <label class="text-primary">Pin</label>
            <input type="text" class="form-control form-control-user" name="pin">
           </div>
           <div class="form-group">
            <label class="text-primary">URL</label>
            <input type="text" class="form-control form-control-user" name="url">
           </div>
           <div class="form-group">
            <label class="text-primary">Etichetta</label>
            <input type="text" class="form-control form-control-user" name="tag" value="Altro">
           </div>
           <div class="form-group">
            <label class="text-primary">Icon</label>
            <input type="text" class="form-control form-control-user" name="icon">
           </div>
           <div class="form-group">
            <label class="text-primary">Color</label>
              <div class="form-group row">
                <div class="col-sm-3 mb-3 mb-sm-0">
                 <input type="radio" name="color" value="orange">arancione
                </div>
                <div class="col-sm-3 mb-3 mb-sm-0">
                 <input type="radio" name="color" value="primary">blu
                </div>
               <div class="col-sm-3 mb-3 mb-sm-0">
                <input type="radio" name="color" value="info">ciano
               </div>
               <div class="col-sm-3 mb-3 mb-sm-0">
                <input type="radio" name="color" value="warning">giallo
               </div>
               <div class="col-sm-3 mb-3 mb-sm-0">
                <input type="radio" name="color" value="secondary" checked="checked">grigio
               </div>
               <div class="col-sm-3 mb-3 mb-sm-0">
                <input type="radio" name="color" value="dark">nero
               </div>
               <div class="col-sm-3 mb-3 mb-sm-0">
                <input type="radio" name="color" value="pink">rosa
               </div>
                <div class="col-sm-3 mb-3 mb-sm-0">
                 <input type="radio" name="color" value="danger">rosso
                </div>
                <div class="col-sm-3 mb-3 mb-sm-0">
                 <input type="radio" name="color" value="success">verde
               </div>
                <div class="col-sm-3 mb-3 mb-sm-0">
                 <input type="radio" name="color" value="purple">viola
               </div>
              </div>
           </div>
           <div class="form-group">
            <label class="text-primary">Note</label>
            <textarea type="text" class="form-control form-control-user" name="notes"></textarea>
           </div>
          </div>
       </form>
       <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Annulla</button>
        <input type="submit" name="add" class="btn btn-primary" value="Crea">
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

