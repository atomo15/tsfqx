<?php
	$con = mysqli_connect("localhost","root","","movie");

	$sql = "SELECT DISTINCT `BranchID` FROM `seatinfo`";

    $result = mysqli_query($con,$sql);

    $Branch = '<option value = "">--Please choose a Branch--</option>';

    while($row = mysqli_fetch_array($result))
    	{
    	$Branch = $Branch."<option>".$row['BranchID']."</option>";	
    	}

    $MovieName = '<option value = "">--Please choose the movies--</option>';
    while($row = mysqli_fetch_array($result))
    	{
    	$MovieName = $MovieName."<option>".$row['MovieID']."</option>";	
    	}
    session_start();
    $Branch = $_SESSION["branch"];
    $Theater = $_SESSION["theater"];
    $oritheater = $Theater; 
    $moviesys = $_SESSION['moviesys'];
    $subtheater = sscanf($Theater,"%[A-Z]%d");
    $Theater = $subtheater[1];
    $showtimes = $_SESSION["showtime"];
    $movie = $_SESSION["selectmovie"];
    //add for SSO
    if(!empty($_SESSION["memberid"]))
    {
        $memberid = $_SESSION["memberid"];
    }
    else
    {
        $result = mysqli_query($con,"SELECT *
              FROM log_login WHERE RN =(SELECT max(RN) FROM log_login)")
                or die("Failed to query database ".mysqli_error($con));
        $row = mysqli_fetch_array($result);
                               $memberid = "<br><br>Google Account:<br>".$row['email'];
    }
    //add for SSO
    $allseat = $_SESSION['bookseat'];

    $status = "NOT PAY YET";
    $sql = "SELECT BranchName FROM branch WHERE BranchID = '$Branch'";
    $result = mysqli_query($con,$sql);
    $row = mysqli_fetch_array($result);
    $BranchName = $row['BranchName'];

    $sql = "SELECT Price FROM seatprice WHERE TheaterType LIKE '$moviesys'";
    $result = mysqli_query($con,$sql);
    $seatprice = array();
    $i = 0;
    while($row = mysqli_fetch_array($result))
    {
    	$seatprice[$i] = $row['Price'];
    	$i++;
    }

    $pricereg = $seatprice[0];
    $pricehoney = $seatprice[1];

    $_SESSION['pricereg'] = $pricereg;
    $_SESSION['pricehoney']=$pricehoney;

    //echo 'Price reg = '.$pricereg.'<br>';
    //echo 'Price honey = '.$pricehoney.'<br>';

    $eachseat = explode(":",$allseat);
    $count = count($eachseat)-1;
    $printseat = "";
    $printhoney = "";
    $printreg = "";

    $allprice = 0;
    $allreg =0;
    $allhoney = 0;

    $seatinfonum = "";
    $counthoney = 0;
    $countreg = 0;

    for($i=0;$i<$count;$i++)
    {
    	 $rowchar = sscanf($eachseat[$i],"%[A-Z]%d");
    	 $rownum = ord($rowchar[0]);
    	  //echo $eachseat[$i].'<br>'.$rownum.'<br>';
    	 $seatinfonum = $seatinfonum.'SN'.$Branch.$oritheater.$showtimes.$eachseat[$i].'/';
    	 

    	 //echo $seatinfonum[$i].'<br>';
    	 if($rownum<=68)
    	 {
    	 	$allhoney = $allhoney + $pricehoney;
    	 	$printhoney = $printhoney.'<h6 class = "text-center text-dark"> HONEYMOON: '.$eachseat[$i].' </h6>';
    	 	$counthoney++;
    	 }
    	 else
    	 {
    	 	$allreg = $allreg + $pricereg;
    	 	$printreg = $printreg.'<h6 class = "text-center text-dark"> Regular: '.$eachseat[$i].' </h6>';
    	 	$countreg++;
    	 }
    	
    } 

   	$_SESSION['counthoney'] = $counthoney;
   	$_SESSION['countreg'] = $countreg;

    $_SESSION['allseatinfo'] = $seatinfonum;
    $allprice = $allreg + $allhoney;
    $printseat = $printhoney.$printreg;

    $_SESSION['amount'] = $allprice;

    $sql = "SELECT BookingID FROM bookingseat WHERE RN = (SELECT max(RN) FROM bookingseat)";
    	$result = mysqli_query($con,$sql);
    	$row = mysqli_fetch_array($result);
    	$lastbooking = $row['BookingID'];

    	if(!empty($lastbooking)){
    	$seplastbooking = sscanf($lastbooking,"%[A-Z]%d");
    	$lastnumbooking = $seplastbooking[1];

    	//echo $lastnumbooking;
    	
    	 if(($lastnumbooking+1)<10){$newbooking = "BK00".($lastnumbooking+1);}
        else if(($lastnumbooking+1)<100){$newbooking = "BK0".($lastnumbooking+1);}
        else{$newbooking = "BK".($lastnumbooking+1);}}
        else
        	{
        		$newbooking = "BK001";
        	}

    if(!empty($_SESSION['allseatinfo'])&&!empty($_POST['confirm']))
    {
    	$status = "PAID";
    	$allseatinfo = $_SESSION['allseatinfo'];
    	$eachseatinfo = explode("/",$allseatinfo);
    	$countinfo = count($eachseatinfo)-1;
    	$numreg = $_SESSION['countreg'];
    	$numhoney = $_SESSION['counthoney'];
    	$numtotal = $numreg+$numhoney;
    	$movieid = $_SESSION["selectmovie"];
    	$movieidreal = $_SESSION['movieid'];
    	//echo $movieid,'<br>';
    	

        //echo $newbooking.'<br>';

    	date_default_timezone_set("Asia/Bangkok");
    	$datebok = date("d-M-Y");
    	$timebok = date("h:i");
    	//echo $memberid.'<br>';

    	if(!empty($_POST['Options']))
    	{
    		$payment = $_POST['Options'];
    		//echo $payment.'<br>';
    	}

		$sql1 = "INSERT INTO bookingseat (BookingID,Seatinfo)
				VALUES ";    	

    	for($i=0;$i<$countinfo;$i++)
    	{
    		if($i==0)
    		{
    			$sql1 = $sql1."('$newbooking','".$eachseatinfo[$i]."')";
    		}
    		else
    		{
    			$sql1 = $sql1.",('$newbooking','".$eachseatinfo[$i]."')";
    		}
    		//echo $eachseatinfo[$i].'<br>';
    	}
    	$sql1 = $sql1.";";
    	   if (!mysqli_query($con,$sql1))
              {
              die('Error: ' . mysqli_error($con));
              }

    	//echo $sql1.'<br>';



    	//echo $numhoney.'<br>'.$numreg.'<br>'.$numtotal.'<br>';
    	$amount = $_SESSION['amount'];
   

    	$sql2 = "INSERT INTO bookingdetail (BookingID,Datebok,Timebok,MemberID
    	,Payment,BranchID,MovieID,Honeymoon,Regular,Allseat,Amount)
				VALUES ('$newbooking','$datebok','$timebok','$memberid','$payment','$Branch','$movieidreal','$numhoney','$numreg','$numtotal','$amount')";
		//echo $sql2;
		   if (!mysqli_query($con,$sql2))
              {
              die('Error: ' . mysqli_error($con));
              }

    }
   

?>
<!DOCTYPE html>
<html>
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    	<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<link rel = "stylesheet" href = "style.css">

		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title> Doonung Home </title>
	</head>
<body  style="background-color:#313133;">
	<!-- Navigation bar -->
 	<nav>
			<ul class = "topnav">
				<li><a href = "homepage.php"> Home </a></li>
				<li><a href = "cinema.php"> Cinemas </a></li>
				<li><a href = "movie.php"> Movies </a></li>
				<li><a href = "member.php"> Log in / Sign up </a></li>
			</ul>
	</nav> 
	
	<!-- Transaction summary -->
	<div class = "booking">
		<?php 
		if(empty($_POST['confirm']))
		{
			echo '<h1 class = "text-white text-center pt-5"> Transaction Summary </h1>';
		}
		else
		{
			echo '<h1 class = "text-white text-center pt-5"> Please bring this page to the staff </h1>';
		}
		?>

		<div class = "d-flex justify-content-center mt-3 row">
			<div  class = "container deep-blue-gradient color-block shadow p-3 mb-5 rounded col-6 mt-4 ">
				<div class = "form-inline">
					<div class = "col-8 form-inline">
						<h4 class = "font-weight-bold" style = "color: black"><?php echo $movie ?></h4> 
						<h5 class = "ml-3" style = "color: black"> (<?php echo $moviesys; ?>)</h4>
					</div>
					<div class = "col-4">
						<h6 class = "text-right" style = "color: black"> Booking ID : <?php echo $newbooking;?> </h6>
						<h6 class = "text-right" style = "color: black"> Member ID : <?php echo $memberid;?> </h6>
						<h6 class = "text-right" style = "color: black"> Status : <?php echo $status;?> </h6>
					</div>
				</div>

				<div class = "col-8">
					<h5 class = "text-left" style = "color: black"> <?php echo $BranchName;?> </h5>
				</div>

	
				<div class = "form-inline mt-5 d-flex align-items-start">
					<div class = "col-3 "><?php date_default_timezone_set("Asia/Bangkok"); ?>
						<h6 class = "text-center font-weight-bold text-dark "> DATE </h5> 
						<h6 class = "text-cente text-dark"> <? echo date("D,d M Y");?>
						<h6 class = "text-cente text-dark"> <? echo date("h:i a");?>
					</div>
					<div class = "col-3">
						<h6 class = "text-center font-weight-bold text-dark"> SHOWTIME </h5>
						<h6 class = "text-center text-dark"> <?php echo $showtimes;?> </h6>
					</div>
					<div class = "col-3">
						<h6 class = "text-center font-weight-bold text-dark"> THEATRE </h5>
						<h6 class = "text-center text-dark"> <?php echo $Theater;?> </h6>
					</div>
					<div class = "col-3">
						<h6 class = "text-center font-weight-bold text-dark"> SEAT NO</h5>
						<?php echo  $printseat;?>
					</div>
				</div>
				<hr>
				<div class = "form-inline mb-2">
					<div class= "col-8">
						<h6 class = "text-right" style = "color: black"> Honeymoon : <?php echo $pricehoney; ?> Baht </h6>
						<h6 class = "text-right" style = "color: black"> Regular : <?php echo $pricereg; ?> Baht </h6>
					</div>

					<div class = "col-4 mt-4">
						
						<h5 class = "text-right" style = "color: black"><b> Total <?php echo $allprice; ?> Baht </b></h5>
					</div>
				</div>
			</div>
		</div>
		<!-- Total price -->
		<?php if(empty($_POST['confirm'])){ echo '<form action="booking.php" method="post">
		<div class = "d-flex justify-content-center row">
			<div class = "container shadow p-3 mb-5 bg-white rounded col-6">
				<h2 class = "text-center font-weight-bold"> To Buy Ticket </h1>

				<div class = "form-inline">
					<h3 class = "font-weight-bold mt-2 col-3"> Payments </h2>
					<div class = "col-9 form-inline">
						<div class="form-check form-check-inline col ">
						  <input class="form-check-input" type="radio" name="Options" id="inlineRadio1" value="Credit Card">
						  <label class="form-check-label" for="inlineRadio1"> Credit Card </label>
						</div>

						<div class="form-check form-check-inline col">
						  <input class="form-check-input" type="radio" name="Options" id="inlineRadio2" value="Online Banking">
						  <label class="form-check-label" for="inlineRadio2"> Online Banking </label>
						</div>

						<div class="form-check form-check-inline col">
						  <input class="form-check-input" type="radio" name="Options" id="inlineRadio2" value="Cash" checked>
						  <label class="form-check-label" for="inlineRadio2"> Cash </label>
						</div>
					</div>
				</div>
			</div>
		</div>';}?>

		<!-- Button -->
		<?php if(empty($_POST['confirm'])){ echo '
		<div class = "d-flex justify-content-center mt-3 row">
			<div class = "col-6">

				
					<button id = "btnok"class="btn btn-primary btn-lg float-right" onclick="myFunction()" type="submit" style = "width: 25%;"> OK 
					</button>
					<input type="hidden" name="confirm" value="ok">
				</form>
					<form action="waitingpage.php" method="POST">
					<input type="hidden" name="cancel" value="ok">
				<button class="btn btn-primary btn-lg float-right" type = "submit" style = "width: 25%;"> BACK</button>
					</form>
				<script>
					function myFunction() {
					  alert("Success!");
					}
				</script>
			</div>
		</div>';}?>
	</div>

</body>
<html>
