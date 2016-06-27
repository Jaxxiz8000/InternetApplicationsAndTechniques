<?php
require_once("core/session.php");
require_once('core/functions/class.user.php');

$auth_user = new USER();
$bookID = $_GET['bookID'];
$bookTitle = $_GET['book_title'];

unset($_SESSION['cart'][$bookID]);

$auth_user->redirect("show-cart.php?action=removed&bookID=".$bookID."&book_title=".$bookTitle);
$auth_user->updateBookQuantityPlus($bookID);

 ?>
