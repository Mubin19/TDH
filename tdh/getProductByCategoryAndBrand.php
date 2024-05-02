<?php
// Include database connection
include_once 'db_connect.php';

// Function to retrieve products by both category and brand
function displayProductsByCategoryAndBrand($category_id, $brand_id) {
    global $conn;

    // Prepare SQL statement to retrieve products by both category and brand
    $stmt = $conn->prepare("SELECT * FROM products WHERE category_id = ? AND brand_id = ?");
    $stmt->bind_param("ii", $category_id, $brand_id);
    $stmt->execute();

    // Get result set
    $result = $stmt->get_result();

    // Check if products are found for the category and brand
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
        // No products found for the category and brand
        echo "No products found for the selected category and brand.";
    }

    // Close statement
    $stmt->close();
}

// Check if category_id and brand_id are provided in the request
if (isset($_GET['category_id']) && isset($_GET['brand_id'])) {
    // Sanitize and retrieve the category_id and brand_id from the request
    $category_id = $_GET['category_id'];
    $brand_id = $_GET['brand_id'];

    // Call the function to display products by both category and brand
    displayProductsByCategoryAndBrand($category_id, $brand_id);
} else {
    // category_id or brand_id parameter is missing
    echo "Both category_id and brand_id parameters are required.";
}

// Close database connection
$conn->close();
?>
