<?php
error_reporting( ~E_NOTICE);
require_once("core/session.php");
require_once('core/functions/class.user.php');

$auth_user = new USER();
$userID = $_SESSION['user_session'];
$cost = $_GET['cost'];

if(!empty($_SESSION['cart'])) {
  $ids = "";
  foreach ($_SESSION['cart'] as $id => $value) {
    $ids = $ids . $id . ",";
  }
  $ids = rtrim($ids, ',');

  $checkUserID = $auth_user->runQuery("SELECT * FROM approve_cart WHERE userID=:uid");
  $checkUserID->bindparam('uid', $userID);
  $checkUserID->execute();

  $result = $checkUserID->fetchAll(PDO::FETCH_ASSOC);

  if(count($result) == 0) {
    $sql = "INSERT INTO approve_cart(userID, bookIDS, Cost)VALUES(:userid, :bookids, :cost)";
    $stmt = $auth_user->runQuery($sql);
    $stmt->bindparam(':userid', $userID);
    $stmt->bindparam(':bookids', $ids);
    $stmt->bindparam(':cost', $cost);

    $stmt->execute();

    $auth_user->redirect('index.php?action=approval');
  } else {
    $auth_user->redirect('show-cart.php?action=alsent');
  }
}

 ?>
