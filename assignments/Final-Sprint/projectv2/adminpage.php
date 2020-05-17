<?php

  $displaymenu = 1;

  if(!empty($_POST['ResetAllsession']))
  {
    session_start();
    session_unset();
  }
  $backbtn = '<center><a href = "adminpage.php">
          <button type="submit" class="btn btn-primary mr-3">BACK
          </button></a>
          </center>';
  $con = mysqli_connect("localhost","root","","movie");


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
  $cor = 0;
  $result = mysqli_query($con,"SELECT *FROM log_login WHERE RN =(SELECT max(RN) FROM log_login)")
                  or die("Failed to query database ".mysqli_error($con));
  $row = mysqli_fetch_array($result);
  if($row['status'] == 1){
  $email = $row['email'];
  $sql = "select FirstName from member where Email = '$email' and MemberType = 'ADMIN'";
  $result = mysqli_query($con,$sql);
  $row = mysqli_fetch_array($result);
  if(!empty($row)){$adminname =  "ADMIN : ".$row['FirstName'];$cor=1;}
  else{$adminname = 'INVALID ADMIN<br>"Please Try to login with ADMIN Account Agian."';}}
  else{$adminname = 'INVALID ADMIN<br>"Please Try to login with ADMIN Account Agian."';}
mysqli_close($con);
?>

<!-- MANAGE BRANCH -->
<?php
  /*BRANCH MENU*/
  if(!empty($_POST['managebranch']))
  {
    $displaymenu = 0;
    $addbranchbtn = ' <div class = "text-center mt-5">
                        <form action="adminpage.php" method = "POST">
                        <input type="hidden" name="addbranch" value="ok">
                        <button type="submit" class="btn btn-lg text-white" style="background-color: #33b5e5";>ADD BRANCH</button>
                        </form>
                      </div>';
    $editbranchbtn = '
                      <div class = "text-center mt-3">
                        <form action="adminpage.php" method = "POST">
                        <input type="hidden" name="editbranch" value="ok">
                        <button type="submit" class="btn btn-lg text-white" style="background-color: #33b5e5";>EDIT BRANCH</button>
                        </form>
                      </div>';

    $deletebranchbtn = '<div class = "text-center mt-3">
                          <form action="adminpage.php" method = "POST">
                          <input type="hidden" name="deletebranch" value="ok">
                          <button type="submit" class="btn btn-lg text-white" style="background-color: #33b5e5";>DELETE BRANCH</button>
                          </form>
                        </div>';
  }
  /*BRANCH MENU*/

  /*ADD BRANCH FORM*/
  if(!empty($_POST['addbranch']))
  {
    $displaymenu = 0;
    $addbranchform = '
          <div class="container">
          <div class="card mt-5">
          <div class="card-body">
            <form action="adminpage.php" method = "POST">
            <h3 class="text-dark font-weight-bold mb-4 ml-3">ADD BRANCH FORM</h3>

            <div class="form-group row">
              <label class="col-sm-2 col-form-label">BRANCH NAME: </label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" style="width:50%;" name="branchname" placeholder="eg. Siam paragon" required>
                </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 col-form-label">BRANCH ADDRESS : </label>
                  <div class="col-sm-10">
                    <textarea name="branchaddress" class="form-control" rows="10" cols="50" placeholder="bangkok" required></textarea>
                  </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 col-form-label">BRANCH PHONE : </label>
                  <div class="col-sm-10">
                    <input type="text" name= "branchphone" style="width:50%;" class="form-control" placeholder="02-999-9999" required>
                  </div>
            </div>

            <input type="hidden" name="confirmaddbranch" value="ok">
            <center><button type="submit" class="btn text-white mt-5" style = "background-color: #33b5e5";>ADD BRANCH</button></center>
            </form>
          </div>
          </div>

          <center>
          <a href = "adminpage.php"><button type="submit" class="btn btn-lg btn-outline-primary mt-3">Cancel
          </button></a>
          </center>
         
        </div>';
  }
  if(!empty($_POST['confirmaddbranch']))
  {
    $displaymenu = 0;
    if(!empty($_POST['branchname'])&&!empty($_POST['branchaddress'])&&!empty($_POST['branchphone'])){
    $branchname = $_POST['branchname'];
    $branchaddress = $_POST['branchaddress'];
    $branchphone = $_POST['branchphone'];
    $confirmaddbranch = '
          <div class="container">
          <div class="card mt-5">
          <div class="card-body text-center">
            <form action="adminpage.php" method = "POST">
            <h3 class="text-center text-dark font-weight-bold mb-4">ADD BRANCH FORM</h3>
            <label><h5>BRANCH NAME :</h5></label> '.$branchname.' 
            <input type="hidden" name="branchname" value= "'.$branchname.'" >
            <br>
            <label><h5>BRANCH ADDRESS :</h5></label>
            <input type="hidden" name= "branchaddress" value="'.$branchaddress.'">
            '.$branchaddress.'
            <br>
            <label><h5>BRANCH PHONE :</h5></label>
            '.$branchphone.'
            <input type="hidden" name= "branchphone" value="'.$branchphone.'"">
            <input type="hidden" name="insertbranch" value="ok"><br>

            <br><center><button type="submit" class="btn text-white mt-5" style = "background-color: #33b5e5";>Confirm</button></center></form>
            </div>
            </div>

            <center><a href = "adminpage.php"><button type="submit" class="btn btn-lg btn-outline-primary mt-3">Cancel</button></a>
            </center>
          </div>';
        }
  }
  if(!empty($_POST['insertbranch']))
  {
    $displaymenu = 0;
    $resultadd = "ADD FAIL!!";
    if(!empty($_POST['branchname'])&&!empty($_POST['branchaddress'])&&!empty($_POST['branchphone'])){
    $branchname = $_POST['branchname'];
    $branchaddress = $_POST['branchaddress'];
    $branchphone = $_POST['branchphone'];
    $con = mysqli_connect("localhost","root","","movie");
    $sql = "SELECT MAX(RN) as MAXRN FROM branch";
    $result = mysqli_query($con,$sql);
    $row = mysqli_fetch_array($result);
    $newbranchnum = $row['MAXRN']+1;
    if($newbranchnum<10){$newbranchnum = "B00".$newbranchnum;}
      else if($newbranchnum<100){$newbranchnum = "B0".$newbranchnum;}
      else{$newbranchnum = "B".$newbranchnum;}
    $sql = "INSERT INTO branch(BranchID, BranchName, Address, PhoneNumber) VALUES 
    ('$newbranchnum','$branchname','$branchaddress','$branchphone')";
    
    if (mysqli_query($con,$sql)) {$resultadd = 
      "<center><h3 class='text-white'>New Branch $branchname created successfully</h3></center>"
      .'
      <center><a href = "adminpage.php"><button type="submit" class="btn btn-lg btn-primary mt-3">BACK</button></a>
      </center></div></div>';} 
    else {echo "Error: " . $sql . "<br>" . mysqli_error($con);}
    
    mysqli_close($con);
    }
  }
  /*ADD BRANCH FORM*/

/*EDIT BRANCH FORM*/

  /*Find ALL BRANCH TO EDIT*/
  if(!empty($_POST['editbranch']))
  {
      $displaymenu = 0;
      $con = mysqli_connect("localhost","root","","movie");
      $sql = "SELECT * from branch";
      $result = mysqli_query($con,$sql);
      $selecteditbranch = '
      <div class="container">
      <div class="card mt-5">
      <div class="card-body text-center">
        <form action="adminpage.php" method = "POST">
        <h3 class="text-center text-dark font-weight-bold mb-4">EDIT BRANCH FORM</h3><br>
        <select name="branchnum" required><option value = "">--Please choose a Branch--</option>';
      while($row = mysqli_fetch_array($result))
      {
        $branchnum = $row['BranchID'];
        $selecteditbranch = $selecteditbranch.'<option value="'.$branchnum.'">'.$row['BranchName']."</option>";
      }
      $selecteditbranch = $selecteditbranch.'</select><br>
      <input type="hidden" name="steditbranch" value="ok">
      <br><center><button type="submit" class="btn text-white mt-3" style = "background-color: #33b5e5";>Confirm</button></form></center>
      </div>
      </div>
     <center><a href = "adminpage.php"><button type="submit" class="btn btn-lg btn-outline-primary mt-3">Cancel</button></a>
     </center>
      </div>';
      mysqli_close($con);
  } 
  /*Find ALL BRANCH TO EDIT*/

  /*START EDIT BRANCH*/
  if(!empty($_POST['steditbranch']))
  {
    $displaymenu = 0;
    if(!empty($_POST['branchnum'])){
    $branchnum = $_POST['branchnum'];
    $con = mysqli_connect("localhost","root","","movie");
    $sql = "SELECT * from branch where BranchID = '$branchnum'";
    $result = mysqli_query($con,$sql);
    $row = mysqli_fetch_array($result);
    if(!empty($row))
    {
      $branchname = $row['BranchName'];
      $branchaddress = $row['Address'];
      $branchphone = $row['PhoneNumber'];

      $editmenu = '
          <div class="container">
          <div class="card mt-5">
          <div class="card-body">

            <form action="adminpage.php" method = "POST">
            <h3 class="text-center text-dark font-weight-bold mb-4">EDIT BRANCH FORM</h3>
            <label><h5>BRANCH NAME :</h5></label>
            <input type="text" name="branchnameup" value= "'.$branchname.'" >

            <br>
            <label><h5>BRANCH ADDRESS :</h5></label>
            <textarea name="branchaddressup" rows="10" cols="50" >'.$branchaddress.'</textarea>

            <br>
            <label><h5>BRANCH PHONE :</h5></label>
            <input type="text" name= "branchphoneup" value="'.$branchphone.'"><br><br>

            <input type="hidden" name="updatebranch" value="ok"><br>
            <input type="hidden" name="branchid" value="'.$branchnum.'">
            <br><center><button type="submit" class="btn text-white mt-5" style = "background-color: #33b5e5";>Confirm</button></center></form>
            </div>
            </div>
            <center><a href = "adminpage.php"><button type="submit" class="btn btn-lg btn-outline-primary mt-3">Cancel</button></a></center>
          </div>';
    }
    
    }
  }
  /*START EDIT BRANCH*/

  /*EDIT BRANCH PROCESS*/
  $checkbranchup = 0;
  $resultupbranch = "UPDATE ERROR";
  if(!empty($_POST['updatebranch']))
  {
    $displaymenu = 0; 
    $con = mysqli_connect("localhost","root","","movie");
    if(!empty($_POST['branchnameup'])&&!empty($_POST['branchaddressup'])&&!empty($_POST['branchphoneup'])
      &&!empty($_POST['branchid'])){
    $branchnameup = $_POST['branchnameup'];
    $branchaddressup = $_POST['branchaddressup'];
    $branchphoneup = $_POST['branchphoneup'];
    $branchid = $_POST['branchid'];

    $sql = "UPDATE branch SET BranchName = '$branchnameup'
    ,Address = '$branchaddressup', PhoneNumber = '$branchphoneup'
      WHERE BranchID = '$branchid'";
    mysqli_autocommit($con,$sql);
    if (mysqli_query($con, $sql)) {$checkbranchup = 1;} 
    else {echo "Error updating record: " . mysqli_error($con);}}
    if($checkbranchup==1){
      $sql = "SELECT * from branch where BranchID = '$branchid'";
      $result = mysqli_query($con,$sql);
      $row = mysqli_fetch_array($result);
      if(!empty($row))
      {
      $branchname = $row['BranchName'];
      $branchaddress = $row['Address'];
      $branchphone = $row['PhoneNumber'];
      $resultupbranch = '
          <div class="container">
          <div class="card mt-5">
          <div class="card-body">
            <h3 class="text-center text-dark font-weight-bold mb-4"EDIT BRANCH FORM</h3><br>
            <label><h5>BRANCH NAME : </h5></label>'.$branchname.'<br>
            <label><h5>BRANCH ADDRESS : </h5></label>'.$branchaddress.'<br>
            <label><h5>BRANCH PHONE :</h5></label>'.$branchphone.'<br>
            <a href = "adminpage.php"><button type="submit" class="btn btn-lg btn-primary mt-4">BACK</button></a>
          </div></div>';
      }

    }
  }
  /*EDIT BRANCH PROCESS*/

/*EDIT BRANCH FORM*/

  /*DELETE BRANCH*/

  /*SELECT BRANCH TO DELETE*/
  if(!empty($_POST['deletebranch']))
  {
    $displaymenu = 0;
      $con = mysqli_connect("localhost","root","","movie");
      $sql = "SELECT * from branch";
      $result = mysqli_query($con,$sql);
      $selectdelbranch = '
      <div class="container">
      <div class="card mt-5">
      <div class="card-body text-center">

        <h3 class="text-center text-dark font-weight-bold mb-4">DELETE BRANCH FORM</h3>
        <form action="adminpage.php" method = "POST">
        <select name="branchnum" required><option value = "">--Please choose a Branch--</option>';
        while($row = mysqli_fetch_array($result))
        {
          $branchnum = $row['BranchID'];
          $selectdelbranch = $selectdelbranch.'<option value="'.$branchnum.'">'.$row['BranchName']."</option>";
        }
        $selectdelbranch = $selectdelbranch.'</select><br>
        <input type="hidden" name="condelbranch" value="ok">
        <br><center><button type="submit" class="btn text-white mt-5" style = "background-color: #33b5e5";>Confirm</button></center></form>
        </div>
        </div>
        <center><a href = "adminpage.php"><button type="submit" class="btn btn-lg btn-outline-primary mt-3">Cancel</button></a>
            </center>
        </div>';
      mysqli_close($con);
  }
  /*SELECT BRANCH TO DELETE*/

  /*DELETE BRANCH PROCESS*/
  if(!empty($_POST['condelbranch']))
  {
    $con = mysqli_connect("localhost","root","","movie");
    $displaymenu = 0;
    $resultdel = "DELETE FALL";
    if(!empty($_POST['branchnum']))
    {
      $branchnum = $_POST['branchnum'];
      $sql = "SELECT * from branch where BranchID = '$branchnum'";
      $result = mysqli_query($con,$sql);
      $row = mysqli_fetch_array($result);
      if(!empty($row)){$branchname = $row['BranchName'];}
      $sql = "DELETE FROM branch WHERE BranchID = '$branchnum'";
      if (mysqli_query($con,$sql)) {
      $sql = "DELETE FROM theater WHERE BranchID = '$branchnum'";
      if (mysqli_query($con,$sql)){
         $sql = "DELETE FROM seatinfo WHERE BranchID = '$branchnum'";
         mysqli_query($con,$sql);
      $resultdel = '<h2 class="text-white text-center mt-5">DELETE Branch: '.$branchname.' successfully</h2>
      '.'<br>
      <center><a href = "adminpage.php"><button type="submit" class="btn btn-lg btn-primary mt-3">BACK</button></a>
      </center>';} 
        else {echo "Error: " . $sql . "<br>" . mysqli_error($con);}}
      else {echo "Error: " . $sql . "<br>" . mysqli_error($con);}
    }
    mysqli_close($con);

  }
  /*DELETE BRANCH PROCESS*/

  /*DELETE BRANCH*/
?>
<!-- MANAGE BRANCH -->

<!-- MANAGE MOVIE-->
<?php
    $moviemenu = "moviemenu";

    /*MOVIE MENU*/
    if(!empty($_POST['managemovie']))
    {
    $displaymenu = 0; 
    $addnewmoviebtn = '
          <div class="text-center mt-5">
            <form action="adminpage.php" method = "POST">
            <input type="hidden" name="addmovie" value="ok">
            <button type="submit" class="btn btn-lg text-white" style="background-color: #33b5e5";>ADD NEW MOVIE</button>
            </form>
          </div>';
    $addmovieshowtimebtn = '
          <div class="text-center mt-3">
            <form action="adminpage.php" method = "POST">
            <input type="hidden" name="addmovieshowtime" value="ok">
            <button type="submit" class="btn btn-lg text-white" style="background-color: #33b5e5";>ADD MOVIE SHOWTIME</button>
            </form>
          </div>';
    $editmoviebtn = '
          <div class="text-center mt-3">
            <form action="adminpage.php" method = "POST">
            <input type="hidden" name="editmovie" value="ok">
            <button type="submit" class="btn btn-lg text-white" style="background-color: #33b5e5";>EDIT MOVIE</button>
            </form>
          </div>';
    $deletemoviebtn = '
          <div class="text-center mt-3">
            <form action="adminpage.php" method = "POST">
            <input type="hidden" name="selectdelmovie" value="ok">
            <button type="submit" class="btn btn-lg text-white" style="background-color: #33b5e5";>DELETE MOVIE</button>
            </form>
          </div>
          ';
    $resetallmovieshowtime = '
          <div class="text-center mt-3">
            <form action="adminpage.php" method = "POST">
            <input type="hidden" name="resetallmovieshowtime" value="ok">
            <button type="submit" class="btn btn-lg btn-danger text-white";>RESET ALL MOVIE SHOWTIME</button>
            </form>
          </div>
          '; 
    }
    /*MOVIE MENU*/

    /*ADD NEW MOVIE FORM*/
    if(!empty($_POST['addmovie']))
    {
      $displaymenu = 0;

      $con = mysqli_connect("localhost","root","","movie");
      $sql = "SELECT MovieTypeName FROM movietype";
      $result = mysqli_query($con,$sql); 
      $optiontype = "";
      while($row = mysqli_fetch_array($result)){$type = $row['MovieTypeName'];
      $optiontype = $optiontype.'<label><input type="checkbox" name="movietype[]" value="'.$type.'">'.$type."<br>";}

      $sql = "SELECT DISTINCT TheaterType  FROM seatprice";
      $result = mysqli_query($con,$sql); 
      $optionsystype = "<label>";
      while($row = mysqli_fetch_array($result)){$systype = $row['TheaterType'];
      $optionsystype = $optionsystype.'<input type="checkbox" name="systemtypes[]" value="'.$systype.'">'.$systype."<br>";}
      $optionsystype = $optionsystype."</label>";

      $addmovieform = '
          <div class="container">
          <div class="card mt-5">
          <div class="card-body">
            <form action="adminpage.php" method = "POST">
            <div class="form-group row">
              <label class="col-sm-2 col-form-label"> Movie name: </label>
              <div class="col-sm-10">
                <input type="text" name="moviename" required>
              </div>
            </div>

            <div class="form-group row">
             <label class="col-sm-2 col-form-label"> Movie Type: </label>
            '.$optiontype.'<br>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Movie Detail :</label>
              <div class="col-sm-10">
                <textarea name="MovieDetail" rows="10" cols="50" required></textarea>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Movie Lenght : </label>
              <div class="col-sm-10">
                <input type = "number" name = "MovieLenght" required> mins
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Main Actor : </label>
              <div class="col-sm-10">
                <textarea name="MainActor" rows="10" cols="50" required></textarea>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Rate :</label>
              <div class="col-sm-10">
                <input type = "radio" name = "Rate" value = " All adults and age" checked> All adults and age <br>
                <input type = "radio" name = "Rate" value = "13+"> 13+<br>
                <input type = "radio" name = "Rate" value = "15+"> 15+<br>
                <input type = "radio" name = "Rate" value = "18+"> 18+<br>
                <input type = "radio" name = "Rate" value = "20+"> 20+<br>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Release Date :</label>
              <div class="col-sm-10">
                <input id="ReleaseDate" type = "date" name = "ReleaseDate" required>
              </div>
            </div>


            <div class="form-group row">
              <label class="col-sm-2 col-form-label">End Date :</label>
              <div class="col-sm-10">
                <input type = "date" name = "EndDate" >
              </div>
            </div>  

            <div class="form-group row">
              <label class="col-sm-2 col-form-label"> System Type: </label>
              <div class="col-sm-10">
               '.$optionsystype.'
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Link Trailer : </label>
              <div class="col-sm-10">
                <input type = "text" name ="Trailer">
              </div>
            </div>

            <input type="hidden" name="insertnewmovie" value="ok">
            <center><button type="submit" class="btn btn-primary mr-3">ADD NEW MOVIE</button></center>
            </form>
            </div></div>
            <center>
            <a href = "adminpage.php"><button type="submit" class="btn btn-lg btn-outline-primary mt-3">Cancel
          </button></a>
            </center>
            </div>';
          mysqli_close($con);
    }
    /*ADD NEW MOVIE FORM*/

    /*ADD NEW MOVIE PROCESS*/
    if(!empty($_POST['insertnewmovie']))
    {
        $displaymenu = 0;
        $con = mysqli_connect("localhost","root","","movie");


/*ADD MOVIE SYSTEM */
        $action = 0;
        $animation = 0;
        $adventure = 0;
        $comedy = 0;
        $crime = 0;
        $drama = 0;
        $fantasy = 0;
        $horror = 0;
        $mystery = 0;
        $scifi = 0;
        $romance = 0;
        $thriller = 0;

        $sql = "SELECT MovieID FROM movclasstype WHERE RN = (SELECT max(RN) FROM movclasstype)";

        $result = mysqli_query($con,$sql);

        $row = mysqli_fetch_array($result);

        $movieidor = $row['MovieID'];

        $sep = sscanf($movieidor, "%[A-Z]%d");

        if(($sep[1]+1)<10){$movieid = "MOV00".($sep[1]+1);}
        else if(($sep[1]+1)<100){$movieid = "MOV0".($sep[1]+1);}
        else{$movieid = "MOV".($sep[1]+1);}

        $systemtypes = $_POST['systemtypes'];

          $countsystype = count($systemtypes);
          //echo 'countsystype: '.$countsystype.'<br>';
          $systemtype = "";

          for($k=0;$k<$countsystype;$k++)
          {
            //echo $systemtypes[$k].'<br>';
            $systemtype = $systemtype.$systemtypes[$k].':';
          }

        //echo $systemtype.'<br><br>';
        $sql = "SHOW COLUMNS FROM movclasssys";
        $result = mysqli_query($con,$sql);
        $countrow = 0;
        $countfield = 0;
        $Field = "";
        while($row = mysqli_fetch_array($result))
          {
            if($countrow>=3)
            {
              // echo $row['Field'].'<br>';
              $Field = $Field.$row['Field'].':';
              $countfield++;
            }
              $countrow++;
          }
       // echo $systemtype."<br>".$Field.'<br>';
        $sepsys = explode(':',$systemtype);
        $sepField = explode(':', $Field);
          //$countrow = $countrow-2;
          $countloop = 0;
          $loc ="";
          $sql = "INSERT INTO movclasssys (MovieID,summary,";
          $movsys = "";
          //echo $countsystype.'<br>'.$countfield;
          for($i=0;$i<$countsystype;$i++)
          {
            for($j=0;$j<$countfield;$j++)
            {
              //echo "sepsys: ".$sepsys[2]."<br>";
              if(!strcasecmp($sepField[$j],$sepsys[$i]))
              {
            
                $loc = $loc.$i.':';
                $countloop++;
              }//echo "sepField: ".$sepField[4]."<br>"."<br>";
              
            } 
          }
          //echo "countloop= ".$countloop.'<br>';
          $seploc = explode(':', $loc);
          for($l=0;$l<$countloop;$l++)
          {
            if($l==0)
            {
              $sql = $sql.$sepsys[$seploc[$l]];
              $movsys = $movsys.$sepsys[$seploc[$l]];
            }
            else
            {
              $sql = $sql.','.$sepsys[$seploc[$l]];
              $movsys = $movsys.','.$sepsys[$seploc[$l]];
            }
          }
          //echo $movsys;
          $sql = $sql.') VALUES ('."'$movieid','$movsys',";

          for($l=0;$l<$countloop;$l++)
          {
            if($l==0)
            {
              $sql = $sql.'1';
            }
            else
            {
              $sql = $sql.','.'1';
            }
          }
          $sql = $sql.')';
          //echo $sql;
          $result = mysqli_query($con,$sql);
/*ADD MOVIE SYSTEM */

/*ADD MOVIE TYPE*/
        if(!empty($_POST['movietype']))
        {
          $movietype = $_POST['movietype'];
          $check_count = count($movietype);
        
          for($i=0;$i<$check_count;$i++)
          {
            //echo $movietype[$i]."<br>";
            if($movietype[$i] == "Action"){$action = 1;}
            if($movietype[$i] == "Adventure"){$adventure = 1;}
            if($movietype[$i] == "Animation"){$animation = 1;}
            if($movietype[$i] == "Comedy"){$comedy = 1;}
            if($movietype[$i] == "Crime"){$crime = 1;}
            if($movietype[$i] == "Drama"){$drama = 1;}
            if($movietype[$i] == "Fantasy"){$fantasy = 1;}
            if($movietype[$i] == "Horror"){$horror = 1;}
            if($movietype[$i] == "Mystery"){$mystery = 1;}
            if($movietype[$i] == "Sci-fi"){$scifi = 1;}
            if($movietype[$i] == "Romance"){$romance = 1;}
            if($movietype[$i] == "Thriller"){$thriller = 1;}
          }
          //echo "<br>";
          $summary = $action.':'.$adventure.':'.$animation.':'.$comedy.':'.$crime.':'.$drama.':'.$fantasy.':'.$horror.':'.$mystery.':'.$scifi.':'.$romance.':'.$thriller;
          //echo $summary;
          //echo "<br>";

          $sql = "INSERT INTO movclasstype (`MovieID`, `summary`, `Action`, `Adventure`, `Animation`,`Comedy`, `Crime`, `Drama`, `Fantasy`, `Horror`, `Mystery`, `Romance`, `Sci-fi`, `Thriller`) 
                  VALUES ('$movieid','$summary','$action','$adventure','$animation','$comedy','$crime','$drama','$fantasy','$horror','$mystery','$scifi','$romance','$thriller')";
          //echo $sql;
              if (!mysqli_query($con,$sql))
              {
              die('Error: ' . mysqli_error($con));
              }
        }
/*ADD MOVIE TYPE*/

/*ADD MOVIE DETAIL*/
        $moviename    = $_POST['moviename'];
        $moviedetail  = $_POST['MovieDetail'];
        $movielength  = $_POST['MovieLenght'];
        $mainactor    = $_POST['MainActor'];
        $movierate    = $_POST['Rate'];
        $movierelease = $_POST['ReleaseDate'];
        $movieend   = $_POST['EndDate'];

        /*จัดการให้ชื่อเรื่องอยู่ในรูปแบบที่สามารถตั้งเป็นชื่อไฟล์ได้*/
        $movieup = str_replace(' ', '-', $moviename);
        $movieup = str_replace(':', '-', $movieup);
        /*จัดการให้ชื่อเรื่องอยู่ในรูปแบบที่สามารถตั้งเป็นชื่อไฟล์ได้*/

        /*ชื่อที่สามารถตั้งเป็นชื่อในไฟล์รูปได้ เปิดcommentต่อเมื่อต้องการsaveรูปเรื่องใหม่*/
        $resultaddnewmovie = '<br><center><h2 class="text-white mt-5"><b>PLEASE INSERT POSTER WITH BELOW NAME FILE</b></h2></center>
        <br><center><h2 class="text-white mt-5"><b>'.$movieup.'.jpg'."</b></h2></center><br>";
        /*ชื่อที่สามารถตั้งเป็นชื่อในไฟล์รูปได้ เปิดcommentต่อเมื่อต้องการsaveรูปเรื่องใหม่*/

        if($movielength%60==0){$delayshowtime = ($movielength/60)+1;}
        else if($movielength%60>=40){$delayshowtime = ceil($movielength/60)+1;}
        else {$delayshowtime = ceil($movielength/60);}
        //echo "delay = ".$delayshowtime;

        $summary2 = explode(':',$summary);

        // echo $movieidor.'<br>';

        // echo $row['summary'].'<br>';

        $type = array(array("Action"),array("Adventure"),array("Animation"),array("Comedy")
            ,array("Crime"),array("Drama"),array("Fantasy"),array("Horror"),array("Mystery")
            ,array("Sci-fi"),array("Romance"),array("Thriller"));

        $typemov = "";
        $count = 0;
        $coltype = "";

        for($i=0;$i<12;$i++)
        {
          if($summary2[$i]==1)
          {
            //$typemov = $typemov.$type[$i][0];
            $coltype = $coltype.$i.":";
            $count++;
          }
        }
        //echo $coltype."<br>".$count."<br>";

        $sep = explode(":",$coltype);

        $alltype = "";
        for($j=0;$j<$count;$j++)
        {
          $septype = $sep[$j];
          if($j<($count-1))
          {
            $alltype = $alltype.$type[$septype][0].",";
          }
          else
          {
            $alltype = $alltype.$type[$septype][0];
          }    
        }
        $sql = "INSERT INTO moviedata(MovieID,Version,MovieName,MovieTypeID
        ,MovieDetail,MovieLenght,MainActor,Rate,ReleaseDate,EndDate,delayshowtime,Trailer)
        VALUES ('$movieid',1,'$moviename','$alltype','$moviedetail','$movielength','$mainactor'
        ,'$movierate','$movierelease','$movieend','$delayshowtime','$Trailer')";
        //echo $sql;
          if (!mysqli_query($con,$sql))
              {
              die('Error: ' . mysqli_error($con));
              }
/*ADD MOVIE DETAIL*/
    }
    /*ADD NEW MOVIE PROCESS*/

    /*EDIT MOVIE HOME*/
    if(!empty($_POST['editmovie']))
    {
      $displaymenu = 0;
      $con = mysqli_connect("localhost","root","","movie");
      $sql = "SELECT * from moviedata";
      $result = mysqli_query($con,$sql);
      $selecteditmovie = '
      <div class="container">
      <div class="card mt-5">
      <div class="card-body text-center">
        <h3 class="text-center text-dark font-weight-bold mb-4">EDIT MOVIE FORM</h3>
        <form action="adminpage.php" method = "POST">
        <select name="movieid" required><option value = "">--Please choose a movie--</option>';
        while($row = mysqli_fetch_array($result))
        {
          $movieid = $row['MovieID'];
          $selecteditmovie = $selecteditmovie.'<option value="'.$movieid .'">'.$row['MovieName']."</option>";
        }
        $selecteditmovie = $selecteditmovie.'
        </select><br>
        <input type="hidden" name="editmovieform" value="ok">
        <br><center><button type="submit" class="btn text-white mt-3" style = "background-color: #33b5e5";>Confirm</button></center></form>
        </div>
        </div>
        <center><a href = "adminpage.php"><button type="submit" class="btn btn-lg btn-outline-primary mt-3">Cancel</button></a></center>
        </div>';
      mysqli_close($con);
    }
    /*EDIT MOVIE HOME*/

    /*EDIT MOVIE FORM*/
    if(!empty($_POST['editmovieform']))
    {
      $displaymenu = 0;
      $con = mysqli_connect("localhost","root","","movie");

      $movieid = $_POST['movieid'];
      $sql = "SELECT * FROM moviedata WHERE MovieID = '$movieid'";
      $result = mysqli_query($con,$sql);
      $row = mysqli_fetch_array($result);
      $moviename = $row['MovieName'];
      $moviedetail = $row['MovieDetail'];
      $movielength = $row['MovieLenght'];
      $mainactor = $row['MainActor'];
      $releasedate = $row['ReleaseDate'];


      $sql = "SELECT MovieTypeName FROM movietype";
      $result = mysqli_query($con,$sql); 
      $optiontype = "";
      while($row = mysqli_fetch_array($result)){$type = $row['MovieTypeName'];
      $optiontype = $optiontype.'<label><input type="checkbox" name="movietype[]" value="'.$type.'">'.$type."<br>";}

      $sql = "SELECT DISTINCT TheaterType  FROM seatprice";
      $result = mysqli_query($con,$sql); 
      $optionsystype = "<label>";
      while($row = mysqli_fetch_array($result)){$systype = $row['TheaterType'];
      $optionsystype = $optionsystype.'<input type="checkbox" name="systemtypes[]" value="'.$systype.'">'.$systype."<br>";}
      $optionsystype = $optionsystype."</label>";

      $moviename = str_replace(' ', '&nbsp;', $moviename);
      $moviedetail = str_replace(' ', '&nbsp;', $moviedetail);
      $mainactor = str_replace(' ', '&nbsp;', $mainactor);

      $editmovieform = '
          <div class="container">
          <div class="card mt-5">
          <div class="card-body text-center">
            <form action="adminpage.php" method = "POST">
            <h3 class="text-center text-dark font-weight-bold mb-4">EDIT MOVIE FORM</h3>

            <div class="form-group row">
              <label class="col-sm-2 col-form-label"> Movie name:</label>
                <div class="col-sm-10 col-form-label text-left">
                '.$moviename.'
                </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 col-form-label"> Movie Type: </label>
               <div class="col-sm-10 text-left">
              '.$optiontype.'
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 col-form-label"> Movie Detail :</label>
              <div class="col-sm-10 text-left">
                <textarea name="MovieDetail" rows="10" cols="50">'.$moviedetail.'</textarea>
              </div>
            </div>


            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Movie Lenght :</label>
              <div class="col-sm-10 text-left">
                <input type = "number" name = "MovieLenght" value="'.$movielength.'"> mins
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Main Actor : </label>
              <div class="col-sm-10 text-left">
                <textarea name="MainActor" rows="10" cols="50">'.$mainactor.'</textarea>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Rate :</label>
              <div class="col-sm-10 text-left">
                <input type = "radio" name = "Rate" value = " All adults and age"> All adults and age
                <br><input type = "radio" name = "Rate" value = "13+"> 13+<br>
                <input type = "radio" name = "Rate" value = "15+"> 15+<br>
                <input type = "radio" name = "Rate" value = "18+"> 18+<br>
                <input type = "radio" name = "Rate" value = "20+"> 20+<br>
              </div>
            </div>

          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Release Date :</label>
            <div class="col-sm-10 text-left">
              <input id="ReleaseDate" type = "date" name = "ReleaseDate" value="'.$releasedate.'">
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-2 col-form-label">End Date :</label>
            <div class="col-sm-10 text-left">
              <input type = "date" name = "EndDate" required>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-2 col-form-label">System Type: '.$optionsystype.' </label><br>
            <div class="col-sm-10">
              <input type="hidden" name="movieid" value="'.$movieid.'">
            </div>
          </div>

          <input type="hidden" name="updatemovie" value="ok">

          <center><button type="submit" class="btn text-white mt-5" style = "background-color: #33b5e5";>UPDATE MOVIE</button></center></form>
          </div></div>

          <center><a href = "adminpage.php"><button type="submit" class="btn btn-lg btn-outline-primary mt-3">Cancel
          </button></a></center>
          </div>';
          mysqli_close($con);
    }
    /*EDIT MOVIE FORM*/

    /*EDIT MOVIE PROCESS*/
    if(!empty($_POST['updatemovie']))
    {
      $displaymenu = 0;
      $con = mysqli_connect("localhost","root","","movie");

/*EDIT MOVIE SYSTEM */
        $action = 0;
        $animation = 0;
        $adventure = 0;
        $comedy = 0;
        $crime = 0;
        $drama = 0;
        $fantasy = 0;
        $horror = 0;
        $mystery = 0;
        $scifi = 0;
        $romance = 0;
        $thriller = 0;

        $movieid = $_POST['movieid'];

        $systemtypes = $_POST['systemtypes'];

          $countsystype = count($systemtypes);
          //echo 'countsystype: '.$countsystype.'<br>';
          $systemtype = "";

          for($k=0;$k<$countsystype;$k++)
          {
            //echo $systemtypes[$k].'<br>';
            $systemtype = $systemtype.$systemtypes[$k].':';
          }

        //echo $systemtype.'<br><br>';
        $sql = "SHOW COLUMNS FROM movclasssys";
        $result = mysqli_query($con,$sql);
        $countrow = 0;
        $countfield = 0;
        $Field = "";
        while($row = mysqli_fetch_array($result))
          {
            if($countrow>=3)
            {
              // echo $row['Field'].'<br>';
              $Field = $Field.$row['Field'].':';
              $countfield++;
            }
              $countrow++;
          }
       // echo $systemtype."<br>".$Field.'<br>';
        $sepsys = explode(':',$systemtype);
        $sepField = explode(':', $Field);
          //$countrow = $countrow-2;
          $countloop = 0;
          $loc ="";
          $sql = "UPDATE movclasssys SET ";
          $movsys = "";
          //echo $countsystype.'<br>'.$countfield;
          for($i=0;$i<$countsystype;$i++)
          {
            for($j=0;$j<$countfield;$j++)
            {
              //echo "sepsys: ".$sepsys[2]."<br>";
              if(!strcasecmp($sepField[$j],$sepsys[$i]))
              {
            
                $loc = $loc.$i.':';
                $countloop++;
              }//echo "sepField: ".$sepField[4]."<br>"."<br>";
              
            } 
          }
          //echo "countloop= ".$countloop.'<br>';
          $sql2 = "UPDATE movclasssys SET ";
         
          $seploc = explode(':', $loc); 
          $p = 0;
          $savepos ="";

          //echo $countfield.'<br>';
          $z = 0;
          for($k=0;$k<$countfield;$k++)
          {
            $eiei = $seploc[$p];
            //echo '<br>'.$k.'<br>';
            if($sepField[$k]==$sepsys[$eiei])
            {
              $p++;
              //echo $sepField[$k];
              if($p==($countsystype-$countloop))
              {
                $p--;
              }
            }
            else
            {
              if($z==0)
              {
                $sql2 = $sql2.' '.$sepField[$k].' = '."'0'";
                $z++;
              }
              else
              {
                $sql2 = $sql2.' ,'.$sepField[$k].' = '."'0'";
              }
              $savepos = $savepos.$k.':';
            }
          }
          $sql2 = $sql2." WHERE MovieID = '".$movieid."';";
          //echo $sql2.'<br>';
          $result = mysqli_query($con,$sql2);
          //echo '<br>'.$savepos.'<br>';
          $seppos = explode(':', $savepos); 


          for($l=0;$l<$countloop;$l++)
          {
            if($l==0)
            {
              $sql = $sql.$sepsys[$seploc[$l]]." = '1'";
              $movsys = $movsys.$sepsys[$seploc[$l]];
            }
            else
            {
              $sql = $sql.','.$sepsys[$seploc[$l]]." = '1'";
              $movsys = $movsys.','.$sepsys[$seploc[$l]];
            }
          }
          //echo $movsys;
          $sql = $sql." ,summary = '".$movsys."' WHERE MovieID = '".$movieid."';";
          //echo $sql.'<br>';
          $result = mysqli_query($con,$sql);
/*EDIT MOVIE SYSTEM */

/*EDIT MOVIE TYPE*/
        if(!empty($_POST['movietype']))
        {
          $movietype = $_POST['movietype'];
          $check_count = count($movietype);
        
          for($i=0;$i<$check_count;$i++)
          {
            //echo $movietype[$i]."<br>";
            if($movietype[$i] == "Action"){$action = 1;}
            if($movietype[$i] == "Adventure"){$adventure = 1;}
            if($movietype[$i] == "Animation"){$animation = 1;}
            if($movietype[$i] == "Comedy"){$comedy = 1;}
            if($movietype[$i] == "Crime"){$crime = 1;}
            if($movietype[$i] == "Drama"){$drama = 1;}
            if($movietype[$i] == "Fantasy"){$fantasy = 1;}
            if($movietype[$i] == "Horror"){$horror = 1;}
            if($movietype[$i] == "Mystery"){$mystery = 1;}
            if($movietype[$i] == "Sci-fi"){$scifi = 1;}
            if($movietype[$i] == "Romance"){$romance = 1;}
            if($movietype[$i] == "Thriller"){$thriller = 1;}
          }
          //echo "<br>";
          $summary = $action.':'.$adventure.':'.$animation.':'.$comedy.':'.$crime.':'.$drama.':'.$fantasy.':'.$horror.':'.$mystery.':'.$scifi.':'.$romance.':'.$thriller;
          //echo $summary;
          //echo "<br>";

          $sql = "UPDATE movclasstype SET summary = '".$summary."',Action = ".$action.",Adventure = ".$adventure.",Animation = ".$animation.",Comedy = ".$comedy.", Crime = ".$crime.",Drama = ".$drama.",Fantasy = ".$fantasy.",Horror = ".$horror.",Mystery = ".$mystery.",Romance = ".$romance." WHERE 
            MovieID = '".$movieid."';";
          //echo $sql.'<br>';
           if (!mysqli_query($con,$sql))
              {
              die('Error: ' . mysqli_error($con));
              }
          $sql = "UPDATE movclasstype SET  `Sci-fi`= ".$scifi.",`Thriller`=".$thriller." WHERE 
            MovieID = '".$movieid."';";
          //echo $sql.'<br>';
            if (!mysqli_query($con,$sql))
              {
              die('Error: ' . mysqli_error($con));
              }

        }
/*EDIT MOVIE TYPE*/

/*EDIT MOVIE DETAIL*/

        $moviename    = mysqli_real_escape_string($con, $_POST['moviename']);
        $moviedetail  = mysqli_real_escape_string($con, $_POST['MovieDetail']);
        $movielength  = mysqli_real_escape_string($con, $_POST['MovieLenght']);
        $mainactor    = mysqli_real_escape_string($con, $_POST['MainActor']);
        $movierate    = mysqli_real_escape_string($con, $_POST['Rate']);
        $movierelease = $_POST['ReleaseDate'];
        $movieend   = $_POST['EndDate'];


        if($movielength%60==0){$delayshowtime = ($movielength/60)+1;}
        else if($movielength%60>=40){$delayshowtime = ceil($movielength/60)+1;}
        else {$delayshowtime = ceil($movielength/60);}
        //echo "delay = ".$delayshowtime;

        $summary2 = explode(':',$summary);

        // echo $movieidor.'<br>';

        // echo $row['summary'].'<br>';

        $type = array(array("Action"),array("Adventure"),array("Animation"),array("Comedy")
            ,array("Crime"),array("Drama"),array("Fantasy"),array("Horror"),array("Mystery")
            ,array("Sci-fi"),array("Romance"),array("Thriller"));

        $typemov = "";
        $count = 0;
        $coltype = "";

        for($i=0;$i<12;$i++)
        {
          if($summary2[$i]==1)
          {
            //$typemov = $typemov.$type[$i][0];
            $coltype = $coltype.$i.":";
            $count++;
          }
        }
        //echo $coltype."<br>".$count."<br>";

        $sep = explode(":",$coltype);

        $alltype = "";
        for($j=0;$j<$count;$j++)
        {
          $septype = $sep[$j];
          if($j<($count-1))
          {
            $alltype = $alltype.$type[$septype][0].",";
          }
          else
          {
            $alltype = $alltype.$type[$septype][0];
          }    
        }
        $sql = "UPDATE moviedata SET MovieTypeID = '".$alltype."'
        ,MovieDetail = '".$moviedetail."',MovieLenght = '".$movielength."',MainActor = '".$mainactor."',Rate = '".$mainactor."',ReleaseDate = '".$movierelease."',EndDate = '".$movieend."',delayshowtime = ".$delayshowtime." WHERE MovieID = '".$movieid."';";
        //echo $sql.'<br>';
          if (!mysqli_query($con,$sql))
              {
              die('Error: ' . mysqli_error($con));
              }
/*EDIT MOVIE DETAIL*/
    header("Refresh: 0; url=adminpage.php");
    mysqli_close($con);
    }
    /*EDIT MOVIE PROCESS*/

    /*DELETE MOVIE FORM*/
    if(!empty($_POST['selectdelmovie']))
    {
      $displaymenu = 0;
      $con = mysqli_connect("localhost","root","","movie");
      $Movielist = '<option value = "">--Please choose the movies--</option>';
      $sql = "SELECT MovieName FROM moviedata";
      $result = mysqli_query($con,$sql);
      if(!empty($result))
      {
        while($row = mysqli_fetch_array($result))
          {
          $Movielist = $Movielist."<option>".$row['MovieName']."</option>"; 
          }
      }
    $delmovieform = '
      <div class="container">
      <div class="card mt-5">
      <div class="card-body">

        <h3 class="text-dark font-weight-bold text-center mb-4 ml-3"> DELETE MOVIE :</h3>
        <center><select name="movieid" required>'.$Movielist.'</select></center>
        <input type="hidden" name="delmovie" value="ok">
        <center><button type="submit" class="btn text-white mt-5" style = "background-color: #33b5e5";>DELETE MOVIE</button></center></form>
        </div></div>

        <center><a href = "adminpage.php"><button type="submit" class="btn btn-lg btn-outline-primary mt-3">Cancel
        </button></a></center>

      </div>
    ';
    }
    /*DELETE MOVIE FORM*/

    /*DELETE MOVIE PROCESS*/
    if(!empty($_POST['delmovie']))
    {
      $displaymenu = 0;
      $con = mysqli_connect("localhost","root","","movie");
      $movieid = $_POST['movieid'];

      $sql = "SELECT MovieID FROM moviedata WHERE MovieName = '$movieid'";
      $result = mysqli_query($con,$sql);
      $row = mysqli_fetch_array($result);

      $movieid = $row['MovieID'];

      $sql = "DELETE FROM moviedata WHERE MovieID = '$movieid'";
      $result = mysqli_query($con,$sql);

      //echo $sql.'<br>';

      $sql = "DELETE FROM movclasstype WHERE MovieID = '$movieid'";
      $result = mysqli_query($con,$sql);

      //echo $sql.'<br>';

      $sql = "DELETE FROM movclasssys WHERE MovieID = '$movieid'";
      $result = mysqli_query($con,$sql);

      //echo $sql.'<br>';

      $sql = "UPDATE theater SET MovieID = '-' WHERE MovieID = '$movieid'";
      $result = mysqli_query($con,$sql);

      //echo $sql.'<br>';

      $resultdelmovie = "DELETE successfully".'<br>';

      mysqli_close($con);

    }
    /*DELETE MOVIE PROCESS*/

    /*ADD MOVIE SHOWTIME FORM*/
    if(!empty($_POST['addmovieshowtime']))
    {
      $displaymenu = 0;
      $con = mysqli_connect("localhost","root","","movie");
      $sql = "SELECT * from branch";
      $result = mysqli_query($con,$sql);
      $selectbranch = '
      <div class="container">
      <div class="card mt-5">
      <div class="card-body text-center">

      <form action="adminpage.php" method = "POST">
      <h3 class="text-center text-dark font-weight-bold mb-4">ADD MOVIE SHOWTIME FORM</h3>
      <h5>SELECT BRANCH</h5>
      <select name="branchnum" required><option value = "">--Please choose a Branch--</option>';
      while($row = mysqli_fetch_array($result))
      {
        $branchnum = $row['BranchID'];
        $selectbranch = $selectbranch.'<option value="'.$branchnum.'">'.$row['BranchName']."</option>";
      }
      $Movielist = ' <select name="movieid" required><option value = "">--Please choose the movies--</option>';
      $sql = "SELECT MovieName FROM moviedata";
      $result = mysqli_query($con,$sql);
      if(!empty($result))
      {
        while($row = mysqli_fetch_array($result))
          {
          $Movielist = $Movielist."<option>".$row['MovieName']."</option>"; 
          }
      }
      $Movielist = $Movielist.'</select><br>';
      $selectbranch = $selectbranch.'</select><br><br>
      <h5>SELECT MOVIE</h5>'.$Movielist.'
      <input type="hidden" name="searchfreetheater" value="ok">
      <br><center><button type="submit" class="btn text-white mt-5" style = "background-color: #33b5e5";>SEARCH THEATER</button></center></form>
      </div>
      </div>
      <center>
          <a href = "adminpage.php"><button type="submit" class="btn btn-lg btn-outline-primary mt-3">Cancel
          </button></a>
          </center></div>';
      mysqli_close($con);
    }
    /*ADD MOVIE SHOWTIME FORM*/

    /*SELECT THEATER TO ADD MOVIE*/
    if(!empty($_POST['searchfreetheater']))
    {
      $displaymenu = 0;
      $moviename = $_POST['movieid'];
      $movienames = $moviename;
      $branchid = $_POST['branchnum'];
      $con = mysqli_connect("localhost","root","","movie");

      $sql = "SELECT BranchName FROM branch WHERE BranchID = '$branchid'";
      $result = mysqli_query($con,$sql);
      $row = mysqli_fetch_array($result);
      $branchname = $row['BranchName'];

      $sql = "SELECT MovieID FROM moviedata WHERE MovieName = '$moviename'";
      $result = mysqli_query($con,$sql);
      $row = mysqli_fetch_array($result);
      $movieid = $row['MovieID'];

      $sql = "SELECT summary FROM movclasssys WHERE MovieID = '$movieid'";
      $result = mysqli_query($con,$sql);
      $row = mysqli_fetch_array($result);
      $moviesys = $row['summary']; 

      $sepmoviesys = explode(",",$moviesys);
      $countsys = count($sepmoviesys);

      $printtheater = "";
      $printtable = '<br><center><h2><b>SHOW THEATER IN '.$branchname.'</b></h2></center><br><center>
      <table><tr><th>THEATER</th><th>THEATER TYPE</th>';

      for($i=0;$i<$countsys;$i++)
      {
        $movsys = $sepmoviesys[$i];
        $sql = "SELECT DISTINCT TheaterID FROM seatinfo WHERE BranchID LIKE '$branchid' AND 
        TheaterType LIKE '$movsys'";
        $result = mysqli_query($con,$sql);
        $count=0;
        while($row = mysqli_fetch_array($result)){
        $printtheater = $printtheater.'<option value = "'.$row['TheaterID'].'">'.$row['TheaterID'].'</option>';
        $printtable = $printtable.'<tr><td>'.$row['TheaterID'].'</td>';
        $printtable = $printtable.'<td>'.$movsys.'</td></tr>';
        $count=1;
        }
        if($count==0)
        {
        $printtheater = $printtheater.'<option value = "">'."EMPTY".'</option>';
        $printtable = $printtable.'<tr><td>'."EMPTY".'</td>';
        $printtable = $printtable.'<td>'."EMPTY".'</td></tr>';  
        }
        
      }
    $branchids =$branchid;
    //echo $movienames.'<br>'.$branchids;
    $printtable = $printtable.'</tr></table></center><br>';
    $selecttheater2addmovie = '<div id="Center"><div class="form-inline">
      <form action="adminpage.php" method = "POST">
      <center><h2>ADD MOVIE SHOWTIME FORM</h2></center><br>'.$printtable.'
      <center><h3>SELECT THEATER</h3></center><center>
      <select name="theater" required != ""><option value = "">--Please choose a THEATER--</option>
      '.$printtheater.'</select></center>
      
      <input type="hidden" name="movienames" value="'.$movienames.'">
      <input type="hidden" name="branchids" value="'.$branchids.'">
      <input type="hidden" name="findshowtime" value="ok">
          <br><br><center><button type="submit">FIND SHOWTIME</button></center></form>
          </div></div>';
      mysqli_close($con);
    }
    /*SELECT THEATER TO ADD MOVIE*/

    /*SHOW ALL SHOWTIME IN THEATER*/
    if(!empty($_POST['findshowtime']))
    {
      $displaymenu = 0;
      //echo "findshowtime in ";
      if(!empty($_POST['branchids'])&&!empty($_POST['theater'])
        &&!empty($_POST['movienames'])){
      $con = mysqli_connect("localhost","root","","movie");
      //echo "findshowtime 2";
      $branchid = $_POST['branchids'];
      $theaterid = $_POST['theater'];
      $moviename = $_POST['movienames'];


      $sql = "SELECT BranchName FROM branch WHERE BranchID = '$branchid'"; 
      $result = mysqli_query($con,$sql);
      $row = mysqli_fetch_array($result);
      $branchname = $row['BranchName'];

      $sql = "SELECT TheaterType  FROM seatinfo WHERE BranchID = '$branchid' AND TheaterID = '$theaterid'";
      $result = mysqli_query($con,$sql);
      $row = mysqli_fetch_array($result);
      $theatersys = $row['TheaterType'];

      $sql = "SELECT Showtime,MovieID,Audio FROM theater WHERE BranchID LIKE '$branchid' AND TheaterID LIKE '$theaterid'";
      $result = mysqli_query($con,$sql);
      $showtimes = "";
      $showmovie = "";
      $showaudio = "";
      while($row = mysqli_fetch_array($result))
      {
        $mdn = $row['MovieID'];
        $sql2 = "SELECT MovieName FROM moviedata WHERE MovieID = '$mdn'";
        $result2 = mysqli_query($con,$sql2);
        $row2 = mysqli_fetch_array($result2);
        if(!empty($row2))
        {
           $showmovie = $showmovie.$row2['MovieName'].'/';
        }
        else
        {
          $showmovie = $showmovie.$row['MovieID'].'/';
        }
        $showtimes = $showtimes.$row['Showtime'].'/';
       
        $showaudio = $showaudio.$row['Audio'].'/';
      }
      $sepshowtimes = explode("/",$showtimes);
      $sepshowmovie = explode("/",$showmovie);
      $sepshowaudio = explode("/",$showaudio);
      $showallshowtime = '<br><center><h2><b>SHOW ALL SHOWTIME <br><br>IN '.$branchname
      .'<br><br>IN '.$theaterid.'<br><br>SYSTEMTYPE :'.$theatersys.'
      <br><br>MOVIE : '.$moviename.'</b></h2></center><br><center>
            <table><tr>';

      $k = 0;
      $l = 8;
      for($i=0;$i<48;$i++)
      {
        if($i%8==0)
        {
          $showallshowtime = $showallshowtime.'</tr><tr>';
          if($i!=0)
          {
            for($j=$k;$j<$l;$j++)
            {
              $showallshowtime = $showallshowtime.'<th>'.$sepshowmovie[$j].'</th>'; 
             /*$showallshowtime = $showallshowtime.'<th>'.$sepshowaudio[$j].'</th>'; */
            }
            $showallshowtime = $showallshowtime.'</tr><tr>';
            for($j=$k;$j<$l;$j++)
            { 
             $showallshowtime = $showallshowtime.'<th>'.$sepshowaudio[$j].'</th>'; 
            }
            $showallshowtime = $showallshowtime.'</tr><tr>';
          $k = $k+8;
          $l = $l+8;
          }

          $showallshowtime = $showallshowtime.'<th>'.$sepshowtimes[$i].'</th>';      
        }
        else
        {
          $showallshowtime = $showallshowtime.'<th>'.$sepshowtimes[$i].'</th>';
        }
      }


      $showallshowtime = $showallshowtime.'</tr><tr>';
        for($j=40;$j<48;$j++)
            {
            $showallshowtime = $showallshowtime.'<th>'.$sepshowmovie[$j].'</th>'; 
            }
            $showallshowtime = $showallshowtime.'</tr><tr>';
            for($j=40;$j<48;$j++)
            { 
             $showallshowtime = $showallshowtime.'<th>'.$sepshowaudio[$j].'</th>'; 
            }
            $showallshowtime = $showallshowtime.'</tr>';

      $showallshowtime = $showallshowtime.'</tr></center><table><br><br>';

      $sql = "SELECT delayshowtime FROM moviedata WHERE MovieName = '$moviename'";
      $result = mysqli_query($con,$sql);
      $row = mysqli_fetch_array($result);
      $delayshowtime = $row['delayshowtime'];

      $allshowtime = "";
      $sql = "SELECT Showtime FROM theater WHERE MovieID LIKE '-' AND BranchID LIKE '$branchid' AND TheaterID LIKE '$theaterid'";
      $result = mysqli_query($con,$sql);
      $i=0;
      while($row = mysqli_fetch_array($result))
      {
        if($i==0)
        {
          $allshowtime = $allshowtime.$row['Showtime'];
          $i++;
        }
        else
        {
          $allshowtime = $allshowtime.','.$row['Showtime'];
        }
        //echo $row['Showtime'].'<br>';
      }
      $sepallshowtime = explode(",",$allshowtime);
      $countsepshow = count($sepallshowtime);
      //echo $countsepshow.'<br>';

      $vashow = '<option value = "">--Please choose a SHOWTIME--</option>';
      for($i=0;$i<$countsepshow;$i++)
      {
        if(($sepallshowtime[$i]!="23:00")&&($sepallshowtime[$i]!="23:30"))
        {
          $vashow = $vashow.'<option value="'.$sepallshowtime[$i].'">'.$sepallshowtime[$i]."</option>";
        }
      }

      $movienames = $moviename;
      $branchids = $branchid;
      $theaterids = $theaterid;
      $showallshowtime = $showallshowtime.'<br><center><h2><b>SELECT SHOWTIME</b></h2></center><br><center>
      <div id="Center"><div class="form-inline">
      <form action="adminpage.php" method = "POST">'
      .'<select name="showtimes">'.$vashow.'</select><br>
      <input type="hidden" name="theater" value="'.$theaterids.'">
      <input type="hidden" name="branchid" value="'.$branchids.'">
      <input type="hidden" name="movienames" value="'.$movienames.'">
      <input type="hidden" name="verifyshowtime" value="ok">
      <br><br><center><button type="submit">VERIFY SHOWTIME</button></center></form>
      </div></div><br><br>'.'<form action="adminpage.php" method="post"><div id="Center">
      <div class="form-inline"><center>
      <input type="hidden" name="theater" value="'.$theaterids.'">
      <input type="hidden" name="movieid" value="'.$movienames.'">
      <input type="hidden" name="branchnum" value="'.$branchids.'">
      <input type="hidden" name="searchfreetheater" value="ok">
      <button  type="submit">BACK</button></center></div></div></form>'.'<br><br><br><br>';
      mysqli_close($con);
      }
    }
    /*SHOW ALL SHOWTIME IN THEATER*/

    /*VERIFY SHOWTIME*/
    if(!empty($_POST['verifyshowtime']))
    {
      if(!empty($_POST['showtimes'])&&
        !empty($_POST['branchid'])&&!empty($_POST['theater'])
        &&!empty($_POST['movienames']))
      {
      $displaymenu = 0;
      $branchid = $_POST['branchid'];
      $theaterid = $_POST['theater'];
      $moviename = $_POST['movienames'];
      $showtimes = $_POST['showtimes'];
      
      $con = mysqli_connect("localhost","root","","movie");
      $allbusyshowtime = "";
      $sql = "SELECT Showtime FROM theater WHERE MovieID NOT LIKE '-' AND BranchID LIKE '$branchid' AND TheaterID LIKE '$theaterid'";
      $result = mysqli_query($con,$sql);
      $i=0;
      while($row = mysqli_fetch_array($result))
        {
        if($i==0)
          {
          $allbusyshowtime = $allbusyshowtime.$row['Showtime'];
          $i++;
          }
        else
          {
          $allbusyshowtime = $allbusyshowtime.','.$row['Showtime'];
          }
        }
      if(!empty($allbusyshowtime))
      {
      $sepallbusyshowtime = explode(",",$allbusyshowtime);
      $countsepbusyshow = count($sepallbusyshowtime);
      //echo $countsepbusyshow;
       $sql = "SELECT delayshowtime FROM moviedata WHERE MovieName = '$moviename'";
      $result = mysqli_query($con,$sql);
      $row = mysqli_fetch_array($result);
      $delayshowtime = $row['delayshowtime'];

      $alldelay = $delayshowtime*2;
      //echo $alldelay;

      $busytime = "";
      $showtimestemp = $showtimes;
      $check = 1;
      for($i=0;$i<$alldelay;$i++)
        {
        
        for($j=0;$j<$countsepbusyshow;$j++)
          {
          //echo $sepallbusyshowtime[$j],'<br>';
          //echo $showtimestemp.'<br>';
          if($showtimestemp==$sepallbusyshowtime[$j])
            {
            $check = 0;
            break;
            }
          }
        if($check==0)
          {
          break;
          }
        $sepshowtimes = explode(":",$showtimestemp);
          if($sepshowtimes[1]=='00')
            {
            $showtimestemp = $sepshowtimes[0].':'.'30';
            }
          else
            {
            $hr = $sepshowtimes[0]+1;
            if($hr>=0)
              {
              if($hr<10)
                {
                  $showtimestemp = '0'.$hr.':'.$sepshowtimes[1];
                }
              else
                {
                $showtimestemp  = $hr.':'.$sepshowtimes[1];
                }
              }
            else
              {
                $showtimestemp = $hr.':'.$sepshowtimes[1];
              }
          }
        } 
     
      if($check==0)
        {
        $theaterids = $theaterid;
        $branchids = $branchid;
        $movienames = $moviename;
        $resultverify = '<center><h1><b>INVALID SHOWTIME</b></h1></center>
        <div id="Center"><div class="form-inline"><form action="adminpage.php"
        method="POST">
        <center>
        <input type="hidden" name="theater" value="'.$theaterids.'">
        <input type="hidden" name="branchids" value="'.$branchids.'">
        <input type="hidden" name="movienames" value="'.$movienames.'">
        <input type="hidden" name="findshowtime" value="55555">
        <button  type="submit">BACK</button>
        </center></form></div></div>
        ';
        }
      else
        {
        $theaterids = $theaterid;
        $branchids = $branchid;
        $movienames = $moviename;
        $resultverify = '<center><h1><b>VALID SHOWTIME</b></h1></center>
        <div id="Center"><div class="form-inline"><form action="adminpage.php"
        method="POST">
        <center>
        <input type="hidden" name="theater" value="'.$theaterids.'">
        <input type="hidden" name="branchid" value="'.$branchids.'">
        <input type="hidden" name="movienames" value="'.$movienames.'">
        <input type="hidden" name="showtimes" value="'.$showtimes.'">
        <input type="hidden" name="addmovieinshowtimeprocess" value="ok">
        <h3><b>SELECT Audio</b></h3><br>
        <select name="Audio" required><option value="">-- Audio --</option>
        <option value="EN">EN</option><option value="TH">TH</option>
        </select></center><br><center>
        <button  type="submit">CONFRIM</button>
        </center></form></div></div>
        ';
        }
      }
      else
      {
        $theaterids = $theaterid;
        $branchids = $branchid;
        $movienames = $moviename;
        $resultverify = '<center><h1><b>VALID SHOWTIME</b></h1></center>
        <div id="Center"><div class="form-inline"><form action="adminpage.php"
        method="POST">
        <center>
        <input type="hidden" name="theater" value="'.$theaterids.'">
        <input type="hidden" name="branchid" value="'.$branchids.'">
        <input type="hidden" name="movienames" value="'.$movienames.'">
        <input type="hidden" name="showtimes" value="'.$showtimes.'">
        <input type="hidden" name="addmovieinshowtimeprocess" value="ok">
        <h3><b>SELECT Audio</b></h3><br>
        <select name="Audio" required><option value="">-- Audio --</option>
        <option value="EN">EN</option><option value="TH">TH</option>
        </select></center><br><center>
        <button  type="submit">CONFRIM</button>
        </center></form></div></div>
        <form action="adminpage.php" method="post"><div id="Center">
      <div class="form-inline"><center>
      <input type="hidden" name="theater" value="'.$theaterids.'">
       <input type="hidden" name="movienames" value="'.$movienames.'">
      <input type="hidden" name="branchids" value="'.$branchids.'">
      <input type="hidden" name="findshowtime" value="ok">
      <button  type="submit">BACK</button></center></div></div></form>'.'<br><br><br><br>
        ';
      }
      mysqli_close($con);
      }
    }
    /*VERIFY SHOWTIME*/

    /*ADD MOVIE IN SHOWTIME PROCESS*/
    if(!empty($_POST['addmovieinshowtimeprocess']))
    {
      //echo "hello";
      $displaymenu = 0;
      if(!empty($_POST['theater'])&&!empty($_POST['branchid'])
        &&!empty($_POST['movienames'])&&!empty($_POST['showtimes']))
      {
        //echo "hello2";
        /*echo $_POST['theater'].'<br>'.$_POST['branchid'].'<br>'.
        $_POST['movienames'].'<br>'.$_POST['showtimes'].'<br>'.$_POST['Audio'].'<br>';*/
        $con = mysqli_connect("localhost","root","","movie");

        $moviename  =   $_POST['movienames'];
        $theater    =   $_POST['theater'];
        $branchid   =   $_POST['branchid'];
        $showtimes  =   $_POST['showtimes'];
        $Audio      =   $_POST['Audio']; 

        $sql    = "SELECT delayshowtime FROM moviedata WHERE MovieName = '$moviename'";
        $result = mysqli_query($con,$sql);
        $row    = mysqli_fetch_array($result);
        $delay  = $row['delayshowtime'];
        $alldelay = $delay*2;

        $allshowtime = $showtimes;
        $showtimestemp = $allshowtime;

        for($i=0;$i<$alldelay;$i++)
        {
        $sepshowtimes = explode(":",$showtimestemp);
          if($sepshowtimes[1]=='00')
            {
            $allshowtime = $allshowtime.','.$sepshowtimes[0].':'.'30';
            $showtimestemp = $sepshowtimes[0].':'.'30';
            }
          else
            {
            $hr = $sepshowtimes[0]+1;
            if($hr>=0)
              {
              if($hr<10)
                {
                  $allshowtime = $allshowtime.','.'0'.$hr.':'.'00';
                  $showtimestemp = '0'.$hr.':'.'00';
                }
              else
                {
                $allshowtime = $allshowtime.','.$hr.':'.'00';
                $showtimestemp  = $hr.':'.'00';
                }
              }
            else
              {
                $allshowtime = $allshowtime.','.$hr.':'.'00';
                $showtimestemp = $hr.':'.'00';
              }
          }
        } 
        //echo $allshowtime;
        $sepallshowtime = explode(",",$allshowtime);
        $count = count($sepallshowtime);

        $sql = "SELECT MovieID FROM moviedata WHERE MovieName = '$moviename'";
        $result = mysqli_query($con,$sql);
        $row = mysqli_fetch_array($result);
        $movieid = $row['MovieID'];

        $sql = "UPDATE theater SET MovieID = '$movieid',Audio = '$Audio' WHERE Showtime = '$showtimes' 
        AND BranchID = '$branchid' AND TheaterID = '$theater'";

        $result = mysqli_query($con,$sql);
        for($i=1;$i<$count;$i++)
        {
          $showtimed = $sepallshowtime[$i];
          $sql = "UPDATE theater SET MovieID = '*',Audio = '*' WHERE Showtime = '$showtimed' 
            AND BranchID = '$branchid' AND TheaterID = '$theater'";
          $result = mysqli_query($con,$sql);  
        }

        $printaddmovieshowtime = '<center><h1><b>ADD MOVIE SHOWTIME</b></h1></center>
        <div id="Center"><div class="form-inline"><form action="adminpage.php"
        method="POST">
        <center>ADD successfully</center>
        <center>
        <button  type="submit">BACK</button>
        </center></form></div></div>';
        //echo $allshowtime;
        mysqli_close($con);
      }
    }
    /*ADD MOVIE IN SHOWTIME PROCESS*/

    /*RESET MOVIE SHOWTIME*/
    if(!empty($_POST['resetallmovieshowtime']))
    {
      $con = mysqli_connect("localhost","root","","movie");
      $sql = "UPDATE theater SET MovieID = '-', Audio = '-' WHERE 1";
      $result = mysqli_query($con,$sql);
      mysqli_close($con);
    }
    /*RESET MOVIE SHOWTIME*/

?>
<!-- MANAGE MOVIE -->
  
<!-- MANAGE THEATER -->
<?php
  
  /*THEATER MENU*/
  if(!empty($_POST['managetheater']))
    {
    $displaymenu = 0;
    $addtheaterbtn = '
          <div class="text-center mt-5">
            <form action="adminpage.php" method = "POST">
            <input type="hidden" name="addtheater" value="ok">
            <button type="submit"button type="submit" class="btn btn-lg text-white" style="background-color: #33b5e5";>ADD THEATER</button>
            </form>
          </div>';
    $deletetheaterbtn = '
        <div class="text-center mt-3">
          <form action="adminpage.php" method = "POST">
          <input type="hidden" name="deletetheater" value="ok">
          <button type="submit"button type="submit" class="btn btn-lg text-white" style="background-color: #33b5e5";> DELETE THEATER</button>
          </form>
        </div>';
    $showalltheaterbtn = '
        <div class="text-center mt-3">
          <form action="adminpage.php" method = "POST">
          <input type="hidden" name="showalltheater" value="ok">
          <button type="submit"button type="submit" class="btn btn-lg text-white" style="background-color: #33b5e5";> SHOW ALL THEATER</button>
          </form>
        </div>';

    $resetallseat = '
        <div class="text-center mt-3">
          <form action="adminpage.php" method = "POST">
          <input type="hidden" name="resetallseat" value="ok">
          <button type="submit"button type="submit" class="btn btn-lg btn-danger text-white";> RESET ALL SEAT</button>
          </form>
        </div>';

    }
    /*THEATER MENU*/

    /*ADD THEATER FORM*/
    if(!empty($_POST['addtheater']))
    {
    $displaymenu = 0;

    $con = mysqli_connect("localhost","root","","movie");
    $sql = "SELECT * from branch";
    $result = mysqli_query($con,$sql);
    $branchlist ='<option value = "">--Please choose a Branch--</option>';
    while($row = mysqli_fetch_array($result))
      {
        $branchnum = $row['BranchID'];
        $branchlist = $branchlist.'<option value="'.$branchnum.'">'.$row['BranchName']."</option>";
      }

    $sql = "SELECT DISTINCT TheaterType  FROM seatprice";
    $result = mysqli_query($con,$sql); 
    $syslist ='<option value = "">--Please choose a SYSTEMTYPE--</option>';
    while($row = mysqli_fetch_array($result)){$systype = $row['TheaterType'];
    $syslist = $syslist.'<option value="'.$systype.'">'.$systype."</option>";}

    $addtheaterform = '
      <div class="container">
      <div class="card mt-5">
      <div class="card-body text-center">

      <form action="adminpage.php" method = "POST">
      <h3 class="text-center text-dark font-weight-bold mb-5"> ADD THEATER </h3>

      <div class="form-group row">
        <label class="col-sm-2 col-form-label">BRANCH :</label>
         <div class="col-sm-10 text-left">
          <select name="Branchnum" required>'.$branchlist.'</select>
         </div>
      </div>

    
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">SYSTEMTYPE :</label>
        <div class="col-sm-10 text-left">
          <select name="theatertype" required>'.$syslist.'</select>
        </div>
    </div>

    <div class="form-group row"> 
     <label class="col-sm-3 col-form-label">TOTAL ROW:</label>
     <div class="col-sm-3 text-left">
      <input type="number" name="Rownum" min="2" max="15" placeholder="2-15" required>
     </div>
     <label class="col-sm-3 col-form-label">TOTAL SEAT PER ROW:</label>
     <div class="col-sm-3 text-left">
      <input type="number" name="totalseat" min="4" max="15" placeholder="4-15" required>
     </div>
    </div>
     
    </center>
    <input type="hidden" name="createtheater" value="ok">
    <center><button type="submit" class="btn text-white mt-5" style = "background-color: #33b5e5";>CREATE THEATER</button></center></form>
    </div></div>

     <center>
      <a href = "adminpage.php"><button type="submit" class="btn btn-lg btn-outline-primary mt-3">Cancel
      </button></a>
    </center>
    </div>

    ';
    }
    /*ADD THEATER FORM*/

    /*ADD THEATER PROCESS*/
    if(!empty($_POST['createtheater']))
    {
    $displaymenu = 0;
    $branch = $_POST['Branchnum'];
    $theatertype = $_POST['theatertype'];
    $rownum = $_POST['Rownum'];
    $totalseat = $_POST['totalseat'];
  
    $resultaddtheater = '<center><h2 class="text-light mt-5">'.$branch.'&nbsp;'.'row: '.$rownum.'&nbsp;'.'totalseat: '.$totalseat.'</h2></center><br>';
    $totalseat = $totalseat + 1;

    $con = mysqli_connect("localhost","root","","movie");

    $sql = "SELECT `TheaterID` from theater where BranchID like '$branch'";

    $result = mysqli_query($con,$sql);

    $theatercount = 0;

    while($row = mysqli_fetch_array($result))
    {
      //echo $row['TheaterID'];
      $theatercount = $row['TheaterID'];
    }

    //echo $theatercount;

    $sep = sscanf($theatercount, "%[A-Z]%d");

    //echo $sep[0];
    //echo "<br>";
    //echo $sep[1];

    $theatercount = $sep[1] +1;

    if($theatercount<10)
    {
      $theatercount = "T0".$theatercount;
    }
    else
    {
      $theatercount = "T".$theatercount;
    }

    $sql2 = "SELECT BranchName from branch where BranchID = '$branch'";
    $result2 = mysqli_query($con,$sql2);
    $row2 = mysqli_fetch_array($result2);
    $branchname = $row2['BranchName'];

    $showtimes = '<option value = "">--Please choose a showtimes--</option>';

    $k =0;

    $sql2 =   "INSERT INTO seatinfo(`SeatInfo`, `BranchID`, `TheaterID`, `showtime`, `SeatType`, `TheaterType`, `SeatRow`, `SeatNumber`, `SeatStatus`) VALUES";

    $check = 0;

    for ($i=0;$i<48;$i++) 
      { 
        if($k<10)
          {
          if(($i%2)==0)
            {
            $showtimes = '0'.$k.':'.'00';
            //echo $showtimes."<br>";
            $sql = "INSERT INTO `theater`(`BranchID`, `TheaterID`, `Showtime`, `MovieID`, `Audio`) 
            VALUES ('$branch','$theatercount','$showtimes','-','-')";
            
            if (!mysqli_query($con,$sql))
        {
        die('Error: ' . mysqli_error($con));
        }
      for($l=0;$l<$rownum;$l++)
        {
          $seatrow = chr($l+65);
          if($l<=3)
            {
            $seattype = "Honeymoon";
            }
          else
            {
            $seattype = "Regular";
            }
          $seatnum = "0"."1";
          $seatinfo = "SN".$branch.$theatercount.$showtimes.$seatrow.$seatnum;
          if($check == 0)
          {
            $sql2 =   $sql2."('$seatinfo','$branch','$theatercount','$showtimes','$seattype','$theatertype'
            ,'$seatrow','$seatnum','available')";
            $check = 1;
          }
          else
          {
            $sql2 = $sql2.",('$seatinfo','$branch','$theatercount','$showtimes','$seattype','$theatertype'
            ,'$seatrow','$seatnum','available')";
          }
          
          for($m=2;$m<$totalseat;$m++)
            {
            if($m<10)
              {
              $seatnum = "0".$m;
              }
            else
              {
              $seatnum = $m;  
              }
            $seatinfo = "SN".$branch.$theatercount.$showtimes.$seatrow.$seatnum;

            $sql2 = $sql2.",('$seatinfo','$branch','$theatercount','$showtimes','$seattype','$theatertype'
            ,'$seatrow','$seatnum','available')";
            }
        }
            }
          else
            {
            $showtimes = '0'.$k.':'.'30';
            //echo $showtimes."<br>";
            $sql = "INSERT INTO `theater`(`BranchID`, `TheaterID`, `Showtime`, `MovieID`, `Audio`) 
            VALUES ('$branch','$theatercount','$showtimes','-','-')";
            
            if (!mysqli_query($con,$sql))
        {
        die('Error: ' . mysqli_error($con));
        }
        for($l=0;$l<$rownum;$l++)
        {
          $seatrow = chr($l+65);
          if($l<=3)
            {
            $seattype = "Honeymoon";
            }
          else
            {
            $seattype = "Regular";
            }
          $seatnum = "0"."1";
          $seatinfo = "SN".$branch.$theatercount.$showtimes.$seatrow.$seatnum;
          $sql2 =   $sql2.",('$seatinfo','$branch','$theatercount','$showtimes','$seattype','$theatertype'
            ,'$seatrow','$seatnum','available')";

          for($m=2;$m<$totalseat;$m++)
            {
            if($m<10)
              {
              $seatnum = "0".$m;
              }
            else
              {
              $seatnum = $m;  
              }
            $seatinfo = "SN".$branch.$theatercount.$showtimes.$seatrow.$seatnum;

            $sql2 = $sql2.",('$seatinfo','$branch','$theatercount','$showtimes','$seattype','$theatertype'
            ,'$seatrow','$seatnum','available')";
            }
        }
            $k = $k+1;
            }
          }
        else
          {
          if($i%2==0)
            {
            $showtimes = $k.':'.'00';
            //echo $showtimes."<br>";
            $sql = "INSERT INTO `theater`(`BranchID`, `TheaterID`, `Showtime`, `MovieID`, `Audio`) 
            VALUES ('$branch','$theatercount','$showtimes','-','-')";
            
            if (!mysqli_query($con,$sql))
        {
        die('Error: ' . mysqli_error($con));
        }

        for($l=0;$l<$rownum;$l++)
        {
          $seatrow = chr($l+65);
          if($l<=3)
            {
            $seattype = "Honeymoon";
            }
          else
            {
            $seattype = "Regular";
            }
          $seatnum = "0"."1";
          $seatinfo = "SN".$branch.$theatercount.$showtimes.$seatrow.$seatnum;
          $sql2 =   $sql2.",('$seatinfo','$branch','$theatercount','$showtimes','$seattype','$theatertype'
            ,'$seatrow','$seatnum','available')";
          for($m=2;$m<$totalseat;$m++)
            {
            if($m<10)
              {
              $seatnum = "0".$m;
              }
            else
              {
              $seatnum = $m;  
              }
            $seatinfo = "SN".$branch.$theatercount.$showtimes.$seatrow.$seatnum;

            $sql2 =   $sql2.",('$seatinfo','$branch','$theatercount','$showtimes','$seattype','$theatertype'
            ,'$seatrow','$seatnum','available')";
            }
        }
            }
          else
            {
            $showtimes = $k.':'.'30';
            //echo $showtimes."<br>";
            $sql = "INSERT INTO `theater`(`BranchID`, `TheaterID`, `Showtime`, `MovieID`, `Audio`) 
            VALUES ('$branch','$theatercount','$showtimes','-','-')";
            
            if (!mysqli_query($con,$sql))
        {
        die('Error: ' . mysqli_error($con));
        }
        for($l=0;$l<$rownum;$l++)
        {
          $seatrow = chr($l+65);
          if($l<=3)
            {
            $seattype = "Honeymoon";
            }
          else
            {
            $seattype = "Regular";
            }
          $seatnum = "0"."1";
          $seatinfo = "SN".$branch.$theatercount.$showtimes.$seatrow.$seatnum;
          $sql2 =   $sql2.",('$seatinfo','$branch','$theatercount','$showtimes','$seattype','$theatertype'
            ,'$seatrow','$seatnum','available')";
          for($m=2;$m<$totalseat;$m++)
            {
            if($m<10)
              {
              $seatnum = "0".$m;
              }
            else
              {
              $seatnum = $m;  
              }
            $seatinfo = "SN".$branch.$theatercount.$showtimes.$seatrow.$seatnum;
            $sql2 =   $sql2.",('$seatinfo','$branch','$theatercount','$showtimes','$seattype','$theatertype'
            ,'$seatrow','$seatnum','available')";
            }
            
        }
            $k = $k+1;
            } 
          }
      }
      $sql2 = $sql2.";";
            if (!mysqli_query($con,$sql2))
        {
        die('Error: ' . mysqli_error($con));
        }
      mysqli_close($con);  
    }
    //echo "<br><br><center>".$sql2."</center><br><br>";
    /*ADD THEATER PROCESS*/

    /*DELETE THEATER FORM*/
    if(!empty($_POST['deletetheater']))
    {
      $displaymenu = 0;
      $con = mysqli_connect("localhost","root","","movie");
      $sql = "SELECT * from branch";
      $result = mysqli_query($con,$sql);
      $branchlist ='<option value = "">--Please choose a Branch--</option>';
      while($row = mysqli_fetch_array($result))
      {
        $branchnum = $row['BranchID'];
        $branchlist = $branchlist.'<option value="'.$branchnum.'">'.$row['BranchName']."</option>";
      }

      $deltheaterform = '
      <div class="container">
      <div class="card mt-5">
      <div class="card-body text-center">
        <form action="adminpage.php" method = "POST">
        <h3 class="text-center text-dark font-weight-bold mb-4">DELETE THEATER FORM</h3>
        <center><select name="Branchnum" required>'.$branchlist.'</select></center>
        <input type="hidden" name="searchdeltheater" value="ok">
        <center><button type="submit" class="btn text-white mt-5" style = "background-color: #33b5e5";>
        SEARCH THEATER</button></center></form>
      </div>
      </div>
      </div>
      <br>
    ';
      mysqli_close($con);
    }
    /*DELETE THEATER FORM*/

    /*SELECT DELETE THEATER*/
    if(!empty($_POST['searchdeltheater']))
    {
      $displaymenu = 0;
      $branchid = $_POST['Branchnum'];
      $con = mysqli_connect("localhost","root","","movie");

      $sql = "SELECT BranchName FROM branch WHERE BranchID = '$branchid'";
      $result = mysqli_query($con,$sql);
      $row = mysqli_fetch_array($result);
      $branchname = $row['BranchName'];

      $sql = "SELECT DISTINCT TheaterID FROM theater WHERE BranchID LIKE '$branchid'";
      $result = mysqli_query($con,$sql);
      $theaterlist ='<option value = "">--Please choose a THEATER--</option>';
      while($row = mysqli_fetch_array($result))
      {
        $theaterlist = $theaterlist.'<option value="'.$row['TheaterID'].'">'.$row['TheaterID']."</option>";
      }
      
      $sql = "SELECT  TheaterID,TheaterType,COUNT(*)/48 as countall,COUNT(DISTINCT(SeatRow)) as countrow,
      COUNT(DISTINCT(SeatNumber)) as countseat 
      FROM seatinfo WHERE BranchID LIKE '$branchid' GROUP BY TheaterID";
      $result = mysqli_query($con,$sql);
      $dspyallth = '<h2 class="mt-5 mb-4 text-light text-center font-weight-bold";>DELETE THEATER</h2>
      <center>
      <table><tr><th><h5 class="text-light text-center">BRANCH </h5></th>
      <th><h5 class="text-light text-center"> THEATER </h5></th>
      <th><h5 class="text-light text-center"> THEATER TYPE </h5></th>
      <th><h5 class="text-light text-center"> THEATER SIZE </h5></th>
      <th><h5 class="text-light text-center"> ROW SIZE </h5></th>
      <th><h5 class="text-light text-center"> SEAT PER ROW </h5></th></tr>';
      $check = 0;
      while($row = mysqli_fetch_array($result))
      {
        $dspyallth = $dspyallth.'<tr><td><h6 class="text-light text-center">'.$branchname.'</h6></td>
        <td><h6 class="text-light text-center">'.$row['TheaterID'].'</h6></td>
        <td><h6 class="text-light text-center">'.$row['TheaterType'].'</h6></td>
        <td><h6 class="text-light text-center">'.(int)$row['countall'].'</h6></td>
        <td><h6 class="text-light text-center">'.$row['countrow'].'</h6></td>
        <td><h6 class="text-light text-center">'.$row['countseat'].'</h6></td></tr>'; 
        $check = 1;
      }
      if(empty($row)&&$check==0)
        {
          $dspyallth = $dspyallth.'<tr><td><h6 class="text-light text-center">'.$branchname.'</h6></td>
          <td><h6 class="text-light text-center">'.'EMPTY'.'</h6></td>
          <td><h6 class="text-light text-center">'.'EMPTY'.'</h6></td>
          <td><h6 class="text-light text-center">'.'EMPTY'.'</h6></td>
          <td><h6 class="text-light text-center">'.'EMPTY'.'</h6></td>
          <td><h6 class="text-light text-center">'.'EMPTY'.'</h6></td></tr>';

        }
      $dspyallth = $dspyallth.'</table></center><br>'.'
      <form action="adminpage.php" method = "POST">
      <div class="container">
      <div class="card mt-5">
      <div class="card-body text-center">
        <h3 class="text-center text-dark font-weight-bold mb-4">THEATER :</h3>
        <select name="theater" required>'.$theaterlist.'</select>
        <input type="hidden" name="deltheater" value="ok">
        <input type="hidden" name="Branchnum" value="'.$branchid.'">
        <center><button type="submit" class="btn text-white mt-5" style = "background-color: #33b5e5";>DELETE THEATER</button></center>
      </form>
      </div>
      </div>
      <form>
      <center><a href = "adminpage.php"><button type="submit" class="btn btn-lg btn-outline-primary mt-3">Cancel</button></a>
      </center></form>
      </div>
      ';
     
      mysqli_close($con);
    }
    /*SELECT DELETE THEATER*/

    /*DELETE THEATER PROCESS*/
    if(!empty($_POST['deltheater']))
    {
      $displaymenu = 0;
      $deltheater = $_POST['theater'];
      $branchid = $_POST['Branchnum'];
      $con = mysqli_connect("localhost","root","","movie");

      $sql = "DELETE FROM seatinfo WHERE BranchID = '$branchid' AND TheaterID = '$deltheater'";
      $result = mysqli_query($con,$sql);

      $sql = "DELETE FROM theater WHERE BranchID = '$branchid' AND TheaterID = '$deltheater'";
      $result = mysqli_query($con,$sql);

      $sql = "SELECT BranchName FROM branch WHERE BranchID = '$branchid'";
      $result = mysqli_query($con,$sql);
      $row = mysqli_fetch_array($result);
      $branchname = $row['BranchName'];

  
      
      $sql = "SELECT  TheaterID,TheaterType FROM seatinfo WHERE BranchID LIKE '$branchid' GROUP BY TheaterID";
      $result = mysqli_query($con,$sql);
      $resultdelth = '<br><center><h2><b>DELETE THEATER</b></h2></center><br><center>
      <table><tr><th> BRANCH </th><th> THEATER </th><th> THEATER TYPE </th></tr>';
      $check = 0;
      while($row = mysqli_fetch_array($result))
      {
        $resultdelth = $resultdelth.'<tr><td>'.$branchname.'</td><td>'.$row['TheaterID'].'</td><td>'.$row['TheaterType'].'</td></tr>';
        $check = 1;
      }
      if(empty($row)&&$check==0)
        {
          $resultdelth = $resultdelth.'<tr><td>'.$branchname.'</td><td>'.'EMPTY'.'</td><td>'.'EMPTY'.'</td></tr>';
        }
      $resultdelth = $resultdelth.'</table></center><br>
      <center>
      <table><tr><th> BRANCH </th><th> THEATER </th><th> STATUS </th></tr>
      <tr><td>'.$branchname.'</td><td>'.$deltheater.'</td><td>'."DELETE".'</td></tr></table></center>'.'<br>'.$backbtn;
      mysqli_close($con);
    }
    /*DELETE THEATER PROCESS*/

    /*SHOW ALL THEATER*/
    if(!empty($_POST['showalltheater']))
    {
      $displaymenu = 0;
      $con = mysqli_connect("localhost","root","","movie");
      $sql = "SELECT  BranchID,TheaterID,TheaterType,COUNT(*)/48 as countall,COUNT(DISTINCT(SeatRow)) as countrow,
      COUNT(DISTINCT(SeatNumber)) as countseat FROM seatinfo GROUP BY TheaterID,BranchID ORDER BY BranchID,TheaterID";
      $result = mysqli_query($con,$sql);
      $showalltheater = '
      <h2 class="text-center text-light font-weight-bold mb-4 mt-5"> SHOW ALL THEATER</h2>
      <center>
      <table>
        <tr><th><h6 class="text-light text-center"> BRANCH </h6></th>
            <th><h6 class="text-light text-center"> THEATER </h6></th>
            <th><h6 class="text-light text-center"> THEATER TYPE </h6></th>
            <th><h6 class="text-light text-center"> THEATER SIZE </h6></th>
            <th><h6 class="text-light text-center"> ROW SIZE </h6></th>
            <th><h6 class="text-light text-center"> SEAT PER ROW </h6></th>
        </tr>
      </center>';
      $check = 0;
      while($row = mysqli_fetch_array($result))
      {
        $branchid =$row['BranchID'];
        $sql2 = "SELECT BranchName FROM branch WHERE BranchID = '$branchid'";
        $result2 = mysqli_query($con,$sql2);
        $row2 = mysqli_fetch_array($result2);
        $showalltheater = $showalltheater.'<tr>
        <td><h6 class="text-light text-center">'.$row2['BranchName'].'</h6></td>
        <td><h6 class="text-light text-center">'.$row['TheaterID'].'</h6></td>
        <td><h6 class="text-light text-center">'.$row['TheaterType'].'</h6></td>
        <td><h6 class="text-light text-center">'.(int)$row['countall'].'</h6></td>
        <td><h6 class="text-light text-center">'.$row['countrow'].'</h6></td>
        <td><h6 class="text-light text-center">'.$row['countseat'].'</h6></td>
        </tr>'; 
        $check = 1;
      }
      if(empty($row)&&$check==0)
        {
          $showalltheater = $showalltheater.'<tr><td><h6 class="text-light text-center">'.'EMPTY'.'</h6></td>
          <td><h6 class="text-light text-center">'.'EMPTY'.'</h6></td>
          <td><h6 class="text-light text-center">'.'EMPTY'.'</h6></td>
          <td><h6 class="text-light text-center">'.'EMPTY'.'</h6></td>
          <td><h6 class="text-light text-center">'.'EMPTY'.'</h6></td>
          <td><h6 class="text-light text-center">'.'EMPTY'.'</h6></td></tr>';
        }
      $showalltheater = $showalltheater.'</table></center><br>';
      mysqli_close($con);
    }
    /*SHOW ALL THEATER*/

    /*RESET ALL SEAT*/
    if(!empty($_POST['resetallseat']))
    {
      $displaymenu = 0;
      $con = mysqli_connect("localhost","root","","movie");
      $sql = "UPDATE seatinfo SET SeatStatus = 'available'";

      if (mysqli_query($con, $sql)) {
      // echo "<br>"."Record updated successfully";
      $resetallseat = "<br><center><h1><b>"."Now! This seat is Booking
      </b></h1></center>";
      } else {
       $resetallseat = "<br><center><h1><b>"."Error updating record: " . mysqli_error($con)."</b></h1></center>";
      }
      header("Refresh: 0; url=adminpage.php");
    }
    /*RESET ALL SEAT*/

?>
<!-- MANAGE THEATER -->

<!-- MANAGE SYSTEM TYPE -->
<?php

  /*MOVIE MENU*/
    if(!empty($_POST['managesytemtype']))
    {
    $displaymenu = 0; 
    $addsystemtypebtn = '
          <div class="text-center mt-5">
            <form action="adminpage.php" method = "POST">
            <input type="hidden" name="addsystemtype" value="ok">
            <button type="submit" class="btn btn-lg text-white" style="background-color:#33b5e5;">ADD SYSTEMTYPE
            </button></center>
            </form>
          </div>';
    $deletesystemtypebtn = '
        <div class="text-center mt-3">
          <form action="adminpage.php" method = "POST">
          <input type="hidden" name="deletesystemtype" value="ok">
          <button type="submit" class="btn btn-lg text-white" style="background-color:#33b5e5;"> DELETE SYSTEMTYPE</button></center>
          </form>
        </div>';
    }
  /*MOVIE MENU*/

  /*ADD SYSTEM TYPE FORM*/
  if(!empty($_POST['addsystemtype']))
  {
    $displaymenu = 0; 
    $addsystemtypeform = '
          <div class="container">
          <div class="card mt-5">
          <div class="card-body text-center">
            <form action="adminpage.php" method = "POST">
            <h3 class="text-center text-dark font-weight-bold mb-4">ADD SYSTEMTYPE FORM</h3>
            Theather Type:&nbsp;<input type="text" name="theatertype" required><br><br>
            Regular price:&nbsp;<input type="number" name="regprice" required><br><br>
            Honeymoon price:&nbsp;<input type="number" name="honeyprice" required><br>
            <input type="hidden" name="insertsystemtype" value="ok">
            <center><button type="submit" class="btn text-white mt-5" style = "background-color: #33b5e5";>ADD SYSTEMTYPE</button></center>
            </form>
          </div>
          </div>
           <center><a href = "adminpage.php"><button type="submit" class="btn btn-lg btn-outline-primary mt-3">Cancel</button></a>
          </center>
          </div>';
  }
  /*ADD SYSTEM TYPE FORM*/

  /*INSERT SYSTEM TYPE*/
  if(!empty($_POST['insertsystemtype']))
  {
    $displaymenu = 0;
    $resultaddsys = "ERROR ADD SYSTEMTYPE";
    $con = mysqli_connect("localhost","root","","movie");
    $theatertype  = $_POST['theatertype'];
    $regprice   =   $_POST['regprice'];
    $honeyprice   = $_POST['honeyprice'];

    $sql = "INSERT INTO seatprice(SeatType,TheaterType,Price) 
    VALUES ('Regular','$theatertype','$regprice')
    ,('Honeymoon','$theatertype','$honeyprice')";
    
    if (!mysqli_query($con,$sql))
          {
          die('Error: ' . mysqli_error($con));
          }

    /*add column*/
    $sql = "ALTER TABLE movclasssys ADD $theatertype VARCHAR (100)";

    if (!mysqli_query($con,$sql))
          {
          die('Error: ' . mysqli_error($con));
          }
     $resultaddsys = '<center><h3 class="text-light mt-5">
     ADD SYSTEMTYPE : '.$theatertype.'<br>
     HONEYMOON SEAT : '.$honeyprice.'<br>
     REGULAR SEAT   : '.$regprice.'<br></h2></center>
     <center>
        <a href = "adminpage.php"><button type="submit" class="btn btn-lg btn-primary mt-3"> Back
        </button></a>
      </center>';
     mysqli_close($con);
  }
  /*INSERT SYSTEM TYPE*/

  /*DELETE SYSTEM TYPE FORM*/
  if(!empty($_POST['deletesystemtype']))
  {
    $displaymenu = 0;
    $con = mysqli_connect("localhost","root","","movie");
    $sql = "SELECT DISTINCT TheaterType  FROM seatprice";
    $result = mysqli_query($con,$sql); 
    $systypeop = '
      <div class="container">
      <div class="card mt-5">
      <div class="card-body text-center">
        <form action="adminpage.php" method = "POST">
        <h3 class="text-center text-dark font-weight-bold mb-4">DELETE SYSTEMTYPE FORM</h3>
        <select name="delsystype"><option value = "">--Please choose a SYSTEMTYPE--</option>';
        while($row = mysqli_fetch_array($result)){$systype = $row['TheaterType'];
        $systypeop = $systypeop.'<option value="'.$systype.'">'.$row['TheaterType']."</option>";}
        $systypeop = $systypeop.'</select><br><br>
        <input type="hidden" name="delsystemtype" value="ok">
        <center><button type="submit" class="btn text-white mt-5" style = "background-color: #33b5e5";> DELETE SYSTEMTYPE</button></center>
        </form>
      </div>
      </div>
      <center>
        <a href = "adminpage.php"><button type="submit" class="btn btn-lg btn-outline-primary mt-3">Cancel
        </button></a>
      </center>
      </div>';
    mysqli_close($con);
  }
  /*DELETE SYSTEM TYPE FORM*/

  /*DELETE SYSTEM TYPE*/
  if(!empty($_POST['delsystemtype']))
  {
    $displaymenu = 0;
    if(!empty($_POST['delsystype']))
    {
      $delsys = $_POST['delsystype']; 
      $con = mysqli_connect("localhost","root","","movie");
      $sql = "DELETE FROM seatprice WHERE TheaterType LIKE '$delsys'";
      $result = mysqli_query($con,$sql);
      // if($result){echo("The column has been deleted.");}
      // else{echo("The column has not been deleted.");}
      $sql = "ALTER TABLE movclasssys DROP COLUMN $delsys";
      $result = mysqli_query($con,$sql);
      // if($result){echo("The column has been deleted.");}
      // else{echo("The column has not been deleted.");}
      mysqli_close($con);
    }
  }
  /*DELETE SYSTEM TYPE*/

  /*ALTER TABLE customers DROP email*/

?>
<!-- MANAGE SYSTEM TYPE -->

<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
		<link rel = "stylesheet" href = "style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		
		<title> ADMIN Home </title>


	<!-- advertisement -->
	<style type="text/css">

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
	</head>
<body>
	<!-- Navigation bar -->
 	<nav>
			<ul class = "topnav">
				<li><a href = "homepage.php"> Home </a></li>
				<li><a href = "cinema.php"> Cinemas </a></li>
				<li><a href = "movie.php"> Movies </a></li>
				<li><a href = "member.php"><?php echo $adminname; ?> </a></li>
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
          <form class="form-inline" action="bookingprocess.php" method="POST">
            <select class = "minimal mr-3 ml-5" name = "MovieName" required> 
                <?php echo $MovieName;?>
            </select>
            <div class = "text-white"> At </div>
            <select class = "minimal ml-3" name="Branchnum" required>
                <?php echo $Branch;?>
            </select>
          </form>
      </div>
      <div id = "Right" class = "mt-1">
        <left><button class = "button button1" id="ButtonShowtime"> SHOW TIME</button></left>
      </div>
    </div>
  </div>

<!-- Choosr the choices-->
<div class = "container-fluid" style = "margin-top: 5%;">
  <h1 class = "text-center text-white">HELLO <?php echo $adminname;?></h1>

<?php

if($cor==1&&$displaymenu==1){

/*MAIN ADMIN MENU*/
echo '
    <div class = "container mt-5">
      <div class = "d-flex justify-content-center row" style = "margin-top: 5%;">
        <div class = "row form-inline">
          <div class = "col text-center">
            <form action="member.php" method = "POST">
              <button type="submit" class="btn btn-primary btn-lg">PROFILE</button>
             </form>
          </div>

          <div class = "col text-center">
            <form action="adminpage.php" method = "POST">
              <input type="hidden" name="managebranch" value="ok">
                <button type="submit" class="btn btn-primary btn-lg">BRANCH</button>
            </form>
          </div>

          <div class = "col text-center">
            <form action="adminpage.php" method = "POST">
                <input type="hidden" name="managemovie" value="ok">
              <button type="submit" class="btn btn-primary btn-lg">MOVIE</button>
            </form>
          </div>

          <div class = "col text-center">
            <form action="adminpage.php" method = "POST">
              <input type="hidden" name="managetheater" value="ok">
              <button type="submit" class="btn btn-primary btn-lg">THEATER</button>
            </form>
          </div>

          <div class = "col text-center">
            <form action="adminpage.php" method = "POST">
              <input type="hidden" name="managesytemtype" value="ok">
              <button type="submit" class="btn btn-primary btn-lg">SYSTEMTYPE</button>
            </form>
          </div>

          <div class = "col text-center">
            <form action="analysis.php" method = "POST">
              <input type="hidden" name="managesytemtype" value="ok">
              <button type="submit" class="btn btn-primary btn-lg">ANALYSIS </button>
            </form>
          </div>

        </div>
      </div>
    </div>

  ';

}
  else{
      /*BRANCH MENU*/
      if(!empty($_POST['managebranch']))
        {
          echo $addbranchbtn.'<br>';
          echo $editbranchbtn.'<br>';
          echo $deletebranchbtn.'<br><br>';
          echo $backbtn;
        }
      if(!empty($_POST['addbranch'])){echo $addbranchform;}
      if(!empty($_POST['confirmaddbranch'])){echo $confirmaddbranch;}
      if(!empty($_POST['insertbranch'])){echo'<h2 class="text-white text-center mt-5">'.$resultadd.'</h3>';}
      if(!empty($_POST['editbranch'])){echo $selecteditbranch;}
      if(!empty($_POST['steditbranch'])&&!empty($_POST['branchnum'])){echo $editmenu;} 
      if(!empty($_POST['updatebranch'])){echo $resultupbranch;}
      if(!empty($_POST['deletebranch'])){echo $selectdelbranch;}
      if(!empty($_POST['condelbranch'])){echo $resultdel;}
        /*BRANCH MENU*/

      /*MOVIE MENU*/
      if(!empty($_POST['managemovie']))
      {
          echo $addnewmoviebtn.'<br>';
          echo $editmoviebtn.'<br>';
          echo $deletemoviebtn.'<br><br>';
          echo $addmovieshowtimebtn.'<br>';
          echo $resetallmovieshowtime.'<br><br>';
          echo $backbtn;
      }

      /*ADD NEW MOVIE FORM*/
      if(!empty($_POST['addmovie']))
      {
          echo $addmovieform;
      }
      /*ADD NEW MOVIE FORM*/

      /*ADD NEW MOVIE PROCESS*/
      if(!empty($_POST['insertnewmovie']))
      {
        echo $resultaddnewmovie;
        echo '<br>'.$backbtn;
      }
      /*ADD NEW MOVIE PROCESS*/

      /*EDIT MOVIE HOME*/
      if(!empty($_POST['editmovie']))
      {
        echo $selecteditmovie;
      }
      /*EDIT MOVIE HOME*/

      /*EDIT MOVIE FORM*/
      if(!empty($_POST['editmovieform']))
      {
        echo $editmovieform;
      }
      /*EDIT MOVIE FORM*/

      /*EDIT MOVIE PROCESS*/
        if(!empty($_POST['updatemovie']))
        {

        }
      /*EDIT MOVIE PROCESS*/

      /*DELETE MOVIE FORM*/
      if(!empty($_POST['selectdelmovie']))
      {
        echo  $delmovieform;
      }
      /*DELETE MOVIE FORM*/

      /*DELETE MOVIE PROCESS*/
      if(!empty($_POST['delmovie']))
      {
        echo $resultdelmovie;
      }
      /*DELETE MOVIE PROCESS*/

      /*ADD MOVIE SHOWTIME*/
      if(!empty($_POST['addmovieshowtime']))
      {
        echo $selectbranch;
      }
      /*ADD MOVIE SHOWTIME*/

      /*SELECT THEATER TO ADD MOVIE*/
      if(!empty($_POST['searchfreetheater']))
      {
        echo $selecttheater2addmovie;
        echo '<br><br>'.$backbtn;
      }
      /*SELECT THEATER TO ADD MOVIE*/

       /*SHOW ALL SHOWTIME IN THEATER*/
      if(!empty($_POST['findshowtime'])&&!empty($_POST['branchids'])&&!empty($_POST['theater'])
        &&!empty($_POST['movienames']))
      {
        echo $showallshowtime;
      }

      /*VERIFY SHOWTIME*/
      if(!empty($_POST['verifyshowtime']))
      {
        if(!empty($_POST['showtimes'])&&
        !empty($_POST['branchid'])&&!empty($_POST['theater'])
        &&!empty($_POST['movienames']))
        {
          echo $resultverify;
        }
      }
      /*VERIFY SHOWTIME*/

      /*ADD MOVIE IN SHOWTIME PROCESS*/
      if(!empty($_POST['addmovieinshowtimeprocess']))
      {
        if(!empty($_POST['theater'])&&!empty($_POST['branchid'])
          &&!empty($_POST['movienames'])&&!empty($_POST['showtimes']))
        {
          echo $printaddmovieshowtime;
        }
      }
      /*ADD MOVIE IN SHOWTIME PROCESS*/


      /*MOVIE MENU*/

      /*THEATER MENU*/
      if(!empty($_POST['managetheater']))
        {
          echo $addtheaterbtn.'<br>';
          echo $deletetheaterbtn.'<br>';
          echo $showalltheaterbtn.'<br>';
          echo $resetallseat.'<br><br>';
          echo $backbtn;
        } 

      /*ADD THEATER FORM*/
      if(!empty($_POST['addtheater']))
        {
        echo  $addtheaterform;
        }
      /*ADD THEATER FORM*/

      /*ADD THEATER PROCESS*/
      if(!empty($_POST['createtheater']))
      {
        echo $resultaddtheater;
        echo $backbtn;
      }
      /*ADD THEATER PROCESS*/

      /*DELETE THEATER FORM*/
      if(!empty($_POST['deletetheater']))
      {
        echo $deltheaterform;
        echo '<br>'.$backbtn;
      }
      /*DELETE THEATER FORM*/

      /*SELECT DELETE THEATER*/
      if(!empty($_POST['searchdeltheater']))
      {
       echo $dspyallth;
      }
      /*SELECT DELETE THEATER*/

      /*DELETE THEATER PROCESS*/
      if(!empty($_POST['deltheater']))
      {
        echo $resultdelth;
      }
      /*DELETE THEATER PROCESS*/

      /*SHOW ALL THEATER*/
      if(!empty($_POST['showalltheater']))
      {
      echo $showalltheater;
       echo '<br>'.$backbtn;
      }
      /*SHOW ALL THEATER*/

      /*RESET ALL SEAT*/
      if(!empty($_POST['resetallseat']))
      {
        echo $resetallseat;
      }
      /*RESET ALL SEAT*/

      /*THEATER MENU*/  

      /*SYSTEMTYPE MENU*/  
      if(!empty($_POST['managesytemtype']))
      {
        echo $addsystemtypebtn.'<br>';
        echo $deletesystemtypebtn.'<br><br>';
        echo $backbtn;
      }
      if(!empty($_POST['addsystemtype']))
      {
        echo $addsystemtypeform;
      }
      if(!empty($_POST['insertsystemtype']))
      {
        echo $resultaddsys;
      }

      /*DELETE SYSTEM TYPE FORM*/
      if(!empty($_POST['deletesystemtype']))
      {
        echo $systypeop;
      }
      /*DELETE SYSTEM TYPE FORM*/

      /*SYSTEMTYPE MENU*/
      }
?>
<script  src="index.js"></script>
</body>
</html>
