<?php
    include_once "resources/dbcontroller.php";
    include_once "src/Model/User.php";
    
    # >> melakukan test koneksi ke database
    echo cekkoneksi();

    # Inisialisasi objek model User
    $userModel = new User($conn);

    # Mengambil data user
    $allUsers = $userModel->getAllUsers();
    print_r($allUsers);
    
?>