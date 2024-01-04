<?php 

include 'connect.php';

session_start();


$username = $_POST['username'];

$password = $_POST['password'];

$select = "SELECT COUNT(*) as total FROM civilian WHERE username ='$username' and password ='$password'";

$result = $conn->query($select);

$row = $result->fetch_assoc();

$total = $row['total'];

if($total>0)
	
	{
		$_SESSION["logged"]=1;
		
		$_SESSION['user'] = $username;
		
		$_SESSION['type'] = "civilian";
		
		header("Location:home_page_civilian.php");
		
		
	}
	
else
	
	{
		header("Location:index.php");
		
		
	}





?>