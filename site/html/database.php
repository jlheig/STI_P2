<?php

namespace Messenger;

use PDO;

class Database {

    private $conn;
    
    function __construct() {
        // Create (connect to) SQLite database in file
        $this->conn = new PDO('sqlite:/usr/share/nginx/databases/database.sqlite');
        // Set errormode to exceptions
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, 
                            PDO::ERRMODE_EXCEPTION);
    }

    public function find_user_by_id($id) {
        return $this->conn->query("SELECT * FROM users WHERE id = '{$id}'")->fetchAll()[0];
    }

    public function find_user_by_username($username) {
        $sth = $this->conn->prepare("SELECT * FROM users WHERE username = ?");
        $sth->execute(array($username));
        return $sth->fetchAll();
    }

    public function get_users() {
        return $this->conn->query("SELECT * FROM users")->fetchAll();
    }

    public function create_user($username, $passwd, $role) {
        $this->conn->exec("INSERT INTO users (username, password, role) VALUES ('$username', '$passwd', '$role')");
    }

    public function send_email($sender, $receiver, $subject, $message, $received_date, $parent) {
        return $this->conn->exec("INSERT INTO emails (sender, receiver, subject, message, received_date, parent_email) VALUES ('$sender', '$receiver', '$subject', '$message', '$received_date', '$parent')");
    }

    public function find_email_by_id($id) {
        return $this->conn->query("SELECT * FROM emails WHERE id = '{$id}'")->fetchAll()[0];
    }

    public function find_emails_by_receiver($receiver) {
        return $this->conn->query("SELECT * FROM emails WHERE receiver = '{$receiver}'")->fetchAll();
    }

    public function get_user_conversations($userId) {
        return $this->conn->query("SELECT * FROM emails WHERE (receiver = {$userId} or sender = {$userId}) and (parent_email is null or parent_email = '')")->fetchAll();
    }

    public function get_conversation($parent) {
        return $this->conn->query("SELECT * FROM emails WHERE parent_email = {$parent} or id = {$parent}")->fetchAll();
    }

    public function delete_email_by_id($id) {
        return $this->conn->query("DELETE FROM emails WHERE id = '{$id}'")->fetchAll();
    }

    public function update_user_by_id($id, $username, $role, $state){
        return $this->conn->query("UPDATE users SET username='$username', role='$role', active='$state' WHERE id = '{$id}'");
    }

    public function update_password_by_id($id, $password){
        return $this->conn->exec("UPDATE users SET password='$password' WHERE id = '{$id}'");
    }
}
