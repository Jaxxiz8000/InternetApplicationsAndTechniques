<?php
require_once("core/session.php");
require_once('core/functions/class.user.php');

$auth_user = new USER();

$action = $_GET['action'];
$bookTitle = $_GET['book_title'];
$total_price = 0;

if(count($_SESSION['cart']) > 0) {
  $ids = "";
  foreach ($_SESSION['cart'] as $id => $value) {
    $ids = $ids . $id . ",";
  }
  $ids = rtrim($ids, ',');
  $sql = "SELECT bookID, book_title, price FROM books WHERE bookID IN($ids)";
  echo $sql;
  $stmt = $auth_user->runQuery($sql);
  $stmt->execute();
  $total_price = 0;

  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
}


?>
<?php include 'includes/header-layout.php'; ?>
<?php if($action=='removed') {
  echo "<div class='alert alert-info'>";
    echo "<strong>{$bookTitle}</strong> was removed from your cart!";
  echo "</div>";
} ?>
<?php if(count($_SESSION['cart']) > 0) { ?>
<table class="table">
  <tr>
    <th>Book Title</th>
    <th>Price</th>
    <th>
      <?php  foreach ($results as $price) { $cost +=$price['price']; }  ?>
      <a href="approve-cart.php?cost=<?php echo $cost; ?>" class="btn" style="color:blue;">Send for Approval</a>
    </th>
  </tr>
  <?php foreach ($results as $row) {
    ?>
    <tr>
      <td>
        <?php echo $row['book_title']; ?>
      </td>
      <td>
        &pound;<?php echo $row['price']; ?>
      </td>
      <td>
        <a href="remove-from-cart.php?bookID=<?php echo $row['bookID'] ?>&book_title=<?php echo $row['book_title'] ?>" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span>Remove from cart</a>
      </td>
    </tr>
    <?php $total_price+=$row['price'];
  } ?>
  <tr>
    <td></td>
    <td>
      Total: &pound;<?php echo $total_price; ?>
    </td>
  </tr>
</table>
<?php } else {
  echo "<strong>No books found!</strong>";
    echo "<br>";
    echo "<a href='products.php'>Return to book catalog</a>";
} ?>
<?php include 'includes/footer-layout.php'; ?>
