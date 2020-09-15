<?php

   //Session
   session_start();

   if(!isset($_SESSION['login']))
      header("Location: login.php");

   //Logout
   if(isset($_POST['logout'])){
      session_start();
      session_destroy();
      header('Location: login.php');
      if(isset($_COOKIE['login']))
         setcookie("login", "", time() - 3600);
      header('Location: login.php');
   }

?>


<?php

   include 'account/variables.php';
   include 'components/redirect.php';
   include 'components/cripty.php';


   //Date
   setlocale(LC_TIME, 'ita', 'it_IT.utf8');
   $time=time();
   $date = strftime("%Y%m%d%H%M%S",$time);

   // IMPORT
   if(isset($_POST['import'])){

         if(!isset($_FILES['file']) || !is_uploaded_file($_FILES['file']['tmp_name'])){
            echo 'File not send';
         }
         else{

            $uploaddir = 'tmp/';
            $userfile_tmp = $_FILES['file']['tmp_name'];
            $userfile_name = 'file.csv';

            if(move_uploaded_file($userfile_tmp, $uploaddir . $userfile_name)){
               echo 'File sended';
            }
            else
               echo 'Upload not valide';
         }


      if($_POST['importSelection']== "accounts"){


         //Open the file.
         $fileHandle = fopen("tmp/file.csv", "r");

         //Read the colums names
         $row = fgetcsv($fileHandle, 0, ",");

         //Initialization of indexes
         $title=-1;
         $url=-1;
         $username=-1;
         $passwd=-1;
         $pin=-1;
         $icon=-1;
         $color=-1;
         $tag=-1;
         $creationDate=-1;
         $updateDate=-1;
         $favorites=-1;
         $deleted=-1;

         //Loop save position of colums
         for($i=0; $i<sizeof($row); $i++){

         if(preg_match("/^(name)$/i", $row[$i]))
            $title=$i;

         if(preg_match("/^(url)$/i", $row[$i]))
            $url=$i;

         if(preg_match("/^(username)$/i", $row[$i]))
            $username=$i;

         if(preg_match("/^(password)$/i", $row[$i]))
            $passwd=$i;

         if(preg_match("/^(pin)$/i", $row[$i]))
            $pin=$i;

         if(preg_match("/^(icon)$/i", $row[$i]))
            $icon=$i;

         if(preg_match("/^(color)$/i", $row[$i]))
            $color=$i;

         if(preg_match("/^(tag)$/i", $row[$i]))
            $tag=$i;

         if(preg_match("/^(creationdate)$/i", $row[$i]))
            $creationDate=$i;

         if(preg_match("/^(updatedate)$/i", $row[$i]))
            $updateDate=$i;

         if(preg_match("/^(favorites)$/i", $row[$i]))
            $favorites=$i;

         if(preg_match("/^(deleted)$/i", $row[$i]))
            $deleted=$i;

      }

      //Loop through the CSV rows.
      while (($row = fgetcsv($fileHandle, 0, ",")) !== FALSE) {

         if($row[$title] == "")
            $titleQ=Titolo;
         else
            $titleQ=$row[$title];

         if($row[$color] == "")
            $colorQ=secondary;
         else
            $colorQ=$row[$color];

         if($row[$tag] == "")
            $tagQ=Altro;
         else
            $tagQ=$row[$tag];

         if($row[$icon] == "")
            $iconQ="";
         else
            $iconQ=$row[$icon];

         if($row[$creationDate] == "")
            $creationDateQ=$date;
         else
            $creationDateQ=$row[$creationDate];

/* RESOLVE PROBLEMS ABOUT UPDATE DATE
         if($row[$updateDate] == "")
            $updateDateQ="";
         else
            $updateDateQ=$row[$updateDate];
*/
         if($row[$favorites] == "")
            $favoritesQ="0";
         else
            $favoritesQ=$row[$favorites];

         if($row[$deleted] == "")
            $deletedQ="0";
         else
            $deletedQ=$row[$deleted];


         $encryptionKey = keyGenerator();
         $usernameEncrypted = cry($row[$username], $encryptionKey);
         $passwordEncrypted = cry($row[$passwd], $encryptionKey);


         $str = "INSERT INTO accounts(Title, Username, Passwd, Pin, Url, Color, Tag, Icon, KeyC, CreationDate, UpdateDate, Favorites, Deleted) VALUES( '$titleQ', '$usernameEncrypted', '$passwordEncrypted', '$pinQ', '$urlQ', '$colorQ', '$tagQ', '$iconQ', '$encryptionKey', '$creationDateQ', NULL, '$favoritesQ', '$deletedQ');";
         $strLong .= $str;
      }

         exec('rm tmp/file.csv');

         try{
             //connect to mysql
             $con = new PDO($dsn,$dbUser,$dbPassword);
             $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         }catch (Exception $ex) {
            echo 'Not Connected '.$ex->getMessage();
            }

         //mysql query
         $query = $con->prepare($strLong);
         $query->execute();
         mysqli_close($connection);

      } //end of accounts



      exec('rm tmp/file.csv');

   }



   /* EXPORT */

   if($_POST['exportSelection'] == "encrypted"){

      try{
          // connect to mysql
          $con = new PDO($dsn,$dbUser,$dbPassword);
          $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      }catch (Exception $ex) {
         echo 'Not Connected '.$ex->getMessage();
         }

      // mysql select query
      $str="SELECT * FROM accounts;";

      $query = $con->prepare($str);
      $query->execute();
      $result = $query->fetchAll();

      mysqli_close($connection);


      $fileName = 'tmp/passowrd'.$date.'.xls';
      $fp = fopen($fileName, "w") or die("Unable to open file!");

      fwrite($fp, '<table border="1">');
      fwrite($fp, '<tr>');
      fwrite($fp, '<td>Nome</td>');
      fwrite($fp, '<td>Chiave</td>');
      fwrite($fp, '<td>Username</td>');
      fwrite($fp, '<td>Password</td>');
      fwrite($fp, '<td>Url</td>');
      fwrite($fp, '</tr>');

        foreach ($result as $row){

           fwrite($fp, '<tr>');
           fwrite($fp, '<td>'.$row['Title'].'</td>');
           fwrite($fp, '<td>'.$row['KeyC'].'</td>');
           fwrite($fp, '<td>'.$row['Username'].'</td>');
           fwrite($fp, '<td>'.$row['Passwd'].'</td>');
           fwrite($fp, '<td>'.$row['Url'].'</td>');
           fwrite($fp, '</tr>');

        }

        fwrite($fp, '</table>');
        fclose($fp);

        header('Content-Description: File Transfer');
        header('Content-Disposition: attachment; filename='.basename($fileName));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($fileName));
        header("Content-Type: application/vnd.ms-excel; charset=utf-8");
        readfile($fileName);

        //Delete the file for security reasons
        exec('rm '.$fileName);

   }

  if($_POST['exportSelection'] == "decrypted"){

      try{
          // connect to mysql
          $con = new PDO($dsn,$dbUser,$dbPassword);
          $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      }catch (Exception $ex) {
         echo 'Not Connected '.$ex->getMessage();
         }

      // mysql select query
      $str="SELECT * FROM accounts;";

      $query = $con->prepare($str);
      $query->execute();
      $result = $query->fetchAll();

      mysqli_close($connection);


      $fileName = 'tmp/passowrd'.$date.'.csv';
      $fp = fopen($fileName, "w") or die("Unable to open file!");

      fwrite($fp, 'Name,');
      fwrite($fp, 'Url,');
      fwrite($fp, 'Username,');
      fwrite($fp, 'Password,');
      fwrite($fp, 'Pin,');
      fwrite($fp, 'Icon,');
      fwrite($fp, 'Color,');
      fwrite($fp, 'Tag,');
      fwrite($fp, 'CreationDate,');
      fwrite($fp, 'UpdateDate,');
      fwrite($fp, 'Favorites,');
      fwrite($fp, 'Deleted'."\n");

        foreach ($result as $row){

           fwrite($fp, $row['Title'].',');
           fwrite($fp, $row['Url'].',');
           fwrite($fp, decry($row['Username'], $row['KeyC']).',');
           fwrite($fp, decry($row['Passwd'], $row['KeyC']).',');
           fwrite($fp, decry($row['Pin'], $row['KeyC']).',');
           fwrite($fp, $row['Icon'].',');
           fwrite($fp, $row['Color'].',');
           fwrite($fp, $row['Tag'].',');
           fwrite($fp, $row['CreationDate'].',');
           fwrite($fp, $row['UpdateDate'].',');
           fwrite($fp, $row['Favorites'].',');
           fwrite($fp, $row['Deleted']."\n");

        }

        fclose($fp);

        header('Content-Description: File Transfer');
        header('Content-Disposition: attachment; filename='.basename($fileName));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($fileName));
        header("Content-Type: application/vnd.ms-excel; charset=utf-8");
        readfile($fileName);

        exec('rm '.$fileName);

   }

   if(isset($_POST['mysqldump'])){

      $fileName = 'tmp/backup'.$date.'.sql';

      exec('mysqldump --user='.$dbUser.' --password='.$dbPassword.' '.$db.' > '.$fileName);

      header('Content-Description: File Transfer');
      header('Content-Disposition: attachment; filename='.basename($fileName));
      header('Expires: 0');
      header('Cache-Control: must-revalidate');
      header('Pragma: public');
      header('Content-Length: ' . filesize($fileName));
      header("Content-Type: application/vnd.ms-excel; charset=utf-8");
      readfile($fileName);

      exec('rm '.$fileName);
   }

   if($_POST['exportSelection'] == "zip"){

      try{
          // connect to mysql
          $con = new PDO($dsn,$dbUser,$dbPassword);
          $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      }catch (Exception $ex) {
         echo 'Not Connected '.$ex->getMessage();
         }

      // mysql select query
      $str="SELECT * FROM accounts;";

      $query = $con->prepare($str);
      $query->execute();
      $result = $query->fetchAll();

      mysqli_close($connection);

      $passwordZip = '123';
      $fileZip = 'tmp/archive'.$date.'.zip';
      $fileName = 'tmp/passowrd'.$date.'.xls';
      $fp = fopen($fileName, "w") or die("Unable to open file!");

      fwrite($fp, '<table border="1">');
      fwrite($fp, '<tr>');
      fwrite($fp, '<td>Nome</td>');
      fwrite($fp, '<td>Chiave</td>');
      fwrite($fp, '<td>Username</td>');
      fwrite($fp, '<td>Password</td>');
      fwrite($fp, '<td>Url</td>');
      fwrite($fp, '</tr>');

        foreach ($result as $row){

           fwrite($fp, '<tr>');
           fwrite($fp, '<td>'.$row['Title'].'</td>');
           fwrite($fp, '<td>'.$row['KeyC'].'</td>');
           fwrite($fp, '<td>'.$row['Username'].'</td>');
           fwrite($fp, '<td>'.$row['Passwd'].'</td>');
           fwrite($fp, '<td>'.$row['Url'].'</td>');
           fwrite($fp, '</tr>');

        }

        fwrite($fp, '</table>');
        fclose($fp);

        exec('zip -P '.$passwordZip.' '.$fileZip.' '.$fileName);

        header('Content-Description: File Transfer');
        header('Content-Disposition: attachment; filename='.basename($fileZip));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($fileZip));
        header("Content-Type: application/vnd.ms-excel; charset=utf-8");
        readfile($fileZip);

        exec('rm '.$fileName);
        exec('rm '.$fileZip);

   }


?>


<!DOCTYPE html>
<html lang="it">

<head>

<?php
   include 'components/meta.php';
   include 'components/head.php';
?>

 <title>Impostazioni</title>

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
            <h1 class="h3 mb-0 text-gray-800">Impostazioni</h1>
           </div>


          <div class="row">

            <div class="col-lg-12">
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Backup</h6>
                </div>
                <div class="card-body">
                 <div class="row">
                  <div class="col-lg-11">
                  Esegui un backup dell'intero database, mi raccomando tienilo in un posto sicuro.
                 </div>
                 <div class="col-lg-1">
                  <div class="text-align">
                   <form action="" method="POST">
                    <input type="submit" name="mysqldump" value="Esegui" class="btn btn-primary">
                   </form>
                  </div>
                 </div>
                </div>
               </div>
             </div>
           </div>

            <div class="col-lg-12">
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Importa</h6>
                </div>
                <div class="card-body">
                 <div class="row">
                  <div class="col-lg-11">
                    Se vuoi puoi importare i tuoi accounts con estrema facilità caricando il file CSV.
                 </div>
                 <div class="col-lg-1">
                  <div class="text-align"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#import">Apri</button></div>
                 </div>
                </div>
               </div>
             </div>
           </div>

            <div class="col-lg-12">
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Esporta</h6>
                </div>
                <div class="card-body">
                 <div class="row">
                  <div class="col-lg-11">
                   Se vuoi puoi esportare i tuoi accounts con estrema facilità i un file CSV.
                 </div>
                 <div class="col-lg-1">
                  <div class="text-align"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#export">Apri</button></div>
                 </div>
                </div>
               </div>
             </div>
           </div>

            <div class="col-lg-12">
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Componenti</h6>
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
                  <h6 class="m-0 font-weight-bold text-primary">Estensione</h6>
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


  <!-- Import -->
  <div class="modal fade" id="import" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Importa accounts</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
       <form action="" method="POST" enctype="multipart/form-data">
        <div class="modal-body">
         <div class="form-group">
          <select name="importSelection" class="form-control form-control-user">
           <option value="0" selected disabled hidden>Seleziona il tipo di file</option>
           <option value="accounts">Accounts</option>
           <option value="contacts">Contatti</option>
           <option value="notes">Note</option>
          </select>
         </div>
         <div class="form-group">
          <div class="custom-file">
           <input type="file" class="custom-file-input" id="customFile" name="file">
           <label class="custom-file-label" for="customFile">Seleziona immagine profilo</label>
          </div>
         </div>
       </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Annulla</button>
          <input type="submit" class="btn btn-primary" value="Invia" name="import">
        </div>
       </form>
      </div>
    </div>
  </div>

  <!-- Export-->
  <div class="modal fade" id="export" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Inserisci la nuova domanda</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
       <form action="" method="POST">
        <div class="modal-body">
          <select class="form-control form-control-user" name="exportSelection">
           <option value="0" selected disabled hidden>Seleziona il tipo di file</option>
           <option value="decrypted">File non criptato</option>
           <option value="encrypted">File criptato</option>
           <option value="zip">File zip</option>
          </select>
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
          <h5 class="modal-title" id="exampleModalLabel">Inserisci la nuova risposta</h5>
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
       <form action="" method="POST">
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
          <h5 class="modal-title" id="exampleModalLabel">Inserisci la nuova risposta</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
       <form action="" method="POST">
        <div class="modal-body">
           <div class="form-group">
            <label class="text-primary">Color</label>
            <input type="number" max="60">
           </div>
       </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Annulla</button>
          <input type="submit" class="btn btn-primary" value="Invia" name="answerSubmit">
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
