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
$selectmovie = $_POST['MovieName'];
$selectbranch =$_POST['Branchnum'];
$selecttheater = "T03";
session_start();
$_SESSION["selectmovie"] = $selectmovie;
$movieup = str_replace(' ', '-', $selectmovie);
        $movieup = str_replace(':', '-', $movieup);
//$selectbranchname = "b001";
    $showtimetheater = ""; 
    $sql = "SELECT BranchName FROM branch WHERE BranchID = '$selectbranch'";
    $result = mysqli_query($con,$sql);
    $row = mysqli_fetch_array($result);
    $selectbranchname = $row['BranchName'];

    $sql = "SELECT MovieID,MovieTypeID,MovieLenght,Rate FROM moviedata WHERE MovieName = '$selectmovie'";
    $result = mysqli_query($con,$sql);
    $row = mysqli_fetch_array($result);

    $movietype = $row['MovieTypeID'];
    $MovieLenght = $row['MovieLenght'];
    $movierate = $row['Rate'];
    $movieid = $row['MovieID'];

    $_SESSION['movieid'] = $movieid;

    $sql = "SELECT DISTINCT(TheaterID) FROM `theater` WHERE MovieID LIKE '$selectmovie' AND BranchID LIKE '$selectbranch'";
    $result = mysqli_query($con,$sql);

    $alltheater = "";
    while($row = mysqli_fetch_array($result))
    {
        $alltheater = $alltheater.$row['TheaterID'].':';
    }

    $selecttheater = explode(":", $alltheater);
    $count = count($selecttheater)-1;
    //echo $count;

    /*$sql = "SELECT summary FROM movclasssys WHERE MovieID = '$movieid'";
    $result = mysqli_query($con,$sql);
    $row = mysqli_fetch_array($result);
    $movsys = $row['summary'];*/


    for($i=0;$i<$count;$i++)
    {
    $subtheater = $selecttheater[$i];
    $sql = "SELECT Showtime FROM theater WHERE BranchID LIKE '$selectbranch' AND TheaterID LIKE '$subtheater' AND MovieID = '$selectmovie'";
    //echo $sql;
    $result = mysqli_query($con,$sql);

    $sql2 = "SELECT DISTINCT TheaterType FROM seatinfo WHERE BranchID = '$selectbranch' AND TheaterID = '$subtheater'";
    $result5 = mysqli_query($con,$sql2);
    $row5 = mysqli_fetch_array($result5);
    $movsys = $row5['TheaterType'];

    

    $allshowtime = "";
    date_default_timezone_set("Asia/Bangkok");
    $datetimenow = date("H:i");
    $hrnow = $datetimenow[0].$datetimenow[1];
    $minnow = $datetimenow[3].$datetimenow[4];

    $printtime = "";



        while($row=mysqli_fetch_array($result))
        {
        //echo "hello";
        $movieshow = $row['Showtime'];
        $sql3 = "SELECT Audio FROM theater WHERE BranchID = '$selectbranch' AND TheaterID = '$subtheater' AND MovieID = '$selectmovie' AND Audio != '*' AND Showtime = '$movieshow'";
        $result6 = mysqli_query($con,$sql3);
        $row6 = mysqli_fetch_array($result6);
        $audio = $row6['Audio'];   

        $movietime = explode(":",$row['Showtime']);
        $hrmovie = $movietime[0];
        $minmovie = $movietime[1];
        //echo $subtheater.$row['Showtime'].'<br>';

        if($hrnow<$hrmovie)
        {
            //echo $hrmovie.'<br>';
            $printtime = $printtime.'<form action="waitingpage.php" method="POST">';
                $printtime = $printtime.'<input type="hidden" name="showtime" value= "'.$row['Showtime'].'" >';
                $printtime = $printtime.'<input type="hidden" name="theater" value= "'.$subtheater.'" >';
                $printtime = $printtime.'<input type="hidden" name="Branchnum" value= "'.$selectbranch.'" >';
                $printtime = $printtime.'<input type="hidden" name="moviesys" value= "'.$movsys.'" >';
                $printtime = $printtime.'<button type="submit" class="btn btn-primary mr-3">'.$row['Showtime'].'</button>';
                $printtime = $printtime.'</form>';

        }
        else if($hrnow==$hrmovie)
        {
            if($minnow<$minmovie)
            {
                $printtime = $printtime.'<form action="waitingpage.php" method="POST">';
                $printtime = $printtime.'<input type="hidden" name="showtime" value= "'.$row['Showtime'].'" >';
                $printtime = $printtime.'<input type="hidden" name="theater" value= "'.$subtheater.'" >';
                $printtime = $printtime.'<input type="hidden" name="Branchnum" value= "'.$selectbranch.'" >';
                $printtime = $printtime.'<input type="hidden" name="moviesys" value= "'.$movsys.'" >';
                $printtime = $printtime.'<button type="submit" class="btn btn-primary mr-3">'.$row['Showtime'].'</button>';
                $printtime = $printtime.'</form>';
            }
            else
            {
                $printtime = $printtime.'<button type="button" class="btn btn-secondary mr-3">'.$row['Showtime'].'</button>';
            }
        }
        else
        {
               $printtime = $printtime.'<button type="button" class="btn btn-secondary mr-3">'.$row['Showtime'].'</button>';
        }
        }

        $sep = sscanf($subtheater,"%[A-Z]%d");
        //echo $subtheater;
        
        
        $showtimetheater = $showtimetheater.'<div class = "form-inline align-items-start">
                            <div class = "col-2">
                                <h2> Theater '.'</h2>
                                <br><h1 class="text-center"> '.$sep[1].' </h1>
                            </div>
                            <div class = "col-2 mt-2">
                                <img src="movie-pics/'.$movieup.'.jpg" style="width:150px; height:200px;">
                            </div>
                            <div class = "col-6 ml-4">
                                <h5>'.$selectmovie.'</h5>
                                        <p>'.$movietype.': '.$MovieLenght.' mins</p>
                                    <p>Rate: '.$movierate.'</p><p>System Type: '.$movsys.'</p><p>Audio: '.$audio.'</p>
                                <div class="form-inline">'.$printtime.'
                                </div>
                            </div>
                        </div>';
    }
    
    //echo $datetimenow;


mysqli_close($con);
?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel = "stylesheet" href = "style.css">
        <title> Doonung Home </title>
    </head>
<body style="background-color:#313133;">
     
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
    <!-- Select movie -->
    <div class = "container-fluid">
        <?php echo '<h1 class = "mt-4 text-white"> '.$selectbranchname.' </h1>';?>
        <div class = "card bg-light mt-3">
            <div class = "card-body">
                <div class = "row d-flex justify-content-center ">
                    <div class = "col-10 mt-3">
                        <?php echo $showtimetheater;?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
<html>