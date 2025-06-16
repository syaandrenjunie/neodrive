<?php
include '../../database/dbconn.php';

$sql = "SELECT status, COUNT(*) AS total
        FROM timer_sessions
        GROUP BY status";

$result = mysqli_query($conn, $sql);

$statuses = [];
$counts = [];

while ($row = mysqli_fetch_assoc($result)) {
    $statuses[] = ucfirst(str_replace('_', ' ', $row['status']));
    $counts[] = $row['total'];
}

echo json_encode([
    'labels' => $statuses,
    'data' => $counts
]);
?>
