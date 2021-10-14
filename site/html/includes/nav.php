<?php
require_once('database.php');
require_once('authorization.php');

use Messenger\Authorization;
?>
<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
    <div class="container px-4 px-lg-5">
        <a class="navbar-brand">Secure Messenger</a>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto">
                <?php if (!Authorization::checkSession()): ?>
                    <li class="nav-item"><a class="nav-link" href="index.php">Login</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="mailbox.php">Mail Box</a></li>
                    <li class="nav-item"><a class="nav-link" href="writeMail.php">Write Email</a></li>
                    <?php if (Authorization::access(Authorization::ADMIN)): ?>
                        <li class="nav-item"><a class="nav-link" href="admin.php">Admin Panel</a></li>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

