<?php
include '../../database/dbconn.php';

$sql = "SELECT u.username, COUNT(ts.session_id) AS session_count
        FROM timer_sessions ts
        JOIN users u ON ts.user_id = u.user_id
        WHERE ts.status = 'completed'
        GROUP BY ts.user_id
        ORDER BY session_count DESC
        LIMIT 5";

$result = mysqli_query($conn, $sql);

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

echo json_encode($data);
?>
