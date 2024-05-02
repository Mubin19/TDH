<?php
// Database connection
include_once 'db_connect.php';


// Filter parameters
$category = isset($_GET['category']) ? $_GET['category'] : "";
$brand = isset($_GET['brand']) ? $_GET['brand'] : "";
$min_price = isset($_GET['min_price']) ? $_GET['min_price'] : 0;
$max_price = isset($_GET['max_price']) ? $_GET['max_price'] : 100000;

// Pagination parameters
$results_per_page = 10; // Number of products per page

if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}

$start_index = ($page - 1) * $results_per_page;

// Build SQL query based on filters
$sql = "SELECT * FROM products WHERE price BETWEEN $min_price AND $max_price";
if (!empty($category)) {
    $sql .= " AND category = '$category'";
}
if (!empty($brand)) {
    $sql .= " AND brand = '$brand'";
}
$sql .= " LIMIT $start_index, $results_per_page";

$result = $conn->query($sql);

// Display products
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Display product information (image, name, price, add to cart button)
        echo "<div>";
        echo "<img src='" . $row["image"] . "' alt='" . $row["pname"] . "'>";
        echo "<h2>" . $row["pname"] . "</h2>";
        echo "<p>Price: $" . $row["price"] . "</p>";
        echo "<button>Add to Cart</button>";
        echo "</div>";
    }
} else {
    echo "No products found.";
}

// Pagination links
$sql_total = "SELECT COUNT(*) AS total FROM products WHERE price BETWEEN $min_price AND $max_price";
if (!empty($category)) {
    $sql_total .= " AND category = '$category'";
}
if (!empty($brand)) {
    $sql_total .= " AND brand = '$brand'";
}

$result_total = $conn->query($sql_total);
$row_total = $result_total->fetch_assoc();
$total_pages = ceil($row_total["total"] / $results_per_page);


// echo "<div class='pagination'>";
// for ($i = 1; $i <= $total_pages; $i++) {
//     echo "<a href='shop.php?page=" . $i . "'>" . $i . "</a>";
// }
// echo "</div>";



// Previous button
if ($page > 1) {
    echo "<a href='shop_page.php?page=" . ($page - 1) . "' class='pagination-button'>Previous</a>";
}

// Pagination buttons
echo "<div class='pagination'>";
for ($i = 1; $i <= ceil($result->num_rows / $results_per_page); $i++) {
    if ($page == $i) {
        echo "<span class='current-page'>$i</span>";
    } else {
        echo "<a href='shop_page.php?page=$i' class='pagination-button'>$i</a>";
    }
}
echo "</div>";

// Next button
if ($page < ceil($result->num_rows / $results_per_page)) {
    echo "<a href='shop_page.php?page=" . ($page + 1) . "' class='pagination-button'>Next</a>";
}


$conn->close();
?>
