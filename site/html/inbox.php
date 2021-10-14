<?php
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

session_start();

require_once('database.php');
require_once('authorization.php');

use Messenger\Database;
use Messenger\Authorization;

if (!Authorization::access())
    Authorization::redirect();

$db = new Database();

$messages = $db->get_user_conversations($_SESSION['id']);

if(isset($_GET['id_delete'])) {
    $id_delete = $_GET['id_delete'];
    $db->delete_email_by_id($id_delete);
    header( "Location: inbox.php" );
}

require_once('includes/header.php');
?>
<!-- Navigation-->
<?php include 'includes/nav.php' ?>

<aside class="sidebar bg-light">
    <div class="tab-content h-100" role="tablist">
        <!-- Chats -->
        <div class="tab-pane fade h-100 active show" id="tab-content-chats" role="tabpanel">
            <div class="d-flex flex-column h-100 position-relative">
                <div class="hide-scrollbar">

                    <div class="container py-8">
                        <!-- Title -->
                        <div class="mb-8">
                            <h2 class="fw-bold m-0">Chats</h2>
                        </div>

                        <!-- Chats -->
                        <div class="card-list">
                            <?php if (count($messages) <= 0):?>
                            No emails
                            <?php else: ?>
                            <?php foreach ($messages as $message): ?>
                            <!-- Card -->
                            <a href="inbox.php?parent=<?= $message['id'] ?>" class="card border-0 text-reset">
                                <div class="card-body">
                                    <div class="row gx-5">
                                        <div class="col">
                                            <div class="d-flex align-items-center mb-3">
                                                <h5 class="me-auto mb-0"><?= $db->find_user_by_id($message['sender'] == $_SESSION['id'] ? $message['receiver'] : $message['sender'])['username'] ?></h5>
                                                <span class="text-muted extra-small ms-2"><?= $message['received_date'] ?></span>
                                            </div>

                                            <div class="d-flex align-items-center">
                                                <div class="line-clamp me-auto">
                                                    <?= $message['subject'] ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- .card-body -->
                            </a>
                            <!-- Card -->
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</aside>

<?php
if(isset($_GET["parent"])):

$convo = $db->get_conversation($_GET['parent']);

if (empty($convo)) {
    Authorization::redirect('inbox.php?=unknownuser=1');
}
$senderid = $convo[0]['sender'] == $_SESSION['id'] ? $convo[0]['receiver'] : $convo[0]['sender'];
$sender = $db->find_user_by_id($senderid);
?>

<main class="main is-visible">
    <div class="container-fluid h-100">

        <div class="d-flex flex-column h-100 position-relative">
            <!-- Chat: Header -->
            <div class="chat-header border-bottom py-4 py-lg-7">
                <div class="row align-items-center">
                    <!-- Content -->
                    <div class="col-8 col-xl-12">
                        <div class="row align-items-center text-center text-xl-start">
                            <!-- Title -->
                            <div class="col-12 col-xl-6">
                                <div class="row align-items-center gx-5">
                                    <div class="col overflow-hidden">
                                        <h5 class="text-truncate"><?= $sender['username'] ?></h5>
                                    </div>
                                </div>
                            </div>
                            <!-- Title -->
                        </div>
                    </div>
                    <!-- Content -->
                </div>
            </div>
            <!-- Chat: Header -->

            <!-- Chat: Content -->
            <div class="chat-body hide-scrollbar flex-1 h-100">
                <div class="chat-body-inner" style="padding-bottom: 87px">
                    <div class="py-6 py-lg-12">
                    <?php foreach ($convo as $message): ?>
                        <div class="message <?= $message['sender'] == $_SESSION['id'] ? 'message-out' : '' ?>">
                            <div class="message-inner">
                                <div class="message-body">
                                    <div class="message-content">
                                        <div class="message-text">
                                            <p><?= $message['message'] ?></p>
                                        </div>
                                        <?php if ($message['sender'] == $_SESSION['id']): ?>
                                        <div class="message-action">
                                            <div class="dropdown">
                                                <a class="dropdown-item d-flex align-items-center text-danger" href="delete.php?id=<?= $message['id'] ?>">
                                                    <div class="icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="message-footer">
                                    <span class="extra-small text-muted"><?= $message['received_date'] ?></span>
                                </div>
                            </div>
                        </div>
                    <?php  endforeach; ?>
                    </div>
                </div>
            </div>
            <!-- Chat: Content -->

            <!-- Chat: Footer -->
            <div class="chat-footer pb-3 pb-lg-7 position-absolute bottom-0 start-0">

                <!-- Chat: Form -->
                <form class="chat-form rounded-pill bg-dark" method="post" action="send.php">
                    <div class="row align-items-center gx-0">
                        <input type="hidden" name="receiver" value="<?= $sender['id'] ?>"/>
                        <input type="hidden" name="subject" value="<?= $convo[0]['subject'] ?>" />
                        <input type="hidden" name="parent" value="<?= $convo[0]['id'] ?>" />
                        <div class="col">
                            <div class="input-group">
                                <textarea name="message" class="form-control px-0" placeholder="Type your message..." rows="1" data-emoji-input="" data-autosize="true" style="margin-left: 20px; overflow: hidden; overflow-wrap: break-word; resize: none; height: 47px;"></textarea>
                            </div>
                        </div>

                        <div class="col-auto">
                            <button class="btn btn-icon btn-primary rounded-circle ms-5">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-send"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                            </button>
                        </div>
                    </div>
                </form>
                <!-- Chat: Form -->
            </div>
            <!-- Chat: Footer -->
        </div>

    </div>
</main>

<?php
endif;

require_once('includes/footer.php');