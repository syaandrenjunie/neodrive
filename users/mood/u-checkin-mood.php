<?php
include '../../database/dbconn.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$mindful_note = "";
$giphy_url = "";
$success_message = "";

// Fetch check-in records
function getUserMoodCheckIns($conn, $user_id) {
    $sql = "SELECT mood_type, user_note, checkin_at FROM mood_checkin WHERE user_id = ? ORDER BY checkin_at DESC LIMIT 5";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    return $stmt->get_result();
}

$result_all_checkins = getUserMoodCheckIns($conn, $user_id);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mood_type = $_POST['mood_type'] ?? '';
    $user_note = $_POST['user_note'] ?? '';

    // Get random active mindful note
    $sql_note = "SELECT mnotes_id, m_notes FROM mindful_notes WHERE mood_type = ? AND mnotes_status = 'Active' ORDER BY RAND() LIMIT 1";
    $stmt_note = $conn->prepare($sql_note);
    $stmt_note->bind_param("s", $mood_type);
    $stmt_note->execute();
    $result_note = $stmt_note->get_result();
    $row = $result_note->fetch_assoc();

    $mindful_note_id = $row['mnotes_id'] ?? null;
    $mindful_note = $row['m_notes'] ?? '';

    // Giphy logic
    $giphySearch = in_array($mood_type, ['sad', 'scared', 'stressed']) ? 'motivational' : $mood_type;
    $apiKey = "YGFjXtFazQBGT89EKK0sNkYR5cDyVENr";
    $giphyEndpoint = "https://api.giphy.com/v1/gifs/search?api_key=$apiKey&q=$giphySearch&limit=1&offset=0&rating=g&lang=en";

    $giphy_response = file_get_contents($giphyEndpoint);
    $giphy_data = json_decode($giphy_response, true);
    $giphy_url = $giphy_data['data'][0]['images']['downsized']['url'] ?? '';

    // Insert mood check-in
    $sql_insert = "INSERT INTO mood_checkin (user_id, mood_type, user_note, mindful_note_id) VALUES (?, ?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("issi", $user_id, $mood_type, $user_note, $mindful_note_id);
    $stmt_insert->execute();

    $result_all_checkins = getUserMoodCheckIns($conn, $user_id);
    $success_message = "Your mood check-in has been recorded!";
}
?>
