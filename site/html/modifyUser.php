<?php

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

require_once('database.php');

use Messenger\Database;

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
<!-- Masthead-->
<header class="masthead">
    <div class="container px-4 px-lg-5 d-flex h-100 align-items-center justify-content-center">
        <div class="d-flex justify-content-center">
            <div class="text-center">
                <!-- TODO -->
                <section class="projects-section bg-light" id="login">
                    <form action="/modifyUser.php?id=<?php if(isset($id_user)) { echo $id_user; } ?>" method="post">
                        <label for="username"><b>Username</b></label>
                        <input type="text" value="<?php if(isset($username)) { echo $username; } ?>" name="username" required readonly>

                        <label for="pwd"><b>Password</b></label>
                        <input type="text" name="pwd" placeholder="Enter new password here">

                        <label for="active"><b>State</b></label>
                        <select name="active" required>
                            <option <?php if(isset($state) && $state) { echo "selected"; } ?> value="activated">Activated</option>
                            <option <?php if(isset($state) && !$state) { echo "selected"; } ?> value="deactivated">Deactivated</option>
                        </select>

                        <label for="role"><b>Role</b></label>
                        <select name="role" required>
                            <option <?php if(isset($role) && $role != "admin") { echo "selected"; } ?> value="user">User</option>
                            <option <?php if(isset($role) && $role == "admin") { echo "selected"; } ?> value="admin">Admin</option>
                        </select>

                        <input type="submit" value="Change User">
                    </form>
                </section>
            </div>
        </div>
    </div>
</header>
        
<?php
require_once('includes/footer.php');
