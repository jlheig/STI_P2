<?php
    ini_set('display_startup_errors', 1);
    ini_set('display_errors', 1);
    error_reporting(-1);
    require_once('database.php');

    session_start();

    $db = new Database();


    //if we sent an email
    if( isset($_GET["username"]) && isset($_GET["title"]) && isset($_GET["text"]) )
    {
        //get our values
        $login = "test";
        $sender = $login;
        $receiver = $_GET["username"];
        $subject = $_GET["title"];
        $message = $_GET["text"];
        $received_date = date("d-m-Y H:i:s");

        //send the mail
        $db->send_email($sender, $receiver, $subject, $message, $received_date);
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
                    <form action="/writeMail.php" method="GET">
                        <label for="username">To</label>
                        <input type="text" id="username" name="username" placeholder="username of receiver" value="<?php echo isset($_GET['name']) ? htmlspecialchars($_GET['name']) : ''; ?>">

                        <label for="title">Title</label>
                        <input type="text" id="title" name="title" placeholder="Your title.." value="<?php echo isset($_GET['subject']) ? htmlspecialchars($_GET['subject']) : ''; ?>">

                        <label for="text">Text</label>
                        <textarea id="text" name="text" placeholder="Write something.."></textarea>

                        <input type="submit" value="Submit">
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
        
<?php
require_once('includes/footer.php');
