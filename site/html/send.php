<?php
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

require_once('database.php');
require_once('authorization.php');
session_start();

use Messenger\Database;
use Messenger\Authorization;

if (!Authorization::access())
    Authorization::redirect();

$db = new Database();

if (!empty($_POST)) {
    $errors = "";
    if (empty($_POST['receiver']) || empty($_POST['subject']) || empty($_POST['message'])) {
        $errors = 'You must fill all fields!';
    } else {
        if ($db->find_user_by_id($_POST['receiver']) == null) {
            $errors = 'Unknown user';
        } else {

            $parent = empty($_POST['parent']) ? null : $_POST['parent'];

            $db->send_email($_SESSION['id'], $_POST['receiver'], $_POST['subject'], $_POST['message'], date("d-m-Y H:i:s"), $parent);

            $extras = '';
            if (!empty($parent))
                $extras = "?parent=$parent";

            Authorization::redirect("inbox.php$extras");
        }
    }


    Authorization::redirect("compose.php?errors=$errors");
}
