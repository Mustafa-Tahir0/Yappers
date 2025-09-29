<?php
// Content of database.php
$mysql = new mysqli('localhost', 'apache', 'apache_123', 'module6');

if ($mysql->connect_errno) {
    printf("Connection Failed: %s\n", $mysql->connect_error);
    exit;
}
?>