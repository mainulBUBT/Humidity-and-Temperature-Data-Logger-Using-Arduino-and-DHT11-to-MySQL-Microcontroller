<?php

include "connection.php";



$sql = "SELECT * FROM sensor order by id desc limit 1";
$stmt = $conn->prepare($sql); 
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
     $temp = $row['temperature'];
     $humi = $row['humidity'];
     $date = $row['date'];
}
$faren = (1.8*$temp)+32;

?>



<html class="no-js" lang="">

<head>
  <meta charset="utf-8">
  <title></title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <meta property="og:title" content="">
  <meta property="og:type" content="">
  <meta property="og:url" content="">
  <meta property="og:image" content="">

  <link rel="manifest" href="site.webmanifest">
  <link rel="apple-touch-icon" href="icon.png">
  <!------------------Boostrap CSS---------------------->
  <link rel="stylesheet" href="css/bootstrap.min.css">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/main.css">

  <meta name="theme-color" content="#fafafa">
  <style>
  a:hover {
    text-decoration: none;

                }
    
  </style>
</head>

<body>

  <section class="content container">
  <header>
    
<h1><i class="fa fa-cubes"></i> HWS</h1>

  </header>
  
  
<div class="row">
  <div class="card col-7">
    <div class="card-body">
      <h5 class="card-title">Temperature</h5>
      <p class="card-text text-center" style="font-weight: bolder;font-size: 6rem;"><i
          aria-hidden="true" class="fa fa-thermometer-half"></i>
        <span id="sensor-temperature"><?php echo $temp; ?></span> °C</p>
    </div>
  </div>
  <div class="col-5">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Humidity</h5>
        <p class="card-text text-center" style="font-weight: bolder;font-size: 4rem;"><i aria-hidden="true"
                                                                                         class="fa fa-tint"></i>
          <span id="sensor-humidity"><?php echo $humi; ?></span>%</p>
      </div>
    </div>
    <div class="row card-deck"  style="margin-top: 1rem;">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Good to Know</h5>
          <div class="row">
            <div class="col text-right">Date:</div>
            <div class="col"><i aria-hidden="true" class="fas fa-calendar-day"></i>
              <span id="net-temperature"><?php echo $date; ?></span>
            </div>
          </div>
          <div class="row">
            <div class="col text-right">Temperature:</div>
            <div class="col"><i aria-hidden="true" class="fa fa-thermometer-half"></i>
              <span id="net-temperature"><?php echo $faren; ?></span> °F
            </div>
          </div>
          <div class="row">
            <div class="col text-right">Humidity:</div>
            <div class="col"><i aria-hidden="true" class="fa fa-tint"></i>
              <span id="net-humidity"><?php if($humi>=30 && $humi<=50)
              {
                echo "Perfect Humidity";

              }
              elseif ($humi>=55 && $humi<=65) {
                echo "Just Okay</i>";
              }
              elseif ($humi>=70 && $humi<=80) {
                echo "Bad Humidity";
              }
              else
              {
                echo "Dangerous Humidity";

              }

              ?></span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row" style="margin-top: 1rem;">
  <div class="card col">
    <div class="card-body">
      <div class="row">
        <div class="col">
          <i aria-hidden="true" class="fas fa-th-list"></i> 
          <a href="#tempModal" data-toggle="modal">
            Temperature Data Table
          </a>
        </div>
      </div>
    </div>
  </div>
  <div class="col">
    <div class="card">
      
    <div class="card-body">
      <div class="row">
       
      <div class="col">
        <i aria-hidden="true" class="fas fa-th-list"></i> 
        <a href="#humiModal" data-toggle="modal">
            Humidity Data Table
          </a>
    </div>
    </div>
  </div>
</div>

</section>








   <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="js/jquery-3.5.1.min.js"></script>  
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="https://kit.fontawesome.com/417824116f.js" crossorigin="anonymous"></script>


   <!-- Custom JS and Plugins JS -->
  <script src="js/plugins.js"></script>
  <script src="js/main.js"></script>

  <!-- Google Analytics: change UA-XXXXX-Y to be your site's ID. -->
  <script>
    window.ga = function () { ga.q.push(arguments) }; ga.q = []; ga.l = +new Date;
    ga('create', 'UA-XXXXX-Y', 'auto'); ga('set', 'anonymizeIp', true); ga('set', 'transport', 'beacon'); ga('send', 'pageview')
  </script>
  <script src="https://www.google-analytics.com/analytics.js" async></script>




  <!-- Modal For Temperature-->
<div class="modal fade" id="tempModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header float-right">
                <h5>Sensor Data Details</h5>
                <div class="text-right"> <i data-dismiss="modal" aria-label="Close" class="fa fa-close"></i> </div>
            </div>
            <div class="modal-body">
                <div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Temperature</th>
                                <th scope="col">Date</th>
                            </tr>
                        </thead>
                        <?php

                        $sql = "SELECT temperature, date FROM sensor order by date desc LIMIT 10";
                        $stmt = $conn->prepare($sql); 
                        $stmt->execute();
                        $result = $stmt->get_result();
                        while ($row = $result->fetch_assoc()) {
                             
                             ?>

                        <tbody>
                            <tr>
                                <th scope="row"><?php echo $row['temperature'];?> °C</th>
                                <td><?php echo $row['date'];?></td>
                            </tr>
                        </tbody>
                        <?php
                        }
                        ?>
                    </table>
                </div>
            </div>
            <div class="modal-footer"> <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button></div>
        </div>
    </div>
  </div>

   <!-- Modal For Humidity-->
<div class="modal fade" id="humiModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header float-right">
                <h5>Sensor Data Details</h5>
                <div class="text-right"> <i data-dismiss="modal" aria-label="Close" class="fa fa-close"></i> </div>
            </div>
            <div class="modal-body">
                <div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Humidity</th>
                                <th scope="col">Date</th>
                            </tr>
                        </thead>
                        <?php

                        $sql = "SELECT humidity, date FROM sensor order by date desc LIMIT 10";
                        $stmt = $conn->prepare($sql); 
                        $stmt->execute();
                        $result = $stmt->get_result();
                        while ($row = $result->fetch_assoc()) {
                             
                             ?>

                        <tbody>
                            <tr>
                                <th scope="row"><?php echo $row['humidity'];?> %</th>
                                <td><?php echo $row['date'];?></td>
                            </tr>
                        </tbody>
                        <?php
                        }
                        ?>
                    </table>
                </div>
            </div>
            <div class="modal-footer"> <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button></div>
        </div>
    </div>
  </div>



 

</body>

</html>
