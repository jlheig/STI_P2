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
}
