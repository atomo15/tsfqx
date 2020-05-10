<?php  
	$con = mysqli_connect("localhost","root","","movie");

	$FirstName = mysqli_real_escape_string($con, $_POST['FirstName']);
	$LastName = mysqli_real_escape_string($con, $_POST['Lastname']);
	$DOB = mysqli_real_escape_string($con, $_POST['DOB']);
	$gender = mysqli_real_escape_string($con, $_POST['gender']);
	$Citizenid = mysqli_real_escape_string($con, $_POST['Citizenid']);	
	$email = mysqli_real_escape_string($con, $_POST['email']);
	$password = mysqli_real_escape_string($con, $_POST['password']);
	$confirmpassword = mysqli_real_escape_string($con, $_POST['ConfirmPassword']);
	$MemberType = mysqli_real_escape_string($con, $_POST['MemberType']);
	$Address = mysqli_real_escape_string($con,$_POST['Address']);
	$Phone = mysqli_real_escape_string($con,$_POST['Phone']);

	if($password == $confirmpassword)
		{
		$result = mysqli_query($con,"select * from member where Email = '$email' or CitizenID = '$Citizenid'")
					or die("Failed to query database ".mysqli_error($con));

		$row = mysqli_fetch_array($result);

		if($row['Email'] == $email)
			{
			echo "register Failed!!! ";
			echo $row['Email']."is exist";
			}

		$sql = "select MemberID from member where MemberID like 'MEM%'";
		$result = mysqli_query($con,$sql);
	
		while($row = mysqli_fetch_array($result)){
			$mem = $row['MemberID'];
			$sep = sscanf($mem,"%[A-Z]%d");
			$MAXRN = $sep[1]+1;
			if($MAXRN<10){$memberid = "MEM00".$MAXRN;}
			else if($MAXRN<100){$memberid = "MEM0".$MAXRN;}
			else{$memberid = "MEM".$MAXRN;}
		};
		$sql ="INSERT INTO member (MemberID,FirstName, LastName, DOB, Gender,CitizenID ,Membertype,Address,Phone, Email,Password)
		VALUES ('$memberid','$FirstName', '$LastName','$DOB','$gender','$Citizenid','$MemberType','$Address','$Phone','$email' ,'$password')";

		if (mysqli_query($con,$sql)) {header("Refresh: 0; url=http://localhost/projectv2/member.php");} 
		else {echo "Error: " . $sql . "<br>" . mysqli_error($con);}
	}
	else
	{echo "Error with password";}
	mysqli_close($con);
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
				<li><a href = "cinema.php"> Cinemas </a></li>
				<li><a href = "movie.php"> Movies </a></li>
				<li><a href = "member.php"> Log in / Sign up </a></li>
			</ul>
		</nav> 
</body>
<html>