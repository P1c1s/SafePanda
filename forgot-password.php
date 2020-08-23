<?php

   include 'account/variables.php';

   if(!file_exists('account/singleUser'))
      header('Location: index.php');

      try{
          // connect to mysql
          $con = new PDO($dsn,$dbUser,$dbPassword);
          $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      }catch (Exception $ex) {
         echo 'Not Connected '.$ex->getMessage();
         }

      // mysql select query
      $query = $con->prepare("SELECT * FROM user;");
      $query->execute();
      $result = $query->fetch();
      mysqli_close($connection);

   if(isset($_POST['submitButton'])){

      if($result['Answer'] == sha1($_POST['answer'])){

          try{
          // connect to mysql
          $con = new PDO($dsn,$dbUser,$dbPassword);
          $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         }catch (Exception $ex) {
            echo 'Not Connected '.$ex->getMessage();
         }

          $password = sha1($_POST['password']);

          // mysql select query
          $str = "UPDATE user SET Passwd = '$password';";
          $query = $con->prepare($str);
          $query->execute();
          $result = $query->fetch();
          mysqli_close($connection);
          header('Location: login.php');

      }
      else
         echo 'Risposta sbagliata';

   }

?>

<!DOCTYPE html>
<html lang="it">

<head>

<?php
   include 'components/meta.php';
   include 'components/head.php';
?>

  <title>Recupero Password</title>

</head>

<body class="bg-gradient-primary">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-2">Hai dimenticato la password?</h1>
                  </div>
                  <form class="user" action="" method="POST">
                   <div class="form-group">
                    <label>Domanda</label>
                    <?php echo '<h4>'.$result['Question'].'</h4>'; ?>
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" name="answer" aria-describedby="emailHelp" placeholder="Risposta">
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" name="password" aria-describedby="emailHelp" placeholder="Nuova password">
                    </div>
                    <input type="submit" name="submitButton" value="Invio" class="btn btn-primary btn-user btn-block">
                  </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

</body>

</html>
