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

	<body  style = "background-color:#313133;">
		<nav>
			<ul class = "topnav">
				<li><a href = "#Home"> Home </a></li>
				<li><a href = "cinema.php"> Cinemas </a></li>
				<li><a href = "#Movies"> Movies </a></li>
				<li><a href = "#Promotion"> Promotion </a></li>
				<li><a href = "#Log in / Sign up"> Log in / Sign up </a></li>
			</ul>
		</nav> 

		<div class = "succes">
			<h1 class = "text-center text-white pt-5"> Please bring this page to the staff </h1>
			<div class = "d-flex justify-content-center mt-3 row">
				<div  class = "container deep-blue-gradient color-block shadow p-3 mb-5 rounded col-6 mt-4 ">
					<div class = "form-inline">
						<div class = "col-8 form-inline">
							<h2 class = "font-weight-bold text-dark"> Aladdin </h3> 
							<h5 class = "ml-3 text-dark"> (3D)</h4>
						</div>
						<div class = "col-4">
							<h6 class = "text-right text-dark"> Booking ID : 123456789 </h6>
						</div>
					</div>

					<div class = "col-8">
						<h5 class = "text-left text-dark"> ICON SIAM </h5>
					</div>

					<div class = "form-inline mt-5 d-flex align-items-start">
						<div class = "col-3 ">
							<h6 class = "text-center font-weight-bold text-dark "> DATE </h5> 
							<h6 class = "text-center text-dark"> Thu,16 JUN 2019
						</div>
						<div class = "col-3">
							<h6 class = "text-center font-weight-bold text-dark"> TIME </h5>
							<h6 class = "text-center text-dark"> 7:30 p.m. </h6>
						</div>
						<div class = "col-3">
							<h6 class = "text-center font-weight-bold text-dark"> THEATRE </h5>
							<h6 class = "text-center text-dark"> 3 </h6>
						</div>
						<div class = "col-3">
							<h6 class = "text-center font-weight-bold text-dark"> SEAT NO</h5>
							<h6 class = "text-center text-dark"> Regular: B5 </h6>
							<h6 class = "text-center text-dark"> Regular: B6 </h6>
							<h6 class = "text-center text-dark"> Regular: B7 </h6>
						</div>
					</div>
					<hr>
					<div class = "form-inline mb-2">
						<div class= "col-8">
						</div>

						<div class = "col-4 mt-4">
							<div class = "form-inline float-right">
								<h6 class = "text-dark"> Paid by: </h6>
								<h6 class = "text-dark font-weight-bold ml-3">Credit Card </h6>
							</div>
							<div class = "form-inline float-right mt-3">
								<h6 class = "text-dark"> Total </h6>
								<h6 class = "text-dark font-weight-bold ml-3">280 Baht </h6>
							</div>
						</div>
					</div>

				</div>
			</div>

			<div class = "d-flex justify-content-center mt-3 row">
				<div class = "col-6  text-center">	
					<a href = "homepage.php">
					<button class="btn btn-primary btn-lg" type="submit" style = "width: 25%;">
					 OK
					 </button>
					</a>
				</div>
			</div>
		</div>
	</body>

<html>