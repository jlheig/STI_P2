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
        
<?php
require_once('includes/footer.php');
