<?php
// Include database connection
include_once 'db_connect.php';

// Function to retrieve products by category
function displayProductsByCategory($category_id) {
    global $conn;

    // Prepare SQL statement to retrieve products by category
    $stmt = $conn->prepare("SELECT * FROM products WHERE category_id = ?");
    $stmt->bind_param("i", $category_id);
    $stmt->execute();

    // Get result set
    $result = $stmt->get_result();

    // Check if products are found for the category
    if ($result->num_rows > 0) {
        // Fetch and display products
        while ($row = $result->fetch_assoc()) {
            echo "<div>";
            echo "<h3>Product Name: " . $row["pname"] . "</h3>";
            echo "<p>Price: $" . $row["price"] . "</p>";
            echo "<img src='" . $row["image"] . "' alt='" . $row["pname"] . "'>";
            // Add more details as needed
            echo "</div>";
        }
    } else {
        // No products found for the category
        echo "No products found for the selected category.";
    }

    // Close statement
    $stmt->close();
}

// Check if category_id is provided in the request
if (isset($_GET['category_id'])) {
    // Sanitize and retrieve the category_id from the request
    $category_id = $_GET['category_id'];

    // Call the function to display products by category
    displayProductsByCategory($category_id);
} else {
    // category_id parameter is missing
    echo "category_id parameter is required.";
}

// Close database connection
$conn->close();
?>
