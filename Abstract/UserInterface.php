<?php

    interface UserInterface{
        public function registerUsers($fname, $lname, $email);
        public function showUsers();
        public function showOneUsers($id);
        public function deleteUser($id);
     
    }