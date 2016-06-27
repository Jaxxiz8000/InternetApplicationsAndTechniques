<?php
require_once("core/session.php");

require_once('core/functions/class.user.php');
$auth_user = new USER();


$user_id = $_SESSION['user_session'];

$stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:user_id");
$stmt->execute(array(":user_id"=>$user_id));

$userRow=$stmt->fetch(PDO::FETCH_ASSOC);


?>
<nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="">Name of Site!</a>
        </div>
        <?php if ($auth_user->is_loggedin() && $_SESSION['staff'] == 1): ?>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li class="active"><a href="index.php" class="glyphicon glyphicon-home"></a></li>
              <li><a href="products.php">Manage Books</a></li>
              <li><a href="awaiting-approval.php">Approvals</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
          <span class="glyphicon glyphicon-user"></span>&nbsp; <?php print($userRow['user_name']); ?>&nbsp;<span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="profile.php"><span class="glyphicon glyphicon-user"></span>&nbsp;View Profile</a></li>

                  <li><a href="logout.php?logout=true"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out</a></li>
                </ul>
              </li>
        <?php endif; ?>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
