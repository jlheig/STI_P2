<?php
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

require_once('database.php');

$db = new Database();

$login = "test";
$receiver = $login;
$result = $db->find_emails_by_receiver($receiver);

if(isset($_GET['id_delete'])) {
    $id_delete = $_GET['id_delete'];
    $db->delete_email_by_id($id_delete);
    header( "Location: mailbox.php" );
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
<?php
require_once('includes/footer.php');