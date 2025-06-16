<?php
include '../../database/dbconn.php';

$sql = "SELECT DATE(updated_at) AS date, COUNT(*) AS completed_tasks
        FROM to_do_list
        WHERE is_completed = 1
        GROUP BY DATE(updated_at)
        ORDER BY DATE(updated_at) ASC
        LIMIT 30"; // adjust for recent 30 days if needed

$result = mysqli_query($conn, $sql);

$dates = [];
$counts = [];

while ($row = mysqli_fetch_assoc($result)) {
    $dates[] = $row['date'];
    $counts[] = $row['completed_tasks'];
}

echo json_encode([
    'labels' => $dates,
    'data' => $counts
]);
?>
