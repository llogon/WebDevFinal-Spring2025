<?php
// Start a new or resume an existing session
session_start();

// Include database connection script
require_once 'db_connect.php';

// Clears all session variables (Ensures all users are logged out)
$_SESSION = array(); 
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>FRUGL LOGIN</title>
        <link rel="stylesheet" type="text/css" href="styles.css">
    </head>
    <body>
        <div class="login-box">
            <h1>FRUGL</h1>

            <!-- Login form that sends data to validateLogin.php using POST method -->
            <form id="loginForm" action="loginHandler.php" method="post">
                <!-- Username input field -->
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="admin" required>

                <!-- Password input field -->
                <label for="password">Password</label>
                <input type="password" id="password" name="password" value="admin1234" required>

                <!-- Form submit button -->
                <button type="submit" value="Login">LOGIN</button>
            </form>
            
            <!-- Button to navigate to the About Page -->
            <button type="text" value="about-page" onclick="location.href='about-page.html'">About Page</button>
        
        </div>
    </body>
</html>