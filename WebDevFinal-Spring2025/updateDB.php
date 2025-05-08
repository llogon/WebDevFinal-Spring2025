<?php
// Sets a specific ID for the session and starts it
session_id('0qp3hlbq1p8jiun0hhaj0tsd1o');
session_start();

// Include database connection
require_once 'db_connect.php';

// Retrieve the userID from the session
$userID = $_SESSION['userID'];

// Handle EXPENSE form submission
if($_POST['form-type'] === 'expense') {
    // Get form input values
    $name = $_POST['expense-name'];
    $cost = str_replace('$', '', $_POST['expense-cost']); // Remove any '$' symbol
    $cost = floatval($cost); // Convert cost back to floatval
    $dueBy = $_POST['expense-due']; // Due date for expense

    if($_POST['action'] === 'update') {
        // Update an existing expense
        $expenseID = $_POST['expense-id'];

        $stmt = $db->prepare("UPDATE Expense SET name = :name, cost = :cost, dueBy = :dueBy WHERE expenseID = :expenseID");
        $stmt->execute([
            'expenseID' => $expenseID,
            'name' => $name, 
            'cost' => $cost,
            'dueBy' => $dueBy
        ]);
    } else if($_POST['action'] === 'add') {
        // Insert a new expense
        $stmt = $db->prepare("INSERT INTO Expense (userID, name, cost, dueBy) VALUES (:userID, :name, :cost, :dueBy)");
        $stmt->execute([
            'userID' => $userID,
            'name' => $name,
            'cost' => $cost,
            'dueBy' => $dueBy
        ]);
    } else if($_POST['action'] === 'delete') {
        // Delete an expense
        $expenseID = $_POST['expense-id'];
        $stmt = $db->prepare("DELETE FROM Expense WHERE expenseID = :expenseID AND userID = :userID");
        $stmt->execute([
            'expenseID' => $expenseID,
            'userID' => $userID
        ]);
    }

    // Reloads the page to see changes made
    header("Location: budget.php");
    exit();
} 

 // Handles EXTRA form submission
else if ($_POST['form-type'] === 'extra') {
    // Get form input values
    $name = $_POST['extra-name'];
    $amount = str_replace('$', '', $_POST['extra-amount']); // Remove any '$' symbol
    $amount = floatval($amount); // Convert amount to float

    if($_POST['action'] === 'extra-update') {
        // Update existing extra
        $extraID = $_POST['extra-id'];

        $stmt = $db->prepare("UPDATE Extra SET name = :name, amount = :amount WHERE extraID = :extraID");
        $stmt->execute([
            'extraID' => $extraID,
            'name' => $name,
            'amount' => $amount
        ]);
    } else if ($_POST['action'] === 'extra-add') {
        // Insert a new extra 
        $stmt = $db->prepare("INSERT INTO Extra (userID, name, amount) VALUES (:userID, :name, :amount)");
        $stmt->execute([
            'userID' => $userID,
            'name' => $name,
            'amount' => $amount
        ]);
    } else if ($_POST['action'] === 'extra-delete') {
        // Delete extra 
        $extraID = $_POST['extra-id'];
        
        $stmt = $db->prepare("DELETE FROM Extra WHERE extraID = :extraID AND userID = :userID");
        $stmt->execute([
            'extraID' => $extraID,
            'userID' => $userID
        ]);
    }
} 

// Handle INCOME form submission
else if($_POST['form-type'] === 'income') {
        $payType = $_POST['pay-type']; // Check if user selected hourly or salary

        if($payType === 'hourly') {
            // Calculate income based on hourly rate and hours worked
            $hourly = floatval($_POST['rate']);
            $hoursWorked = floatval($_POST['hours']);
            $amount = $hourly * $hoursWorked;

            // Check if income record exists
            $stmt = $db->prepare("SELECT incomeID FROM Income WHERE userID = :userID");
            $stmt->execute(['userID' => $userID]);
            $existingIncome = $stmt->fetch();

            if($existingIncome) {
                // Update existing income record
                $stmt = $db->prepare("UPDATE Income SET salary = NULL, hourly = :hourly, hoursWorked = :hoursWorked, amount = :amount WHERE userID = :userID");
            } else {
                // Insert new income record
                $stmt = $db->prepare("INSERT INTO Income (salary, hourly, hoursWorked, amount, userID) VALUES (NULL, :hourly, :hoursWorked, :amount, :userID)");
            }

            $stmt->execute([
                'hourly' => $hourly,
                'hoursWorked' => $hoursWorked,
                'amount' => $amount,
                'userID'=> $userID
            ]);
        } else if ($payType === 'salary') {
            // Calculate monthly salary income
            $salary = floatval($_POST['salary']);
            $amount = $salary / 12.0; // Monthly amount

            // Check if income record exists
            $stmt = $db->prepare("SELECT incomeID FROM Income WHERE userID = :userID");
            $stmt->execute(['userID' => $userID]);
            $existingIncome = $stmt->fetch();

            if($existingIncome) {
                // Update income with salary values
                $stmt = $db->prepare("UPDATE Income SET salary = :salary, hourly = NULL, hoursWorked = NULL, amount = :amount WHERE userID = :userID");
            } else {
                // Insert new salary-based income
                $stmt = $db->prepare("INSERT INTO Income (salary, hourly, hoursWorked, amount, userID) VALUES (:salary, NULL, NULL, :amount, :userID)");
            }

            $stmt->execute([
                'salary' => $salary,
                'amount' => $amount,
                'userID' => $userID
            ]);
        }
    }

    // Reloads page to see new changes
    header("Location: budget.php");
    exit();
?>