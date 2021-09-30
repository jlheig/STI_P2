<?php
    ini_set('display_startup_errors', 1);
    ini_set('display_errors', 1);
    error_reporting(-1);

    session_start();

    if (!empty($_POST)) {
        // Create (connect to) SQLite database in file
        $db = new PDO('sqlite:/usr/share/nginx/databases/database.sqlite');
        // Set errormode to exceptions
        $db->setAttribute(PDO::ATTR_ERRMODE, 
                            PDO::ERRMODE_EXCEPTION);

        // find the user from the database
        $result = $db->query("SELECT * FROM users WHERE username = '{$_POST['username']}'")->fetchAll();

        // check if the user exists
        if (count($result) > 0) {            
            // check if the correct password was given
            if (md5($_POST['password']) == $result[0]['password']) { 
                // success! redirect to mail box
                $_SESSION['id']         = $result[0]['id'];
                $_SESSION['username']   = $result[0]['username'];
                header("Location: mailbox.php");
                exit();
            } else {
                // password mismatch :sadcat:
                $errors = "Wrong password";
            }
        } else {
            // nope, display an error
            $errors = "User {$_POST['username']} doesn't exist";
        }
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
        <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand">Kayoumi Doran & Blanc Jean-Luc</a>
                <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    Menu
                    <i class="fas fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Masthead-->
        <header class="masthead">
            <div class="container px-4 px-lg-5 d-flex h-100 align-items-center justify-content-center">
                <div class="d-flex justify-content-center">
                    <div class="text-center">
                        <section class="projects-section bg-light" id="login">
                            <?php if (!empty($errors)) echo $errors; ?>
                            <form action="/index.php" method="post">
                                <div>
                                    <label for="username"><b>Username</b></label>
                                    <input type="text" placeholder="Enter Username" name="username" required>
                                </div>
                                <div>
                                    <label for="password"><b>Password</b></label>
                                    <input type="password" placeholder="Enter Password" name="password" required>
                                </div>
                                <div>      
                                    <button type="submit">Login</button>
                                </div>
                                <div>
                                    <span class="psw">Forgot <a href="#">password?</a></span>
                                </div>
                            </form>
                        </section>
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
