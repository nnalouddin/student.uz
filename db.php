<?php

$conn = mysqli_connect('localhost', 'root', '', 'dars1');

if (!$conn) {
    exit('Databasega ulanishda xatolik yuz berdi.');
}

mysqli_set_charset($conn, 'utf8mb4');