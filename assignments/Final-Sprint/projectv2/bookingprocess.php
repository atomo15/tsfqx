<?php
		$check = 0;	
		$con = mysqli_connect("localhost","root","","movie");

				if(!empty($_POST['Branchnum']))
					{
					$Branch12 = $_POST['Branchnum'];
					// echo $Branch12.'<br>';
					}
				if(!empty($_POST['TheaterID']))
					{
					$TheaterID12 = $_POST['TheaterID'];
					// echo $TheaterID12.'<br>';
					}
				if(!empty($_POST['Rownum']))
					{
					$rownum12 = $_POST['Rownum'];
					// echo $rownum12.'<br>';
					}
				if(!empty($_POST['SeatNumber']))
					{
					$SeatNumber12 = $_POST['SeatNumber'];
					// echo $SeatNumber12.'<br>';
					}
        if(!empty($_POST['showtimes']))
          {
          $showtimes = $_POST['showtimes'];
          $hr = explode(':', $showtimes);
          $optime = $hr[0].':'.$hr[1];
          $optiontime = '<input type="checkbox" name="checkshowtime[]" value="'.$optime.'"><label>'.$optime.'<label><br>';

          for($i=0;($i<21)&&($hr[0]<21);$i=$i+3)
            {
              $hr[0] = $hr[0] + 3;
              $optime = $hr[0].':'.$hr[1];
              $optiontime = $optiontime.'<input type="checkbox" name="checkshowtime[]" value="'.$optime.'"><label>'.$optime.'<label><br>';
            }
          }

				if(!empty($Branch12)AND!empty($TheaterID12)
				AND!empty($rownum12)AND!empty($SeatNumber12))
				{
				 $sql = "SELECT `SeatStatus` FROM `seatinfo`
				 where BranchID = '$Branch12' 
				 AND TheaterID  = '$TheaterID12'
				 AND SeatRow    = '$rownum12'
				 AND SeatNumber = '$SeatNumber12'";

    			$result = mysqli_query($con,$sql);

    			$row = mysqli_fetch_array($result);

    			if(!empty($row))
    				{
    				// echo "<br>"."status: ".$row['SeatStatus'];
    				if($row['SeatStatus'] == "available")
    					{
    						$sql = "UPDATE `seatinfo` SET SeatStatus = 'unavailable'
    						where BranchID = '$Branch12' 
				 			AND TheaterID  = '$TheaterID12'
				 			AND SeatRow    = '$rownum12'
				 			AND SeatNumber = '$SeatNumber12'";

				 			mysqli_autocommit($con,$sql);

    						if (mysqli_query($con, $sql)) {
    							// echo "<br>"."Record updated successfully";
    							// echo "<br>"."Now! This seat is Booking";
    							$check = 1;
    							$sql = "SELECT `SeatInfo` FROM `seatinfo`
				 					where BranchID = '$Branch12' 
				 					AND TheaterID  = '$TheaterID12'
				 					AND SeatRow    = '$rownum12'
				 					AND SeatNumber = '$SeatNumber12'";

    							$result = mysqli_query($con,$sql);

    							$row = mysqli_fetch_array($result);

    							$SeatInfo = $row['SeatInfo'];
							} else {
    						echo "Error updating record: " . mysqli_error($con);
							}
    					}
    				}
    			}
					
			?>

<!DOCTYPE html>
<html>
<head>
	<title>SeatInfoMockup</title>

<!-- loading figure -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
/* Center the loader */
#loader {
  position: absolute;
  left: 50%;
  top: 50%;
  z-index: 1;
  width: 150px;
  height: 150px;
  margin: -75px 0 0 -75px;
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
}

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

/* Add animation to "page content" */
.animate-bottom {
  position: relative;
  -webkit-animation-name: animatebottom;
  -webkit-animation-duration: 1s;
  animation-name: animatebottom;
  animation-duration: 1s
}

@-webkit-keyframes animatebottom {
  from { bottom:-100px; opacity:0 } 
  to { bottom:0px; opacity:1 }
}

@keyframes animatebottom { 
  from{ bottom:-100px; opacity:0 } 
  to{ bottom:0; opacity:1 }
}

#myDiv {
  display: none;
  text-align: center;
}
</style>
<!-- loading figure -->
</head>

<body>
	<a href="mockuppage.php"><button>Back to homepage</button></a>
</body>

<body onload="myFunction()" style="margin:0;">

<div id="loader"></div>

<div style="display:none;" id="myDiv" class="animate-bottom">
	<?php 
	if($check == 1)
	   {
      $Mix = $Branch12.$TheaterID12.$rownum12.$SeatNumber12;
		  echo '<h2>Booking Successfully!</h2>';
		  echo 'Your Seat ID : '.$SeatInfo;
      echo '<br>Mix ID : '.$Mix;
      echo "<br>".'showtimes: '.$showtimes;
      echo "<br>";
      echo '<form action="showtimemockup.php" method ="POST">';
      echo $optiontime;
      echo '<button type="submit">submit</button>';
      echo "</form>";
		  echo "<br>".'Thank for Booking';
	   }
  	else
  	{
  		echo '<h2>Booking Fail!</h2>';
  	}

  //<p>Some text in my newly loaded page..</p>?>
</div>

<script>
var myVar;

function myFunction() {
  myVar = setTimeout(showPage, 3000);
}

function showPage() {
  document.getElementById("loader").style.display = "none";
  document.getElementById("myDiv").style.display = "block";
}
</script>

</body>

</html>
