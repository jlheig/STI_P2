<?php
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

require_once('database.php');
require_once('authorization.php');


use Messenger\Authorization;
use Messenger\Database;

session_start();

include_once __DIR__ .'/libraries/CSRF-Protector-PHP/libs/csrf/csrfprotector.php';

//Initialise CSRFGuard library
csrfProtector::init();

if (Authorization::checkSession())
    Authorization::redirect('inbox.php');

if (!empty($_POST)) {
    $db = new Database();

    // find the user from the database  -> VULNERABILITY SQL injections
    // CORRECTION : escaping de l'input dans database.php
    $result = $db->find_user_by_username($_POST['username']); 


    // check if the user exists
    if (count($result) > 0) {
        // NOTE : not vulnerable to SQL injections because no proper SQL request is being made
        // check if the correct password was given
        if (password_verify($_POST['password'], $result[0]['password'])) {
            // success! redirect to mail box
            $_SESSION['id'] = $result[0]['id'];
            Authorization::redirect('inbox.php');
        } else {
            // CORRECTION : same error message
            $errors = "Wrong credentials";
        }
    } else {
        // CORRECTION : same error message
        $errors = "Wrong credentials";
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
                        
                        <div class="g-recaptcha" data-sitekey="6LeRlCceAAAAADFSqQlgpwy0JbKMmzoQhH1P4p3c"></div>


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


<?php
require_once('includes/footer.php');