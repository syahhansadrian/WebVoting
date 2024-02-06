<?php
    /*
        Desc: Database Model User dengan fungsi CRUD
        Author: Nur Azis Saputra <nurazissaputra@mirachhub.org>

        Date: 2024-02-06

        This file is part of the Model User.

        Licensed under The MIT License.
    */

class User {
    private $conn;
    protected $table = "users";

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getAllUsers() {
        $query = "SELECT * FROM " . $this->table;
        $result = $this->conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getUserById($userId) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        
        if ($stmt) {
            $stmt->bind_param("i", $userId); // "i" berarti integer, sesuaikan dengan tipe data kolom 'id'
            $stmt->execute();
            
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            
            $stmt->close();
            
            return $user;
        } else {
            return null;
        }
    }

    public function createUser($userData) {
        $username = $userData['username'];
        $email = $userData['email'];
        $password = $userData['password'];
        $verifystatus = $userData['verifystatus'];
    
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
        $query = "INSERT INTO " . $this->table . " (username, email, password, verifystatus) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
    
        if ($stmt) {
            $stmt->bind_param("sssi", $username, $email, $hashedPassword, $verifystatus); // "sss" berarti tiga string
            $result = $stmt->execute();
    
            $stmt->close();
    
            return $result;
        } else {
            $errorMessage = $this->conn->error;
            error_log("Failed to prepare statement: $errorMessage"); 
            return false;
        }
    }

    public function updateUser($userId, $userData) {
        $username = $userData['username'];
        $email = $userData['email'];

        $query = "UPDATE  " . $this->table . " SET username = ?, email = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);

        if ($stmt){
            $stmt->bind_param("ssi", $username, $email, $userId);
            $result = $stmt->execute();

            $stmt->close();

            return $result;
        } else {
            $errorMessage = $this->conn->error;
            error_log("Failed to prepare statement: $errorMessage"); 
            return false;
        }
    }

    public function deleteUser($userId) {
        $query = "DELETE FROM  " . $this->table . "  WHERE id = ?";
        $stmt = $this->conn->prepare($query);

        if ($stmt){
            $stmt->bind_param("i", $userId);
            $result = $stmt->execute();

            $stmt->close();

            return $result;
        } else {
            $errorMessage = $this->conn->error;
            error_log("Failed to prepare statement: $errorMessage"); 
            return false;
        }
    }
}
  


/* 
#### Contoh penggunaan ####
    $conn = new mysqli("localhost", "username", "password", "database_name");
    $userModel = new UserModel($conn);

#Mengambil semua pengguna
    $allUsers = $userModel->getAllUsers();

#Mengambil pengguna berdasarkan ID
    $userById = $userModel->getUserById(1);

#Menambahkan pengguna baru
    $newUser = [
        'username' => 'Nur Azis Saputra',
        'email' => 'nurazissaputra@gmail.org',
        'password' => 'password123',
        'verifystatus' => 2
    ];
    $userModel->createUser($newUser);

#Memperbarui informasi pengguna
    $updateUser = [
        'username' => 'Nur Azis Saputra',
        'email' => 'nurazissaputra@gmail.org'
    ];
    $userModel->updateUser(1, $updateUser);

#Menghapus pengguna berdasarkan ID
    $userModel->deleteUser(1);  
*/
    