<?php
// Include database connection
include_once 'db_connect.php';

// Function to retrieve and display list of categories
function displayCategories() {
    global $conn;

    // Prepare SQL statement to retrieve categories
    $sql = "SELECT * FROM categories";
    $result = $conn->query($sql);

    // Check if categories are found
    if ($result->num_rows > 0) {
        // Fetch and display categories
        while ($row = $result->fetch_assoc()) {
            echo "<a href='?category_id=" . $row['cid'] . "'>" . $row['cname'] . "</a><br>";
        }
    } else {
        // No categories found
        echo "No categories found.";
    }
}

// Function to retrieve and display products by category
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

            // echo "<img src='" . $row["image"] . "' alt='" . $row["pname"] . "'>";
        //     echo "<img src='" . $row["image"] . "' alt='" . $row["pname"] . "' style='max-width: 200px; max-height: 200px;'><br>";

            // Output image directly from database blob
            echo '<img src="data:image/jpeg;base64,' . base64_encode($row['image']) . '" alt="' . $row['pname'] . '" style="max-width: 200px; max-height: 200px;"><br>';

             // Output image directly from base64 encoded string
            // echo '<img src="data:image/jpeg;base64,' . $row['image'] . '" alt="' . $row['pname'] . '" style="max-width: 200px; max-height: 200px;"><br>';

            echo "<h3>Product Name: " . $row["pname"] . "</h3>";
            echo "<p>Price: $" . $row["price"] . "</p>";
            echo "<p>Description: $" . $row["description"] . "</p>";
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

// Check if a category is clicked
if (isset($_GET['category_id'])) {
    // Sanitize and retrieve the category_id from the request
    $category_id = $_GET['category_id'];

    // Call the function to display products by category
    displayProductsByCategory($category_id);
} else {
    // Display categories if no category is clicked
    displayCategories();
}

// Close database connection
$conn->close();
?>
