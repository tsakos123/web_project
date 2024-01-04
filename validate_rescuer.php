<?php

include 'connect.php';

session_start();

$username = $_POST['username'];

$password = $_POST['password'];

$select = "SELECT COUNT(*) as total FROM rescuer WHERE username ='$username' and password ='$password'";

$result = $conn->query($select);

$row = $result->fetch_assoc();

$total = $row['total'];

if($total>0)

{
    $_SESSION['logged']=1;

    $_SESSION['type'] = "rescuer";

    header("Location:home_page_rescuer.php");


}

else

{
    header("Location:index.php");


}





?>