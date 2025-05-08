<?php
// Set a specific session ID and start the session
session_id('0qp3hlbq1p8jiun0hhaj0tsd1o');
session_start();

// Include the database connection
require_once 'db_connect.php';

    // Validate that both username and password were submitted via POST
    if(!isset($_POST['username'], $_POST['password'])) {
        // If either value is missing, terminate the script with an error message
        die("Invalid input.");
    }

    // Assign values from form to variables
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare statement to select username with given username
    $stmt = $db->prepare("SELECT * FROM Login where username = :username");
    $stmt->execute(['username' => $username]);

    // Fetch the result as an array
    $user = $stmt->fetch();

    // Extract userID from the fetched row
    $userID = $user['userID'];

    // Check if a user was found and the password matches exactly
    if($user && $user['password'] === $password) {
        // Store username and userID in session variables
        $_SESSION['username'] = $username;
        $_SESSION['userID'] = $userID; 
        
        // Redirect to dashboard upon successful login
        header("location: dashboard.php");
        exit();
    } else {
        // Reloads the login screen
        header("location: index.php");
    }
?>