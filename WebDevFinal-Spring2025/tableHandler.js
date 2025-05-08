// Run the following functions once the DOM is fully loaded
window.addEventListener('DOMContentLoaded', () => {
    setupExpenseTable(); // Set up click handlers for the expense table
    setupExtraTable();   // Set up click handlers for the extra table
});

function setupExpenseTable() {
    // Reference to the expense table and input fields for editing
    const expenseTable = document.getElementById('expenses-table');
    const expenseNameInput = document.getElementById('expense-name');
    const expenseCostInput = document.getElementById('expense-cost');
    const expenseDueInput = document.getElementById('expense-due');
    const expenseIdInput = document.getElementById('expense-id');

    // Add a click listener to each row in the expense table
    expenseTable.querySelectorAll('tbody tr').forEach(row => {
        row.addEventListener('click', () => {
            const cells = row.querySelectorAll('td');

            // Populate the form inputs with the clicked row's data
            expenseIdInput.value = cells[0].textContent.trim();   // Hidden ID field
            expenseNameInput.value = cells[1].textContent.trim(); // Expense name
            expenseCostInput.value = cells[2].textContent.trim(); // Expense cost
            expenseDueInput.value = cells[3].textContent.trim();  // Due date
        });
    });
}

function setupExtraTable() {
    // Reference to the extra table and input fields for editing
    const extraTable = document.getElementById('extra-table');
    const extraNameInput = document.getElementById('extra-name');
    const extraAmountInput = document.getElementById('extra-amount');
    const extraIDInput = document.getElementById('extra-id');

    // Add a click listener to each row in the extra expense table
    extraTable.querySelectorAll('tbody tr').forEach(row => {
        row.addEventListener('click', () => {
            const cells = row.querySelectorAll('td');

            // Populate the form inputs with the clicked row's data
            extraIDInput.value = cells[0].textContent.trim();     // Hidden ID field
            extraNameInput.value = cells[1].textContent.trim();   // Extra item name
            extraAmountInput.value = cells[2].textContent.trim(); // Extra item amount
        });
    });
}