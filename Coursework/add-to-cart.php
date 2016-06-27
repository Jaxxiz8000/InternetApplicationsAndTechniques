<?php
error_reporting( ~E_NOTICE);
require_once("core/session.php");
require_once('core/functions/class.user.php');

$auth_user = new USER();

$bookID = $_GET['bookID'];
$bookTitle = $_GET['book_title'];

if (empty($_SESSION['cart'])) {
  $_SESSION['cart'] = array();
}

if(array_key_exists($bookID, $_SESSION['cart'])) {
  $auth_user->redirect("products.php?action=exists&bookID=".$bookID."&book_title=".$bookTitle);
} else {
  $_SESSION['cart'][$bookID]=$bookTitle;

  $auth_user->updateBookQuantityMinus($bookID);

  $auth_user->redirect("products.php?action=added&bookID=".$bookID."&book_title=".$bookTitle);
}

?>
