<?php
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

require_once('database.php');
require_once('authorization.php');
session_start();

use Messenger\Database;
use Messenger\Authorization;

$db = new Database();

//if we sent an email
if(!empty($_POST["receiver"]) && !empty($_POST["subject"]) && !empty($_POST["message"]) ) {
    $sender = $_SESSION['id'];
    $receiver = $_POST["receiver"];
    $subject = $_POST["subject"];
    $message = $_POST["message"];
    $received_date = date("d-m-Y H:i:s");

    //send the mail
    $db->send_email($sender, $receiver, $subject, $message, $received_date);

    Authorization::redirect("inbox.php?sender=$receiver");
}
