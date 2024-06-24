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

// Check if entry with the same event and venue exists
$sql = "SELECT * FROM activity_reports WHERE `event` = '$event' AND `venue` = '$venue' AND `date` = '$date'";
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
