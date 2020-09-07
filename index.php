<?php
   /* CONFIGURATION */

   //Generation fo crypty file
   if(!file_exists("components/cripty.php"))
      include 'components/criptyMaker.php';

   $fileName = "account/singleUser";

   if(!file_exists($fileName)){

      if(isset($_POST['submitButton'])){

          fopen($fileName,"w");

          $username = $_POST['username'];
          $password = sha1($_POST['password']);
          $question = $_POST['question'];
          $answer = sha1($_POST['answer']);
          $img = 'account/'.$_FILES['profileImg']['name'];

          include 'account/variables.php';

          try{
          // connect to mysql
          $con = new PDO($dsn,$dbUser,$dbPassword);
          $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          }catch (Exception $ex) {
          echo 'Not Connected '.$ex->getMessage();
          }

         //mysql query
         $str = "INSERT INTO user(Username, Passwd, Question, Answer, ProfileImg, Timeout) VALUES('$username','$password','$question','$answer','$img'. '5');";
         $query = $con->prepare($str);
         $query->execute();
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

         header('Location: login.php');

      }

   }
   else
      header('Location: login.php');

?>

<!DOCTYPE html>
<html lang="it">

<head>

<?php
   include 'components/meta.php';
   include 'components/head.php';
?>

  <title>Registrazione</title>


<style>

#overlay {
  position: fixed; /* Sit on top of the page content */
  width: 100%; /* Full width (cover the whole page) */
  height: 100%; /* Full height (cover the whole page) */
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #F1E6FA;
  background-image: url("img/SafePanda.gif");
  background-repeat: no-repeat;
  background-position: center center;
  background-attachment: fixed;
  z-index: 2; /* Specify a stack order in case you're using a different order for other elements */
  cursor: pointer; /* Add a pointer on hover */
}

</style>

</head>

<body class="bg-gradient-primary">
<div class="container">

<div id="overlay">
</div>

  <div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
          <div class="col-lg-7">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Registrazione</h1>
              </div>
              <form class="user" action="" method="POST" enctype="multipart/form-data">
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user" name="username" placeholder="Username">
                  </div>
                  <div class="col-sm-6">
                    <input type="password" class="form-control form-control-user" name="password"  placeholder="Password">
                  </div>
                </div>
                <div class="form-group">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="customFile" name="profileImg">
                    <label class="custom-file-label" for="customFile">Seleziona immagine profilo</label>
                  </div>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control form-control-user" name="question" placeholder="Domanda di sicurezza">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control form-control-user" name="answer" placeholder="Risposta">
                </div>
                <input type="submit" name="submitButton" class="btn btn-primary btn-user btn-block">
              </form>
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

<script>

   setTimeout(offOverlay, 2000);
   function offOverlay(){
      document.getElementById("overlay").style.display = "none";
}

// Add the following code if you want the name of the file appear on select
$(".custom-file-input").on("change", function() {
  var fileName = $(this).val().split("\\").pop();
  $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});
</script>

</body>

</html>
