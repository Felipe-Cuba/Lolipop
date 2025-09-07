<?php
// Database configuration using environment variables for Docker
$db_host = getenv('DB_HOST') ?: 'localhost';
$db_user = getenv('DB_USER') ?: 'root';
$db_password = getenv('DB_PASSWORD') ?: '';
$db_name = getenv('DB_NAME') ?: 'lolipop';

$conn = mysqli_connect($db_host, $db_user, $db_password, $db_name) or die(mysqli_error($conn));

// Set charset to UTF-8
mysqli_set_charset($conn, "utf8");
?>