<?php
    /*
        Desc: Database connection dengan fungsi test koneksi
        Author: Wildy Sheverando <wildyrando@mirachhub.org>

        Date: 2024-01-28

        This file is part of the Database connection.

        Licensed under The MIT License.
    */

    # >> Load phpdotenv
    require_once __DIR__ . '/../vendor/autoload.php'; 
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();

    # >> Load environment variables
    $D_HOST = $_ENV['DBHOST'];
    $D_USER = $_ENV['DBUSER'];
    $D_PASS = $_ENV['DBPASS'];
    $D_NAME = $_ENV['DBNAME'];

    # >> Create connection
    $conn = new mysqli($D_HOST, $D_USER, $D_PASS, $D_NAME);

    # >> Fungsi untuk cek koneksi database
    function cekkoneksi() {
        global $conn;
        if ($conn->ping()) {
            return "Koneksi Berhasil!";
        } else {
            return "Koneksi Gagal: $conn->error";
        }
    }
?>