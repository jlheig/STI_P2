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

$errors = "";

if (!empty($_GET['id'])) {
    if (!$db->find_email_by_id($_GET['id'])) {
        $errors = "?errors=Error - Unknown message";
    } else {
        $db->delete_email_by_id($_GET['id']);
    }
}


Authorization::redirect("inbox.php$errors");