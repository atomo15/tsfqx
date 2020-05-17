

<!-- Analysis 1 -->
   <?php 
    if(!empty($_POST['option'])){
    if($_POST['option']==1){
    $con = mysqli_connect("localhost","root","","movie");
    $sql = "SELECT MovieName,SUM(Allseat) AS Seat FROM bookingdetail d,moviedata m WHERE ";
    $sql = $sql.'d.MovieID = m.MovieID GROUP BY d.MovieID ORDER BY Seat DESC LIMIT 3';
        $result = mysqli_query($con,$sql);
        $printanalysis = "";
        while($row = mysqli_fetch_array($result))
        {
          $printanalysis = $printanalysis.'<tr><td>'.$row['MovieName'].'</td><td>'.$row['Seat'].'</td></tr>';
        }
  
    $Analysis = '<br><center>
      <table>
      <tr><th><h2>ANALYSIS : Top popular 3 Movie in all branch</h2><h2>SQL STATEMENT</h2></th></tr>
      <td><h5>SELECT MovieName,SUM(Allseat) AS Seat<br>FROM bookingdetail d,moviedata m
        <br>WHERE d.MovieID = m.MovieID<br>GROUP BY d.MovieID
        <br>ORDER BY Seat DESC LIMIT 3</h5></td>
      </table>
      <br>
            <table>
              <tr>
                <th>MovieName</th>
                <th>Seat</th>
              </tr>
              '.$printanalysis.'
            </table>
        </center><br>';}}
    ?>
    <!-- Analysis 1 -->

    <!-- Analysis 2 -->
   <?php 
    if(!empty($_POST['option'])){
    if($_POST['option']==2){
    $con = mysqli_connect("localhost","root","","movie");
    $sql = "SELECT ".'b.BranchName ,SUM(d.Allseat) as AmountofCustomer 
    FROM  branch b,bookingdetail d
        WHERE d.BranchID = b.BranchID
            GROUP BY b.BranchID';
        $result = mysqli_query($con,$sql);
        $printanalysis = "";
        while($row = mysqli_fetch_array($result))
        {
          $printanalysis = $printanalysis.'<tr><td>'.$row['BranchName'].'</td><td>'.$row['AmountofCustomer'].'</td></tr>';
        }
    $Analysis = '<br><center>
      <table>
      <tr><th><h2>ANALYSIS : Number of booking seat in each branch </h2><h2>SQL STATEMENT</h2></th></tr>
      <td><h5>SELECT b.BranchName ,SUM(d.Allseat) as AmountofCustomer<br>FROM  branch b,bookingdetail d
      <br>WHERE d.BranchID = b.BranchID<br>GROUP BY b.BranchID</h5></td>
      </table>
      <br>
            <table>
              <tr>
                <th>BranchName</th>
                <th>Amount of Customer</th>
              </tr>
              '.$printanalysis.'
            </table>
        </center><br>'; }}
    ?>
    <!-- Analysis 2 -->

     <!-- Analysis 3 -->
   <?php 
    if(!empty($_POST['option'])){
    if($_POST['option']==3){
    $con = mysqli_connect("localhost","root","","movie");
    $sql = "SELECT Payment,COUNT(*) as CountTimes FROM bookingdetail GROUP BY Payment";
        $result = mysqli_query($con,$sql);
        $printanalysis = "";
        while($row = mysqli_fetch_array($result))
        {
          $printanalysis = $printanalysis.'<tr><td>'.$row['Payment'].'</td><td>'.$row['CountTimes'].'</td></tr>';
        }
    $Analysis = '<br><center>
      <table>
      <tr><th><h2>ANALYSIS : Type of member payment </h2><h2>SQL STATEMENT</h2></th></tr>
      <td><h5>SELECT Payment,COUNT(*) as CountTimes<br>FROM bookingdetail<br>GROUP BY Payment</h5></td>
      </table>
      <br>
            <table>
              <tr>
                <th>Payment</th>
                <th>CountTimes</th>
              </tr>
              '.$printanalysis.'
            </table>
        </center><br> ';}}
    ?>
    <!-- Analysis 3 -->

    <!-- Analysis 4 -->
  <?php 
    if(!empty($_POST['option'])){
    if($_POST['option']==4){
    $con = mysqli_connect("localhost","root","","movie");
    $sql = "SELECT ".'a.BranchID,b.BranchName,SUM(a.Amount) as Amounts FROM bookingdetail a,branch b 
    WHERE a.BranchID = b.BranchID 
      GROUP BY a.BranchID';
        $result = mysqli_query($con,$sql);
        $printanalysis = "";
        while($row = mysqli_fetch_array($result))
        {
          $printanalysis = $printanalysis.'<tr><td>'.$row['BranchID'].'</td><td>'.$row['BranchName'].'</td><td>'.$row['Amounts'].'</td></tr>';
        }

   $Analysis ="<br><center>
      <table>
      <tr><th><h2>ANALYSIS : Branch'".'s income</h2><h2>SQL STATEMENT</h2></th></tr>
      <td><h5>SELECT a.BranchID,b.BranchName,SUM(a.Amount) as Amounts<br>FROM bookingdetail a,branch b<br>WHERE a.BranchID = b.BranchID 
      <br>GROUP BY a.BranchID</h5></td>
      </table>
      <br>
            <table>
              <tr>
                <th>BranchID</th>
                <th>BranchName</th>
                <th>Amounts</th>
              </tr>
              '.$printanalysis.'
            </table>
        </center><br>';}}
    ?>
    <!-- Analysis 4 -->

     <!-- Analysis 5 -->
  <?php 
    if(!empty($_POST['option'])){
    if($_POST['option']==5){
    $con = mysqli_connect("localhost","root","","movie");
    $sql = "SELECT "."a.MemberID,b.FirstName,SUM(a.Allseat) as TotalSeats 
  FROM bookingdetail a,member b
      WHERE a.MemberID = b.MemberID  AND a.MemberID NOT LIKE 'ADM%' 
          GROUP BY a.MemberID ORDER BY TotalSeats DESC";
        $result = mysqli_query($con,$sql);
        $printanalysis = "";
        while($row = mysqli_fetch_array($result))
        {
          $printanalysis = $printanalysis.'<tr><td>'.$row['MemberID'].'</td><td>'.$row['FirstName'].'</td><td>'.$row['TotalSeats'].'</td></tr>';
        }
  
    $Analysis ="<br><center>
      <table>
      <tr><th><h2>ANALYSIS : Total booking seats of each members</h2><h2>SQL STATEMENT</h2></th></tr>
      <td><h5>SELECT a.MemberID,b.FirstName,SUM(a.Allseat) as TotalSeats 
      <br>FROM bookingdetail a,member b
        <br>WHERE a.MemberID = b.MemberID  AND a.MemberID NOT LIKE 'ADM%' 
          <br>GROUP BY a.MemberID 
          <br>ORDER BY TotalSeats DESC </h5></td>
      </table>
      <br>
            <table>
              <tr>
                <th>MemberID</th>
                <th>FirstName</th>
                <th>TotalSeats</th>
              </tr>
              ".$printanalysis."
            </table>
        </center><br>";}}
    ?> 
    <!-- Analysis 5 -->

    <!-- Analysis 6 -->
  <?php 
    if(!empty($_POST['option'])){
    if($_POST['option']==6){
    $con = mysqli_connect("localhost","root","","movie");
    $sql = "SELECT "."b.FirstName,a.MemberID,COUNT(a.BookingID) AS AmountBooking 
  FROM bookingdetail a,member b
      WHERE a.MemberID = b.MemberID AND a.MemberID NOT LIKE 'ADM%' 
        GROUP BY a.MemberID 
            ORDER BY AmountBooking DESC";
        $result = mysqli_query($con,$sql);
        $printanalysis = "";
        while($row = mysqli_fetch_array($result))
        {
          $printanalysis = $printanalysis.'<tr><td>'.$row['FirstName'].'</td><td>'.$row['MemberID'].'</td><td>'.$row['AmountBooking'].'</td></tr>';
        }
  
 $Analysis ="<br><center>
      <table>
      <tr><th><h2>ANALYSIS : Total booking seats of each member</h2><h2>SQL STATEMENT</h2></th></tr>
      <td><h5> SELECT b.FirstName,a.MemberID,COUNT(a.BookingID) AS AmountBooking 
      <br>FROM bookingdetail a,member b
        <br>WHERE a.MemberID = b.MemberID AND a.MemberID NOT LIKE 'ADM%' 
        <br>GROUP BY a.MemberID 
          <br>ORDER BY AmountBooking DESC</h5></td>
      </table>
      <br>
            <table>
              <tr>
                <th>FirstName</th>
                <th>MemberID</th>
                <th>AmountBooking</th>
              </tr>
              ".$printanalysis.'
            </table>
        </center><br>';}}
    ?>
    <!-- Analysis 6 -->

    <!-- Analysis 7 -->
  <?php 
    if(!empty($_POST['option'])){
    if($_POST['option']==7){
    $con = mysqli_connect("localhost","root","","movie");
    $sql = "SELECT "."x.BranchID,b.BranchName,d.MovieID,m.MovieName,MAX(mycount) as AmountBooking
    FROM (SELECT BranchID,MovieID,COUNT(MovieID) as mycount
            FROM bookingdetail  
            GROUP BY BranchID,MovieID  ) as x ,branch b,bookingdetail d,moviedata m
    WHERE x.BranchID = b.BranchID AND d.MovieID=m.MovieID
    GROUP BY BranchID";
        $result = mysqli_query($con,$sql);
        $printanalysis = "";
        while($row = mysqli_fetch_array($result))
        {
          $printanalysis = $printanalysis.'<tr><td>'.$row['BranchID'].'</td><td>'.$row['BranchName'].'</td><td>'.$row['MovieID'].'</td><td>'.$row['MovieName'].'</td><td>'.$row['AmountBooking'].'</td></tr>';
        }
  
 $Analysis ='<br><center>
      <table>
      <tr><th><h2>ANALYSIS : Popular movie of each branch</h2><h2>SQL STATEMENT</h2></th></tr>
      <td><h5>SELECT x.BranchID,b.BranchName,d.MovieID,m.MovieName,MAX(mycount) as AmountBooking
      <br>FROM (SELECT BranchID,MovieID,COUNT(MovieID) as mycount
          <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;FROM bookingdetail  
          <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          GROUP BY BranchID,MovieID  ) as x ,branch b,bookingdetail d,moviedata m
      <br>WHERE x.BranchID = b.BranchID AND d.MovieID=m.MovieID
      <br>GROUP BY BranchID</h5></td>
      </table>
      <br>
            <table>
              <tr>
                <th>BranchID</th>
                <th>BranchName</th>
                <th>MovieID</th>
                <th>MovieName</th>
                <th>AmountBooking</th>
              </tr>
              '.$printanalysis.'
            </table>
        </center><br>';}}
    ?>
    <!-- Analysis 7 -->

     <!-- Analysis 8 -->
  <?php 
    if(!empty($_POST['option'])){
    if($_POST['option']==8){
    $con = mysqli_connect("localhost","root","","movie");
    $sql = "SELECT "."d.BranchID,b.branchName,COUNT(*) as AmountBooking 
      FROM bookingdetail  d,branch b
        WHERE d.BranchID=b.BranchID
          GROUP BY BranchID";
        $result = mysqli_query($con,$sql);
        $printanalysis = "";
        while($row = mysqli_fetch_array($result))
        {
          $printanalysis = $printanalysis.'<tr><td>'.$row['BranchID'].'</td><td>'.$row['branchName'].'</td><td>'.$row['AmountBooking'].'</td></tr>';
        }
  
  $Analysis = '<br><center>
      <table>
      <tr><th><h2>ANALYSIS : Number of booking of each branch </h2><h2>SQL STATEMENT</h2></th></tr>
      <td><h5>SELECT d.BranchID,b.branchName,COUNT(*) as AmountBooking 
      <br>FROM bookingdetail  d,branch b
      <br>WHERE d.BranchID=b.BranchID
      <br>GROUP BY BranchID </h5></td>
      </table>
      <br>
            <table>
              <tr>
                <th>BranchID</th>
                <th>branchName</th>
                <th>AmountBooking</th>
              </tr>
              '.$printanalysis.'
            </table>
        </center><br>';}}
    ?>
    <!-- Analysis 8 -->

    <!-- Analysis 9 -->
  <?php 
  if(!empty($_POST['option'])){
  if($_POST['option']==9){
    $con = mysqli_connect("localhost","root","","movie");
    $sql = "SELECT MemberID, SUM(Amount) as Amounts
          FROM bookingdetail
            WHERE MemberID NOT LIKE 'ADM%' 
              GROUP BY MemberID
                ORDER BY Amounts DESC";
        $result = mysqli_query($con,$sql);
        $printanalysis = "";
        while($row = mysqli_fetch_array($result))
        {
          $printanalysis = $printanalysis.'<tr><td>'.$row['MemberID'].'</td><td>'.$row['Amounts'].'</td></tr>';
        }
  $Analysis ="<br><center>
      <table>
      <tr><th><h2>ANALYSIS : Amount of each member </h2><h2>SQL STATEMENT</h2></th></tr>
      <td><h5>SELECT MemberID, SUM(Amount) as Amounts
      <br>FROM bookingdetail
      <br>WHERE MemberID NOT LIKE 'ADM%' 
      <br>GROUP BY MemberID
      <br>ORDER BY Amounts DESC</h5></td>
      </table>
      <br>
            <table>
              <tr>
                <th>MemberID</th>
                <th>Amounts</th>
              </tr>
              ".$printanalysis."
            </table>
        </center><br>";}}
    ?>
    <!-- Analysis 9 -->

    


<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel = "stylesheet" href = "style.css">
<style type="text/css">
  table,th,td {
      border : 1px solid lightblue;
      border-collapse: collapse;
    }
    th,td {
      padding: 5px;
    }
</style>
	<title> Analysis </title>
</head>

<body style="background-color: black;">
  <!-- Navigation bar -->
  <nav>
      <ul class = "topnav">
        <li><a href = "homepage.php"> Home </a></li>
        <li><a href = "cinema.php"> Cinemas </a></li>
        <li><a href = "movie.php"> Movies </a></li>
        <li><a href = "member.php"> Log in / Sign up </a></li>
      </ul>
  </nav>
  <div class = "container">
  	<h1 class = "text-white text-center" style="margin-top:5%;"> Analysis Data </h1>
        <div class = "text-white text-center"> <?php if(empty($_POST['option']))
        {$Analysis = "";}echo $Analysis;?></div>
  	<div class = "form-inline" style = "margin-top: 10%; justify-content:center;">
  		<div class = "text-center">
  		<div class = "row">
  			<div class = "col">
  				<form action="analysis.php" method="POST">
            <input type="hidden" name="option" value="7">
	  				<button type="submit" class="btn btn-warning btn-lg" style = "width:100%; height:100%;">
	  				<h5 class = "text-dark"> Popular movie of each branch</h5>
	  				</button>
  				</form>
  			</div>
  			<div class = "col">
  				<form action="analysis.php" method="POST">
            <input type="hidden" name="option" value="6">
	  				<button type="submit" class="btn btn-warning btn-lg" style = "width:100%; height:100%;">
	  				<h5 class = "text-dark"> Total booking seats of each member </h5>
	  				</button>
  				</form>
  			</div>
  			<div class = "col">
  				<form action="analysis.php" method="POST">
            <input type="hidden" name="option" value="1">
	  				<button type="submit" class="btn btn-warning btn-lg" style = "width:100%; height:100%;">
	  				<h5 class = "text-dark"> Popular 3 Movies in all branch</h5>
	  				</button>
  				</form>
  			</div>
  			</div>
  		</div>
  	</div>

  	<div class = "form-inline mt-5">
  		<div class = "text-center">
  		<div class = "row">
	  		<div class = "col">
	  			<form action="analysis.php" method="POST">
            <input type="hidden" name="option" value="2">
		  			<button type="submit" class="btn btn-info btn-lg" style = "width:100%; height:100%;">
		  			<h5 class = "text-white">  Number of booking seat in each branch </h5>
		  			</button>
	  			</form>
	  		</div>
	  		<div class = "col">
  				<form action="analysis.php" method="POST">
            <input type="hidden" name="option" value="3">
	  				<button type="submit" class="btn btn-info btn-lg" style = "width:100%; height:100%;">
	  				<h5 class = "text-white">  Type of member payment </h5>
	  				</button>
  				</form>
  			</div>
  			<div class = "col">
  				<form action="analysis.php" method="POST">
            <input type="hidden" name="option" value="4">
	  				<button type="submit" class="btn btn-info btn-lg" style = "width:100%; height:100%;">
	  				<h5 class = "text-white">  Branch's income </h5>
	  				</button>
  				</form>
  			</div>
  			<div class = "col">
  				<form action="analysis.php" method="POST">
            <input type="hidden" name="option" value="5">
	  				<button type="submit" class="btn btn-info btn-lg" style = "width:100%; height:100%;">
	  				<h5 class = "text-white"> Total booking seats of each members </h5>
	  				</button>
  				</form>
  			</div>
  			<div class = "col">
  				<form action="analysis.php" method="POST">
            <input type="hidden" name="option" value="8">
	  				<button type="submit" class="btn btn-info btn-lg" style = "width:100%; height:100%;">
	  				<h5 class = "text-white">  Number of booking of each branch </h5>
	  				</button>
  				</form>
  			</div>
  			<div class = "col">
  				<form action="analysis.php" method="POST">
            <input type="hidden" name="option" value="9">
	  				<button type="submit" class="btn btn-info btn-lg" style = "width:100%; height:100%;">
	  				<h5 class = "text-white">  Amount of each member </h5>
	  				</button>
  				</form>
  			</div>
	  	</div>
	  	</div>
  	</div>



  	<div class = "text-center" style = "margin-top: 10%;">
		<a href="adminpage.php"><button type = "submit" class="btn btn-primary btn-lg my-1"> BACK </button></a>
	</div>
  </div>
</body>
</html>