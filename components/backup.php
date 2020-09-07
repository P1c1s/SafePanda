<?php

   include 'cripty.php';
   include '../account/variables.php';

   //Date
   setlocale(LC_TIME, 'ita', 'it_IT.utf8');
   $time=time();
   $date = strftime("%d-%B-%Y",$time);

   if(isset($_POST['encrypted'])){

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


      $fileName = '../tmp/passowrd'.$date.'.xls';
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


   if(isset($_POST['decrypted'])){

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


      $fileName = '../tmp/passowrd'.$date.'.xls';
      $fp = fopen($fileName, "w") or die("Unable to open file!");

      fwrite($fp, '<table border="1">');
      fwrite($fp, '<tr>');
      fwrite($fp, '<td>Nome</td>');
      fwrite($fp, '<td>Username</td>');
      fwrite($fp, '<td>Password</td>');
      fwrite($fp, '<td>Url</td>');
      fwrite($fp, '</tr>');

        foreach ($result as $row){

           fwrite($fp, '<tr>');
           fwrite($fp, '<td>'.$row['Title'].'</td>');
           fwrite($fp, '<td>'.decry($row['Username'], $row['KeyC']).'</td>');
           fwrite($fp, '<td>'.decry($row['Passwd'], $row['KeyC']).'</td>');
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

        exec('rm '.$fileName);

   }

   if(isset($_POST['mysqldump'])){

      $fileName = '../tmp/backup'.$date.'.sql';

      exec('mysqldump --user='.$dbUser.' --password=qss-s3E-IH9_Khz '.$db.' > '.$fileName);

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

   if(isset($_POST['zip'])){

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
      $fileZip = '../tmp/archive'.$date.'.zip';
      $fileName = '../tmp/passowrd'.$date.'.xls';
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





   if(isset($_POST['extention'])){

      $fileName = '../tmp/extention.zip';

      exec('zip '.$fielName.' extention');
      exec('zip ../tmp/a.zip backup.php');

      header('Content-Description: File Transfer');
      header('Content-Disposition: attachment; filename='.basename($fileName));
      header('Expires: 0');
      header('Cache-Control: must-revalidate');
      header('Pragma: public');
      header('Content-Length: ' . filesize($fileName));
      header("Content-Type: application/vnd.ms-excel; charset=utf-8");
      readfile($fileName);

      //exec('rm '.$fileName);
   }




?>
