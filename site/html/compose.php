<?php
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

require_once('database.php');
require_once('authorization.php');

session_start();

include_once __DIR__ .'/libraries/CSRF-Protector-PHP/libs/csrf/csrfprotector.php';

//Initialise CSRFGuard library
csrfProtector::init();

use Messenger\Database;
use Messenger\Authorization;

if (!Authorization::access())
    Authorization::redirect();

$db = new Database();

require_once('includes/header.php');
?>
    <!-- Navigation-->
<?php include 'includes/nav.php' ?>


<main class="main is-visible" data-dropzone-area="">
    <div class="container">
        <div class="row align-items-center justify-content-center min-vh-100 gx-0">
            <form class="row g-6" method="post" action="send.php">
                <div class="col-12">
                    <div class="text-center">
                        <h3 class="fw-bold mb-2">New Message</h3>
                    </div>
                    <?php if (!empty($_GET['errors'])): ?>
                        <div class="alert alert-danger" role="alert">
                            <?= $_GET['errors'] ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-12">
                    <div class="form-floating">
                        <select class="form-control" name="receiver" id="receiver">
                            <option value="" selected></option>
                            <?php foreach ($db->get_users() as $user): ?>
                            <?php if ($user['id'] == $_SESSION['id']): continue; endif;?>
                            <option value="<?= $user['id'] ?>"><?= $user['username'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label for="receiver">Receiver</label>
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-floating">
                        <input name="subject" type="text" class="form-control" id="subject" placeholder="Subject">
                        <label for="subject">Subject</label>
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-floating">
                        <textarea id="message" name="message" class="form-control px-0" placeholder="Type your message..." rows="" data-emoji-input="" data-autosize="true" style="height: 150px; padding: 1.625rem 1rem !important;"></textarea>
                        <label for="message">Message</label>
                    </div>
                </div>

                <div class="col-12">
                    <button class="btn btn-block btn-lg btn-primary w-100" type="submit">Send Message</button>
                </div>
            </form>
        </div> <!-- / .row -->
    </div>
</main>



<?php
require_once('includes/footer.php');
