<?php


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
}
