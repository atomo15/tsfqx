

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
    $BranchQuery = mysqli_query($con,"SELECT * FROM `branch`");

?>
<?php
    $con = mysqli_connect("localhost","root","","movie");
    session_start();

   

    if(!empty($_POST['moviesys']))
    {
        $_SESSION['moviesys'] = $_POST['moviesys'];
    }
    if(!empty($_POST['Branchnum'])){$Branch = $_POST['Branchnum'];}
    else{$Branch = $_SESSION["branch"];}
    // $_SESSION["branch"]=$Branch;

    if(!empty($_POST['theater'])){$Theater = $_POST['theater'];}
    else{$Theater = $_SESSION["theater"];}
     // $_SESSION["theater"] = $Theater;

    if(!empty($_POST['showtime'])){$showtimes = $_POST['showtime'];}
    else{$showtimes = $_SESSION["showtime"];}

    // $_SESSION["showtime"] = $showtimes;

    $movie = $_SESSION["selectmovie"];
    $printshowtimes = $_SESSION["showtime"];
    $moviesys = $_SESSION['moviesys'];

    $sql3 = "SELECT BranchName FROM branch WHERE BranchID='$Branch'";
    $result3 = mysqli_query($con,$sql3);
    $row3 = mysqli_fetch_array($result3);
    $printbranch = $row3['BranchName'];

    $showtime = $showtimes;
    $sql = "SELECT Distinct SeatRow FROM `seatinfo`where BranchID 
    like '$Branch' and TheaterID like '$Theater' and showtime like '$showtimes' ";

    $result = mysqli_query($con,$sql);

    $Rowcount = 0;

    //echo $sql;
    
    while($row = mysqli_fetch_array($result))
        {
        if($Rowcount==0)
            {
            $colrow = $row['SeatRow'];  
            $strow = $row['SeatRow'];   
            }
        else
            {
            $colrow = $colrow.$row['SeatRow'];  
            }
        $Rowcount++;
        }
    $lastrow = $colrow[$Rowcount-1];

    //echo "<br>"."Row: ".$Rowcount."<br>";
    //echo "<br>"."St Row: ".$strow."<br>";
    //echo "<br>"."last Row: ".$lastrow."<br>";

    $sql = "SELECT Distinct SeatNumber FROM `seatinfo`where BranchID 
    like '$Branch' and TheaterID like '$Theater' and showtime like '$showtimes'";

    $result = mysqli_query($con,$sql);

    $SeatNumcount = 0;

    while($row = mysqli_fetch_array($result))
        {
        $SeatNumcount++;
        }

    //echo "<br>"."Seat per Row: ".$SeatNumcount."<br>";

    $sql = "SELECT SeatStatus FROM `seatinfo`where BranchID 
    like '$Branch' and TheaterID like '$Theater' and showtime like '$showtimes'";
  
    $result = mysqli_query($con,$sql);

    $rowdetail = mysqli_fetch_array($result);

    if($rowdetail['SeatStatus'] == "available"){$status = 1;}
    else{$status = 0;}

    while($rowdetail = mysqli_fetch_array($result))
        {
            if($rowdetail['SeatStatus'] == "available")
                {
                $status = $status.'1';
                }
            else
                {
                $status = $status.'0';
                }
        }
    //echo $status;

    $numstatus = strlen($status);

    //echo "count status: ".$numstatus."<br>";

    $chnrow = 0;



?>

    <?php
            $printseat = "";
            for ($i=0; $i <$Rowcount; $i++) { 
                $row = chr($Rowcount-$i+65-1);
                $stroweach = $numstatus-$chnrow-$SeatNumcount;
                //echo $row.$stroweach."<br>";
                $rm = 1;
                $printseat = $printseat.'<div class="seatRow">';
                $printseat = $printseat.'<div class="seatRowNumber"> '.$row.' </div>';
                $sql = "SELECT Price FROM seatprice WHERE SeatType = (
                        SELECT SeatType FROM seatinfo WHERE BranchID = '$Branch' 
                                AND TheaterID = '$Theater' AND showtime = '$showtime'
                                AND SeatRow = '$row' AND SeatNumber = '$rm')
                        AND TheaterType = (SELECT TheaterType FROM seatinfo WHERE BranchID = '$Branch' 
                        AND TheaterID = '$Theater'AND showtime = '$showtime'
                                AND SeatRow = '$row' AND SeatNumber = '$rm')";
                $result = mysqli_query($con,$sql);
                $rowprice = mysqli_fetch_array($result);
                $price = $rowprice['Price'];                
            if($status[$stroweach]==0)
                {
                $printseat = $printseat.'<div id="'.$row.'_'.($i+1).'" title="" role="checkbox"'.'value="'.$price.'"'.'aria-checked="false" focusable="true" tabindex="-1" class=" seatNumber seatUnavailable"> 1 </div>';
                }
            else
                {
                $printseat = $printseat.'<div id="'.$row.'_1" title="" role="checkbox"'.'value="'.$price.'"'.' aria-checked="false" focusable="true" tabindex="-1" class=" seatNumber "> 1 </div>';
                }
            $lastroweach = $stroweach + $SeatNumcount -1;

            for ($j=0; $j <$SeatNumcount-1; $j++) { 
                $rm = $j+2;
                $sql = "SELECT Price FROM seatprice WHERE SeatType = (
                        SELECT SeatType FROM seatinfo WHERE BranchID = '$Branch' 
                                AND TheaterID = '$Theater' AND showtime = '$showtime'
                                AND SeatRow = '$row' AND SeatNumber = '$rm')
                        AND TheaterType = (SELECT TheaterType FROM seatinfo WHERE BranchID = '$Branch' 
                        AND TheaterID = '$Theater'AND showtime = '$showtime'
                                AND SeatRow = '$row' AND SeatNumber = '$rm')";

                $result = mysqli_query($con,$sql);
                $rowprice = mysqli_fetch_array($result);
                $price = $rowprice['Price'];  
                if($status[$lastroweach-$SeatNumcount+$j+2]==0)
                    {
                    $printseat = $printseat.'<div id="'.$row.'_'.($j+2).'" title="" role="checkbox"'.'value="'.$price.'" aria-checked="false" focusable="true" tabindex="-1" class=" seatNumber seatUnavailable">'.($j+2).' </div>';      
                    }
                else
                    {
                    $printseat = $printseat.'<div id="'.$row.'_'.($j+2).'" title="" role="checkbox"'.'value="'.$price.'" aria-checked="false" focusable="true" tabindex="-1" class=" seatNumber "> '.($j+2).' </div>';
                    }      
                }
            $chnrow = $chnrow + $SeatNumcount;
            $printseat = $printseat.'</div>';
        }
        $Branchs = $Branch;
        $theater = $Theater;

        $printseat = $printseat.'<input type="hidden" name="branch" value="'.$Branchs.'">';
        $printseat = $printseat.'<input type="hidden" name="showtime" value="'.$showtime.'">';
        $printseat = $printseat.'<input type="hidden" name="theater" value="'.$theater.'">';
        ?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel = "stylesheet" href = "style.css">
        <link rel = "stylesheet" href = "style1.css">
        <link rel = "stylesheet" href = "seat.css">
        <title> Doonung Home </title>
        </head>
    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
        <script src="https://unpkg.com/axios/dist/axios.min.js"></script>


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


    <br><br><br><br><br><br>
        <center>
        <h1><b><?php echo $movie;?></h1></b><br>
        <h2><b><?php echo $printbranch;?></b></h2>
        <h3><b>Theater <?php $subtheater = sscanf($Theater,"%[A-Z]%d");
        $Theaters = $subtheater[1];echo $Theaters; ?> </b></h3>
        <h3><b>System : <?php echo $moviesys;?> </b></h3>
        <h3><b>Showtime : <?php echo  $printshowtimes;?></b></h3>


        </center><br><br><br><br><br><br>
    

     <form action="waitingpage.php" method="post">
    <!-- seat reservation -->
    <div class="seatSelection col-lg-12">
        <center><p style = "font-size: 48px"> SCREEN </p></center>
        <center><div class="seatsChart col-lg-6">
            <?php echo $printseat;?>
        </div></center>

        <center>
         <div class="seatsReceipt col-lg-2">
            <p><strong>Selected Seats: <span class="seatsAmount" />0 </span></strong> <button id="btnClear" class="btn btn-primary mr-3">Clear</button></p>
            <ul id="seatsList" class="nav nav-stacked"></ul>
        </div></center>
        <input type="hidden" name="clearseat" value="ok">
    </div></form>

         <script  src="seat.js"></script>
<form action="action.php" method="post">
<center>
        <div class="checkout col-lg-offset-6">
            <!-- <span></span><span class="txtSubTotal"></span><br /> --><button id="btnCheckout" type="submit" name="btnCheckout" class="btn btn-primary mr-3" onclick="sendseat();"> Check out </button>        
        </div>
</center>
        <input type="hidden" name="branch" value="<?php $Branchs;?>">
        <input type="hidden" name="showtime" value="'.$showtime.'">
        <input type="hidden" name="theater" value="'.$theater.'">
       <input type="hidden" id="eiei" name= "atom" value="hello">
    </form>
</body>

<html>
