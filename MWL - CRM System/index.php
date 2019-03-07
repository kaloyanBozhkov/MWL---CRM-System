<?php 
session_start();
if(isset($_SESSION['adminLogged']) && $_SESSION['adminLogged'] == true){
	header('Location: dashboard.php');
}

$_SESSION['loginSection'] = "admin";
?>
<!DOCTYPE HTML>
<html lang='en-US'>
<head>
	<title>MWL - Login</title>
	<!-- OTHER -->
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name="description" content="CRM system used to store information about customers.">
	<meta name="keywords" content="MWL exercise">
	<meta name="author" content="Kaloyan Bozhkov">	
	<meta name="robots" content="index, follow">	
	<!-- Google Fonts - Comfortaa  && icons -->
	<link href="https://fonts.googleapis.com/css?family=Comfortaa&amp;subset=cyrillic,cyrillic-ext,greek,latin-ext,vietnamese" rel="stylesheet">
	
	<!-- CSS -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
	<link rel="stylesheet" href="assets/css/styles.css" />
    <link rel="stylesheet" href="assets/css/material-dashboard.css" />
    <link rel="stylesheet" href="assets/templates/prompt/style.css" />
	<?php require('assets/templates/loginForm/head.php'); ?>	
</head>
<body>

<!-- LOGIN FORM -->
<?php require('assets/templates/loginForm/body.php'); ?>

<!-- MODAL PROMPT -->
<?php require('assets/templates/prompt/prompt.php') ?>

<!-- MODAL PROMPT JS FUNCTIONALITY -->
<script src="assets/templates/prompt/functionality.js" type="text/javascript"></script>
<script>


	
$(document).on('click', '#alert #ok', function(){
	
	if(window.GLOBAL_goToWhere.length !== 0){
		window.location = window.GLOBAL_goToWhere;
	}
	
});

</script>
</body>
</html>