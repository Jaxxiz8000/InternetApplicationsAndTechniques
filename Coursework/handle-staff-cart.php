<?php
require_once("core/session.php");
require_once('core/functions/class.user.php');

$auth_user = new USER();

$action = $_GET['action'];
$uid = $_GET['userid'];
$cost = $_GET['cost'];
$bookIDS = $_GET['bookIDS'];



if($action == 'approved') {
  $userSQL = "SELECT user_balance FROM users WHERE user_id=:uid";
  $ustmt = $auth_user->runQuery($userSQL);
  $ustmt->bindparam('uid', $uid);

  $ustmt->execute();

  $balance = $ustmt->fetch();

  if($cost <= $balance['user_balance']) {
    $newBalance = $balance['user_balance'] - $cost;
  } else {
    $auth_user->redirect('awaiting-approval.php?action=pfailed');
  }

  $updateSQL = "UPDATE users SET user_balance=:ubance WHERE user_id=:uid";
  $stm = $auth_user->runQuery($updateSQL);
  $stm->bindparam('ubance', $newBalance);
  $stm->bindparam('uid', $uid);
  $stm->execute();
  
  $delete = $auth_user->runQuery("DELETE FROM approve_cart WHERE userID=:uid");
  $delete->bindparam('uid', $uid);
  $delete->execute();

  $auth_user->redirect('awaiting-approval.php?action=approved');

} else if ($action == 'rejected') {

  $rejSQL = "UPDATE books SET quantity = quantity + 1 WHERE bookID IN($bookIDS)";
  $st = $auth_user->runQuery($rejSQL);
  $st->execute();

  $delete = $auth_user->runQuery("DELETE FROM approve_cart WHERE userID=:uid");
  $delete->bindparam('uid', $uid);
  $delete->execute();

  $auth_user->redirect('awaiting-approval.php');
}

 ?>
