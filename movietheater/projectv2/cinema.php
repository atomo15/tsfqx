<?php
	$con = mysqli_connect("localhost","root","","movie");

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
	    $moviecount = 0;
	    $releasedate = 0;
	  if(!empty($result))
	  {
	    while($row = mysqli_fetch_array($result))
	    	{
	    	$MovieName = $MovieName."<option>".$row['MovieName']."</option>";
	    	$movie[$moviecount] = $row['MovieName'];
	    	$release[$releasedate] = $row['ReleaseDate'];
	    	$releasedate++;
	    	$moviecount++;	
	    	}
	    }
    while($row = mysqli_fetch_array($result))
    	{
    	$MovieName = $MovieName."<option>".$row['MovieID']."</option>";	
    	}
    $BranchQuery = mysqli_query($con,"SELECT * FROM `branch`");
    $printdetail = "";
    while($row = mysqli_fetch_array($BranchQuery))
					 {
					    $printdetail = $printdetail.'<h4 class = "font-weight-bold text-dark ml-3">' .$row['BranchName'] . '</h4>
						<div class = "text-dark">'.$row['Address'] . "<br><br>".	
						'<p> Tel:'.$row['PhoneNumber'] . '</p>'.	 
						"<hr>";

				    }

?>
<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<link rel = "stylesheet" href = "style.css">
		<title> Doonung Home </title>
	</head>
<body>
	<!-- Navigation bar -->
 	<nav>
			<ul class = "topnav">
				<li><a href = "homepage.php"> Home </a></li>
				<li><a href = "#Cinemas"> Cinemas </a></li>
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
				<left><button type="submit" class = "button button1" id="ButtonShowtime"> SHOW TIME</button></left>
			</div>
			</form>
		</div>
	</div>

	<!-- Branch's cinema-->
    <div class = "container mt-3">
    	<div class = "card">
    		<div class = "card-body">
		    	<h1 class = "card-title text-center"> DooNangMaiJa Cinema  </h1><br>
		    	<?php 
					echo $printdetail;
			    ?>
			</div>
		 </div>
    </div>
</body>
<html>