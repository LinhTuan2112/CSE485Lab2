<?php

class User {
    private $id;
    private $username;
    private $password;
    private $role;

    // Constructor để khởi tạo đối tượng với các giá trị ban đầu
    public function __construct($id, $username , $password, $role = 0) {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->role = $role;
    }

    // Getter và Setter cho thuộc tính $id
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    // Getter và Setter cho thuộc tính $username
    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    // Getter và Setter cho thuộc tính $password
    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    // Getter và Setter cho thuộc tính $role
    public function getRole() {
        return $this->role;
    }

    public function setRole($role) {
        $this->role = $role;
    }
}

?>
