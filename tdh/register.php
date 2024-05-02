<?php

include_once 'db_connect.php';

// Function to sanitize user inputs
function sanitize_input($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

// Function ti register user
function  registerUser() {
    global $conn;

    // Retrieve POST data and decode Base64 encoded fields
    $username = sanitize_input(base64_decode($_POST['username']));
    $email = sanitize_input(base64_decode($_POST['email']));
    $password = sanitize_input(base64_decode($_POST['password']));
    $contact = sanitize_input(base64_decode($_POST['contact']));
    $PAN = sanitize_input(base64_decode($_POST['PAN']));
    $address = sanitize_input(base64_decode($_POST['address']));
    $GST_certificate = sanitize_input($_POST['GST_certificate']); 
    $address_proof = sanitize_input($_POST['address_proof']); 

    // Validate input data
    if (empty($username) || empty($email) || empty($password) || empty($contact) || empty($PAN) || empty($GST_certificate) || empty($address_proof)) {
        
        echo "All fields are required.";

        if(preg_match('/^[0-9]{10}+$/', $contact)) {
            echo "Valid Phone Number";
            } else {
            echo "Invalid Phone Number";
            }
    }
    
    $sql = "INSERT INTO registration (username, email, password, contact, PAN, address, GST_certificate, address_proof) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssisss", $username, $email, $password, $contact, $PAN, $address, $GST_certificate, $address_proof);

    if ($stmt->execute()) {
        echo "Registration Successful";
       // $stmt->close();
        return true;
    } else {
        echo "Error: " . $conn->error;
       // $stmt->close();
        return false;
    }
    
    $stmt->close();
    
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $register = registerUser();
    if ($register){
        echo "Success: True";
        echo "Registration Successful";
    }

else {
    echo "Success: False";
    echo "Registration Failed";
}
}



?>




<!-- 

function validating($phone){
if(preg_match('/^[0-9]{10}+$/', $phone)) {
echo " Valid Phone Number";
} else {
echo " Invalid Phone Number";
}
} -->