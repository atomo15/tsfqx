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
        $moviename = $movie[$moviecount];
        $release[$releasedate] = $row['ReleaseDate'];
        $releasedate++;
        $moviecount++;  
        }
    }

  $sql = "SELECT BranchID FROM `branch`";

    $result = mysqli_query($con,$sql);

  if($result)
  {
    while($row = mysqli_fetch_array($result))
      {
        $branchnum = $row['BranchID'];
        $sql2 = "SELECT BranchName from branch where BranchID = '$branchnum'";
        $result2 = mysqli_query($con,$sql2);
        $row2 = mysqli_fetch_array($result2); 
      }
  }

    $sql = "SELECT MovieName,ReleaseDate FROM moviedata";
    $result = mysqli_query($con,$sql);
    $moviecount = 0;
    $releasedate = 0;
if($result)
  {
    while($row = mysqli_fetch_array($result))
      {
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
        $moviesys[$moviecount] = $row2['summary'];
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
		<link rel = "stylesheet" href = "style1.css">
		
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

<!-- Movie -->
<?php

  if(!empty($movie))
  {
    /*จัดการให้ชื่อเรื่องอยู่ในรูปแบบที่สามารถตั้งเป็นชื่อไฟล์ได้*/
    $movieup = str_replace(' ', '-', $movie[0]);
    $movieup = str_replace(':', '-', $movieup);
    /*จัดการให้ชื่อเรื่องอยู่ในรูปแบบที่สามารถตั้งเป็นชื่อไฟล์ได้*/

    /*เปลี่ยนรูปแบบวันที่เช้าฉายให้เป็นslash*/
    $releaseup = str_replace('-', '/', $release[0]);
    /*เปลี่ยนรูปแบบวันที่เช้าฉายให้เป็นslash*/


    $printmovie = '<div class="panels">
                <div class="panel">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <div class="background" style="background-image: url(movie-pics/'.$movieup.'.jpg);"></div>
                        <div class="text">
                            <div class="location">'.$moviesys[0].'</div>
                            <div class="title">'.$movie[0].'</div>
                            <div class="author">Release Date: '.$releaseup.'</div>
                           <form action="title.php" method="post">
                                <input type="hidden" name="moviename" value="'.$movie[0].'">
                                <button type="submit" class="btn btn-primary mr-3">Movie Detail</button>
                                </form>
                        </div>
                </div>';
 
    $j = 2;
    for($i = 1;$i<$moviecount;$i++)
    {
        /*จัดการให้ชื่อเรื่องอยู่ในรูปแบบที่สามารถตั้งเป็นชื่อไฟล์ได้*/
        $movieup = str_replace(' ', '-', $movie[$i]);
        $movieup = str_replace(':', '-', $movieup);
        /*จัดการให้ชื่อเรื่องอยู่ในรูปแบบที่สามารถตั้งเป็นชื่อไฟล์ได้*/

        /*เปลี่ยนรูปแบบวันที่เช้าฉายให้เป็นslash*/
        $releaseup = str_replace('-', '/', $release[$i]);
        /*เปลี่ยนรูปแบบวันที่เช้าฉายให้เป็นslash*/

        /*ชื่อที่สามารถตั้งเป็นชื่อในไฟล์รูปได้ เปิดcommentต่อเมื่อต้องการsaveรูปเรื่องใหม่*/
        //echo $movieup."<br>";
        /*ชื่อที่สามารถตั้งเป็นชื่อในไฟล์รูปได้ เปิดcommentต่อเมื่อต้องการsaveรูปเรื่องใหม่*/

        $printmovie =  $printmovie.'<div class="panel">
                    <div class="background" style="background-image: url(movie-pics/'.$movieup.'.jpg);"></div>
                        <div class="text">
                            <div class="location">'.$moviesys[$i].'</div>
                            <div class="title">'.$movie[$i].'</div>
                            <div class="author">Release Date: '.$releaseup.'</div>
                            <form action="title.php" method="post">
                            <input type="hidden" name="moviename" value="'.$movie[$i].'">
                            <button type="submit" class="btn btn-primary mr-3">Movie Detail</button>
                            </form>
                        </div>
                </div>';
        if($j%4==0)
        {
        $printmovie = $printmovie."</div>".'<br><br><br><br><br>
        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
        <br><br><br><br><br><br><br><br><br><br><br><br><br>
        <br><br><br><br>'.'<div class="panels">';   
        }
        //echo "<br>".$movie[$i]."<br>";
        $j++;
    }
    $printmovie = $printmovie."</div>";
    echo $printmovie;
  }

?>

    <script  src="index.js"></script>

</body>
</html>
