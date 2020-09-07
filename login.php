<?php

   include 'account/variables.php';

   if(!file_exists('account/singleUser'))
      header('Location: index.php');

   if(isset($_POST['submitButton'])){

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

      if($_POST['username'] == $result['Username'] && sha1($_POST['password']) == $result['Passwd']){
         session_start();
         $_SESSION['login'] = 'ok';
         $_SESSION['timeout'] = time();
         $_SESSION['countDown'] = $result['Timeout'];

         if($_POST['checkbox'] == "yes")
            setcookie("login", "ok", strtotime("+3 week"), "", null, true, true);

         header('Location: dashboard.php');
      }

   }

?>

<?php

   session_start();

   if(isset($_SESSION['login']))
      header("Location: dashboard.php");
   else
      if(isset($_COOKIE['login'])){
         session_start();
         $_SESSION['login'] = 'ok';
         header("Location: dashboard.php");
      }

?>


<!DOCTYPE html>
<html lang="it">

<head>

<?php
   include 'components/meta.php';
   include 'components/head.php';
?>

  <title>Accedi</title>

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
              <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Benvenuto!</h1>
                  </div>
                  <form class="user" action="" method="POST">
                    <div class="form-group">
                      <input type="text" name="username" class="form-control form-control-user" aria-describedby="emailHelp" placeholder="Username">
                    </div>
                    <div class="form-group">
                      <input type="password" name="password" class="form-control form-control-user" placeholder="Password">
                    </div>
                    <div class="form-group">
                      <div class="custom-control custom-checkbox small">
                        <input type="checkbox" name="checkbox" value="yes" class="custom-control-input" id="customCheck">
                        <label class="custom-control-label" for="customCheck">Ricordami</label>
                      </div>
                    </div>
                    <input class="btn btn-primary btn-user btn-block" value="Accedi" type="submit" name="submitButton">
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="forgot-password.php">Hai dimenticato la password?</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

<?php
   include 'components/script.php';
?>


</body>

</html>
