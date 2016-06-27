<?php
error_reporting( ~E_NOTICE);
require_once("core/session.php");
require_once('core/functions/class.user.php');

$auth_user = new USER();

if($_SESSION['staff'] != 1) {
  $_SESSION['message'] = "You need to be a staff member to see that!";
  $auth_user->redirect('index.php');
}

$action = $_GET['action'];

try {
  if(isset($_POST['btn-add-product'])) {
    $bookn = strip_tags($_POST['txt_book_name']);
    $author = strip_tags($_POST['txt_authors']);
    $book_description = strip_tags($_POST['txt_desc']);
    $quant = strip_tags($_POST['txt_quant']);
    $price = strip_tags($_POST['txt_price']);

    $imgFile = $_FILES['book_image']['name'];
    $tmp_dir = $_FILES['book_image']['tmp_name'];
    $imgType = $_FILES['book_image']['type'];


    //valid extensions
    $valid_extensions = array('jpeg','jpg','png','gif');
    if(isset($imgType)) {
      if(in_array(end(explode('.', $imgFile)), $valid_extensions)) {
        $userpic = rand(1000,1000000)."-".$imgFile;
      } else {
        $errMSG[] = "Sorry your file needs to be of type png, gif, jpeg or jpg";
      }
    }

    $upload_dir = 'images/user_images/';
    move_uploaded_file($tmp_dir,$upload_dir.$userpic);

    if(empty($bookn)) {
      $errMSG[] = "Please provide a book title";
    } else if (empty($author)) {
      $errMSG[] = "Please provide an author";
    } else if (empty($book_description)) {
      $errMSG[] = "Please provide a description";
    } else if (empty($quant)) {
      $errMSG[] = "Please provide a quantity";
    } else if (empty($price)) {
      $errMSG[] = "Please provide a price";
    }

    if(!isset($errMSG)){
      if($auth_user->addProduct($bookn,$author,$book_description,$quant,$price,$userpic)) {
          $auth_user->redirect("product-add.php?action=Success");
        }
    } else {
      $errMSG[] = "error while inserting..";
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
  if ($action == "Success") {
    echo "<div class='alert alert-info'>";
      echo "The new book was added!";
    echo "</div>";
    $action = "";
  }
  ?>
<h2>Add a product</h2>
<div class="form-group">
  <input type="text" name="txt_book_name" placeholder="Enter Bookname">
</div>
<div class="form-group">
  <input type="text" name="txt_authors" Placeholder="Enter Authors">
</div>
<!-- <div class="form-group">
  <input type="radio" name="catagory-type" value="Fantasy">&nbsp; Fantasy <br>
  <input type="radio" name="catagory-type" value="Crime">&nbsp; Crime
</div> -->
<!-- <div class="form-group">
  <input type="text" name="txt_cat_id" placeholder="Catagory ID">
</div> -->
<div class="form-group">
  <input type="text" name="txt_quant" placeholder="Enter quantity">
</div>
<div class="form-group">
  <input type="text" name="txt_price" placeholder="Enter product price">
</div>
<div class="form-group">
  <textarea name="txt_desc" placeholder="Enter a description" rows="8" cols="40"></textarea>
</div>
<div class="form-group">
  <input type="file" name="book_image" id="bookIMG">
  <?php if (isset($imgErrMSG)) { ?>
    <div class="" style="color:#FF0000;">
       <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $imgErrMSG; ?>
    </div>
    <?php } ?>
</div>
<div class="clearfix"></div><hr />
<div class="form-group">
  <button type="submit" class="" name="btn-add-product">
    <i class="glyphicon glyphicon-plus">&nbsp;Add product</i>
  </button>
</div>
</form>

<script type="text/javascript" src="Jquery/img-format-check.min.js"></script>
<?php include 'includes/footer-layout.php'; ?>
