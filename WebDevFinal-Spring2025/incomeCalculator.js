// Wait for the full DOM to load before running any scripts
document.addEventListener("DOMContentLoaded", () => {
    const TAX_RATE = 0.25; // 25% tax rate applied to income

    // Get references to input fields and display elements
    const rateInput = document.getElementById("rate");       // Hourly rate input
    const hoursInput = document.getElementById("hours");     // Hours worked input
    const salaryInput = document.getElementById("salary");   // Annual salary input
    const amountDisplay = document.getElementById("amount"); // Element to display calculated net amount

    // Containers for showing/hiding based on pay type
    const hourlyFields = document.getElementById("hourly-fields");
    const salaryField = document.getElementById("salary-field");

    // Get radio buttons for selecting pay type (hourly or salary)
    const radioButtons = document.querySelectorAll("input[name='pay-type']");

    // Helper funtion to calculate income after tax
    function getNetMonthly(amount) {
        return amount * (1 - TAX_RATE);
    }

    // Main function to calculate income based on selected pay type
    function calculateAmount() {
        const selectedType = document.querySelector("input[name='pay-type']:checked")?.value;

        if (selectedType === "hourly") {
            const rate = parseFloat(rateInput.value);
            const hours = parseFloat(hoursInput.value);

            // Only calculate if both inputs are valid numbers
            if (!isNaN(rate) && !isNaN(hours)) {
                const total = rate * hours;
                amountDisplay.textContent = getNetMonthly(total).toFixed(2); // Show net amount
            }
        } else if (selectedType === "salary") {
            const salary = parseFloat(salaryInput.value);

            // Only calculate if salary is a valid number
            if(!isNaN(salary)) {
                const monthlySalary = salary / 12;
                amountDisplay.textContent = getNetMonthly(monthlySalary).toFixed(2); // Show net monthly salary
            }
        }
    }

    // Set up event listeners for when the user selects a pay type
    radioButtons.forEach(radio => {
        radio.addEventListener("change", () => {
            const selectedType = document.querySelector("input[name='pay-type']:checked")?.value;

            // Show/hide fields based on selected pay type
            if (selectedType === "hourly") {
                hourlyFields.style.display = "block";
                salaryField.style.display = "none";
            } else if (selectedType === "salary") {
                salaryField.style.display = "block";
                hourlyFields.style.display = "none";
            }

            // Immediately calculate the amount when switching pay types
            calculateAmount();
        });
    });

    // Recalculate amount in real time as input values change
    rateInput.addEventListener("input", calculateAmount);
    hoursInput.addEventListener("input", calculateAmount);
    salaryInput.addEventListener("input", calculateAmount);
});