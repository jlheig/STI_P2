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
        return $this->conn->query("SELECT * FROM users WHERE username = '{$username}'")->fetchAll();
    }

    public function get_users() {
        return $this->conn->query("SELECT * FROM users")->fetchAll();
    }

    public function create_user($username, $passwd, $role) {
        $this->conn->exec("INSERT INTO users (username, password, role) VALUES ('$username', '$passwd', '$role')");
    }

    public function send_email($sender, $receiver, $subject, $message, $received_date) {
        return $this->conn->query("INSERT INTO emails (sender, receiver, subject, message, received_date) VALUES ('$sender', '$receiver', '$subject', '$message', '$received_date')");
    }

    public function find_email_by_id($id) {
        return $this->conn->query("SELECT * FROM emails WHERE id = '{$id}'")->fetchAll();
    }

    public function find_emails_by_receiver($receiver) {
        return $this->conn->query("SELECT * FROM emails WHERE receiver = '{$receiver}'")->fetchAll();

    }

    public function delete_email_by_id($id) {
        return $this->conn->query("DELETE FROM emails WHERE id = '{$id}'")->fetchAll();
    }
}
