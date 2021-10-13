<?php
namespace Messenger;
require_once('database.php');

class Authorization {

    const ADMIN    = 'admin';
    const EMPLOYEE = 'employee';

    public static function checkSession() {
        return !empty($_SESSION['id']);
    }

    public static function access($role = self::EMPLOYEE) {
        if (!self::checkSession())
            self::redirect();

        $user = (new Database())->find_user_by_id($_SESSION['id']);
        
        if ($user['role'] != $role || $user['role'] != self::ADMIN) 
            self::redirect();
    }

    public static function redirect($target = 'index.php') {
        header("Location: $target");
        exit();
    }
}