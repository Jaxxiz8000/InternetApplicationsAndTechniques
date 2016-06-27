<?php

	require_once("core/session.php");

	require_once('core/functions/class.user.php');
	$auth_user = new USER();


	$user_id = $_SESSION['user_session'];
	$stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));

	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

	$page_title = $userRow['user_name'];

?>
<?php include 'includes/header-layout.php'; ?>
    	<label class="h5"> <?php print($userRow['user_name']); ?></label>
        <hr />


        <p class="h4">Another Secure Profile Page</p>

<?php include 'includes/footer-layout.php'; ?>
