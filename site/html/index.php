<?php
    require_once('database.php');
    require_once('authorization.php');

    if (Authorization::checkSession()) 
        Authorization::redirect('mailbox.php');

    session_start();
    if (!empty($_POST)) {
        $db = new Database();

        // find the user from the database
        $result = $db->find_user_by_username($_POST['username']);

        // check if the user exists
        if (count($result) > 0) {            
            // check if the correct password was given
            if (md5($_POST['password']) == $result[0]['password']) { 
                // success! redirect to mail box
                $_SESSION['id']         = $result[0]['id'];
                Authorization::redirect('mailbox.php');
            } else {
                // password mismatch :sadcat:
                $errors = "Wrong password";
            }
        } else {
            // nope, display an error
            $errors = "User {$_POST['username']} doesn't exist";
        }
    }
    require_once('includes/header.php');
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-6 login-section-wrapper">
            <div class="brand-wrapper">
                <span>Secure Messenger</span>
            </div>
            <div class="login-wrapper my-auto">
                <h1 class="login-title">Log in</h1>
                <form action="/index.php" method="post">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" class="form-control" placeholder="johnsnow">
                    </div>
                    <div class="form-group mb-4">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="enter your passsword">
                    </div>
                    <input name="login" id="login" class="btn btn-block login-btn" type="submit" value="Login"/>
                </form>
            </div>
        </div>
        <div class="col-sm-6 px-0 d-none d-sm-block">
            <img src="assets/img/login.jpg" alt="login image" class="login-img">
        </div>
    </div>
</div>

<?php
require_once('includes/footer.php');