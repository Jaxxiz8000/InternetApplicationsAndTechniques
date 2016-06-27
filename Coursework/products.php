<script type="text/javascript">
  function delete_id(id) {
    if(confirm('Sure to remove this record?')) {
      window.location.href='product-delete.php?bookID='+id;
    }
  }
</script>
<?php

require_once("core/session.php");

require_once('core/functions/class.user.php');

$auth_user = new USER();

$bookID = $_GET['bookID'];
$bookTitle = $_GET['book_title'];
$action = $_GET['action'];

$user_id = $_SESSION['user_session'];
$stmt = $auth_user->runQuery("SELECT * FROM books");
$stmt->execute();

$results=$stmt->fetchAll(PDO::FETCH_ASSOC);

$page_title = $userRow['user_name'];
?>
<?php include 'includes/header-layout.php'; ?>
<!-- <?php if ($_SESSION['staff'] == 1): ?>
  <nav class="nav-bar">
    <ul class="nav navbar-nav">
      <li><a href="product-add.php">Add new book</a></li>
    </ul>
  </nav>
<?php endif; ?> -->
<?php
 if($action=='added') { ?>
  <div class="alert alert-info">
    <strong><?php echo $bookTitle ?></strong> was added to your cart!
  </div>
<?php  } ?>
<?php
 if($action=='exists') { ?>
  <div class="alert alert-info">
    <strong><?php echo $bookTitle ?></strong> already exists in your cart!
  </div>
<?php  } ?>
<?php if($action=='deleted'){ ?>
  <div class="alert alert-info">
    Book was removed from the catalog!
  </div>
<?php } ?>
<table class="table">
<tr>
  <th>Book Title</th>
  <th>Author</th>
  <th>Description</th>
  <th>Qty</th>
  <th>Price</th>
  <th></th>
  <th><?php if ($_SESSION['staff'] != 1): ?>
    <a href="show-cart.php">Go to Cart!</a>
    <?php else: ?>
      <div class="btn">
        <a href="product-add.php">Add new book</a>
      </div>
  <?php endif; ?>
  </th>
</tr>
<?php foreach( $results as $row ){
echo "<tr><td>"; ?>
  <a href="product.php?bookID=<?php echo $row['bookID']?>&book_title=<?php echo $row['book_title'] ?>"><?php echo $row['book_title'] ?></a>
  <?php
  echo "</td><td>";
  echo $row['author'];
  echo "</td><td>";
  echo $row['book_description'];
  echo "</td><td>";
  echo $row['quantity'];
  echo "</td><td>";
  echo "&pound;" . $row['price'];
  echo "</td><td>";
  ?>
  <img src="images/user_images/<?php echo $row['book_img'] ?>" alt="" />
  <?php
  echo "</td><td>";
    ?>
    <?php

    if($_SESSION['staff'] == 1) { ?>
      <a href="product-update.php?bookID=<?php echo $row['bookID'] ?>&book_title=<?php echo $row['book_title'] ?>"class="btn">Update</a>
      <br>
      <a href="javascript:delete_id(<?php echo $row['bookID']; ?>)" class="btn">Delete</a>
    <?php } else { ?>
      <a href="add-to-cart.php?bookID=<?php echo $row['bookID'] ?>&book_title=<?php echo $row['book_title'] ?>">Add to Cart</a>
      <?php } ?>
    <?php
  echo "</td>";
echo "</tr>";
}
?>
</table>

<?php include 'includes/footer-layout.php'; ?>
