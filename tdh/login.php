<?php

include_once 'db_connect.php';

// Function to sanitize user inputs
function sanitize_input($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

// Function to authenticate user
function authenticateUser($email, $password) {
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM registration WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user with provided email exists
    if ($result->num_rows == 1) {
        // Fetch user data
        $user = $result->fetch_assoc();
        
        // Verify password
        if (password_verify($password, $user['password'])) {
           // return $user; // Authentication successful
           echo "Success: True";
        echo "Login Successful";
            return true;
        }

    }
    

    //return null; // Authentication failed
    return false;
    
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = sanitize_input($_POST['email']);
    $password = sanitize_input($_POST['password']);

    // Authenticate the user
    $user = authenticateUser($email, $password);
    if ($user) {
        echo "Success: True";
        echo "Login Successful";
        return true;
    
    } else {
        // Authentication failed
        echo "Success: False";
        echo "Invalid email or password!";
    }
    

}


authenticateUser("Mubin19", "Mubin@2000");

?>
