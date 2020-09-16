<?php
   include 'components/security.php';
   include 'account/variables.php';
   include 'components/cripty.php';
?>

<?php

   if(isset($_POST['userSubmit'])){

      $username = $_POST['username'];

      try{
          // connect to mysql
          $con = new PDO($dsn,$dbUser,$dbPassword);
          $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      }catch (Exception $ex) {
         echo 'Not Connected '.$ex->getMessage();
         }

      // mysql select query
      $str="UPDATE user SET Username='$username';";
      $query = $con->prepare($str);
      $query->execute();
      $result = $query->fetchAll();
      mysqli_close($connection);

      header('Location: profile.php');

   }

   if(isset($_POST['passwdSubmit'])){

      $password = $_POST['password'];

      try{
          // connect to mysql
          $con = new PDO($dsn,$dbUser,$dbPassword);
          $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      }catch (Exception $ex) {
         echo 'Not Connected '.$ex->getMessage();
         }

      // mysql select query
      $str="UPDATE user SET Passwd='$password';";
      $query = $con->prepare($str);
      $query->execute();
      $result = $query->fetchAll();
      mysqli_close($connection);

      header('Location: profile.php');

   }

   if(isset($_POST['questionSubmit'])){

      $question = $_POST['question'];

      try{
          // connect to mysql
          $con = new PDO($dsn,$dbUser,$dbPassword);
          $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      }catch (Exception $ex) {
         echo 'Not Connected '.$ex->getMessage();
         }

      // mysql select query
      $str="UPDATE user SET Question='$question';";
      $query = $con->prepare($str);
      $query->execute();
      $result = $query->fetchAll();
      mysqli_close($connection);

      header('Location: profile.php');

   }

   if(isset($_POST['answerSubmit'])){

      $answer = sha1($_POST['answer']);

      try{
          // connect to mysql
          $con = new PDO($dsn,$dbUser,$dbPassword);
          $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      }catch (Exception $ex) {
         echo 'Not Connected '.$ex->getMessage();
         }

      // mysql select query
      $str="UPDATE user SET Answer='$answer';";
      $query = $con->prepare($str);
      $query->execute();
      $result = $query->fetchAll();
      mysqli_close($connection);

      header('Location: profile.php');

   }

   if(isset($_POST['imgSubmit'])){

      $img = $_POST['profileImg'];

      try{
          // connect to mysql
          $con = new PDO($dsn,$dbUser,$dbPassword);
          $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      }catch (Exception $ex) {
         echo 'Not Connected '.$ex->getMessage();
         }

      // mysql select query
      $str="UPDATE user SET ProfileImg='$img';";
      $query = $con->prepare($str);
      $query->execute();
      $result = $query->fetchAll();
      mysqli_close($connection);


      if(!isset($_FILES['profileImg']) || !is_uploaded_file($_FILES['profileImg']['tmp_name'])){
         echo 'File not send';
      }
      else{

         $uploaddir = 'account/';
         $userfile_tmp = $_FILES['profileImg']['tmp_name'];
         $userfile_name = $_FILES['profileImg']['name'];

         if(move_uploaded_file($userfile_tmp, $uploaddir . $userfile_name)){
            echo 'File sended';
         }
         else
           echo 'Upload not valide';
      }

   }


   if(isset($_POST['timeoutSubmit'])){

      $timeout = $_POST['timeout'];
      $_SESSION['countDown'] = $timeout;

      try{
          // connect to mysql
          $con = new PDO($dsn,$dbUser,$dbPassword);
          $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      }catch (Exception $ex) {
         echo 'Not Connected '.$ex->getMessage();
         }

      // mysql select query
      $str="UPDATE user SET Timeout='$timeout';";
      $query = $con->prepare($str);
      $query->execute();
      $result = $query->fetchAll();
      mysqli_close($connection);

      header('Location: profile.php');

   }


   if(isset($_POST['pinSubmit'])){

      $pin = sha1($_POST['pin']);

      try{
          // connect to mysql
          $con = new PDO($dsn,$dbUser,$dbPassword);
          $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      }catch (Exception $ex) {
         echo 'Not Connected '.$ex->getMessage();
         }

      // mysql select query
      $str="UPDATE user SET Pin='$pin';";
      $query = $con->prepare($str);
      $query->execute();
      $result = $query->fetchAll();
      mysqli_close($connection);

      header('Location: profile.php');

   }

?>



<!DOCTYPE html>
<html lang="it">

<head>

<?php
   include 'components/meta.php';
   include 'components/head.php';
?>

 <title>Profilo</title>

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
            <h1 class="h3 mb-0 text-gray-800">Profilo</h1>
           </div>


          <div class="row">

            <div class="col-lg-12">
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Nome Utente</h6>
                </div>
                <div class="card-body">
                 <div class="row">
                  <div class="col-lg-11">
                  Scegli il nome utente con il quale effetuare l'accesso al tuo portachiavi personale. Puoi cambiarlo in qualsisi momento.
                 </div>
                 <div class="col-lg-1">
                  <div class="text-align"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#username">Cambia</button></div>
                 </div>
                </div>
               </div>
             </div>
           </div>

            <div class="col-lg-12">
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Password</h6>
                </div>
                <div class="card-body">
                 <div class="row">
                  <div class="col-lg-11">
                  Scegli con molta attenzione la password con la quale accedere al tuo portachiavi personale. Mi raccomando usa una password molto sicura e difficile da individuare dai malintenzonati!!!
                 </div>
                 <div class="col-lg-1">
                  <div class="text-align"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#password">Cambia</button></div>
                 </div>
                </div>
               </div>
             </div>
           </div>

            <div class="col-lg-12">
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Domanda di sicurezza</h6>
                </div>
                <div class="card-body">
                 <div class="row">
                  <div class="col-lg-11">
                   Scegli la domanda di sicurezza che ti verrà chiesta in caso di password smarrita affinchè tu possa generarne una nuova.
                 </div>
                 <div class="col-lg-1">
                  <div class="text-align"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#domanda">Cambia</button></div>
                 </div>
                </div>
               </div>
             </div>
           </div>

            <div class="col-lg-12">
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Risposta di sicurezza</h6>
                </div>
                <div class="card-body">
                 <div class="row">
                  <div class="col-lg-11">
                 Scegli la risposta relativa alla domamnda di sicurezza.
                 </div>
                 <div class="col-lg-1">
                  <div class="text-align"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#risposta">Cambia</button></div>
                 </div>
                </div>
               </div>
             </div>
           </div>

            <div class="col-lg-12">
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Immagine profilo</h6>
                </div>
                <div class="card-body">
                 <div class="row">
                  <div class="col-lg-11">
                 Scegli l'imagine del tuo profilo.
                 </div>
                 <div class="col-lg-1">
                  <div class="text-align"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#immagine">Cambia</button></div>
                 </div>
                </div>
               </div>
             </div>
           </div>

            <div class="col-lg-12">
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Timeout</h6>
                </div>
                <div class="card-body">
                 <div class="row">
                  <div class="col-lg-11">
                 Scegli dopo quanto tempo devi reinserire la password.
                 </div>
                 <div class="col-lg-1">
                  <div class="text-align"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#timeout">Cambia</button></div>
                 </div>
                </div>
               </div>
             </div>
           </div>

            <div class="col-lg-12">
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Pin</h6>
                </div>
                <div class="card-body">
                 <div class="row">
                  <div class="col-lg-11">
                 Scegli dopo quanto tempo devi reinserire la password.
                 </div>
                 <div class="col-lg-1">
                  <div class="text-align"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#pin">Cambia</button></div>
                 </div>
                </div>
               </div>
             </div>
           </div>

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


  <!-- Username -->
  <div class="modal fade" id="username" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-primary" id="exampleModalLabel">Inserisci il nuovo nome utente</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
       <form action="" method="POST">
        <div class="modal-body">
          <label class="text-primary">Username</label>
          <input type="text" name="username" class="form-control form-control-user">
       </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Annulla</button>
          <input type="submit" class="btn btn-primary" value="Invia" name="userSubmit">
        </div>
       </form>
      </div>
    </div>
  </div>

  <!-- Password -->
  <div class="modal fade" id="password" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-primary" id="exampleModalLabel">Inserisci la nuova password</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
       <form action="" method="POST">
        <div class="modal-body">
          <label class="text-primary">Password</label>
          <input type="text" name="password" class="form-control form-control-user">
       </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Annulla</button>
          <input type="submit" class="btn btn-primary" value="Invia" name="passwordSubmit">
        </div>
       </form>
      </div>
    </div>
  </div>

  <!-- Question  -->
  <div class="modal fade" id="domanda" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-primary" id="exampleModalLabel">Inserisci la nuova domanda</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
       <form action="" method="POST">
        <div class="modal-body">
          <label class="text-primary">Domanda</label>
          <input type="text" name="question" class="form-control form-control-user">
       </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Annulla</button>
          <input type="submit" class="btn btn-primary" value="Invia" name="questionSubmit">
        </div>
       </form>
      </div>
    </div>
  </div>

  <!-- Answer -->
  <div class="modal fade" id="risposta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-primary" id="exampleModalLabel">Inserisci la nuova risposta</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
       <form action="" method="POST">
        <div class="modal-body">
          <label class="text-primary">Risposta</label>
          <input type="text" name="answer" class="form-control form-control-user">
       </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Annulla</button>
          <input type="submit" class="btn btn-primary" value="Invia" name="answerSubmit">
        </div>
       </form>
      </div>
    </div>
  </div>

  <!-- Profile Img -->
  <div class="modal fade" id="immagine" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Seleziona la tua nuova immagine profilo</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
       <form action="" method="POST" enctype="multipart/form-data">
        <div class="modal-body">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="customFile" name="profileImg">
                    <label class="custom-file-label" for="customFile">Seleziona immagine profilo</label>
                  </div>
       </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Annulla</button>
          <input type="submit" class="btn btn-primary" value="Invia" name="imgSubmit">
        </div>
       </form>
      </div>
    </div>
  </div>


  <!-- Timeout -->
  <div class="modal fade" id="timeout" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-primary" id="exampleModalLabel">Imposta il timeout</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
       <form action="" method="POST">
        <div class="modal-body">
           <div class="form-group">
            <label class="text-primary">Color</label>
            <input type="number" max="60" name="timeout">
           </div>
       </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Annulla</button>
          <input type="submit" class="btn btn-primary" value="Invia" name="timeoutSubmit">
        </div>
       </form>
      </div>
    </div>
  </div>


  <!-- Timeout -->
  <div class="modal fade" id="pin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-primary" id="exampleModalLabel">Imposta il timeout</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
       <form action="" method="POST">
        <div class="modal-body">
           <div class="form-group">
            <label class="text-primary">Color</label>
            <input type="text" maxlength="4" required pattern="[0-9]{4}" name="pin">
           </div>
       </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Annulla</button>
          <input type="submit" class="btn btn-primary" value="Invia" name="pinSubmit">
        </div>
       </form>
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
