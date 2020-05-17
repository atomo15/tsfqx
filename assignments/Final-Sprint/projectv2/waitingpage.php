<?php
session_start();

    if(!empty($_POST['moviesys']))
    {
        $_SESSION['moviesys'] = $_POST['moviesys'];
    }
    if(!empty($_POST['Branchnum'])){$Branch = $_POST['Branchnum'];
    $_SESSION["branch"]=$Branch;}
    else{$Branch = $_SESSION["branch"];}

    if(!empty($_POST['theater'])){$Theater = $_POST['theater'];
    $_SESSION["theater"] = $Theater;}
    else{$Theater = $_SESSION["theater"];}

    if(!empty($_POST['showtime'])){$showtimes = $_POST['showtime'];
    $_SESSION["showtime"] = $showtimes;}
    else{$showtimes = $_SESSION["showtime"];}
?>
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="https://www.w3schools.com/
    w3css/4/w3.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel = "stylesheet" href = "style.css">
    <link rel = "stylesheet" href = "style1.css">
        <style type="text/css">
        body {
    background-color: black;
  }
 .lds-spinner {
  color: official;
  display: inline-block;
  position: relative;
  width: 64px;
  height: 64px;
}
.lds-spinner div {
  transform-origin: 32px 32px;
  animation: lds-spinner 1.2s linear infinite;
}
.lds-spinner div:after {
  content: " ";
  display: block;
  position: absolute;
  top: 3px;
  left: 29px;
  width: 5px;
  height: 14px;
  border-radius: 20%;
  background: #fff;
}
.lds-spinner div:nth-child(1) {
  transform: rotate(0deg);
  animation-delay: -1.1s;
}
.lds-spinner div:nth-child(2) {
  transform: rotate(30deg);
  animation-delay: -1s;
}
.lds-spinner div:nth-child(3) {
  transform: rotate(60deg);
  animation-delay: -0.9s;
}
.lds-spinner div:nth-child(4) {
  transform: rotate(90deg);
  animation-delay: -0.8s;
}
.lds-spinner div:nth-child(5) {
  transform: rotate(120deg);
  animation-delay: -0.7s;
}
.lds-spinner div:nth-child(6) {
  transform: rotate(150deg);
  animation-delay: -0.6s;
}
.lds-spinner div:nth-child(7) {
  transform: rotate(180deg);
  animation-delay: -0.5s;
}
.lds-spinner div:nth-child(8) {
  transform: rotate(210deg);
  animation-delay: -0.4s;
}
.lds-spinner div:nth-child(9) {
  transform: rotate(240deg);
  animation-delay: -0.3s;
}
.lds-spinner div:nth-child(10) {
  transform: rotate(270deg);
  animation-delay: -0.2s;
}
.lds-spinner div:nth-child(11) {
  transform: rotate(300deg);
  animation-delay: -0.1s;
}
.lds-spinner div:nth-child(12) {
  transform: rotate(330deg);
  animation-delay: 0s;
}
@keyframes lds-spinner {
  0% {
    opacity: 1;
  }
  100% {
    opacity: 0;
  }
}


    </style>
</head>

<body>
  <nav>
      <ul class = "topnav">
        <li><a href = "homepage.php"> Home </a></li>
        <li><a href = "cinema.php"> Cinemas </a></li>
        <li><a href = "movie.php"> Movies </a></li>
        <li><a href = "member.php"> Log in / Sign up </a></li>
      </ul>
    </nav> 
<center><br><br><br>


<?php 
if(!empty($_POST['cancel']))
{
  $con = mysqli_connect("localhost","root","","movie");

   $branch= $_SESSION["branch"];
   $theater =  $_SESSION["theater"];
   $showtimes =  $_SESSION["showtime"];

        echo '<h1><b><font color="White">Cancel Booking..</font></b></h1></center>
        <br><br><br><br><center>
        <div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></center>
        ';
        $allseat = $_SESSION['bookseat'];

        $seatbok = explode(":", $allseat);
        $check_count = count($seatbok)-1;
        //echo $check_count.'<br>';
        //echo "<h2>selected".$check_count."</h2>";
        $seatsep = sscanf($seatbok[0], "%[A-Z]%d");
        $seatrow = $seatsep[0];
        $seatnum = $seatsep[1];

        if($seatnum<10)
          {
            $seatnum = '0'.$seatnum; 
          }
        //echo $seatrow.$seatnum."<br>";
        $seatlist = $seatrow.$seatnum."<br>";

        $sql = "UPDATE `seatinfo` SET SeatStatus = 'available'
                    where (BranchID = '$branch' 
                  AND TheaterID  = '$theater'
                  AND SeatRow    = '$seatrow'
                  AND SeatNumber = '$seatnum'
                  AND showtime = '$showtimes');";
        //echo $sql.'<br>';
        mysqli_autocommit($con,$sql);
        mysqli_query($con, $sql);

          for($i=1;$i<$check_count;$i++)
            {
              $seatsep = sscanf($seatbok[$i], "%[A-Z]%d");
              $seatrow = $seatsep[0];
              $seatnum = $seatsep[1];
              if($seatnum<10)
                {
                $seatnum = '0'.$seatnum; 
                }
              //echo $seatrow.$seatnum."<br>";
              $seatlist = $seatlist.$seatrow.$seatnum."<br>";
              $sql = "UPDATE `seatinfo` SET SeatStatus = 'available'
                      where (BranchID = '$branch' 
                    AND TheaterID  = '$theater'
                    AND SeatRow    = '$seatrow'
                    AND SeatNumber = '$seatnum'
                    AND showtime = '$showtimes');";
                //echo $sql.'<br>';
              mysqli_autocommit($con,$sql);
              mysqli_query($con, $sql);
            }
        header("Refresh: 1; url=http://localhost:8080/projectv2/waitingpage.php");
}
else
{
  echo '<h1><b><font color="White">Loading Theater..</font></b></h1></center>
  <br><br><br><br><center>
  <div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></center>
  ';
  header("Refresh: 1; url=http://localhost:8080/projectv2/bookingseat.php");
}
?>

</body>
</html>