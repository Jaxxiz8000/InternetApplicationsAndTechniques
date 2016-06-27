<?php
error_reporting( ~E_NOTICE);
require_once("core/session.php");
require_once('core/functions/class.user.php');

$auth_user = new USER();

$bookID = $_GET['bookID'];
$bookTitle = $_GET['book_title'];
//$action = $ $_GET['action'];

if($auth_user->deleteProduct($bookID)) {
  $auth_user->redirect('products.php?action=deleted');
} else {
  $errMSG[] = "book failed to delete";
}
 ?>
<?php include 'includes/header-layout.php'; ?>
<?php
if(isset($errMSG))
{
  foreach($errMSG as $error)
  {
     ?>
     <div class="" style="color:#FF0000;">
        <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?>
     </div>
     <?php
  }
}
?>
<?php include 'includes/footer-layout.php'; ?>
