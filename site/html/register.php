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

    var_dump($_POST);
    // check a user with the same username already exists
    if (count($db->find_user_by_username($_POST['username'])) > 0) {
        $errors = "User {$_POST['username']} already exists";
    } else {
        // check that both passwords match
        if ($_POST['password'] != $_POST['confirm']) {
            $errors = "Passwords don't match";
        } else {
            $hash = md5($_POST['password']);
            $db->create_user($_POST['username'], $hash, $_POST['role']);

            Authorization::redirect('index.php?success=1');
        }
    }

}

require_once('includes/header.php');
require_once('includes/nav.php');
?>

<section class="vh-100 gradient-custom">
    <div class="container py-5 h-100">
        <div class="row justify-content-center align-items-center h-100">
            <div class="col-12 col-lg-9 col-xl-7">
                <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                    <div class="card-body p-4 p-md-5">
                        <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Registration Form</h3>
                        <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger" role="alert">
                            <?= $errors ?>
                        </div>
                        <?php endif; ?>
                        <form action="register.php" method="post">
                            <div class="form-outline mb-4">
                                <input name="username" type="text" id="username" class="form-control form-control-lg" />
                                <label class="form-label" for="username">Username</label>
                            </div>

                            <div class="form-outline mb-4">
                                <input name="password" type="password" id="password" class="form-control form-control-lg" />
                                <label class="form-label" for="password">Password</label>
                            </div>
                            <div class="form-outline mb-4">
                                <input name="confirm" type="password" id="confirm" class="form-control form-control-lg" />
                                <label class="form-label" for="confirm">Confirm Password</label>
                            </div>
                            <input type="hidden" name="role" value="<?= Authorization::EMPLOYEE ?>">
                            <div class="mt-4 pt-2">
                                <button name="register" class="btn btn-primary btn-lg" type="submit">Register</button>
                            </div>
                        </form>
                        <hr class="my-4">
                        <p class="mb-0">Already have an account? <a href="index.php" class="text-dark fw-bold">Sign in</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
require_once('includes/footer.php');