
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel = "stylesheet" href = "style.css">
    <link rel = "stylesheet" href = "style1.css">
  <title>Member Account</title>
</head>
<body>
<!-- style table -->

<style>
    table,th,td {
      border : 1px solid lightblue;
      border-collapse: collapse;
    }
    th,td {
      padding: 5px;
    }
  </style>

<!-- style table -->
<nav>
      <ul class = "topnav">
        <li><a href = "homepage.php"> Home </a></li>
        <li><a href = "cinema.php"> Cinemas </a></li>
        <li><a href = "movie.php"> Movies </a></li>
        <li><a href = "member.php"> Log in / Sign up </a></li>
      </ul>
    </nav> 
</body>
</html>

<!-- Check username password -->
<?php  

  $email = $_POST['email'];
  $Password = $_POST['pswd'];


  $email = stripcslashes($email);
  $Password = stripcslashes($Password);
   $redirect = 0;


  /*
  echo "email ".$email;
  echo "<br>";
  echo "password ".$Password;
  echo "<br>";*/

  $ok = 0;
  $con = mysqli_connect("localhost","root","","movie");

  $result = mysqli_query($con,"select * from member where Email = '$email'and password = '$Password'")
        or die("Failed to query database ".mysqli_error($con));

  $row = mysqli_fetch_array($result);

  $result2 = mysqli_query($con,"SELECT RN,email,status 
            FROM log_login WHERE RN =(SELECT max(RN) FROM log_login)")
              or die("Failed to query database ".mysqli_error($con));
  $row2 = mysqli_fetch_array($result);

  $memberid = $row['MemberType'];
  $sql = "select StatusType from memberstatus where MemberStatusID = '$memberid' ";
  $result3 = mysqli_query($con,$sql);
  $row3 = mysqli_fetch_array($result3);

  /* insert to log_login */

  $emaillogin = $row['Email'];
  $emaillog   = $row2['email'];
  $statuslog  = $row2['status'];

 session_start();
  


  if($emaillog != $emaillogin and $statuslog == 0)
    {
      $sql = "SELECT MemberID FROM member WHERE Email = '$emaillogin'";
      $result5 = mysqli_query($con,$sql);
      $row5 = mysqli_fetch_array($result5);
     
      $_SESSION["memberid"] = $row5['MemberID'];
      $sql="INSERT INTO log_login(email,status)
      VALUES ('$emaillogin', '1')";
      if(!mysqli_query($con,$sql))
        {
          die('Error: ' . mysqli_error($con));
        }
  //mysqli_close($con);
  /* insert to log_login */
     if($row['Email'] == $email && $row['Password'] == $Password )
        {
        //echo "Login success!!! ";
        echo "<br><br><br><br><br><br><br>";
        if($_SESSION['redirect2bok']==1)
        {
          $_SESSION['redirect2bok'] = 0;
          header("Refresh: 0; url=http://localhost:8080/projectv2/waitingpage.php");
          $ok = 0;
          $redirect =1;
        }
        else if(empty($row3)){
        echo "<meta http-equiv='refresh' content='0; URL=http://localhost:8080/projectv2/adminpage.php'>";
        echo "<center>Welcome Admin ".$row['FirstName']."</center><br>";}
        else{echo "<center>welcome ".$row['FirstName']."</center><br>";}
        $ok = 1;
        }
    else{
        echo "Failed to login!";
        }
  }
if($ok==1&&$redirect==0)
{
// show member data 
header("Refresh: 0; url=http://localhost:8080/projectv2/member.php");
// echo "<br><br><br>";
// echo "<center><table>";
// echo "<tr>";
// echo "<th>Member ID :</th>";
// echo "<td>" . $row['MemberID'] . "</td>";
// echo "</tr>";

// echo "<tr>";
// echo "<th>Firstname :</th>";
// echo "<td>" . $row['FirstName'] . "</td>";
// echo "</tr>";

// echo "<tr>";
// echo "<th>Lastname :</th>";
// echo "<td>" . $row['LastName'] . "</td>";
// echo "</tr>";

// echo "<tr>";
// echo "<th>Date of Birth :</th>";
// echo "<td>" . $row['DOB'] . "</td>";
// echo "</tr>";

// echo "<tr>";
// echo "<th>Gender :</th>";
// echo "<td>" . $row['Gender'] . "</td>";
// echo "</tr>";

// echo "<tr>";
// echo "<th>Citizen ID :</th>";
// echo "<td>" . $row['CitizenID'] . "</td>";
// echo "</tr>";

// echo "<tr>";
// echo "<th>Member Type :</th>";
// if(!empty($row3['StatusType']))
// {echo "<td>" . $row3['StatusType'] . "</td>";}
// else{echo "<td>" . "Admin" . "</td>";}
// echo "</tr>";

// echo "<tr>";
// echo "<th>Address :</th>";
// echo "<td>" . $row['Address'] . "</td>";
// echo "</tr>";

// echo "<tr>";
// echo "<th>Phone :</th>";
// echo "<td>" . $row['Phone'] . "</td>";
// echo "</tr>";

// echo "<tr>";
// echo "<th>Email :</th>";
// echo "<td>" . $row['Email'] . "</td>";
// echo "</tr>";

// echo "<tr>";
// echo "<th>Password :</th>";
// echo "<td>" . $row['Password'] . "</td>";
// echo "</tr>";

// echo "</table></center>";

// show member data 
}
else if($redirect==0)
{
header("Refresh: 0; url=http://localhost:8080/projectv2/member.php");
}

?>
<!-- Check username password -->

