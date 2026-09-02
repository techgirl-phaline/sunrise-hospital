// ================================================================
// JAVASCRIPT VALIDATION FOR APPOINTMENT FORM
// ================================================================

// Wait for the page to load completely
document.addEventListener('DOMContentLoaded', function() {

    // Get the form and the error message div
    const form = document.getElementById('appointmentForm');
    const errorDiv = document.getElementById('errorMessages');

    // When the user clicks "Submit", run validation
    form.addEventListener('submit', function(event) {

        // Clear previous error messages
        errorDiv.innerHTML = '';
        let errors = [];

        // 1. Get all input values
        const patientName = document.getElementById('patient_name').value.trim();
        const nationalId = document.getElementById('national_id').value.trim();
        const gender = document.getElementById('gender').value;
        const phone = document.getElementById('phone').value.trim();
        const email = document.getElementById('email').value.trim();
        const department = document.getElementById('department').value;
        const appointmentDate = document.getElementById('appointment_date').value;

        // ========== VALIDATION RULES ==========

        // 2. Patient Name: must not be empty
        if (patientName === '') {
            errors.push('❌ Patient Name is required.');
        }

        // 3. National ID: must not be empty AND must be a number (at least 5 digits)
        if (nationalId === '') {
            errors.push('❌ National ID Number is required.');
        } else if (isNaN(nationalId) || nationalId.length < 5) {
            errors.push('❌ National ID must be a valid number (at least 5 digits).');
        }

        // 4. Gender: must be selected
        if (gender === '') {
            errors.push('❌ Please select your Gender.');
        }

        // 5. Phone Number: must not be empty AND must be valid Kenyan format
        if (phone === '') {
            errors.push('❌ Phone Number is required.');
        } else {
            // Valid formats: 0712345678 or +254712345678
            const phoneRegex = /^(0|\+254)\d{9}$/;
            if (!phoneRegex.test(phone)) {
                errors.push('❌ Please enter a valid Kenyan phone number (e.g., 0712345678 or +254712345678).');
            }
        }

        // 6. Email Address: must not be empty AND must be valid format
        if (email === '') {
            errors.push('❌ Email Address is required.');
        } else {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                errors.push('❌ Please enter a valid email address (e.g., name@example.com).');
            }
        }

        // 7. Department: must be selected
        if (department === '') {
            errors.push('❌ Please select a Department.');
        }

        // 8. Appointment Date: must not be empty AND must not be in the past
        if (appointmentDate === '') {
            errors.push('❌ Appointment Date is required.');
        } else {
            const today = new Date();
            today.setHours(0, 0, 0, 0); // Reset time to midnight
            const selectedDate = new Date(appointmentDate);
            if (selectedDate < today) {
                errors.push('❌ Appointment Date cannot be in the past. Please select today or a future date.');
            }
        }

        // ========== DISPLAY ERRORS OR SUBMIT ==========

        // If there are errors, stop form submission and show them
        if (errors.length > 0) {
            event.preventDefault(); // This prevents the form from sending to PHP
            errorDiv.innerHTML = errors.join('<br>'); // Show all errors with line breaks
            errorDiv.style.color = 'red';
            
            // Scroll up so the user can see the errors
            document.querySelector('.booking-form').scrollIntoView({ behavior: 'smooth' });
        } else {
            // No errors: allow submission
            errorDiv.style.color = '#00a8b5';
            errorDiv.innerHTML = '✅ Submitting your appointment... Please wait.';
        }
    });

    // ========== EXTRA: Clear errors when Reset button is clicked ==========
    document.querySelector('.btn-reset').addEventListener('click', function() {
        errorDiv.innerHTML = '';
        errorDiv.style.color = 'red';
    });

});
