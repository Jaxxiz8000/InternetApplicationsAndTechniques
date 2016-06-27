<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
<script type="text/javascript" src="JS/Jquery/jquery-1.11.3-jquery.min.js"></script>
<link rel="stylesheet" href="css/style.css" type="text/css"  />
<?php if($auth_user->is_loggedin())
{ ?>
<title>
	<?php echo isset($page_title) ? "welcome - " . $page_title : "Welcome to our site!"; ?>
</title>
<?php } else { ?>
	<title>Welcome to our site!</title>
	<?php } ?>
</head>

<body>
	<?php if($_SESSION['staff'] == 1) {include("nav-bars/staff-nav-bar.php");} else { include("nav-bars/nav-bar.php");} ?>
	<div class="clearfix"></div>

<div class="container-fluid" style="margin-top:80px;">

    <div class="container">
