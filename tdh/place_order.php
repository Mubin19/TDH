<?php
// Include database connection file
include_once 'db_connect.php';

// Function to sanitize user inputs
function sanitize_input($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

// Function to place an order
function placeOrder($username, $email, $items) {
    global $conn;

    // Prepare SQL statement to insert order data
    $stmt = $conn->prepare("INSERT INTO orders (username, email, items) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $items);

    // Execute the statement
    if ($stmt->execute()) {
        return true; // Order placed successfully
    } else {
        return false; // Order placement failed
    }
}

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize form data
    $username = sanitize_input($_POST['username']);
    $email = sanitize_input($_POST['email']);
    $items = $_POST['items']; // Assuming items are passed as an array or serialized JSON

    // Place the order
    if (placeOrder($username, $email, $items)) {
        echo "Order placed successfully!";
    } else {
        echo "Order placement failed!";
    }
}
?>
