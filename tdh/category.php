<?php
// Check if category is provided in the URL
if (isset($_GET['category'])) {
    $category = $_GET['category'];
} else {
    // Handle case when category is not provided
    echo "Category not specified.";
    exit(); // Stop further execution
}

// Function to get products by category
function getProductsByCategory($category) {
    // Database connection
    include_once 'db_connect.php';
    
    // Prepare SQL statement to retrieve products by category
    $stmt = $conn->prepare("SELECT * FROM products WHERE category = ?");
    $stmt->bind_param("s", $category);
    
    // Execute the query
    $stmt->execute();
    
    // Get result set
    $result = $stmt->get_result();
    
    // Check if there are any products
    if ($result->num_rows > 0) {
        // Fetch products as associative array
        $products = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        // No products found
        $products = array();
    }
    
    // Close statement and connection
    $stmt->close();
    $conn->close();
    
    return $products;
}

// Retrieve products by the clicked category
$products = getProductsByCategory($category);

// Display products
if (!empty($products)) {
    foreach ($products as $product) {
        echo "<div>";
        echo "<img src='" . $product["image"] . "' alt='" . $product["pname"] . "'>";
        echo "<h2>" . $product["pname"] . "</h2>";
        echo "<p>Price: $" . $product["price"] . "</p>";
        echo "<button>Add to Cart</button>";
        echo "</div>";
    }
} else {
    echo "No products found for category: $category";
}
?>
