<?php

class User {
    private $id;
    private $username;
    private $password;
    private $role;

    // Static array to hold the list of users
    private static $users = [];

    // Constructor to initialize the object with initial values
    public function __construct($id, $username, $password, $role = 0) {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->role = $role;
    }

    // Getter and Setter for $id
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    // Getter and Setter for $username
    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    // Getter and Setter for $password
    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    // Getter and Setter for $role
    public function getRole() {
        return $this->role;
    }

    public function setRole($role) {
        $this->role = $role;
    }

    // Method to add a user to the list
    public static function addUser($user) {
        foreach (self::$users as $existingUser) {
            if ($existingUser->getId() === $user->getId()) {
                throw new Exception("User with ID {$user->getId()} already exists.");
            }
        }
        self::$users[] = $user;
    }

    // Method to remove a user from the list by ID
    public static function removeUser($id) {
        foreach (self::$users as $index => $user) {
            if ($user->getId() === $id) {
                unset(self::$users[$index]);
                // Re-index the array to prevent gaps
                self::$users = array_values(self::$users);
                return;
            }
        }
        throw new Exception("User with ID $id not found.");
    }

    // Method to display all users (optional, for testing purposes)
    public static function listUsers() {
        foreach (self::$users as $user) {
            echo "ID: {$user->getId()}, Username: {$user->getUsername()}, Role: {$user->getRole()}\n";
        }
    }
}

?>
