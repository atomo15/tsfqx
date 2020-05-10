<?php
	$con = mysqli_connect("localhost","root","","movie");

/*SELECT SHOW*/
	$sql = "SELECT DISTINCT BranchID FROM branch WHERE BranchID IN (SELECT BranchID FROM theater WHERE MovieID NOT LIKE '*'AND MovieID NOT LIKE '-')";

    $result = mysqli_query($con,$sql);

    $Branch = '<option value = "">--Please choose a Branch--</option>';

    if($result)
  {
    while($row = mysqli_fetch_array($result))
    	{
      	$branchnum = $row['BranchID'];
      	$sql2 = "SELECT BranchName from branch where BranchID = '$branchnum'";
      	$result2 = mysqli_query($con,$sql2);
      	$row2 = mysqli_fetch_array($result2);
    	$Branch = $Branch.'<option value="'.$branchnum.'">'.$row2['BranchName']."</option>";	
    	}
  }

    $MovieName = '<option value = "">--Please choose the movies--</option>';
    $sql = "SELECT MovieName,ReleaseDate FROM moviedata WHERE MovieName IN (SELECT DISTINCT MovieID FROM theater WHERE MovieID NOT LIKE '*'AND MovieID NOT LIKE '-')";
    $result = mysqli_query($con,$sql);
  if(!empty($result))
  {
    while($row = mysqli_fetch_array($result))
    	{
    	$MovieName = $MovieName."<option>".$row['MovieName']."</option>";
    	}
    }
/*SELECT SHOW*/


mysqli_close($con);

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

	<!-- choose showtime -->
	<div class = "cotainer-fluid sticky-top">
		<div id = "incontainer">
			<div id = "Left" class = "row form-inline">
				<div class = "col-3">
					<img src = "movie-pics/Doonang.png" class = "ml-5" style = "width: 200%; height: 200%;">
				</div>
				<div class = "col-8">
					<h3 class = "blue "> SHOWTIME </h3> 
					<h5 class = "white "> BUY TICKET </h5>
				</div>
			</div>
			<div id = "Center" class = "pb-2">
					<br>
					<form class="form-inline" action="SelectShow.php" method="POST">
						<select class = "minimal mr-3 ml-5" name = "MovieName" required> 
								<?php echo $MovieName;?>
						</select>
						<div class = "text-white"> At </div>
						<select class = "minimal ml-3" name="Branchnum" required>
								<?php echo $Branch;?>
						</select>
					
			</div>
			<div id = "Right" class = "mt-1">
				<left><button class = "button button1" id="ButtonShowtime"> SHOW TIME</button></left>
			</div></form>
		</div>
	</div>

	<!-- Movie Title -->
	<?php 
	$con = mysqli_connect("localhost","root","","movie");
	$movieselect = $_POST['moviename'];
	echo $_POST['moviename'];
	$sql = "SELECT MovieID,Rate,MovieLenght,ReleaseDate,MovieDetail,MainActor,MovieTypeID,Trailer FROM moviedata WHERE MovieName = '$movieselect'";
  	$result = mysqli_query($con,$sql);
  	$row = mysqli_fetch_array($result);
  	$movieid = $row['MovieID'];
  	$movierate = $row['Rate'];
  	$movielenght = $row['MovieLenght'];
  	$MovieDetail = $row['MovieDetail'];
  	$MovieTypeID = $row['MovieTypeID'];
  	$MainActor = $row['MainActor'];
  	$Trailer = $row['Trailer'];
  	$ReleaseDate = $row['ReleaseDate'];
  	$ReleaseDate = str_replace('-', '/', $ReleaseDate);

	$sql = "SELECT summary FROM movclasssys WHERE MovieID = '$movieid'";
    $result = mysqli_query($con,$sql);
    $row = mysqli_fetch_array($result);
    $moviesys = $row['summary'];

	echo '<div class = "container">
		<div class = "card bg-light mb-2">
			<div class = "card-body text-left" style = "padding-bottom: 0px;">
				<div class = "toptitlemovie">
					<h2 class = "card-title" > '.$movieselect.' </h2>
				</div>
				<div class = "row">
					<div class = "col-2 listbottomtitle">
						<p class = "card-text font-weight-bold"> MOVIE RATE </p>
						<p class = "card-text"> '.$movierate.' </p>
					</div>

					<div class = "col-2 listbottomtitle">
						<p class = "card-text font-weight-bold"> SYSTEM TYPE </p>
						<p class = "card-text"> '.$moviesys.' </p>
					</div>

					<div class = "col-4 listbottomtitle">
						<p class = "card-text font-weight-bold"> GENRE</p>
						<p class = "card-text"> '.$MovieTypeID.' </p>
					</div>

					<div class = "col-1 listbottomtitle">
						<p class = "card-text font-weight-bold"> LENGTH</p>
						<p class = "card-text"> '.$movielenght.' mins </p>
					</div>

					<div class = "col-2" style = "padding: 10px; float: left; height: 70px; margin-left : 5px;">
						<p class = "card-text font-weight-bold"> RELEASE DATE </p>
						<p class = "card-text"> '.$ReleaseDate.' </p>
					</div>
				</div>
			</div>
		</div>

		<!-- Movie Trailer-->
		<div class = "row">
			<div class = "col">
				<div class = "embed-responsive embed-responsive-21by9"> 
					<iframe class = "embed-responsive-item" width="560" height="315" src="'.$Trailer.'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
				</div>
			</div>
		</div>

		 <div class = "card mt-2">
		 	<div class = "card-body">
			 	<h2 class = "card-title text-center"> SYNOPSIS </h2>
			 	<div class = "row d-flex justify-content-center">
			 		<div class = "col-10">
				 		<p div class = "card-text" style = "color: #666666; line-height: 26px; font-weight: normal;">
				 			'.$MovieDetail.'
				 		</p>
			 		</div>
			 	</div>
			 	<br>
			 	<hr>
			 	<br>
			 	<h2 class = "card-title text-center"> Actor / Actress </h2>
			 	<div class = "row d-flex justify-content-center">
			 		<div class = "col-10">
			 			<h5 class = "card-text text-center" style = "color: #666666;"> '.$MainActor.' </h2>
			 		</div>
			 	</div>
			 </div>
		 </div>
	</div>';
	?>

</body>
<html>