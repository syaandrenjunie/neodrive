<?php
include '../../database/dbconn.php';

$sql = "SELECT pc_type, COUNT(*) as count 
        FROM photocard_library 
        WHERE pc_status = 'Active'
        GROUP BY pc_type";

       


$result = mysqli_query($conn, $sql);

$labels = [];
$data = [];

while ($row = mysqli_fetch_assoc($result)) {
    $labels[] = $row['pc_type'];
    $data[] = (int)$row['count'];
}

echo json_encode([
    'labels' => $labels,
    'data' => $data
]);
?>
