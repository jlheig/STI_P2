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
                        <!-- TODO -->
                        <section class="projects-section bg-light" id="login">
                            <form action="/action_page.php" method="post">
                                <label for="email"><b>Email</b></label>
                                <input type="email" value="john.doe@goggle.com" name="email" required readonly>

                                <label for="psw"><b>Password</b></label>
                                <input type="password" value="p4ssw0rd" name="psw" required>

                                <label for="state"><b>State</b></label>
                                <select name="state" required>
                                    <option selected value="online">Online</option>
                                    <option value="offline">Offline</option>
                                </select>
    
                                <label for="role"><b>Role</b></label>
                                <select name="role" required>
                                    <option selected value="user">User</option>
                                    <option value="admin">Admin</option>
                                </select>

                                <input type="submit" value="Change User">
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