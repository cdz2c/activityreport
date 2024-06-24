<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include 'connect.php'; // Include database connection

// Query to fetch distinct events
$sql = "SELECT DISTINCT event FROM activity_reports";
$result = $conn->query($sql);

$events = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $events[] = $row['event'];
    }
}

$response = [
    'status' => 'success',
    'events' => $events
];

echo json_encode($response);

$conn->close();
?>
