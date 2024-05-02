<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>
</head>
<body>
    <!-- Price range slider -->
    <form action="shop_page.php" method="GET">
        <label for="min_price">Min Price:</label>
        <input type="number" id="min_price" name="min_price" value="<?php echo $min_price; ?>" min="0" step="1">
        <label for="max_price">Max Price:</label>
        <input type="number" id="max_price" name="max_price" value="<?php echo $max_price; ?>" min="0" step="1">
        <input type="submit" value="Apply">
    </form>

    <!-- Display products -->
    <?php
    // Display products (assuming $result is already fetched)
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
    echo "<div class='pagination'>";
    for ($i = 1; $i <= $total_pages; $i++) {
        echo "<a href='shop.php?page=" . $i . "'>" . $i . "</a>";
    }
    echo "</div>";


    // Previous button
if ($page > 1) {
    echo "<a href='shop.php?page=" . ($page - 1) . "' class='pagination-button'>Previous</a>";
}

// Pagination buttons
echo "<div class='pagination'>";
for ($i = 1; $i <= ceil($result->num_rows / $results_per_page); $i++) {
    if ($page == $i) {
        echo "<span class='current-page'>$i</span>";
    } else {
        echo "<a href='shop.php?page=$i' class='pagination-button'>$i</a>";
    }
}
echo "</div>";

// Next button
if ($page < ceil($result->num_rows / $results_per_page)) {
    echo "<a href='shop.php?page=" . ($page + 1) . "' class='pagination-button'>Next</a>";
}



    
    ?>
</body>
</html>
