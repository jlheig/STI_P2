<?php


class Database {

    private $db;
    
    function __construct() {
        var_dump('waaaaaaaaaat');
        // Create (connect to) SQLite database in file
        $this->db = new PDO('sqlite:/usr/share/nginx/databases/database.sqlite');
        // Set errormode to exceptions
        $this->db->setAttribute(PDO::ATTR_ERRMODE, 
                            PDO::ERRMODE_EXCEPTION);
    }

    public function find_user_by_id($id) {
        return $this->db->query("SELECT * FROM users WHERE id = '{$id}'")->fetchAll();
    }

    public function find_user_by_username($username) {
        return $this->db->query("SELECT * FROM users WHERE username = '{$username}'")->fetchAll();
    }

    public function send_email($sender, $receiver, $subject, $message, $received_date) {
        return $this->db->query("INSERT INTO emails (sender, receiver, subject, message, received_date) VALUES ('$sender', '$receiver', '$subject', '$message', '$received_date')");
    }

    public function find_email_by_id($id) {
        return $this->db->query("SELECT * FROM emails WHERE id = '{$id}'")->fetchAll();
    }

    public function find_emails_by_receiver($receiver) {
        return $this->db->query("SELECT * FROM emails WHERE receiver = '{$receiver}'")->fetchAll();

    }

    public function delete_email_by_id($id) {
        return $this->db->query("DELETE FROM emails WHERE id = '{$id}'")->fetchAll();
    }
}
