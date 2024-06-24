<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include 'connect.php'; // Include database connection

// Query to fetch the latest entry based on date
$sql = "SELECT event, venue, date, data FROM activity_reports ORDER BY date DESC LIMIT 1";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $response = [
        'status' => 'success',
        'event' => $row['event'],
        'venue' => $row['venue'],
        'date' => $row['date'],
        'data' => $row['data']
    ];
    echo json_encode($response);
} else {
    $response = [
        'status' => 'error',
        'message' => 'No activity reports found'
    ];
    echo json_encode($response);
}

$conn->close();
?>
