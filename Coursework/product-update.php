<?php
error_reporting( ~E_NOTICE);
require_once("core/session.php");
require_once('core/functions/class.user.php');
//include_once('core/functions/product-functions.php');

$auth_user = new USER();
$results;

if($_SESSION['staff'] != 1) {
  $_SESSION['message'] = "You need to be a staff member to see that!";
  $auth_user->redirect('index.php');
}

$bookTitle = $_GET['book_title'];
$bookID = $_GET['bookID'];

$stmt = $auth_user->retrieveByBookID($bookID, $bookTitle);
$results=$stmt->fetch(PDO::FETCH_ASSOC);

try {
  if(isset($_POST['btn-add-product'])) {

    //$tmp_dir = $_FILES['new_book_image']['tmp_name'];
    //$imgSize = $_FILES['new_book_image']['size'];

    if (empty($_POST['new_book_name'])) {
      $newBookTitle = $results['book_title'];
    } else {
      $newBookTitle = strip_tags($_POST['new_book_name']);
    }
    if (empty($_POST['new_authors'])) {
      $newAuthor = $results['author'];
    } else {
      $newAuthor = strip_tags($_POST['new_authors']);
    }
    if (empty($_POST['new_desc'])) {
      $newBookDescription = $results['book_description'];
    } else {
      $newBookDescription = strip_tags($_POST['new_desc']);
    }
    if (empty($_POST['new_quant'])) {
      $newQuant = $results['quantity'];
    } else {
      $newQuant = strip_tags($_POST['new_quant']);
    }
    if (empty($_POST['new_price'])) {
      $newPrice = $results['price'];
    } else {
      $newPrice = strip_tags($_POST['new_price']);
    }
    if (empty($_FILES['new_book_image']['name'])) {
      $newImage = $results['book_img'];
    } else {
      $imgFile = $_FILES['new_book_image']['name'];
      $tmp_dir = $_FILES['new_book_image']['tmp_name'];
      $imgType = $_FILES['new_book_image']['type'];
    }
    //valid extensions
    $valid_extensions = array('jpeg','jpg','png','gif');
    if(isset($imgType)) {
      if(in_array(end(explode('.', $imgFile)), $valid_extensions)) {
        $newImage = rand(1000,1000000)."-".$imgFile;
      } else {
        $errMSG[] = "Sorry your file needs to be of type png, gif, jpeg or jpg";
      }
    }

    $upload_dir = 'images/user_images/';
    move_uploaded_file($tmp_dir,$upload_dir.$newImage);

    if(!isset($errMSG)) {
      if($auth_user->updateProduct($newBookTitle,$newAuthor,$newBookDescription,$newQuant, $newPrice, $newImage, $bookID)) {
        // $stmt = $auth_user->retrieveByBookID($bookID, $newBookTitle);
        // $results=$stmt->fetch(PDO::FETCH_ASSOC);
        $auth_user->redirect("product.php?bookID={$bookID}&book_title={$newBookTitle}&updated");
      } else {
        $errMSG[] = "Updating failed....";
      }
    }
  }
} catch (Exception $e) {
  $e->getMessage();
}

?>
 <?php include 'includes/header-layout.php';?>
 <form class="" method="post" enctype="multipart/form-data">
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
 <h2>Update a product: <?php if(isset($_SESSION['product-name'])){$productName = $_SESSION['product-name'];echo $productName;} ?> </h2>
 <div class="form-group">
   <h5>You are updating information for: <?php echo $bookTitle ?></h5>
   <input type="text" name="new_book_name" placeholder="Enter Bookname">
 </div>
 <div class="form-group">
   <h5>Current author: <?php echo $results['author'] ?></h5>
   <input type="text" name="new_authors" Placeholder="Enter Authors">
 </div>
 <!-- <div class="form-group">
   <input type="radio" name="catagory-type" value="Fantasy">&nbsp; Fantasy <br>
   <input type="radio" name="catagory-type" value="Crime">&nbsp; Crime
 </div> -->
 <!-- <div class="form-group">
   <input type="text" name="txt_cat_id" placeholder="Catagory ID">
 </div> -->
 <div class="form-group">
   <h5>Current Qty: <?php echo $results['quantity'] ?></h4>
   <input type="text" name="new_quant" placeholder="Enter new quantity">
 </div>
 <div class="form-group">
   <h5>Current price: <?php echo $results['price'] ?></h5>
   <input type="text" name="new_price" placeholder="Enter new product price">
 </div>
 <div class="form-group">
   <textarea name="new_desc" placeholder="Enter new description" rows="8" cols="40"></textarea>
 </div>
 <div class="form-group">
   <h5>Select new image or leave blank if current image is fine</h5>
   <input type="file" name="new_book_image">
 </div>
 <div class="clearfix"></div><hr />
 <div class="form-group">
   <button type="submit" class="btn" name="btn-add-product">
     <i class="glyphicon"> Update</i>
   </button>
 </div>
 </form>
 <?php include 'includes/footer-layout.php'; ?>
