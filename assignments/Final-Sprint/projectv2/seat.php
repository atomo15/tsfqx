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
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel = "stylesheet" href = "style.css">
        <link rel = "stylesheet" href = "style1.css">
        <link rel = "stylesheet" href = "seat.css">
        <title> Doonung Home </title>
    </head>
<body>
    <!-- Navigation bar -->
    <nav>
            <ul class = "topnav">
                <li><a href = "homepage.php"> Home </a></li>
                <li><a href = "#Cinemas"> Cinemas </a></li>
                <li><a href = "#Movies"> Movies </a></li>
                <li><a href = "#Promotion"> Promotion </a></li>
                <li><a href = "#Log in / Sign up"> Log in / Sign up </a></li>
            </ul>
        </nav> 

    <br><br><br><br><br><br>
    <!-- seat reservation -->
    <div class="seatSelection col-lg-12">
        <center><p style = "font-size: 48px"> SCREEN </p></center>
        <div class="seatsChart col-lg-6">
            <div class="seatRow">
                <div class="seatRowNumber"> Row 1 </div>
                    <div id="1_1" title="" role="checkbox" value="45" aria-checked="false" focusable="true" tabindex="-1" class=" seatNumber seatUnavailable"> 1 </div>

                    <div id="1_2" role="checkbox" value="45" aria-checked="false" focusable="true" tabindex="-1" class=" seatNumber "> 2 </div>

                    <div id="1_3" role="checkbox" value="45" aria-checked="false" focusable="true" tabindex="-1" class=" seatNumber ">3</div>

                    <div id="1_4" role="checkbox" value="45" aria-checked="false" focusable="true" tabindex="-1" class=" seatNumber seatUnavailable">4</div>

                      <div id="1_5" role="checkbox" value="45" aria-checked="false" focusable="true" tabindex="-1" class=" seatNumber ">5</div>

                     <div id="1_6" role="checkbox" value="45" aria-checked="false" focusable="true" tabindex="-1" class=" seatNumber  ">6</div>

                     <div id="1_7" role="checkbox" value="45" aria-checked="false" focusable="true" tabindex="-1" class=" seatNumber ">7</div>

                     <div id="1_8" role="checkbox" value="45" aria-checked="false" focusable="true" tabindex="-1" class=" seatNumber ">8</div>

            </div>
            <div class="seatRow">
                <div class="seatRowNumber"> Row 2 </div>
                     <div id="2_1" role="checkbox" value="42" aria-checked="false" focusable="true" tabindex="-1" class=" seatNumber ">1</div>

                     <div id="2_2" role="checkbox" value="42" aria-checked="false" focusable="true" tabindex="-1" class=" seatNumber seatUnavailable">2</div>

                     <div id="2_3" role="checkbox" value="42" aria-checked="false" focusable="true" tabindex="-1" class=" seatNumber ">3</div>

                    <div id="2_4" role="checkbox" value="42" aria-checked="false" focusable="true" tabindex="-1" class=" seatNumber ">4</div>

                     <div id="2_5" role="checkbox" value="42" aria-checked="false" focusable="true" tabindex="-1" class=" seatNumber ">5</div>

                     <div id="2_6" role="checkbox" value="42" aria-checked="false" focusable="true" tabindex="-1" class=" seatNumber  ">6</div>

                    <div id="2_7" role="checkbox" value="42" aria-checked="false" focusable="true" tabindex="-1" class=" seatNumber ">7</div>

                    <div id="2_8" role="checkbox" value="42" aria-checked="false" focusable="true" tabindex="-1" class=" seatNumber seatUnavailable">8</div>

            </div>
            <div class="seatRow">
                <div class="seatRowNumber"> Row 3</div>
                    <div id="3_1" role="checkbox" value="38" aria-checked="false" focusable="true" tabindex="-1" class=" seatNumber seatUnavailable">1</div>
                    <div id="3_2" role="checkbox" value="38" aria-checked="false" focusable="true" tabindex="-1" class=" seatNumber ">2</div>
                    <div id="3_3" role="checkbox" value="38" aria-checked="false" focusable="true" tabindex="-1" class=" seatNumber seatUnavailable">3</div>
                    <div id="3_4" role="checkbox" value="38" aria-checked="false" focusable="true" tabindex="-1" class=" seatNumber ">4</div>
                    <div id="3_5" role="checkbox" value="38" aria-checked="false" focusable="true" tabindex="-1" class=" seatNumber seatUnavailable">5</div>
                    <div id="3_6" role="checkbox" value="38" aria-checked="false" focusable="true" tabindex="-1" class=" seatNumber  ">6</div>
                    <div id="3_7" role="checkbox" value="38" aria-checked="false" focusable="true" tabindex="-1" class=" seatNumber ">7</div>
                    <div id="3_8" role="checkbox" value="38" aria-checked="false" focusable="true" tabindex="-1" class=" seatNumber ">8</div>
            </div>
            <div class="seatRow">
                <div class="seatRowNumber"> Row 4 </div>
                    <div id="4_1" role="checkbox" value="30" aria-checked="false" focusable="true" tabindex="-1" class=" seatNumber ">1</div>
                    <div id="4_2" role="checkbox" value="30" aria-checked="false" focusable="true" tabindex="-1" class=" seatNumber ">2</div>
                    <div id="4_3" role="checkbox" value="30" aria-checked="false" focusable="true" tabindex="-1" class=" seatNumber ">3</div>
                     <div id="4_4" role="checkbox" value="30" aria-checked="false" focusable="true" tabindex="-1" class=" seatNumber ">4</div>
                    <div id="4_5" role="checkbox" value="30" aria-checked="false" focusable="true" tabindex="-1" class=" seatNumber ">5</div>
                     <div id="4_6" role="checkbox" value="30" aria-checked="false" focusable="true" tabindex="-1" class=" seatNumber seatUnavailable ">6</div>
                    <div id="4_7" role="checkbox" value="30" aria-checked="false" focusable="true" tabindex="-1" class=" seatNumber ">7</div>
                    <div id="4_8" role="checkbox" value="30" aria-checked="false" focusable="true" tabindex="-1" class=" seatNumber ">8</div>

                </div>
             <div class="seatRow">
                <div class="seatRowNumber"> Row 5 </div>
                    <div id="5_1" role="checkbox" value="28" aria-checked="false" focusable="true" tabindex="-1" class=" seatNumber seatUnavailable">1</div>
                    <div id="5_2" role="checkbox" value="28" aria-checked="false" focusable="true" tabindex="-1" class=" seatNumber ">2</div>
                    <div id="5_3" role="checkbox" value="28" aria-checked="false" focusable="true" tabindex="-1" class=" seatNumber ">3</div>
                    <div id="5_4" role="checkbox" value="28" aria-checked="false" focusable="true" tabindex="-1" class=" seatNumber seatUnavailable">4</div>
                    <div id="5_5" role="checkbox" value="28" aria-checked="false" focusable="true" tabindex="-1" class=" seatNumber ">5</div>
                    <div id="5_6" role="checkbox" value="28" aria-checked="false" focusable="true" tabindex="-1" class=" seatNumber seatUnavailable ">6</div>
                    <div id="5_7" role="checkbox" value="28" aria-checked="false" focusable="true" tabindex="-1" class=" seatNumber ">7</div>
                    <div id="5_8" role="checkbox" value="28" aria-checked="false" focusable="true" tabindex="-1" class=" seatNumber ">8</div>
            </div>
        </div>
         <div class="seatsReceipt col-lg-2">
            <p><strong>Selected Seats: <span class="seatsAmount" />0 </span></strong> <button id="btnClear" class="btn">Clear</button></p>
            <ul id="seatsList" class="nav nav-stacked"></ul>

        </div>
                    </div>

        <div class="checkout col-lg-offset-6">
            <span>Subtotal: CA$</span><span class="txtSubTotal">0.00</span><br /><button id="btnCheckout" name="btnCheckout" class="btn btn-primary"> Check out </button>
                       
        </div>
                </div>
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

    <script  src="seat.js"></script>
</body>
<html>