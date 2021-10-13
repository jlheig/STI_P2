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
        <?php include 'nav.php' ?>
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
        
       
        <!-- Footer-->
        <footer class="footer bg-black small text-center text-white-50"><div class="container px-4 px-lg-5">Copyright &copy; Your Website 2021</div></footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
