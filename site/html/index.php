<?php
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

require_once('database.php');
require_once('authorization.php');

use Messenger\Authorization;
use Messenger\Database;

session_start();

if (Authorization::checkSession())
    Authorization::redirect('inbox.php');

if (!empty($_POST)) {
    $db = new Database();

    // find the user from the database
    $result = $db->find_user_by_username($_POST['username']);

    // check if the user exists
    if (count($result) > 0) {
        // check if the correct password was given
        if (md5($_POST['password']) == $result[0]['password']) {
            // success! redirect to mail box
            $_SESSION['id'] = $result[0]['id'];
            Authorization::redirect('inbox.php');
        } else {
            // password mismatch :sadcat:
            $errors = "Wrong password";
        }
    } else {
        // nope, new error
        $errors = "User {$_POST['username']} doesn't exist";
    }
}

require_once('includes/header.php');

?>

<div class="container">
    <div class="row align-items-center justify-content-center min-vh-100 gx-0">
        <div class="col-12 col-md-5 col-lg-4">
            <div class="card card-shadow border-0">
                <div class="card-body">
                    <form class="row g-6" action="index.php" method="post">
                        <div class="col-12">
                            <div class="text-center">
                                <h3 class="fw-bold mb-2">Sign In</h3>
                                <p>Login to your account</p>
                            </div>
                        </div>
                        <?php if (!empty($errors)): ?>
                            <div class="alert alert-danger" role="alert">
                                <?= $errors ?>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($_GET['success'])): ?>
                            <div class="alert alert-success" role="alert">
                                Your account was successfully created!
                            </div>
                        <?php endif; ?>
                        <div class="col-12">
                            <div class="form-floating">
                                <input name="username" type="text" class="form-control" id="signin-email" placeholder="Username">
                                <label for="signin-email">Username</label>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-floating">
                                <input name="password" type="password" class="form-control" id="signin-password" placeholder="Password">
                                <label for="signin-password">Password</label>
                            </div>
                        </div>

                        <div class="col-12">
                            <button class="btn btn-block btn-lg btn-primary w-100" type="submit">Sign In</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Text -->
            <div class="text-center mt-8">
                <p>Don't have an account yet? <a href="register.php">Sign up</a></p>
            </div>
        </div>
    </div> <!-- / .row -->
</div>

<!--
<section class="vh-100">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card shadow-2-strong">
          <div class="card-body p-5">

            <h3 class="mb-5">Sign in</h3>
            <?php if (!empty($errors)): ?>
            <div class="alert alert-danger" role="alert">
                <?= $errors ?>
            </div>
            <?php endif; ?>
            <?php if (!empty($_GET['success'])): ?>
              <div class="alert alert-success" role="alert">
                  Your account was successfully created!
              </div>
            <?php endif; ?>
            <form action="index.php" method="post">
                <div class="form-outline mb-4">
                    <input name="username" type="text" id="username" class="form-control form-control-lg" />
                    <label class="form-label" for="username">Username</label>
                </div>

                <div class="form-outline mb-4">
                    <input name="password" type="password" id="password" class="form-control form-control-lg" />
                    <label class="form-label" for="password">Password</label>
                </div>

                <button name="login" class="btn btn-primary btn-lg btn-block" type="submit">Login</button>
            </form>
            <hr class="my-4">
            <p class="mb-0">Don't have an account? <a href="register.php" class="text-dark fw-bold">Sign Up</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
-->
<?php
require_once('includes/footer.php');