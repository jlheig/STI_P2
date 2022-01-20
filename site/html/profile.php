<?php
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

require_once('database.php');
require_once('authorization.php');

session_start();

include_once __DIR__ .'/libraries/CSRF-Protector-PHP/libs/csrf/csrfprotector.php';

//Initialise CSRFGuard library
csrfProtector::init();

use Messenger\Authorization;
use Messenger\Database;

if (!Authorization::access())
    Authorization::redirect();


if (!empty($_POST)) {
    $db = new Database();

    $passwd = $_POST['password'];
    $newpasswd = $_POST['new_password'];
    $confirmpasswd = $_POST['confirm_password'];

    // find the user from the database
    $user = $db->find_user_by_id($_SESSION['id']);

    if (md5($passwd) != $user['password']) {
        $errors = "Invalid password";
    } else {
        if ($newpasswd != $confirmpasswd) {
            $errors = "Passwords don't match";
        } else {
            $db->update_password_by_id($user['id'], md5($newpasswd));
            $success = "Password successfully changed!";
        }
    }
}
require_once('database.php');
require_once('authorization.php');

if (!Authorization::access())
    Authorization::redirect();
$db = new Database();

require_once('includes/header.php');
?>
<?php include 'includes/nav.php' ?>

<main class="main is-visible" data-dropzone-area="">
    <div class="container">
        <div class="row align-items-center justify-content-center min-vh-100 gx-0">
            <form class="row g-6" method="post" action="profile.php">
                <div class="col-12">
                    <div class="text-center">
                        <h3 class="fw-bold mb-2">Change password</h3>
                    </div>
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger" role="alert">
                            <?= $errors ?>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($success)): ?>
                        <div class="alert alert-success" role="alert">
                            <?= $success ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="form-floating mb-4">
                    <input name="password" type="password" id="password" class="form-control form-control-lg" placeholder="Old password"/>
                    <label for="password">Current Password</label>
                </div>
                <div class="form-floating mb-4">
                    <input name="new_password" type="password" id="new_password" class="form-control form-control-lg" placeholder="New password"/>
                    <label for="new_password">New Password</label>
                </div>
                <div class="form-floating mb-4">
                    <input name="confirm_password" type="password" id="confirm_password" class="form-control form-control-lg" placeholder="Confirm password" />
                    <label for="confirm_password">Confirm Password</label>
                </div>

                <button name="save" class="btn btn-primary btn-lg btn-block" type="submit">Save</button>
            </form>

            <a href="logout.php" class="btn btn-danger btn-lg btn-block">Logout</a>
        </div> <!-- / .row -->
    </div>
</main>

<?php
require_once('includes/footer.php');
