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
            echo "<a href='get_products_by_category.php?category_id=" . $row['cid'] . "'>" . $row['cname'] . "</a><br>";
        }
    } else {
        // No categories found
        echo "No categories found.";
    }
}

// Call the function to display categories
displayCategories();

// Close database connection
$conn->close();
?>
