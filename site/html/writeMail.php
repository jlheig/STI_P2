<?php
    ini_set('display_startup_errors', 1);
    ini_set('display_errors', 1);
    error_reporting(-1);
    require_once('database.php');

    session_start();

    $db = new Database();


    //if we sent an email
    if( isset($_GET["email"]) && isset($_GET["title"]) && isset($_GET["text"]) )
    {
        //get our values
        $login = "test";
        $sender = $login;
        $receiver = $_GET["email"];
        $subject = $_GET["title"];
        $message = $_GET["text"];
        $received_date = date("d-m-Y H:i:s");

        //send the mail
        $db->send_email($sender, $receiver, $subject, $message, $received_date);
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>STI_Project</title>
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v5.15.3/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body id="page-top">
        <!-- Navigation-->
        <?php include 'includes/nav.php' ?>
        <!-- Masthead-->
        <header class="masthead">
            <div class="container px-4 px-lg-5 d-flex h-100 align-items-center justify-content-center">
                <div class="d-flex justify-content-center">
                    <div class="text-center">
                        <div class="container projects-section bg-light">
                            <form action="/writeMail.php" method="GET">
                                <label for="email">To</label>
                                <input type="email" id="email" name="email" placeholder="Email address.." value="<?php echo isset($_GET['name']) ? htmlspecialchars($_GET['name']) : ''; ?>">

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
        
       
        <!-- Footer-->
        <footer class="footer bg-black small text-center text-white-50"><div class="container px-4 px-lg-5">Copyright &copy; Your Website 2021</div></footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
