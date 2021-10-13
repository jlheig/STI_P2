<?php
require_once('includes/header.php');
?>
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
                            <label for="psw"><b>New password</b></label>
                            <input type="password" placeholder="Enter your new password" name="psw" required>
                            <label for="psw"><b>New password confirmation</b></label>
                            <input type="password" placeholder="Enter your new password" name="psw" required>

                            <input type="submit" value="Change password">
                    </form>
                </section>
            </div>
        </div>
    </div>
</header>

<?php
require_once('includes/footer.php');