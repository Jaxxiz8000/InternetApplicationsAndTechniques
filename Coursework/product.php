<?php
error_reporting( ~E_NOTICE);

require_once("core/session.php");
require_once('core/functions/class.user.php');


$auth_user = new USER();

$bookTitle = $_GET['book_title'];
$bookID = $_GET['bookID'];

//TODO: Wrap in try, catch.
$stmt = $auth_user->runQuery("SELECT * FROM books WHERE book_title=:bookT AND bookID=:bookid");
$stmt->bindparam('bookT', $bookTitle);
$stmt->bindparam('bookid', $bookID);
$stmt->execute();
$results=$stmt->fetch(PDO::FETCH_ASSOC);


 ?>
<?php include 'includes/header-layout.php'; ?>
<?php if($_SESSION['staff'] == 1) {include_once('includes/nav-bars/staff-nav-bar.php');} ?>
<img src="images/user_images/<?php echo $results['book_img'] ?>" alt="" style="width:250px"/>
<ul>
  <div class="">
    <li><?php echo $results['book_title']; ?></li>
    <li><?php echo $results['book_description'] ?></li>
  </div>
</ul>
<?php include 'includes/footer-layout.php'; ?>
