<?php
include '../../database/dbconn.php';

$sql = "SELECT q.type, COUNT(*) AS total
        FROM user_quotes uq
        JOIN quotes_library q ON uq.quotes_id = q.quotes_id
        WHERE q.quotes_status = 'Active'
        GROUP BY q.type";

$result = mysqli_query($conn, $sql);

$types = [];
$counts = [];

while ($row = mysqli_fetch_assoc($result)) {
    $types[] = $row['type'];
    $counts[] = $row['total'];
}

echo json_encode([
    'labels' => $types,
    'data' => $counts
]);
?>
