<?php

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

require_once('database.php');
require_once('authorization.php')

use Messenger\Database;
use Messenger\Authorization;

if (!Authorization::access(Authorization::ADMIN))
    Authorization::redirect();

$db = new Database();

//get informations from user id
if(isset($_GET["id"])){
    $id_user = $_GET["id"];
    $result = $db->find_user_by_id($id_user);
    $username = $result["username"];
    $pwd = $result["password"];
    $state = $result["active"];
    $role = $result["role"];
}

//send modified informations to DB
if(isset($_POST["username"]) && isset($_POST["active"]) && isset($_POST["role"])){
    $m_username = $_POST["username"];
    $m_role = $_POST["role"];

    if($_POST["active"] == "activated"){
        $m_state = 1;
    }
    else{
        $m_state = 0;
    }

    $db->update_user_by_id($id_user, $m_username, $m_role, $m_state);
    header( "Location: modifyUser.php?id=".$id_user );
}

//allows us to not be forced to modify the password
if(isset($_POST["pwd"]) && $_POST["pwd"] != ""){
    $m_pwd = $_POST["pwd"];
    $m_pwd = md5($m_pwd);
    $db->update_password_by_id($id_user, $m_pwd);
}

session_start();

require_once('includes/header.php');
?>
<!-- Navigation-->
<?php include 'includes/nav.php' ?>

<main class="main is-visible" data-dropzone-area="">
    <div class="container">
        <div class="row align-items-center justify-content-center min-vh-100 gx-0">

            <form class="row g-6" action="/modifyUser.php?id=<?php if(isset($id_user)) { echo $id_user; } ?>" method="post">
                <div class="form-floating">
                    <input name="username" type="text" class="form-control" id="username" value="<?php if(isset($username)) { echo $username; } ?>" placeholder="Username" required readonly>
                    <label for="username">Username</label>
                </div>

                <label for="active"><b>State</b></label>
                <select class="form-control" name="active" required>
                    <option <?php if(isset($state) && $state) { echo "selected"; } ?> value="activated">Activated</option>
                    <option <?php if(isset($state) && !$state) { echo "selected"; } ?> value="deactivated">Deactivated</option>
                </select>

                <label for="role"><b>Role</b></label>
                <select class="form-control"  name="role" required>
                    <option <?php if(isset($role) && $role != "admin") { echo "selected"; } ?> value="user">User</option>
                    <option <?php if(isset($role) && $role == "admin") { echo "selected"; } ?> value="admin">Admin</option>
                </select>

                <div class="col-12">
                    <button class="btn btn-block btn-lg btn-primary w-100" type="submit">Change Use</button>
                </div>
            </form>
        </div> <!-- / .row -->
    </div>
</main>

<?php
require_once('includes/footer.php');
