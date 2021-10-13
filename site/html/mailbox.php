<?php
    ini_set('display_startup_errors', 1);
    ini_set('display_errors', 1);
    error_reporting(-1);
    require_once('database.php');

    session_start();

    $db = new Database();

    $login = "test@gmail.qr";
    $receiver = $login;
    $result = $db->find_emails_by_receiver($receiver);

    if(isset($_GET['id_delete'])) {
        $id_delete = $_GET['id_delete'];
        $db->delete_email_by_id($id_delete);
        header( "Location: mailbox.php" );
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
                        <section class="projects-section bg-light" id="login">
                            <table>
                                <tr>
                                    <th>Date</th>
                                    <th>Subject</th>
                                    <th>From</th>
                                    <th>Actions</th>
                                </tr>
                                <?php
                                    //populating table
                                    for($i = 0; $i<count($result); $i++) {
                                        echo "<tr>";
                                        echo "<td>".$result[$i]['received_date']."</td>";
                                        echo "<td>".$result[$i]['subject']."</td>";
                                        echo "<td>".$result[$i]['sender']."</td>";
                                        echo "<td>";
                                        echo "<a href='writeMail.php?name=".$result[$i]['sender']."&subject=".$result[$i]['subject']."'>Answer</a>\n";
                                        echo "<a href='readMail.php?id=".$result[$i]['id']."'>Read</a>\n";
                                        echo "<a href='mailbox.php?id_delete=".$result[$i]['id']."'>Delete</a>\n";
                                        echo "</td>";
                                        echo "</tr>";
                                    } 
                                ?>
                            </table>
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
