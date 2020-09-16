
<?php
   include 'components/security.php';
   include 'account/variables.php';
   include 'components/cripty.php';
?>

<?php

      try{
          // connect to mysql
          $con = new PDO($dsn,$dbUser,$dbPassword);
          $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      }catch (Exception $ex) {
         echo 'Not Connected '.$ex->getMessage();
         }

      $queryx = $con->prepare('SELECT Title, DATE_FORMAT(CreationDate, "%d-%m-%Y") as CreationDate FROM accounts;');
      $queryx->execute();
      $resultx = $queryx->fetchAll();
      mysqli_close($connection);


?>


<?php

//   include 'account/variables.php';
//   include 'components/cripty.php';

   if(isset($_POST['passwdSubmit'])){

      $id = $_POST['idAccount'];

      try{
          // connect to mysql
          $con = new PDO($dsn,$dbUser,$dbPassword);
          $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      }catch (Exception $ex) {
         echo 'Not Connected '.$ex->getMessage();
         }

      $query = $con->prepare("SELECT KeyC FROM accounts WHERE id_account = '$id';");
      $query->execute();
      $result = $query->fetch();
      $password = cry($_POST['password'],$result['KeyC']);
      $query = $con->prepare("UPDATE accounts SET Passwd = '$password' WHERE id_account = '$id';");
      $query->execute();
      mysqli_close($connection);
   }


?>

<?php

   try{
       // connect to mysql
       $con = new PDO($dsn,$dbUser,$dbPassword);
       $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   }catch (Exception $ex) {
      echo 'Not Connected '.$ex->getMessage();
      }

   //Password Length Query
   $query1 = $con->prepare("SELECT LENGTH(Passwd) as PasswdLength, COUNT(Passwd) as PasswdNumber FROM accounts GROUP BY LENGTH(Passwd);");
   $query1->execute();
   $result1 = $query1->fetchAll();
   $query = $con->prepare("SELECT COUNT(Passwd) as Number FROM accounts");
   $query->execute();
   $pNumber = $query->fetch();

   //Security Query
   $query2 = $con->prepare("SELECT id_account, Title, Username, Passwd, KeyC FROM accounts ORDER BY LENGTH(Passwd);");
   $query2->execute();
   $result2 = $query2->fetchAll();

   //Tag
   $query3 = $con->prepare("SELECT Tag, COUNT(TAG) as TagCounter FROM accounts GROUP BY Tag;");
   $query3->execute();
   $result3 = $query3->fetchAll();

   mysqli_close($connection);

?>

<!DOCTYPE html>
<html lang="it">

<head>

<?php
   include 'components/meta.php';
   include 'components/head.php';
?>

 <title>Grafici</title>

<style>

#tooltip {
  background: black;
  border: 1px solid black;
  border-radius: 5px;
  padding: 5px;
}

</style>


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
            <h1 class="h3 mb-0 text-gray-800">Grafici</h1>
          </div>

          <div class="row">

            <!-- Area Chart -->
            <div class="col-xl-8 col-lg-7">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Earnings Overview</h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                      <div class="dropdown-header">Dropdown Header:</div>
                      <a class="dropdown-item" href="javascript:hideCharts('a');">Action</a>
                      <a class="dropdown-item" href="#">Mostra time line come su github</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                  </div>
                </div>
                <!-- Card Body -->
                <div class="card-body" id="a" style="transition: 2s;">
                  <div class="chart-area">

<div id="tooltip" display="none" style="position: absolute; display: none;"></div>



<?php

//echo '<svg height="100%" width="100%" overflow="visible">';
echo '<svg height="100%" width="100%" style="overflow-x: auto; overflow-y: auto ;preserveAspectRatio="xMinYMin slice" overflow="visible">';
$dim=4;
$a=(10-(10*0.8));
$e="a";

$k=0;
$j=1;

   foreach($resultx as $rowx){
   echo '<g transform="translate(50, '.(40*$k/$a).')">';
   $c=1;
   $k++;
   for($i=0;$i<36;$i++){

      if($c<10)
         $x="0".$c;
      else
         $x=$c;

      $pattern = "/.*(-".$x."-).*/";
      $app=$rowx['CreationDate'];

      if(preg_match($pattern, /*$rowx['CreationDate']*/ $app)){
         $app2=substr($rowx['CreationDate'],0,2);

/*
echo '<h1>'.$rowx['CreationDate'].'</h1>';
echo '<h1>'.$app2.'</h1>';
*/



         if($app2>=1 && $app2<=3){
         $s = '<rect class="day" width="'.(30/$a).'" height="'.(30/$a).'" x="'.(40*$i/$a+90).'" y="'.($dim/2+12).'" fill="#9be9a8" data-count="0" data-date="2019-08-25"  onmousemove="showTooltip(evt,';
         $s .= "'$app')";
         $s .= '" onmouseout="hideTooltip();"></rect>';
         echo $s;
        }

else{

         $s = '<rect class="day" width="'.(30/$a).'" height="'.(30/$a).'" x="'.(40*$i/$a+90).'" y="'.($dim/2+12).'" fill="#ebedf0" data-count="0" data-date="2019-08-25"  onmousemove="showTooltip(evt,';
         $s .= "'$app')";
         $s .= '" onmouseout="hideTooltip();"></rect>';
         echo $s;

}

       }
       else
         echo '<rect class="day" width="'.(30/$a).'" height="'.(30/$a).'" x="'.(40*$i/$a+90).'" y="'.($dim/2+12).'" fill="#ebedf0" data-count="0" data-date="2019-08-25"></rect>';


   if($j==3){
     $c++;
     $j=1;
     }
     else $j++;

//$c++;

   }

   echo '</g>';

}

$d=60;
$s=75;
$size=14;
echo '<text x="'.($d+$s).'" y="12" class="month" font-size="'.$size.'">Gen</text>';
echo '<text x="'.(2*$d+$s).'" y="12" class="month" font-size="'.$size.'">Feb</text>';
echo '<text x="'.(3*$d+$s).'" y="12" class="month" font-size="'.$size.'">Mar</text>';
echo '<text x="'.(4*$d+$s).'" y="12" class="month" font-size="'.$size.'">Apr</text>';
echo '<text x="'.(5*$d+$s).'" y="12" class="month" font-size="'.$size.'">Mag</text>';
echo '<text x="'.(6*$d+$s).'" y="12" class="month" font-size="'.$size.'">Giu</text>';
echo '<text x="'.(7*$d+$s).'" y="12" class="month" font-size="'.$size.'">Lug</text>';
echo '<text x="'.(8*$d+$s).'" y="12" class="month" font-size="'.$size.'">Ago</text>';
echo '<text x="'.(9*$d+$s).'" y="12" class="month" font-size="'.$size.'">Set</text>';
echo '<text x="'.(10*$d+$s).'" y="12" class="month" font-size="'.$size.'">Ott</text>';
echo '<text x="'.(11*$d+$s).'" y="12" class="month" font-size="'.$size.'">Nov</text>';
echo '<text x="'.(12*$d+$s).'" y="12" class="month"font-size="'.$size.'">Dic</text>';

$i=0;
   foreach($resultx as $rowx){
$i++;
echo '<text text-anchor="start" class="wday" dx="10" dy="'.(20*$i+10).'">'.$rowx['Title'].'</text>';

}
echo '</svg>';


?>


                  </div>
                </div>
              </div>
            </div>

            <!-- Pie Chart -->
            <div class="col-xl-4 col-lg-5">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Complessità password</h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                      <div class="dropdown-header">Dropdown Header:</div>
                      <a class="dropdown-item" href="#">Action</a>
                      <a class="dropdown-item" href="#">Mostra time line come su github</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                  </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="chart-pie pt-4 pb-2">
                    <canvas id="passwordComplexity"></canvas>
                  </div>
                  <div class="mt-4 text-center small">
                    <span class="mr-2"><i class="fas fa-circle text-danger"></i> Password deboli</span>
                    <span class="mr-2"><i class="fas fa-circle text-warning"></i> Password buone</span>
                    <span class="mr-2"><i class="fas fa-circle text-success"></i> Password forti</span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Content Row -->
          <div class="row">

            <!-- Content Column -->
            <div class="col-lg-6 mb-4">

<?php

   //<!-- Length Password -->
   echo '<div class="card shadow mb-4">';
   echo '<div class="card-header py-3">';
   echo '<h6 class="m-0 font-weight-bold text-primary">Lunghezza Password</h6>';
   echo '</div>';
   echo '<div class="card-body">';


   foreach($result1 as $row1){

      $passwordDecrypted = decry($row1['PasswdLength'], "a");

      echo '<h4 class="small font-weight-bold">'.$row1['PasswdLength'].' caratteri<span class="float-right">'.round(($row1['PasswdNumber']/$pNumber['Number']*100),2).'%</span></h4>';
      echo '<div class="progress mb-4">';
      if($row1['PasswdLength']<=5)
         echo '<div class="progress-bar bg-danger" role="progressbar" style="width: '.($row1['PasswdNumber']/$pNumber['Number']*100).'%" aria-valuenow="'.($row1['PasswdNumber']/$pNumber['Number']*100).'" aria-valuemin="0" aria-valuemax="100"></div>';
      else
         if($row1['PasswdLength']>=6 && $row1['PasswdLength']<10)
            echo '<div class="progress-bar bg-warning" role="progressbar" style="width: '.($row1['PasswdNumber']/$pNumber['Number']*100).'%" aria-valuenow="'.($row1['PasswdNumber']/$pNumber['Number']*100).'" aria-valuemin="0" aria-valuemax="100"></div>';
         else
            if($row1['PasswdLength']>=10)
               echo '<div class="progress-bar bg-success" role="progressbar" style="width: '.($row1['PasswdNumber']/$pNumber['Number']*100).'%" aria-valuenow="'.($row1['PasswdNumber']/$pNumber['Number']*100).'" aria-valuemin="0" aria-valuemax="100"></div>';
      echo '</div>';


   }


   echo '</div></div>';

?>



              <div class="card shadow mb-4">
               <div class="card-header py-3">
                 <h6 class="m-0 font-weight-bold text-primary">Password a rischio</h6>
               </div>
<?php

   //Secutity Password

   $unsafe=0;
   $safe=0;
   $strong=0;
   $toggle=0; //Countr for the toggles

   foreach($result2 as $row2){

      $password = decry($row2['Passwd'], $row2['KeyC']);

      $security=1;
      if((strlen($password)>=10 & preg_match("/[a-z]/", $password) & preg_match("/[A-Z]/", $password))){
         $security=2;
         if((strlen($password)>10 & preg_match("/[a-z]/", $password) & preg_match("/[A-Z]/", $password) & preg_match("/[0-9]/", $password) & preg_match("/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:\<\>,\.\?\\\]/", $password))){
            $security=3;

         }
      }


      if($security == 1){
         $unsafe++;
         echo '<div class="card-body">';
         echo '<div class="col-lg-12 mb-4">';
         echo '<a style="text-decoration: none;" href="#" data-toggle="modal" data-target="#passwd'.$toggle.'">';
         echo '<div class="card bg-danger text-white shadow">';
         echo '<div class="card-body"><h3 class="text-uppercase">'.$row2['Title'].'</h3>';
         echo '<div class="text-white-50">'.decry($row2['Username'], $row2['KeyC']).'</div>';
         echo '</div>';
         echo '</div>';
         echo '</a>';
         echo '</div>';
         echo '</div>';
         $id[$toggle]=$row2['id_account'];
         $toggle++;
      }
      else
         if($security == 2){
            $safe++;
            echo '<div class="card-body">';
            echo '<div class="col-lg-12 mb-4">';
            echo '<a style="text-decoration: none;" href="#" data-toggle="modal" data-target="#passwd'.$toggle.'">';
            echo '<div class="card bg-warning text-white shadow">';
            echo '<div class="card-body">'.$row2['Title'];
            echo '<div class="text-white-50 small">#4e73df</div>';
            echo '</div>';
            echo '</div>';
            echo '</a>';
            echo '</div>';
            echo '</div>';
            $id[$toggle]=$row2['id_account'];
            $toggle++;
         }
         else
            if($security == 3)
               $strong++;

   }


   if($toggle==0)
      echo '<div class="card-body">Tutte le tue password sono sicure. Ottimo lavoro!</div>';

?>

            </div>
            </div>


            <div class="col-lg-6 mb-4">

              <!-- SafePanda advisors -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">I consigli del panda</h6>
                </div>
<?php

   echo '<div class="card-body">';
   echo '<div class="text-center">';
   echo '<img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" src="img/safePandaAlert.png" alt="">';
   echo '</div>';

   $i=0;

   foreach($result2 as $row2){
      $passwords[$i] = decry($row2['Passwd'], $row2['KeyC']);
      $titles[$i] = $row2['Title'];
      $i++;
   }

   $new = array();
   $newV = array();

   $c=0;

   for($i=0; $i<sizeof($passwords); $i++){

      $flag = 0;

      for($j=$i+1; $j<sizeof($passwords); $j++){

         if($passwords[$i]==$passwords[$j] && $passwords[$i]!="empty"){

            if($flag==0){
               $flag = 1;
               $new[$c] = $passwords[$i];
               $newT[$c] = $titles[$i];
               $c++;
            }

            $new[$c] = $passwords[$j];
            $newT[$c] = $titles[$j];
            $passwords[$j] = "empty";
            $c++;

         }

      }
   }

   if(!empty($new))
      echo '<h5 class="text-primary">Stai usando la stessa password per alcuni account</h5>';

   for($i=0; $i<sizeof($new); $i++){

      echo '<ul>';

      while($new[$i]==$new[$i+1]){
         echo '<li>'.$newT[$i].'</li>';
         $i++;
      }
         echo '<li>'.$newT[$i].'</li>';

      echo '</ul>';

   }

   echo '<h5 class="text-primary">Rinnova le password</h5><p>Ricordati ogni tanto di rinnovare le tue password.</p>';

   echo '</div>';

?>

              </div>





              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Tag</h6>
                </div>
                <div class="card-body">
                  <div class="chart-bar"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"></div></div>
                    <canvas id="tagArea" style="display: block; height: 320px; width: 891px;" width="1782" height="640" class="chartjs-render-monitor"></canvas>
                  </div>
                  <hr>
                  Qui vengono raggruppati tutti i tag.
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



<?php

   for($i=0; $i<$toggle; $i++){

      echo '<div class="modal fade" id="passwd'.$i.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">';
      echo '<div class="modal-dialog" role="document">';
      echo '<div class="modal-content">';
      echo '<div class="modal-header">';
      echo '<h5 class="modal-title" id="exampleModalLabel"><b>Aggiorna la password per questo account</b></h5>';
      echo '<button class="close" type="button" data-dismiss="modal" aria-label="Close">';
      echo '<span aria-hidden="true">×</span>';
      echo '</button>';
      echo '</div>';
      echo '<form action="" method="POST">';
      echo '<div class="modal-body">';
      echo '<div class="form-group" id="m11"><label class="text-primary">Password</label>';
      echo '<input name="password" class="form-control form-control-user" placeholder="Password">';
      echo '</div>';
      echo '</div>';
      echo '<div class="modal-footer">';
      echo '<input name="idAccount" type="hidden" value="'.$id[$i].'">';
      echo '<button class="btn btn-secondary" type="button" data-dismiss="modal">Annulla</button>';
      echo '<input type="submit" class="btn btn-primary" value="Aggiorna" name="passwdSubmit">';
      echo '</form>';
      echo '</div>';
      echo '</div>';
      echo '</div>';
      echo '</div>';

   }

?>


  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="login.html">Logout</a>
        </div>
      </div>
    </div>
  </div>

<?php
   include 'components/script.php';
?>



<script>
// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

// Pie Chart Example
var ctx = document.getElementById("boardd");
var myChart = new Chart(ctx, {
    type: 'scatter',

    data: {
        datasets: [{
            data: [20, 50, 100, 75, 25, 0],
            label: 'Left dataset',

            // This binds the dataset to the left y axis
            yAxisID: 'left-y-axis'
        }, {
            data: [0.1, 0.5, 1.0, 2.0, 1.5, 0],
            label: 'Right dataset',

            // This binds the dataset to the right y axis
            yAxisID: 'right-y-axis'
        }],
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']
    },
    options: {
        scales: {
            yAxes: [{
                id: 'left-y-axis',
                type: 'linear',
                position: 'left'
            }, {
                id: 'right-y-axis',
                type: 'linear',
                position: 'right'
            }]
        }

      }
});



/* options: {
    maintainAspectRatio: false,
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      caretPadding: 10,
    },
*/



</script>



<script>
// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

// Pie Chart Example
var ctx = document.getElementById("board");
var myPieChart = new Chart(ctx, {
  type: 'scatter',


    data: {
        datasets: [{
            label: 'Scatter Dataset',
            data: [{
                x: 1,
                y: 1
            }, {
                x: 2,
                y: 3
            }, {
                x: 4,
                y: 5
            }]
        }


],



    },


/*
      backgroundColor: ['#9a0dc6', '#227a8a', '#f66500','#7682dc', '#f8a1f3', '#1cf88a','#e7423b', '#f2c23e', '#1cf88a'],
      hoverBackgroundColor: ['#e02d1b', '#f4b619', '#17a673'],
      hoverBorderColor: "rgba(234, 236, 244, 1)",
    }],
  },


*/
  options: {
    maintainAspectRatio: false,
    tooltips: {
      backgroundColor: "rgb(25,255,255)",
      bodyFontColor: "#858796",
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      caretPadding: 10,
    },
    legend: {
      display: true,
position: "right",
    },
    cutoutPercentage: 80,
  },
});

</script>


<script>
// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

// Pie Chart Example
var ctx = document.getElementById("passwordLength");
var myPieChart = new Chart(ctx, {
  type: 'horizontalBar',
  data: {

<?php

echo 'labels: [';

  foreach ($result1 as $row1){

  echo '"'.$row1['PasswdLength'].'",';
}
echo '],';

echo   ' datasets: [{';

echo 'data: [';
  foreach ($result1 as $row1){

  echo '"'.$row1['PasswdLength'].'",';

}

echo '],';


?>

      backgroundColor: ['#9a0dc6', '#227a8a', '#f66500','#7682dc', '#f8a1f3', '#1cf88a','#e7423b', '#f2c23e', '#1cf88a'],
      hoverBackgroundColor: ['#e02d1b', '#f4b619', '#17a673'],
      hoverBorderColor: "rgba(234, 236, 244, 1)",
    }],
  },
  options: {
    maintainAspectRatio: false,
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      caretPadding: 10,
    },
    legend: {
      display: true,
position: "right",
    },
    cutoutPercentage: 80,
  },
});

</script>


<script>

// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

// Pie Chart Example
var ctx = document.getElementById("passwordComplexity");
var myPieChart = new Chart(ctx, {
  type: 'doughnut',
  data: {
    labels: ["Deboli", "Buone", "Forti"],
    datasets: [{

<?php

echo 'data: ['.$unsafe.', '.$safe.', '.$strong.'],';

?>

      backgroundColor: ['#e74a3b', '#f6c23e', '#1cc88a'],
      hoverBackgroundColor: ['#e02d1b', '#f4b619', '#17a673'],
      hoverBorderColor: "rgba(234, 236, 244, 1)",
    }],
  },
  options: {
    maintainAspectRatio: false,
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      caretPadding: 10,
    },
    legend: {
      display: false
    },
    cutoutPercentage: 80,
  },
});

</script>


<script>
// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

// Pie Chart Example
var ctx = document.getElementById("tagArea");
var myPieChart = new Chart(ctx, {
  type: 'polarArea',
  data: {


<?php

echo 'labels: [';

  foreach ($result3 as $row3){

  echo '"'.$row3['Tag'].'",';
}
echo '],';

echo   ' datasets: [{';

echo 'data: [';
  foreach ($result3 as $row3){

  echo '"'.$row3['TagCounter'].'",';

}

echo '],';

?>


      backgroundColor: ['#0056CC', '#E53C67', '#D086FF', '#F87217','#F62817', '#FAAFBA', '#4AA02C','#F535AA', '#6D6968'],
      hoverBackgroundColor: ['#004DB7', '#CE365C', '#BB78E5', '#E56717', '#E42217', '#F9A7B0', '#4AA02C', '#FF00FF', '#625D5D'],
      hoverBorderColor: "rgba(234, 236, 244, 1)",
    }],
  },
  options: {
    maintainAspectRatio: false,
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      caretPadding: 10,
    },
    legend: {
      display: true,
position: "right",
    },
    cutoutPercentage: 80,
  },
});

</script>

<script>

function showTooltip(evt, text) {
  let tooltip = document.getElementById("tooltip");
  tooltip.innerHTML = text;
  tooltip.style.display = "block";
  tooltip.style.left = evt.pageX + 10 + 'px';
  tooltip.style.top = evt.pageY + 10 + 'px';
}

function hideTooltip() {
  var tooltip = document.getElementById("tooltip");
  tooltip.style.display = "none";
}

</script>

</body>

</html>
