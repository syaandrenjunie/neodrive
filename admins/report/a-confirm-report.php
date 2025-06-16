<?php
include("../../include/auth.php"); 
check_role('admin');

require '../../libs/dompdf/autoload.inc.php';
use Dompdf\Dompdf;

include '../../database/dbconn.php';
session_start();

if (isset($_POST['generate_report'])) {
    $report_type = $_POST['report_type'];
    $admin_id = $_SESSION['user_id'];
    $params = $_POST['params'] ?? [];
    $from = $_POST['from_date'] ?? null;
    $to = $_POST['to_date'] ?? null;

    $json_params = json_encode([
        'params' => $params,
        'from' => $from,
        'to' => $to
    ]);

    $data = [];

    // === USER REPORT ===
    if ($report_type === 'user') {
        $sql = "SELECT * FROM users";
        $result = mysqli_query($conn, $sql);

    // === POMODORO REPORT ===
    } elseif ($report_type === 'pomodoro') {
        $sql = "SELECT * FROM timer_sessions WHERE 1";
        if ($from && $to) {
            $sql .= " AND DATE(created_at) BETWEEN ? AND ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ss", $from, $to);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
        } else {
            $result = mysqli_query($conn, $sql);
        }

    // === PHOTOCARD REPORT ===
    } elseif ($report_type === 'photocard') {
        $sql = "SELECT * FROM photocard_library WHERE 1";
        if ($from && $to) {
            $sql .= " AND DATE(created_at) BETWEEN ? AND ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ss", $from, $to);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
        } else {
            $result = mysqli_query($conn, $sql);
        }

    // === QUOTES REPORT ===
    } elseif ($report_type === 'quotes') {
        $sql = "SELECT * FROM quotes_library WHERE 1";
        if ($from && $to) {
            $sql .= " AND DATE(created_at) BETWEEN ? AND ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ss", $from, $to);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
        } else {
            $result = mysqli_query($conn, $sql);
        }

    // === MOOD REPORT ===
    } elseif ($report_type === 'mood') {
        $sql = "SELECT * FROM mood_checkin WHERE 1";
        if ($from && $to) {
            $sql .= " AND DATE(checkin_at) BETWEEN ? AND ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ss", $from, $to);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
        } else {
            $result = mysqli_query($conn, $sql);
        }

    // === TO-DO LIST REPORT ===
    } elseif ($report_type === 'todolist') {
        $sql = "SELECT * FROM to_do_list WHERE 1";
        if ($from && $to) {
            $sql .= " AND DATE(created_at) BETWEEN ? AND ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ss", $from, $to);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
        } else {
            $result = mysqli_query($conn, $sql);
        }

    // === CHATBOT REPORT ===
    } elseif ($report_type === 'chatbot') {
        $sql = "SELECT * FROM chat_logs WHERE 1";
        if ($from && $to) {
            $sql .= " AND DATE(sent_at) BETWEEN ? AND ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ss", $from, $to);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
        } else {
            $result = mysqli_query($conn, $sql);
        }

    // === MEMBER REPORT ===
    } elseif ($report_type === 'member') {
        $sql = "SELECT * FROM member WHERE 1";
        if ($from && $to) {
            $sql .= " AND DATE(updated_at) BETWEEN ? AND ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ss", $from, $to);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
        } else {
            $result = mysqli_query($conn, $sql);
        }

    // === USER PHOTOCARD COLLECTION REPORT ===
    } elseif ($report_type === 'user_pccollection') {
        $sql = "SELECT up.userpc_id, up.user_id, u.username, pl.pc_title, pl.subunit, up.rewarded_at 
                FROM user_pccollection up
                LEFT JOIN users u ON up.user_id = u.user_id
                LEFT JOIN photocard_library pl ON up.pc_id = pl.pc_id
                WHERE 1";
        if ($from && $to) {
            $sql .= " AND DATE(up.rewarded_at) BETWEEN ? AND ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ss", $from, $to);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
        } else {
            $result = mysqli_query($conn, $sql);
        }

    // === USER QUOTES REPORT ===
    } elseif ($report_type === 'user_quotes') {
        $sql = "SELECT uq.user_id, u.username, q.quotes_text, q.type 
                FROM user_quotes uq
                LEFT JOIN users u ON uq.user_id = u.user_id
                LEFT JOIN quotes_library q ON uq.quotes_id = q.quotes_id";
        $result = mysqli_query($conn, $sql);

    // === REPORT REPORT ===
    } elseif ($report_type === 'report') {
        $sql = "SELECT * FROM report WHERE 1";
        if ($from && $to) {
            $sql .= " AND DATE(generated_at) BETWEEN ? AND ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ss", $from, $to);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
        } else {
            $result = mysqli_query($conn, $sql);
        }

    // === ERROR IF NOT FOUND ===
    } else {
        $_SESSION['report_status'] = 'error';
        header('Location: a-create-report.php');
        exit();
    }

    // === FETCH DATA ===
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
    }

    // ==== Build PDF ====
    $html = "<h2>NeoDrive Report: " . htmlspecialchars($report_type) . "</h2>";
    $html .= "<p>Generated at: " . date('Y-m-d H:i:s') . "</p>";
    $html .= "<p>Parameters: " . htmlspecialchars(implode(', ', $params)) . "</p>";
    $html .= "<table border='1' cellpadding='5' cellspacing='0'>";

    if (!empty($data)) {
        $html .= "<tr>";
        foreach (array_keys($data[0]) as $header) {
            $html .= "<th>" . htmlspecialchars($header) . "</th>";
        }
        $html .= "</tr>";
        foreach ($data as $row) {
            $html .= "<tr>";
            foreach ($row as $cell) {
                $html .= "<td>" . htmlspecialchars($cell) . "</td>";
            }
            $html .= "</tr>";
        }
    } else {
        $html .= "<tr><td colspan='100%'>No data found</td></tr>";
    }

    $html .= "</table>";

    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();

    $reportDir = "../../assets/reports/";
    if (!file_exists($reportDir)) {
        mkdir($reportDir, 0777, true);
    }

    $file_name = "report_" . preg_replace("/[^a-zA-Z0-9_]/", "_", $report_type) . "_" . time() . ".pdf";
    $file_path = $reportDir . $file_name;
    file_put_contents($file_path, $dompdf->output());

    $insert = "INSERT INTO report (user_id, report_type, parameters, report_filepath, report_status)
               VALUES (?, ?, ?, ?, 'Active')";
    $stmt = mysqli_prepare($conn, $insert);
    mysqli_stmt_bind_param($stmt, "isss", $admin_id, $report_type, $json_params, $file_path);
    $exec = mysqli_stmt_execute($stmt);

    $_SESSION['report_status'] = $exec ? 'success' : 'error';
    header("Location: a-create-report.php");
    exit();
}
?>
