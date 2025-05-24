<?php
// Include DB connection and session start
include '../../database/dbconn.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    // Redirect to login if not logged in
    header("Location: ../../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$mindful_note = "";
$giphy_url = "";
$success_message = "";

// Fetch all mood check-in entries for the logged-in user
$sql_all_checkins = "SELECT mood_type, user_note, checkin_at FROM mood_checkin WHERE user_id = ? ORDER BY checkin_at DESC LIMIT 5";
$stmt_all_checkins = $conn->prepare($sql_all_checkins);
$stmt_all_checkins->bind_param("i", $user_id);
$stmt_all_checkins->execute();
$result_all_checkins = $stmt_all_checkins->get_result();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mood_type = $_POST['mood_type'];
    $user_note = $_POST['user_note'];

    // Get a random ACTIVE mindful note for the selected mood
    $sql_note = "SELECT mnotes_id, m_notes FROM mindful_notes WHERE mood_type = ? AND mnotes_status = 'Active' ORDER BY RAND() LIMIT 1";
    $stmt_note = $conn->prepare($sql_note);
    $stmt_note->bind_param("s", $mood_type);
    $stmt_note->execute();
    $result_note = $stmt_note->get_result();
    $row = $result_note->fetch_assoc();
    $mindful_note_id = $row['mnotes_id'];
    $mindful_note = $row['m_notes'];

    // Decide the Giphy search term based on the mood
    $giphySearch = "";
    if (in_array($mood_type, ['sad', 'scared', 'stressed'])) {
        $giphySearch = 'motivational'; // Positive and uplifting content
    } else {
        $giphySearch = $mood_type; // For other moods, use the original mood type
    }

    // Call Giphy API (replace with your actual API key)
    $apiKey = "YGFjXtFazQBGT89EKK0sNkYR5cDyVENr";
    $giphyEndpoint = "https://api.giphy.com/v1/gifs/search?api_key=$apiKey&q=$giphySearch&limit=1&offset=0&rating=g&lang=en";

    $giphy_response = file_get_contents($giphyEndpoint);
    $giphy_data = json_decode($giphy_response, true);

    if (isset($giphy_data['data'][0]['images']['downsized']['url'])) {
        $giphy_url = $giphy_data['data'][0]['images']['downsized']['url'];
    }

    // Insert mood check-in into DB
    $sql_insert = "INSERT INTO mood_checkin (user_id, mood_type, user_note, mindful_note_id) VALUES (?, ?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("issi", $user_id, $mood_type, $user_note, $mindful_note_id);
    $stmt_insert->execute();

    // Update the result_all_checkins to include the new check-in
    $stmt_all_checkins->execute();
    $result_all_checkins = $stmt_all_checkins->get_result();

    $success_message = "Your mood check-in has been recorded!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mood Check-In</title>
    <link rel="stylesheet" href="../../css/style.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <header class="header-container">
        <div class="logo-title-container">
            <img src="../../assets/image/clock.png" alt="Logo">
            <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 
            link-underline-opacity-75-hover" href="#">Mood Check-In</a>
        </div>
        <div class="header-buttons">
            <a href="../pomodoro/timer.php">NeoSpace</a>
            <a href="../pc/pccollection.php">Collection</a>
            <a href="../quotes/quotes.php">Quotes</a>
            <a href="../profile/profile.php" class="profile-icon"><i class="fa-solid fa-user-circle"></i></a>
        </div>
    </header>

    <br>

    <div class="container mt-2">
        <div class="row">
            <div class="col-md-6">
                
    <div class="card p-4 shadow-sm mood-container">
        <h2 class="mb-4">🧠 Mood Check-In</h2>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="moodSelect" class="form-label">How are you feeling today?</label>
                <select class="form-select" name="mood_type" id="moodSelect" required>
                    <option value="">Choose...</option>
                    <option value="happy">Happy</option>
                    <option value="motivated">Motivated</option>
                    <option value="relieved">Relieved</option>
                    <option value="scared">Scared</option>
                    <option value="stressed">Stressed</option>
                    <option value="sad">Sad</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="userNote" class="form-label">Add your thoughts (optional)</label>
                <textarea class="form-control" name="user_note" id="userNote" rows="3"></textarea>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Share</button>
            </div>
        </form>
    </div>
</div>


    <!-- Modal for Mindful Note and Giphy -->
    <div class="modal fade" id="checkInModal" tabindex="-1" aria-labelledby="checkInModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="checkInModalLabel">Your Mood Check-In</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <h6><em><?= htmlspecialchars($mindful_note) ?></em></h6><br>
                <h5>Here's a GIF just for you:</h5>
                    <?php if (!empty($giphy_url)): ?>
                        <img src="<?= $giphy_url ?>" class="img-fluid" alt="Mood GIF">
                    <?php else: ?>
                        <p>No GIF available.</p>
                    <?php endif; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
    <!-- New Container for All Mood Check-Ins -->
    <div class="card p-4 shadow-sm mood-container">
        <h2 class="mb-4">🧠 Previous Mood Check-In Records</h2>

        <?php if ($result_all_checkins->num_rows > 0): ?>
            <ul class="list-group">
                <?php while ($checkin = $result_all_checkins->fetch_assoc()): ?>
                    <li class="list-group-item">
                        <strong>Mood:</strong> <?= htmlspecialchars($checkin['mood_type']); ?> <br>
                        <strong>Note:</strong> <?= htmlspecialchars($checkin['user_note']); ?> <br>
                        <strong>Checked In At:</strong> <?= date("F j, Y, g:i a", strtotime($checkin['checkin_at'])); ?>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p class="text-muted">No mood check-ins found.</p>
        <?php endif; ?>
    </div>
</div>

        </div>
        </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Trigger the modal after successful submission
        <?php if (!empty($success_message)): ?>
            var myModal = new bootstrap.Modal(document.getElementById('checkInModal'), {
                keyboard: false
            });
            myModal.show();
        <?php endif; ?>
    </script>
    <style>
.mood-container {
    max-width: 600px; /* Adjust this value to reduce or increase the width */
    margin: 0 auto; /* Center the container horizontally */
    padding: 20px; /* Add some padding inside */
}

.modal-body img {
        max-height: 300px; /* Adjust this value as needed */
        width: auto; /* Maintain the aspect ratio */
        display: block; /* Center the image */
        margin: 0 auto; /* Center the image horizontally */
    }

    </style>
</body>
</html>
