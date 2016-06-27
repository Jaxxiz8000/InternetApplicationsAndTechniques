
<?php
error_reporting( ~E_NOTICE);
require_once("core/session.php");
require_once('core/functions/class.user.php');

$auth_user = new USER();


if($_SESSION['staff'] != 1) {
  $_SESSION['message'] = "You need to be a staff member to see that!";
  $auth_user->redirect('index.php');
}

$sql = "SELECT * FROM approve_cart";
$stmt =$auth_user->runQuery($sql);
$stmt->execute();

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($results) > 0) {
  $uids = "";
  foreach ($results as $row) {
    $uids = $uids . $row['userID'] . ',';
  }

  $uids = rtrim($uids, ',');

  $sql = "SELECT user_id, user_name FROM users WHERE user_id IN($uids)";
  $stmt = $auth_user->runQuery($sql);
  $stmt->execute();

  $usernames = $stmt->fetchAll(PDO::FETCH_ASSOC);

  if(isset($_GET['bookIDS'])) {
    $bookIDS = $_GET['bookIDS'];
  }

  if(isset($_GET['action'])) {
    $action = $_GET['action'];
  }
} else {
  $msg = "No items for approval";
}
?>
<?php include('includes/header-layout.php'); ?>
<?php if (!$msg): ?>
  <table class="table">
    <tr>
      <th>
        User
      </th>
    </tr>
    <?php foreach ($usernames as $name): ?>
    <tr>
      <td>
        <?php echo $name['user_name']; ?>
      </td>
      <td>
        <a href="staff-show-cart.php?userid=<?php echo $name['user_id']; ?>">View Items</a>
      </td>
    </tr>
    <?php endforeach; ?>
  </table>
  <?php else: ?>
    <?php echo $msg; ?>
<?php endif; ?>
<?php include 'includes/footer-layout.php'; ?>
