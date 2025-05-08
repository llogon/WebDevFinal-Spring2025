<?php
// db_connect.php

$dbhost = '127.0.0.1';
$dbname = 'mysql';
$dbuser = 'root';
$dbpass = '';

try {
    // Create a PDO instance
    $db = new PDO("mysql:host=$dbhost;dbname=$dbname;charset=utf8", $dbuser, $dbpass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Optional: If you want to re-initialize the DB each time:
    // 1) Read the SQL file
    $sqlContents = file_get_contents('Initialize.sql');

    // 2) Execute it
    //    If your system supports multiple statements in one exec call:
    $db->exec($sqlContents);

    //    Otherwise, split on semicolons and run them individually (see prior note).

} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
    exit;
}
?>
