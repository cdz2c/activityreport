<?php
include 'connect.php'; // Include your database connection file

// Check if JSON data is received
$jsonData = file_get_contents('php://input');
if (!$jsonData) {
    die('No data received');
}

// Decode JSON data into associative array
$formData = json_decode($jsonData, true);

// Extract event, venue, and date from formData
$event = $formData['event'];
$venue = $formData['venue'];
$date = $formData['date'];

// Prepare JSON data to be inserted or updated in 'data' column
$data = json_encode($formData, JSON_UNESCAPED_UNICODE);

// Check if data for same date and event exists in database
$sql_check = "SELECT * FROM activity_reports WHERE event = ? AND date = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("ss", $event, $date);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    // Data already exists, update the existing record
    $sql_update = "UPDATE activity_reports SET data = ? WHERE event = ? AND date = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("sss", $data, $event, $date);

    if ($stmt_update->execute()) {
        echo "Data updated successfully";
    } else {
        echo "Error updating data: " . $conn->error;
    }
    $stmt_update->close();
} else {
    // No existing data, insert a new record
    $sql_insert = "INSERT INTO activity_reports (event, venue, date, data)
                   VALUES (?, ?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("ssss", $event, $venue, $date, $data);

    if ($stmt_insert->execute()) {
        echo "Data inserted successfully";
    } else {
        echo "Error inserting data: " . $conn->error;
    }
    $stmt_insert->close();
}

// Close prepared statement and database connection
$stmt_check->close();
$conn->close();
?>
