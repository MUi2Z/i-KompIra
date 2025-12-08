<?php $oof = 1;// include '../backend/connection.php'; ?>

<?php
// Define the function to handle the signup process
    function secure_user_signup($conn) {
        // Check if the request method is POST and necessary fields are set
        if ($_SERVER["REQUEST_METHOD"] !== "POST" || !isset($_POST['email'], $_POST['password'])) {
            http_response_code(405); // Method Not Allowed or Missing Data
            die("Invalid request method or missing data.");
        }

        $email = trim($_POST['email']);
        $plain_password = $_POST['password'];

        // --- Basic Input Validation --- 
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            die("Error: Invalid email format.");
        }

        // You can add more checks here (e.g., password length, complexity)
        if (strlen($plain_password) < 8) {
            die("Error: Password must be at least 8 characters long.");
        }

        // --- Password Hashing (CRITICAL SECURITY STEP) ---
        // PASSWORD_DEFAULT ensures the best, most up-to-date hashing algorithm (currently bcrypt)
        $password_hash = password_hash($plain_password, PASSWORD_DEFAULT);

        // Check if hashing failed (rare, but good practice)
        if ($password_hash === false) {
            error_log("Password hashing failed for user: " . $email);
            die("Error processing request.");
        }

        // =====================================================================
        // 3. PREPARED STATEMENT FOR SECURE INSERTION (PREVENTS SQL INJECTION)
        // =====================================================================

        // Assume you have a table named 'users' with columns: id (AUTO_INCREMENT), email, password_hash
        $sql = "INSERT INTO users (email, password_hash) VALUES (?, ?)";

        // Prepare the statement
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            // Log error if preparation fails (usually due to bad SQL syntax or connection issue)
            error_log("SQL Prepare Error: " . $conn->error);
            die("An internal error occurred.");
        }

        // Bind parameters: 'ss' means two string variables
        // The prepared statement is sent to the database first, then the data is sent separately.
        // This separation is what prevents SQL injection.
        $stmt->bind_param("ss", $email, $password_hash);

        // Execute the statement
        if ($stmt->execute()) {
            // Success response
            echo "User registered successfully!";
            // In a real application, you would typically redirect the user here
            // header("Location: success.html"); 
        } else {
            // Handle execution failure (e.g., duplicate email if column is set to UNIQUE)
            if ($conn->errno === 1062) { // MySQL error code for duplicate entry
                http_response_code(409); // Conflict
                echo "Error: This email is already registered.";
            } else {
                error_log("Execution Error: " . $stmt->error);
                die("Registration failed. Please try again.");
            }
        }

        // Close the statement
        $stmt->close();
    }

    // =========================================================================
    // 4. EXECUTION AND CLEANUP
    // =========================================================================

    // Execute the signup function
    secure_user_signup($conn);

    // Close the database connection
    $conn->close();

?>