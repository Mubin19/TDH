<?php
// Include database connection
include_once 'db_connect.php';

// Function to retrieve products by brand
function displayProductsByBrand($brand_id) {
    global $conn;

    // Prepare SQL statement to retrieve products by brand
    $stmt = $conn->prepare("SELECT * FROM products WHERE brand_id = ?");
    $stmt->bind_param("i", $brand_id);
    $stmt->execute();

    // Get result set
    $result = $stmt->get_result();

    // Check if products are found for the brand
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
        // No products found for the brand
        echo "No products found for the selected brand.";
    }

    // Close statement
    $stmt->close();
}

// Check if brand_id is provided in the request
if (isset($_GET['brand_id'])) {
    // Sanitize and retrieve the brand_id from the request
    $brand_id = $_GET['brand_id'];

    // Call the function to display products by brand
    displayProductsByBrand($brand_id);
} else {
    // brand_id parameter is missing
    echo "brand_id parameter is required.";
}

// Close database connection
$conn->close();
?>
