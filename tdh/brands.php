<?php
// Check if brand is provided in the URL
if (isset($_GET['brand'])) {
    $brand = $_GET['brand'];
} else {
    // Handle case when brand is not provided
    echo "Brand not specified.";
    exit(); // Stop further execution
}

// Function to get products by brand
function getProductsByBrand($brand) {
    // Database connection
    include_once 'db_connect.php';
    
    // Prepare SQL statement to retrieve products by brand
    $stmt = $conn->prepare("SELECT * FROM products WHERE brands = ?");
    $stmt->bind_param("s", $brand);
    
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

$products = getProductsByBrand($brand);

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
    echo "No products found for brand: $brand";
}
?>
