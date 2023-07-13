<?php
// database connection code
// $con = mysqli_connect('localhost', 'database_user', 'database_password','database');

$con = mysqli_connect('localhost', 'root', '','signup');

// get the post records
$Name = $_POST['email'];
$Email= $_POST['password'];

// database insert SQL code
$sql = "INSERT INTO `content` (`email`, `password`) VALUES (`email`, `password`)";

// insert in database 
$rs = mysqli_query($con, $sql);

if($rs)
{
	echo "Signed In Successful";
}

?>