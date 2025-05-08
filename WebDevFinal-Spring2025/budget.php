<?php 
// Set a specific session ID and start session
session_id('0qp3hlbq1p8jiun0hhaj0tsd1o');
session_start();

// Include the database connection
require_once 'db_connect.php';

// Retrieve the current user's ID from the session
$userID = $_SESSION['userID']; // gets userID from session
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Budget</title>
    <link rel="stylesheet" type="text/css" href="budget.css">
    <script type="text/javascript" src="incomeCalculator.js"></script>
    <script type="text/javascript" src="tableHandler.js"></script>
</head>
<body>
    <div class="container">
        <section class="income-section">
            <div class="section-header">
                <h2>Income</h2>
            </div>
            <div class="checkboxes">
                <!-- Form to update income data -->
                <form id="changeDB-form" action="updateDB.php" method="POST">
                    <!-- Hidden inputs to pass context to the backend -->
                    <input type="hidden" name="form-type" value="income" />
                    <input type="hidden" name="action" value="update" />

                    <!-- Income type selection -->
                    <label>
                        <input type="radio" name="pay-type" value="hourly" />Hourly
                    </label>
                    <label>
                        <input type="radio" name="pay-type" value="salary" />Salary
                    </label>

                    <!-- Input fields for hourly workers (Hidden by default) -->
                    <div id="hourly-fields" style="display: none;">
                        <input type="number" id="rate" name="rate" placeholder="Hourly Rate" />
                        <input type="number" id="hours" name="hours" placeholder="Hours Worked" />
                    </div>

                    <!-- Input field for salaried workers (Hidden by default) -->
                    <div id="salary-field" style="display: none;">
                        <input type="number" id="salary" name="salary" placeholder="Yearly Salary" />
                    </div>

                    <!-- Display calculated monthly amount -->
                    <p>Monthly Amount: $<span id="amount">0.00</span></p>

                    <button type="submit" class="save-income">Save</button>
                </form>
        </section>

        <!-- Go back button -->
        <div class="buttons">
            <!-- Redirects to users dashboard -->
            <button class="go-back" onclick="location.href='dashboard.php'">Go Back</button>
        </div>

        <!-- Expenses Section -->
        <section class="expenses-section">
            <div class="section-header">
                <h2>Expenses</h2>
            </div>
            
            <!-- Form to update/add/delete expenses -->
            <form id="changeDB-form" action="updateDB.php" method="POST">
                <input type="hidden" name="form-type" value="expense" />

                <!-- Input fields for expense data -->
                <label>Name<input type="text" id="expense-name" name="expense-name" /></label>
                <label>Cost<input type="text" id="expense-cost" name="expense-cost" /></label>
                <label>Due By<input type="text" id="expense-due" name="expense-due" /></label>
                <label><input type="hidden" name="expense-id" id="expense-id" /></label>

                <!-- Action buttons -->
                <button type="submit" name="action" value="update">Update</button>
                <button type="submit" name="action" value="add">Add</button>
                <button type="submit" name="action" value="delete">Delete</button>
            </form>
            
            <!-- Table to display current expenses -->
            <div class="expenses-list">
                <table id="expenses-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Cost</th>
                            <th>Due By</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            // Fetch all expenses for the logged-in user
                            $stmt = $db->prepare("SELECT expenseID, name, cost, dueBy FROM Expense where userID = :userID");
                            $stmt->execute(['userID' => $userID]);
                            $expenses = $stmt->fetchAll();

                            // Populate table rows with expense data
                            foreach($expenses as $expense) {
                                echo "<tr>
                                        <td class='hidden-cell'>" . htmlspecialchars($expense['expenseID']) . "</td>
                                        <td>" . htmlspecialchars($expense['name']) . "</td>
                                        <td>$" . htmlspecialchars($expense['cost']) . "</td>
                                        <td>" . htmlspecialchars($expense['dueBy']) . "</td>
                                      </tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Extra section -->
        <section class="extra-section">
            <div class="section-header">
                <h2>Extra Expenses</h2>
                    <div class="extra-actions">
                        
                    </div>
            </div>

            <!-- Form to update/add/delete extra entities -->
            <form id="changeDB-form" action="updateDB.php" method="POST">
                <input type="hidden" name="form-type" value="extra" />

                <!-- Input fields for extra entities -->
                <label>Name<input type="text" id="extra-name" name="extra-name" /></label>
                <label>Amount<input type="text" id="extra-amount" name="extra-amount" /></label>
                <label><input type="hidden" name="extra-id" id="extra-id" /></label>

                <!-- Action buttons -->
                <button name="action" value="extra-update">Update</button>  
                <button name="action" value="extra-add">Add</button>
                <button name="action" value="extra-delete">Delete</button>
            </form>
            
            <!-- Table to display extra data -->
            <div class="extra-list">
                <table id="extra-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            // Fetch all extra entries for the current user
                            $stmt = $db->prepare("SELECT extraID, name, amount FROM Extra where userId = :userID");
                            $stmt->execute(['userID' => $userID]);
                            $extras = $stmt->fetchAll();

                            // Populate table rows with extra data
                            foreach ($extras as $extra) {
                                echo "<tr>
                                        <td class='hidden-cell'>" . htmlspecialchars($extra['extraID']) . "</td>
                                        <td>" . htmlspecialchars($extra['name']) . "</td>
                                        <td>$" . htmlspecialchars($extra['amount']) . "</td>
                                      </tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</body>
</html>