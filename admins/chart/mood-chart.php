<?php
include '../../database/dbconn.php';

$sql = "SELECT mood_type, COUNT(*) as count 
        FROM mood_checkin 
        WHERE mood_status = 'Active'
        GROUP BY mood_type";

$result = mysqli_query($conn, $sql);

$labels = [];
$data = [];

while ($row = mysqli_fetch_assoc($result)) {
    $labels[] = $row['mood_type'];
    $data[] = (int)$row['count'];
}

echo json_encode([
    'labels' => $labels,
    'data' => $data
]);
?>
