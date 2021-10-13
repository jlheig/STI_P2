<?php
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);
require_once('database.php');

session_start();

$db = new Database();

//if we have an id specified, then we read the email relateed to it
if(isset($_GET["id"])) {
    $id = $_GET["id"];
    $result = $db->find_email_by_id($id);
    $from = $result[0]['sender'];
    $subject = $result[0]['subject'];
    $message = $result[0]['message'];
    $date = $result[0]['received_date'];
}
require_once('includes/header.php');
?>
<!-- Navigation-->
<?php include 'includes/nav.php' ?>
<!-- Masthead-->
<header class="masthead">
    <div class="container px-4 px-lg-5 d-flex h-100 align-items-center justify-content-center">
        <div class="d-flex justify-content-center">
            <div class="text-center">
                <div class="container projects-section bg-light">
                    <h4>From</h4>
                    <div class="infoReceived" id="email"><?php if(isset($from)) { echo $from; } ?></div>

                    <h4>Date</h4>
                    <div class="infoReceived" id="date"><?php if(isset($date)) { echo $date; } ?></div>

                    <h4>Title</h4>
                    <div class="infoReceived" id="title"><?php if(isset($subject)) { echo $subject; } ?></div>

                    <h4>Text</h4>
                    <div class="infoReceived" id="text"><?php if(isset($message)) { echo $message; } ?></div>
                    <form action="mailbox.php">
                        <input type="submit" value="Close">
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
        
<?php
require_once('includes/footer.php');
