<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include 'connect.php'; // Include database connection

// Retrieve POST data
$data = json_decode(file_get_contents("php://input"), true);

// Extract data from JSON
$event = $conn->real_escape_string($data['event']);
$venue = $conn->real_escape_string($data['venue']);
$date = $conn->real_escape_string($data['date']);

// Check if entry with same date exists
$sql = "SELECT * FROM activity_reports WHERE date = '$date'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Entry with same date exists, perform update
    $sql_update = "UPDATE activity_reports SET event = '$event', venue = '$venue' WHERE date = '$date'";

    if ($conn->query($sql_update) === TRUE) {
        $response = [
            'status' => 'success',
            'message' => 'Record updated successfully'
        ];
        echo json_encode($response);
    } else {
        $response = [
            'status' => 'error',
            'message' => 'Error updating record: ' . $conn->error
        ];
        echo json_encode($response);
    }
} else {
    // Entry with same date does not exist, perform insert
    $sql_insert = "INSERT INTO activity_reports (event, venue, date) VALUES ('$event', '$venue', '$date')";

    if ($conn->query($sql_insert) === TRUE) {
        $response = [
            'status' => 'success',
            'message' => 'New record created successfully'
        ];
        echo json_encode($response);
    } else {
        $response = [
            'status' => 'error',
            'message' => 'Error creating record: ' . $conn->error
        ];
        echo json_encode($response);
    }
}

$conn->close();
?>
