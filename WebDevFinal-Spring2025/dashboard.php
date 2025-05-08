<?php
// Set a specific session ID and start the session\
session_id('0qp3hlbq1p8jiun0hhaj0tsd1o'); 
session_start();

// Include the database connection
require_once 'db_connect.php';

// Retrieve session variables
$username = $_SESSION['username'];
$userID = $_SESSION['userID'];

// Retrieve income-related data for the userID
$stmt = $db->prepare("SELECT salary, hourly, hoursWorked, amount FROM Income where userID = :userID");
$stmt->execute(['userID' => $userID]);
$balance = $stmt->fetch();

// Adjust salary and amount for taxes (25% assumed)
$salary = ($balance['salary'] / 12) * (1 - 0.25); // Monthly salary after tax
$hourly = $balance['hourly'];                     // Hourly rate 
$hoursWorked = $balance['hoursWorked'];           // Hours worked
$amount = $balance['amount'] * (1 - 0.25);;       // Calculated amount after tax

// Retrieve total cost for all expenses
$stmt = $db->prepare("SELECT sum(cost) FROM Expense WHERE userID = :userID");
$stmt->execute(['userID' => $userID]);
$sumCost = $stmt->fetchColumn();

// Retrieve total amount of extra expenses
$stmt = $db->prepare("SELECT sum(amount) FROM Extra WHERE userID = :userID");
$stmt->execute(['userID' => $userID]);
$sumAmount = $stmt->fetchColumn();

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Dashboard</title>
        <link rel="stylesheet" type="text/css" href="dashboard.css">
        <script type="text/javascript" src="incomeCalculator.js"></script>
    </head>
    <body>
        <div class="container">
            <div class="left-column">
                <!-- Welcome message -->
                <div class="box">
                    <h2>Welcome back, <?php echo "<p>$username!</p>" ?></h2>
                </div>

                <!-- Navigation buttons -->
                <div>
                    <button onclick="location.href='budget.php'">UPDATE</button>
                    <button onclick="location.href='index.php'">LOGOUT</button>
                </div>
            </div>

            <div class="right-column">
                <!-- Display balance before expenses -->
                <div class="box">
                    <h3>Balance (before expenses):</h3>
                        <p>
                            <?php
                                // Re-fetch balance for display
                                $stmt = $db->prepare("SELECT salary, hourly, hoursWorked, amount FROM Income where userID = :userID");
                                $stmt->execute(['userID' => $userID]);
                                $balance = $stmt->fetch();

                                if($balance) {
                                    if(!empty($salary)) {
                                        echo "<p>$ $salary</p>"; // Show salary
                                    } else {
                                        $total = $hourly * $hoursWorked;
                                        echo "<p>$" . number_format($total, 2) . "</p>"; // Show hourly * hours
                                    }
                                } else {
                                    echo "$0"; // No income data found
                                }
                            ?>
                        </p>
                </div>

                <!-- Display remaining balance after all expenses -->
                <div class="box">
                    <h3>Remaining Balance:</h3>
                        <p>
                        <?php
                            if(!empty($salary)) {
                                $remainingSalary = $salary - $sumCost - $sumAmount;
                                echo "<p>$" . number_format($remainingSalary, 2) . "</p>"; // Net balance
                            }
                        ?>
                        </p>
                </div>

                <!-- Expense table -->
                <div class="box" style="grid-column: span 2;">
                    <h2>Expenses</h2>
                    <div id="expense-box" style="height: 50vh;">
                        <table>
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Cost</th>
                                    <th>Due By</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    // Fetch all expenses for user
                                    $stmt = $db->prepare("SELECT name, cost, dueBy FROM Expense where userID = :userID");
                                    $stmt->execute(['userID' => $userID]);
                                    $expenses = $stmt->fetchAll();

                                    // Output each expense row in the table
                                    foreach ($expenses as $expense) {
                                        echo "<tr>
                                                <td>" . htmlspecialchars($expense['name']) . "</td>
                                                <td> $" . htmlspecialchars($expense['cost']) . "</td>
                                                <td>" . htmlspecialchars($expense['dueBy']) . "</td>
                                              </tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Extra expense table -->
                <div class="box" style="grid-column: span 2;">
                    <h2>Extra Expenses</h2>
                    <div id="extra-box" style="height: 50vh;">
                        <table>
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php  
                                    // Fetch all extra expenses for user
                                    $stmt = $db->prepare("SELECT name, amount FROM Extra where userID = :userID");
                                    $stmt->execute(['userID' => $userID]);
                                    $extras = $stmt->fetchAll();

                                    // Output each extra row in the table
                                    foreach ($extras as $extra) {
                                        echo "<tr>
                                                <td>" . htmlspecialchars($extra['name']) . "</td>
                                                <td> $" . htmlspecialchars($extra['amount']) . "</td>
                                              </tr>";
                                    }
                                ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>