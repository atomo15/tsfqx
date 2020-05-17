<?php 
	$con = mysqli_connect("localhost","root","","movie");


	$sql = "SELECT DISTINCT MemberStatusID,StatusType FROM memberstatus";

    $result = mysqli_query($con,$sql);

    $memtype = '<option value = "">--Please choose a Membertype--</option>';

  if($result)
  {
    while($row = mysqli_fetch_array($result))
    	{
      	$memberstatusid = $row['MemberStatusID'];
    	$memtype = $memtype.'<option value="'.$memberstatusid.'">'.$row['StatusType']."</option>";	
    	}
  }

?>




<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel = "stylesheet" href = "style.css">

  <title>Register</title>
	<style type="text/css">
		  body {
    background-color: black;
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

   <!-- Prim's edit here -->
   <div class = "container mt-5">
   <h1 class = "text-center text-white mb-3"> Register </h1>
   <div class = "card">
   	<div class = "card-body">
   	<form action = "register.php" method = "POST">
   		<div class = "row d-flex justify-content-center">
   			<div class = "col-10">
				<form>
					<div class = "form-row">
					    <div class = "form-group col-md-6">
						    <label for = "FirstName"><h3  class="col-form-label text-dark"> First Name: </h3></label>
						    <input id = "FirstName" class="form-control form-control-sm " style="width:75%;" name = "FirstName" type = "text" placeholder="e.g. Barbara" required>
						</div>
						<div class="form-group col-md-6">
						    <label for="Lastname"><h3 class="col-form-label text-dark">Last Name :</h3></label>
						    <input id = "Lastname" class="form-control form-control-sm" style="width:75%;" name = "Lastname" type = "text" placeholder = "e.g. Aloha" required>
						</div>
					</div>	

					<div class = "form-row">
						<div class = "form-group col-md-4">
							<label for = "gender"><h3  class="col-form-label text-dark mr-4"> Gender: </h3></label><br>
								<input type="radio" name="gender" value="male" checked>
				  				<label class="form-check-label" for="inlineRadio1"><h4 class="col-form-label text-dark mr-5"> Male </h4></label>
				  				<input type="radio" name="gender" value="female" checked> 
				  				<label class="form-check-label" for="inlineRadio1"><h4 class="col-form-label text-dark"> Female </h4></label>
						</div>
						<div class = "form-group col-md-4">
							<label for = "DOB"><h3  class="col-form-label text-dark"> Date of birth : </h3></label>
							<input id = "DOB" class="form-control form-control-sm" style = "width:75%;" name = "DOB" type = "Date" placeholder = "1999-03-15" required>
						</div>
						<div class = "form-group col-md-4">
							<label for = "Citizenid"><h3  class="col-form-label text-dark"> CitizenID : </h3></label>
							<input id = "Citizenid" class="form-control form-control-sm" style = "width:75%;" name = "Citizenid" type = "text" placeholder = "112970000446x" required>
						</div>
					</div>

					<div class = "form-row">
						<div class = "form-group">
							<label for = "MemberType"><h3 class="col-form-label text-dark mr-4"> MemberType : </h3></label>
				 			<select name= "MemberType"  class="form-control">
				  				<?php echo $memtype; ?>
				   			</select>
				   		</div>
					</div>

					<div class = "form-group">
						<label for = "Address"><h3 class="col-form-label text-dark mr-4"> Address: </h3></label>
			   			<textarea name="Address" class="form-control" style="width:50%;" rows="4" cols="50" ></textarea>
					</div>

					<div class = "form-group">
						<label for = "Phone"><h3 class="col-form-label text-dark mr-4"> Phone : </h3></label>
						<input id = "Phone" class="form-control form-control-sm" style="width:25%;" name = "Phone" type = "text" placeholder="e.g. 094-685-99xx" required>
					</div>

					<div class = "form-group">
						<label for = "email"><h3 class="col-form-label text-dark mr-4"> Email : </h3></label>
						<input id = "email" class="form-control form-control-sm" style="width:25%;" name = "email" type = "text" placeholder="e.g. bart@hotmail.com" required>
					</div>
					
					<div class = "form-row">
						<div class = "form-group col-md-6">
							<label for = "password"><h3 class="col-form-label text-dark mr-4"> Password : </h3></label>
							<input id = "password" class="form-control form-control-sm" style="width:75%;" name = "password" type = "password" placeholder = "Your password"reqiureed >
						</div>
						<div class = "form-group col-md-6">
							<label for = "ConfirmPassword"><h3 class="col-form-label text-dark mr-4"> Confirm Password : </h3></label>
							<input id = "ConfirmPassword" class="form-control form-control-sm" style="width:75%;" name = "ConfirmPassword" type = "password" placeholder = "Your password"reqiureed >
						</div>
					</div>

					<div class = "text-center mt-4">
						<button type = "submit" class="btn btn-primary btn-lg my-1"> SIGN UP </button>
					</div>


				</form>
			</div>
		</div>
	</form>
</div>
</div>
</div>	

</body>
</html>
