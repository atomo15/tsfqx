<?php
  session_start();
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
      $moviename = $movie[$moviecount];
      $release[$releasedate] = $row['ReleaseDate'];
      $sql1 = "SELECT MovieID FROM moviedata WHERE MovieName = '$moviename'";
      $result1 = mysqli_query($con,$sql1);
      $row1 = mysqli_fetch_array($result1);
      $movieid = $row1['MovieID'];
    $sql2 = "SELECT summary FROM movclasssys WHERE MovieID = '$movieid'";
      $result2 = mysqli_query($con,$sql2);
      $row2 = mysqli_fetch_array($result2);
      $moviesys[$moviecount] = $row2['summary'];;
      $releasedate++;
      $moviecount++;  
      }
    }
mysqli_close($con);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel = "stylesheet" href = "style.css">

  <title>Member</title>
</head>
<!-- login -->

<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {font-family: Arial, Helvetica, sans-serif;}
* {box-sizing: border-box;}

.form-inline {  
  display: flex;
  flex-flow: row wrap;
  align-items: center;
}

.form-inline label {
  margin: 5px 10px 5px 0;
}

.form-inline input {
  vertical-align: middle;
  margin: 5px 10px 5px 0;
  padding: 10px;
  background-color: #fff;
  border: 1px solid #ddd;
}

.form-inline button {
  padding: 10px 20px;
  background-color: dodgerblue;
  border: 1px solid #ddd;
  color: white;
  cursor: pointer;
}

.form-inline button:hover {
  background-color: royalblue;
}

@media (max-width: 800px) {
  .form-inline input {
    margin: 10px 0;
  }
  
  .form-inline {
    flex-direction: column;
    align-items: stretch;
  }
}
</style>
<style>
body {
    background-color: black;
  }
    table,th,td {
      border : 1px solid lightblue;
      border-collapse: collapse;
    }
    th,td {
      padding: 5px;
    }
  </style>
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
        <left><button type="submit" class = "button button1" id="ButtonShowtime"> SHOW TIME</button></left></form>
      </div>
    </div>
  </div>

<?php  

    $con = mysqli_connect("localhost","root","","movie");
    $result = mysqli_query($con,"SELECT * 
      FROM log_login WHERE RN =(SELECT max(RN) FROM log_login)")
        or die("Failed to query database ".mysqli_error($con));
    $row = mysqli_fetch_array($result);
    $status = $row['status'];
    $emaillog = $row['email'];
    //$status = 0;
  
  if(!empty($_POST['identify'])&&!empty($_POST['email']))
  {
    if($status==1){
    $emaillog = $_POST['email'];
    $sql="INSERT INTO log_login(email,status,typelogout)
            VALUES ('$emaillog', '0','MANUAL')";
    if(!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
    header("refresh: 0; url = http://localhost:8080/projectv2/member.php");}
  }
  
    
    if($status == 0)
      {  
    /* Prim's edit start*/
    echo'<div class = "container d-flex justify-content-center">
            <div class = "card" style = "width: 45%; margin-top: 10%;">
              <div class = "card-body d-flex justify-content-center">
                <form action="http://localhost:8080/projectv2/login_form.php" class = "mt-3"method="POST">
                        <h2 class = "text-center text-primary"> Welcome DooNangMaiJa! </h2>
                        <h2 class = "text-center text-primary"> Please sign in </h2> 
                        <div class = "form-group ">
                          <h5 class = "text-dark mt-5"><label for="Email">Email:</label></h4>
                          <input type="email" class="form-control" name="email" id="Email" aria-describedby="emailHelp" placeholder="Enter email"  required>
                        </div>
                        <div class = "form-group">
                          <h5 class = "text-dark mt-4"><label for="password">Password:</label></h4>
                           <input type="password" class="form-control" name="pswd" id="password" placeholder="Enter password"  required>
                        </div>
                        <div class = "form-check" style = "margin-left: -6%;">
                          <input type = "checkbox" class = "forn-check-input" id = "exampleCheck1">
                          <label class = "form-check-label" for = "exampleCheck1"> Remember me </label>
                        </div>
                        <div class = "text-right">
                          <button type="submit" class="btn btn-primary btn-lg mt-5 shadow-sm" style = "margin-right: 3%;"> login </button>
                        </div>
                </form>
            </div>
            <div class = "container mb-4">
            <a href = "register_form.php"><button type="submit" class="btn btn-primary btn-lg shadow-sm float-right" style = "margin-right: 12%;"> Register </button></a>
          </div>     
        </div>
        '
        ;
    /* Prim's edit end */
    }
  else
    {
      echo "&nbsp;";
      $con = mysqli_connect("localhost","root","","movie");

      $result = mysqli_query($con,"select * from member where Email = '$emaillog'")or die("Failed to query database ".mysqli_error($con));

      $row = mysqli_fetch_array($result);

    $memberid = $row['MemberType'];
    $sql = "select StatusType from memberstatus where MemberStatusID = '$memberid' ";
    $result2 = mysqli_query($con,$sql);
    $row2 = mysqli_fetch_array($result2);

    echo '  
          <div class = "container d-flex justify-content-center" style = "margin-top: 5%;">
            <div>
              <h1 class = "text-white text-center"> Welcome '.$row['FirstName'].'</h1>
              <table class = "mt-4">
                <tr>
                  <th><h5 class = "text-white"> Member ID : </h5></th>
                  <td><h6 class = "text-white">'.$row['MemberID'].'</h6></td>
                </tr>

                <tr>
                  <th><h5 class = "text-white"> Firstname : </h5></th>
                  <td><h6 class = "text-white">'.$row['FirstName'].'</h6></td>
                </tr>

                <tr>
                  <th><h5 class = "text-white"> Date of Birth : </h5></th>
                  <td><h6 class = "text-white">'.$row['DOB'].'</h6></td>
                </tr>

                <tr>
                  <th><h5 class = "text-white"> Gender : </h5></th>
                  <td><h6 class = "text-white">'.$row['Gender'].'</h6></td>
                </tr>

                <tr>
                  <th><h5 class = "text-white"> Citizen ID : </h5></th>
                  <td><h6 class = "text-white">'.$row['CitizenID'].'</h6></td>
                </tr>

                <tr>
                  <th><h5 class = "text-white"> Member Type : </h5></th>';
                  if(!empty($row2['StatusType'])){
                    echo '<td><h6 class = "text-white">'.$row2['StatusType'].'</h6></td>';
                        }
                  else{
                    echo '<td><h6 class = "text-white"> Admin </h6></td>
                        </tr>';}
                    echo '
                <tr>

                  <th><h5 class = "text-white"> Address : </h5></th>
                  <td><h6 class = "text-white">'.$row['Address'].'</h6></td>
                </tr>

                <tr>
                  <th><h5 class = "text-white"> Phone : </h5></th>
                  <td><h6 class = "text-white">'.$row['Phone'].'</h6></td>
                </tr>

                <tr>
                  <th><h5 class = "text-white"> Email : </h5></th>
                  <td><h6 class = "text-white">'.$row['Email'].'</h6></td>
                </tr>
              </table>

              <div class = "container ">
               <form action="member.php" method = "POST">
               <div class = "text-center mt-5">
                  
                  ';
                   echo '
                  <input type="hidden" name="identify" value="logout">
                  <input type="hidden" name="email" value="'.$row['Email'].'">
                  <button type="submit" class="btn btn-primary" >log out</button></form>';

                  if(empty($row2['StatusType'])){
                  echo '
                        <form action="adminpage.php" method="post">
                        <a href = "http://localhost/projectv2/adminpage.php">
                          <button type="submit" class="btn btn-primary mt-3"> 
                          Management
                          </button>
                        </a></form>
                        ';
                  }
               echo '
            </div>
           </div>
        </div>
          ';
        }
    mysqli_close($con);
?>

<script type="text/javascript">
  function logout_process(<?php $emaillog ?>) {
    <?php
      $con = mysqli_connect("localhost","root","","movie");
      $result = mysqli_query($con,"SELECT * 
            FROM log_login WHERE RN =(SELECT max(RN) FROM log_login)")
              or die("Failed to query database ".mysqli_error($con));
        $row = mysqli_fetch_array($result);

        $interval->i = 0;
        /*Compare time login to auto logout*/
        if($row['status'] == 1)
        {
        $datetimelog = $row['Time'];
        date_default_timezone_set("Asia/Bangkok");
         $datetimenow = date("Y-m-d H:i:s");
        /*echo $datetimelog;
        echo "<br>";
        echo $datetimenow;*/

        /*echo "<br>";
        echo "log out time:";
        echo "<br>";*/
        $datetime1 = date_create($datetimenow);
        $datetime2 = date_create($datetimelog);
        $interval = date_diff($datetime2,$datetime1);
        /*echo $interval->format('%R%a days');
        echo "<br>";
        echo "H : ".$interval->h . " M : ".$interval->i ." S : ".$interval->s;
        echo "<br>";*/
        /*Compare time login to auto logout*/

        /* insert status 0 for logout*/
        if($interval->i >= 2)
          {
            $sql = "select FirstName from member where Email = '$emaillog' and MemberType = 'ADMIN'";
            $result = mysqli_query($con,$sql);
            $row = mysqli_fetch_array($result);
            if(empty($row))
            {$sql="INSERT INTO log_login(email,status,typelogout)VALUES ('$emaillog', '0','AUTO')";
            if(!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}}
          }
        }
        /* insert status 0 for logout*/
        mysqli_close($con);
        //header("refresh: 30; url = http://localhost:81/project/member.php");
    ?>
}
</script>

<!-- login -->

</body>
</html>
