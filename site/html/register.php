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

    var_dump($_POST);
    // check a user with the same username already exists
    if (count($db->find_user_by_username($_POST['username'])) > 0) {
        $errors = "User {$_POST['username']} already exists";
    } else {
        // CORRECTION: Check if password matches the password policy
        $pattern = "^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$";
        $preg = preg_match($pattern, $_POST['password'], $matches);
        if($preg == 0 || $preg == false) {
            $errors = "Passwords don't respect the policy";
        }
        // check that both passwords match
        if ($_POST['password'] != $_POST['confirm']) {
            $errors = "Passwords don't match";
        } else {
            $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $db->create_user($_POST['username'], $hash);

            Authorization::redirect('index.php?success=1');
        }
    }

}

require_once('includes/header.php');
?>

<div class="container">
<div class="row align-items-center justify-content-center min-vh-100 gx-0">

    <div class="col-12 col-md-5 col-lg-4">
        <div class="card card-shadow border-0">
            <div class="card-body">
                <form class="row g-6" method="post" action="register.php">
                    <div class="col-12">
                        <div class="text-center">
                            <h3 class="fw-bold mb-2">Sign Up</h3>
                            <p>Follow the easy steps</p>
                        </div>
                    </div>
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger" role="alert">
                            <?= $errors ?>
                        </div>
                    <?php endif; ?>
                    <div class="col-12">
                        <div class="form-floating">
                            <input name="username" type="text" class="form-control" id="username" placeholder="Username">
                            <label for="username">Username</label>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-floating">
                            <input name="password" type="password" class="form-control" id="password" placeholder="Password">
                            <label for="password">Password</label>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-floating">
                            <input name="confirm" type="password" class="form-control" id="confirm" placeholder="Confirm Password">
                            <label for="confirm">Confirm Password</label>
                        </div>
                    </div>

                    <div class="col-12">
                        <button class="btn btn-block btn-lg btn-primary w-100" type="submit">Create Account</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Text -->
        <div class="text-center mt-8">
            <p>Already have an account? <a href="index.php">Sign in</a></p>
        </div>

    </div>
</div> <!-- / .row -->
</div>
<?php
require_once('includes/footer.php');