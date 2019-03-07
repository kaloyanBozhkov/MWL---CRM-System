<?php
require('mySqlConnect.php');
$username = mysqli_real_escape_string($link, $_POST['username']);
$password = mysqli_real_escape_string($link, $_POST['password']);

$where = "administrators";

$sql = "SELECT * FROM ".$where." WHERE username = '" . $username . "' AND password = '" . $password . "';";
$result = mysqli_query($link, $sql);
$number = mysqli_num_rows($result);
if ($number != 0) {	
	$row = mysqli_fetch_array($result);

		$_SESSION['adminLogged'] = true;
		$_SESSION['adminDetails'] = new stdClass(); //Objects in PHP need a class, but the new stdClass() lets you start quickly without the class {...} jazz. 
		$_SESSION['adminDetails']->username = $row['username'];
		$_SESSION['adminDetails']->password = $row['password'];
		$_SESSION['adminDetails']->email = $row['emailAddress'];
		$_SESSION['adminDetails']->id = $row['administratorId'];

	echo(0);	
}else{
	echo(1);
}
?>

