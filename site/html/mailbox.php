<?php
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
                        <tr>
                            <td>30.09.2021</td>
                            <td>Hello, World!</td>
                            <td>John Doe</td>
                            <td>
                                <a href="writeMail.php">Answer</a> 
                                <a href="">Delete</a> 
                                <a href="readMail.php">Read</a> 
                            </td>
                        </tr>
                        <tr>
                            <td>30.09.2021</td>
                            <td>Hello, World!</td>
                            <td>John Doe</td>
                            <td>
                                <a href="writeMail.php">Answer</a> 
                                <a href="">Delete</a> 
                                <a href="readMail.php">Read</a> 
                            </td>
                        </tr>
                    </table>
                </section>
            </div>
        </div>
    </div>
</header>


<?php
require_once('includes/footer.php');