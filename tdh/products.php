<?php
// Function to get products by both brand and category
function getProductsByBrandAndCategory($brand_name, $category_name) {
    // Database connection
    include_once 'db_connect.php';
    
    // Retrieve brand ID based on brand name
    $stmt_brand = $conn->prepare("SELECT bid FROM brands WHERE bname = ?");
    $stmt_brand->bind_param("s", $brand_name);
    $stmt_brand->execute();
    $result_brand = $stmt_brand->get_result();
    $brand_row = $result_brand->fetch_assoc();
    $brand_id = $brand_row['bid'];
    $stmt_brand->close();

    // Retrieve category ID based on category name
    $stmt_category = $conn->prepare("SELECT cid FROM categories WHERE cname = ?");
    $stmt_category->bind_param("s", $category_name);
    $stmt_category->execute();
    $result_category = $stmt_category->get_result();
    $category_row = $result_category->fetch_assoc();
    $category_id = $category_row['cid'];
    $stmt_category->close();

    // Prepare SQL statement to retrieve products by brand and category
    $stmt_products = $conn->prepare("SELECT * FROM products WHERE brand_id = ? AND category_id = ?");
    $stmt_products->bind_param("ii", $brand_id, $category_id);
    $stmt_products->execute();

    // Get result set
    $result_products = $stmt_products->get_result();
    
    $products = array();
    if ($result_products->num_rows > 0) {
        while ($row = $result_products->fetch_assoc()) {
            $products[] = $row;
        }
    }
    
    // Close statement and connection
    $stmt_products->close();
    $conn->close();
    
    return $products;
}

// Example usage:
$brand_name = "Apple"; // Replace with the selected brand name
$category_name = "Mobiles"; // Replace with the selected category name
$products = getProductsByBrandAndCategory($brand_name, $category_name);

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
    echo "No products found for the selected brand and category.";
}
?>
