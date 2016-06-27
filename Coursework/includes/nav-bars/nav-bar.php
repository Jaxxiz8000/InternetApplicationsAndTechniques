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
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="index.php" class="glyphicon glyphicon-home"></a></li>
            <li><a href="profile.php">Profile</a></li>
            <li><a href="products.php">Catalog</a></li>
            <li><a href="show-cart.php" class=""><?php $cart_count=count($_SESSION['cart']); ?>Cart <span class="badge" id="comparison-count"><?php echo $cart_count; ?></span> </a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <?php if($auth_user->is_loggedin())
            { ?>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
			  <span class="glyphicon glyphicon-user"></span>&nbsp; <?php print($userRow['user_name']); ?>&nbsp;<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="profile.php"><span class="glyphicon glyphicon-user"></span>&nbsp;View Profile</a></li>

                <li><a href="logout.php?logout=true"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out</a></li>
              </ul>
            </li>
            <?php } else { ?>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                <span class="glyphicon glyphicon-user"></span>&nbsp;Log In&nbsp;<span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <form class="dropdown-form-signin" id="login-form-dropdown" action="login.php" method="post">
                    <div id="error">
                    <?php
                      if(isset($error))
                      {
                        ?>
                        <div class="alert alert-danger">
                           <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?> !
                        </div>
                        <?php
                      }
                      ?>
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control" name="txt_uname_email" placeholder="Username or E mail ID"  />
                      <hr />
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control" name="txt_password" placeholder="Your Password" />
                      <hr />
                    </div>
                    <div class="form-group btn-wrapper">
                      <button type="submit" name="btn-login" class="btn btn-default btn-dropdown">
                            <i class="glyphicon glyphicon-log-in"></i> &nbsp; SIGN IN
                      </button>
                    </div>
                    <div class="dropdown-register-link">
                      <label>Don't have account yet? </label><br>
                    </div>
                    <div class="sign-up-link-wrapper">
                      <a href="sign-up.php">Sign Up</a>
                    </div>
                  </form>
                </ul>
              </li>
              <?php } ?>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
