<?php

	//require_once("core/session.php");
	session_start();
	require_once('core/functions/class.user.php');
	$auth_user = new USER();


	$user_id = $_SESSION['user_session'];

	$stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));

	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

	$page_title = $userRow['user_email'];




?>
<?php include 'includes/header-layout.php'; ?>
	<?php if($auth_user->is_loggedin())
			{ ?>
    	<label class="h5">welcome : <?php print($userRow['user_name']); ?></label>
			<?php 	if($_SESSION['message']) {
					$message = $_SESSION['message'];
					echo "<strong>". $message . "</strong>";
					$_SESSION['message'] = "";
				} ?>
			<?php } else { ?>
				<label class="h5">Welcome we hope you enjoy our site. If you have an account please <a href="login.php">Log in</a> if not please
				<a href="sign-up.php">register!</a></label>
				<?php } ?>
        <hr />


        <!-- <h1>
        <a href="home.php"><span class="glyphicon glyphicon-home"></span> home</a> &nbsp;
        <a href="profile.php"><span class="glyphicon glyphicon-user"></span> profile</a></h1>
       	<hr /> -->

        <p class="h4">User Home Page</p>
				<p>
					<a href="products.php">View our catalog of books!</a>
				</p>

<?php include 'includes/footer-layout.php'; ?>
