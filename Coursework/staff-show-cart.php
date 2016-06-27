<?php
require_once("core/session.php");
require_once('core/functions/class.user.php');

$auth_user = new USER();

if($_SESSION['staff'] != 1) {
  $_SESSION['message'] = "You need to be a staff member to see that!";
  $auth_user->redirect('index.php');
}

$uid = $_GET['userid'];

$sql = "SELECT bookIDS, cost FROM approve_cart WHERE userID=:uid";
$stmt = $auth_user->runQuery($sql);
$stmt->bindparam('uid', $uid);
$stmt->execute();

$result = $stmt->fetch();

$ids = $result['bookIDS'];

$cartSql = "SELECT bookID, book_title, price FROM books WHERE bookID IN($ids)";
$stm = $auth_user->runQuery($cartSql);
$stm->execute();

$results = $stm->fetchAll(PDO::FETCH_ASSOC);

$userSQL = "SELECT user_balance FROM users WHERE user_id=:uid";
$ustmt = $auth_user->runQuery($userSQL);
$ustmt->bindparam('uid', $uid);

$ustmt->execute();

$balance = $ustmt->fetch();

?>
<?php include 'includes/header-layout.php'; ?>
<?php if(count($results) > 0) { ?>
<table class="table">
  <tr>
    <th>Book Title</th>
    <th></th>
  </tr>
  <?php foreach ($results as $row): ?>
    <tr>
      <td>
        <?php echo $row['book_title']; ?>
      </td>
        <?php endforeach; ?>
    </tr>
</table>
<p>
  <strong>Cost: </strong>&pound;<?php echo $result['cost']; ?>
  <br>
  <strong>User Balance: </strong>&pound;<?php echo $balance['user_balance']; ?>
</p>
<a href="handle-staff-cart.php?action=approved&userid=<?php echo $uid ?>&cost=<?php echo $result['cost']; ?>">Approve</a> <br><br>
<a href="handle-staff-cart.php?action=rejected&bookIDS=<?php echo $ids ?>&userid=<?php echo $uid ?>">Reject</a>
<?php } else {
  echo "<strong>No books found!</strong>";
    echo "<br>";
    echo "<a href='products.php'>Return to book catalog</a>";
  } ?>
<?php include 'includes/footer-layout.php'; ?>
