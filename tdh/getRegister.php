<?php
// Include database connection file
include_once 'db_connect.php';

// Function to sanitize user inputs
function sanitize_input($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

// Function to retrieve registration data from the database and return as JSON with Base64 encoded values
function getRegistrationData() {
    global $conn;

    // Retrieve all registration data from the database
    $sql = "SELECT * FROM registration";
    $result = $conn->query($sql);

    // Check if there are any rows returned
    if ($result->num_rows > 0) {
        // Initialize an empty array to store the data
        $data = array();

        // Fetch each row from the result set and store it in the data array
        while ($row = $result->fetch_assoc()) {
            // Encode each field value in Base64
            foreach ($row as $key => $value) {
                $row[$key] = json_encode($value);
                //$row[$key] = base64_encode($value);
                

            }
            $data[] = $row;
        }

        // Convert the data array to JSON format
        $json_data = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        return $json_data;
    } else {
        // If no data is found, return an empty JSON array
        return json_encode(array());
    }
}

// Check if the request method is GET
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Get registration data and output as JSON with Base64 encoded values
    $registration_data = getRegistrationData();
    header('Content-Type: application/json');
    echo $registration_data;
}
?>


