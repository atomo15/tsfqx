
<?php
    $emaillog = $_POST['identify'];
    $con = mysqli_connect("localhost","root","","movie");
    $sql="INSERT INTO log_login(email,status,typelogout)
            VALUES ('$emaillog', '0','MANUAL')";
    if(!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
    header("refresh: 0; url = http://localhost:8080/projectv2/member.php");
?>
