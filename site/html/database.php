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

    /**
     * CORRECTIONS : Ces fonctions font des requêtes dans la database vulnérables aux injections
     * Essayons de sécuriser au maximum ces requêtes en utilisant l'escaping, les procédures stockées
     * et les parametrized queries. Il faut savoir que la librairie PHP Data Object (PDO) permet de le faire simplement
     * grâce aux fonctions prepare() et execute() qui s'occupent de paramétriser les requêtes et les "échapper"
     * Selon le manuel PHP :
     * "Les paramètres pour préparer les requêtes n'ont pas besoin d'être entre guillemets ;
     * le pilote gère cela pour vous. Si votre application utilise exclusivement les requêtes préparées,
     * vous pouvez être sûr qu'aucune injection SQL n'est possible"
     * Source : https://www.php.net/manual/fr/pdo.prepared-statements.php
     */
    

    public function find_user_by_id($id) {
        $sth = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
        $sth->execute(array($id));
        return $sth->fetchAll()[0];

    }

    public function find_user_by_username($username) {
       $sth = $this->conn->prepare("SELECT * FROM users WHERE username = ?"); 
       $sth->execute(array($username));
       return $sth->fetchAll();
    }

    public function get_users() {
        $sth =  $this->conn->prepare("SELECT * FROM users");
        $sth->execute();
        return $sth->fetchAll();
    }

    public function create_user($username, $passwd, $role) {
        $sth = $this->conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
        return $sth->execute(array($username, $passwd, "employee"));
    }

    public function send_email($sender, $receiver, $subject, $message, $received_date, $parent) {
        $sth =  $this->conn->prepare("INSERT INTO emails (sender, receiver, subject, message, received_date, parent_email) VALUES (?, ?, ?, ?, ?, ?)");
        return $sth->execute(array($sender, $receiver, $subject, $message, $received_date, $parent));
    }

    public function find_email_by_id($id) {
        $sth = $this->conn->prepare("SELECT * FROM emails WHERE id = ?");
        $sth->execute(array($id));
        return $sth->fetchAll()[0];
    }

    public function find_emails_by_receiver($receiver) {
        $sth = $this->conn->prepare("SELECT * FROM emails WHERE receiver = ?");
        $sth->execute(array($receiver));
        return $sth->fetchAll();
    }

    public function get_user_conversations($userId) {
        $sth = $this->conn->prepare("SELECT * FROM emails WHERE (receiver = ? or sender = ?) and (parent_email is null or parent_email = '')");
        $sth->execute(array($userId, $userId));
        return $sth->fetchAll();
    }

    public function get_conversation($parent) {
        $sth = $this->conn->prepare("SELECT * FROM emails WHERE parent_email = ? or id = ?");
        $sth->execute(array($parent, $parent));
        return $sth->fetchAll();
    }

    public function delete_email_by_id($id) {
        $sth =  $this->conn->prepare("DELETE FROM emails WHERE id = ?");
        $sth->execute(array($id));
        return $sth->fetchAll();
    }

    public function update_user_by_id($id, $username, $role, $state){
        $sth = $this->conn->prepare("UPDATE users SET username= ?, role=?, active=? WHERE id = ?");
        return $sth->execute(array($username, $role, $state, $id));

    }

    public function update_password_by_id($id, $password){
        $sth = $this->conn->prepare("UPDATE users SET password= ? WHERE id = ?");
        return $sth->execute(array($password, $id));

    }
}
