<?php

include_once 'db_connect.php';

// Function to sanitize user inputs
function sanitize_input($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

// Function to generate a unique token // Generate a random 32-byte token and convert it to hexadecimal
function generateToken() {
    return bin2hex(random_bytes(32)); 
}

// Function to send email
function sendEmail($to, $subject, $message) {
    // Code to send email using a library like PHPMailer or using mail() function
}

// Function to handle forget password request
function forgetPassword($email) {
    global $conn;

    // Prepare SQL statement to check if the email exists
    $stmt = $conn->prepare("SELECT * FROM registration WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the email exists
    if ($result->num_rows == 1) {
        // Generate a unique token
        $token = generateToken();

        // Update the database with the token
        $updateStmt = $conn->prepare("UPDATE registration SET reset_token = ? WHERE email = ?");
        $updateStmt->bind_param("ss", $token, $email);
        $updateStmt->execute();

        // Send email with reset password link
        $resetLink = "http://example.com/reset_password.php?token=$token";
        $subject = "Password Reset Request";
        $message = "Dear User,\n\nYou have requested to reset your password. Please click the link below to reset your password:\n\n$resetLink\n\nIf you did not request this, please ignore this email.\n\nBest regards,\nThe Application Team";
       
        sendEmail($email, $subject, $message);
        return true; 
    } else {
      //  echo "Email not found";
        return false; 
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = sanitize_input($_POST['email']);

    // Handle forget password request
    if (forgetPassword($email)) {
        echo "Success: True";
        echo "An email with instructions to reset your password has been sent to $email successfully.";
        return true;
    } else {
        echo "Success: False";
        echo "Email not found. Please check the email address and try again.";
    }
}

?>
