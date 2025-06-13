<?php
include '../../database/dbconn.php';
session_start();

// Check if the user is logged in by verifying session data
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch quotes from the database
$quotes = [];
$sql = "SELECT q.quotes_id, q.quotes_text, m.member_name,
               (SELECT 1 FROM user_quotes u WHERE u.quotes_id = q.quotes_id AND u.user_id = ?) AS pinned
        FROM quotes_library q 
        JOIN member m ON q.member_id = m.member_id 
        ORDER BY q.updated_at DESC";


$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $quotes[] = [
            'id' => $row['quotes_id'],
            'text' => $row['quotes_text'],
            'author' => $row['member_name'],
            'pinned' => $row['pinned'] ? true : false
        ];
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quotes</title>
    <link rel="stylesheet" href="../../css/style.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>

    <header class="header-container">
        <div class="logo-title-container">
            <img src="../../assets/image/clock.png" alt="Logo">
            <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 
                link-underline-opacity-75-hover" href="#">Motivational Quotes</a>
        </div>
        <div class="header-buttons">
            <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 
     link-underline-opacity-75-hover" href="../pomodoro/timer.php">NeoSpace</a>
            <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 
     link-underline-opacity-75-hover" href="../pc/u-pc-collection.php">Collection</a>
            <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 
     link-underline-opacity-75-hover" href="#">Quotes</a>
            <a href="../profile/profile.php" class="profile-icon">
                <i class="fa-solid fa-user-circle"></i>
            </a>

        </div>

    </header><br><br>

    <!-- Quotes Container -->
    <div class="row" id="quotesContainer">
        <!-- Quotes will be inserted here dynamically -->
    </div>

    <a href="../mood/mood.php" class="floating-icon" id="moodCheckinTrigger" title="Mood Check-In"
        data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip">
        <i class="fa-solid fa-heart-circle-check"></i>
    </a>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.forEach(function (tooltipTriggerEl) {
                new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>

    <script>
        // Sample quotes array
        let quotes = <?php echo json_encode($quotes); ?>;

        // Function to render quotes as Bootstrap cards
        function renderQuotes() {
            let container = document.getElementById("quotesContainer");
            container.innerHTML = "";

            // Sort: Pinned quotes first
            let sortedQuotes = quotes.sort((a, b) => b.pinned - a.pinned);

            sortedQuotes.forEach((quote) => {
                let col = document.createElement("div");
                col.className = "col-md-3 mb-2";

                col.innerHTML = `
                    <div class="card mb-3" style="max-width: 18rem; background-color:rgb(193, 241, 116);">
                            <div class="card-header">
                                ${quote.author}
                                <i class="fa-solid fa-thumbtack pin-icon ${quote.pinned ? "pinned" : ""}" onclick="togglePin(${quote.id})"></i>
                            </div>
                            <div class="card-body">
                                <h5 class="card-text">${quote.text}</h5>
                            </div>
                        </div>
                    `;
                container.appendChild(col);
            });
        }

        // Function to toggle pin status
        // Function to toggle pin status and update DB
        function togglePin(id) {
            let quote = quotes.find(q => q.id === id);
            if (!quote) return;

            // Toggle UI immediately
            quote.pinned = !quote.pinned;
            renderQuotes();

            // Send AJAX request to update pin status in DB
            fetch("u-toggle-pin.php", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `quote_id=${id}&action=${quote.pinned ? 'pin' : 'unpin'}`
            })
                .then(response => response.text())
                .then(data => {
                    // Display SweetAlert message based on action
                    if (quote.pinned) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Quote Pinned!',
                            text: 'You have successfully pinned this quote.',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Quote Unpinned!',
                            text: 'You have successfully unpinned this quote.',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong. Please try again later.',
                    });
                });
        }

        // Load quotes on page load
        document.addEventListener("DOMContentLoaded", renderQuotes);

    </script>

    <style>
        .pin-icon {
            cursor: pointer;
            float: right;
            color: gray;
            transition: color 0.3s;
        }

        .pin-icon.pinned {
            color: gold !important;
            /* Ensure the color changes when pinned */
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding-left: 20px;
            padding-right: 20px;
        }

        .custom-tooltip {
            --bs-tooltip-bg: rgb(248, 255, 147);
            --bs-tooltip-color: #000;
        }
    </style>

</body>

</html>