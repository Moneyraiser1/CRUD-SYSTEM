<?php 
require 'Abstract/UserInterface.php';
require 'Model/Database.php'; 
require 'functions.php'; 

class Users implements UserInterface {
    private $id;
    private $firstname;
    private $lastname;
    private $email;
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function registerUsers($fname, $lname, $email) {
        $this->firstname = validateUser($fname);
        $this->lastname = validateUser($lname);
        $this->email = validateUser($email);
   

        if (!empty($this->firstname) &&!empty($this->lastname)  && !empty($this->email)) {
            if (filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
                // Check if email already exists
                $this->db->query('SELECT * FROM users WHERE email = ?');
                $this->db->bind(1, $this->email);
                $row = $this->db->singleRecord();

                if ($row) {
                    return false;
                }

              

                // Insert new user
                $this->db->query('INSERT INTO users(fname, lname, email) VALUES (?, ?, ?)');
                $this->db->bind(1, $this->firstname);
                $this->db->bind(2, $this->lastname);
                $this->db->bind(3, $this->email);

                return $this->db->execute();
            }
        }
        return false;
    }

    public function showUsers(){
 
        $this->db->query('SELECT * FROM users');

        $row = $this->db->resultSet();

        if(count($row) > 0){
            return $row;
        }else{
            return false;
        }

    }

    public function showOneUsers($id){
        $this->db->query('SELECT * FROM users WHERE id = :eid');
        $this->db->bind(':eid', $id);
        return $this->db->singleRecord();
    }
    
    public function updateUser($id, $fname, $lname, $email) {
        $this->db->query('UPDATE users SET fname = ?, lname = ?, email = ? WHERE id = ?');
        $this->db->bind(1, $fname);
        $this->db->bind(2, $lname);
        $this->db->bind(3, $email);
        $this->db->bind(4, $id);
    
        return $this->db->execute();
    }
    
    
    public function deleteUser($id) {
        $this->db->query('DELETE FROM users WHERE id = ?');
        $this->db->bind(1, $id);
        return $this->db->execute();
    }
    
 
}

