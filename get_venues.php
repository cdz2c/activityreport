<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include 'connect.php'; // Include database connection

$sql = "SELECT DISTINCT venue FROM activity_reports";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $venues = [];
    while($row = $result->fetch_assoc()) {
        $venues[] = $row['venue'];
    }
    $response = [
        'status' => 'success',
        'venues' => $venues
    ];
    echo json_encode($response);
} else {
    $response = [
        'status' => 'error',
        'message' => 'No venues found'
    ];
    echo json_encode($response);
}

$conn->close();
?>
