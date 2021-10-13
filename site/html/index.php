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
    Authorization::redirect('mailbox.php');

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
            Authorization::redirect('mailbox.php');
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
require_once('includes/nav.php');
?>

<section class="vh-100">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card shadow-2-strong">
          <div class="card-body p-5">

            <h3 class="mb-5">Sign in</h3>
            <?php if (!empty($errors)): ?>
            <?= $errors ?>
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

            Register
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php
require_once('includes/footer.php');