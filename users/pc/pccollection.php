<?php
// Include DB connection and session start
include '../../database/dbconn.php';
session_start();

// Check if the user is logged in by verifying session data
if (!isset($_SESSION['user_id'])) {
    // Redirect to login if the user is not logged in
    header("Location: ../../login.php");
    exit();
}

// Retrieve the user ID from the session
$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Photocard Collection</title>
    <link rel="stylesheet" href="../../css/style.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">


</head>
<body>

<header class="header-container">
        <div class="logo-title-container">
            <img src="../../assets/image/timer2.png" alt="Logo">
            <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 
                link-underline-opacity-75-hover" href="#">Your Photocards Collection</a>
        </div>
        <div class="header-buttons">
            <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 
     link-underline-opacity-75-hover" href="../pomodoro/timer.php">NeoSpace</a>
            <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 
     link-underline-opacity-75-hover" href="#">Collection</a>
            <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 
     link-underline-opacity-75-hover" href="../quotes/quotes.php">Quotes</a>
            <a href="../profile/profile.php" class="profile-icon">
                <i class="fa-solid fa-user-circle"></i>
            </a>

        </div>

    </header><br>


<!-- <div class="container text-center collection-container"> -->
    
    <div class="row" id="photocardGrid">
        <!-- Photocard items will be added dynamically -->
    </div>
<!-- </div> -->

<!-- Modal for Viewing Photocard -->
<div class="modal fade" id="photoModal" tabindex="-1" aria-labelledby="photoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="photoModalLabel">Photocard Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" class="modal-img" src="" alt="Photocard">
                <p id="photoNote" class="mt-2 text-muted">No notes available.</p> <!-- Notes Section -->
            </div>
        </div>
    </div>
</div>



<script>
    // Sample photocard data
    const photocards = [
        { src: '../../assets/image/IMG_1193.jpg', name: 'Photocard 1', note: 'Special photocard from the fan meeting!' },
        { src: '../../assets/image/IMG_1194.jpg', name: 'Photocard 2', note: 'Limited edition photocard.' },
        { src: '../../assets/image/IMG_1192.jpg', name: 'Photocard 3', note: 'My first photocard collection!' },
        { src: '../../assets/image/IMG_1196.jpg', name: 'Photocard 4', note: 'Signed photocard from a concert!' },
        { src: '../../assets/image/IMG_1195.jpg', name: 'Photocard 5', note: 'Lucky pull from an album.' },
        { src: '../../assets/image/IMG_1198.jpg', name: 'Photocard 6', note: 'A gift from a friend!' },
        { src: '../../assets/image/IMG_1192.jpg', name: 'Photocard 7', note: 'Rare photocard from Japan.' },
        
    ];

    function loadPhotocards() {
        let grid = document.getElementById("photocardGrid");
        grid.innerHTML = "";
        photocards.forEach((photo, index) => {
            let col = document.createElement("div");
            col.className = "col-6 col-md-3 col-lg-2 mb-3"; // 6 per row on large screens
            
            col.innerHTML = `
                <img src="${photo.src}" alt="${photo.name}" class="photocard" onclick="openPhotoModal('${photo.src}', '${photo.note}')">
            `;
            grid.appendChild(col);
        });
    }

    function openPhotoModal(imageSrc, noteText) {
        document.getElementById("modalImage").src = imageSrc;
        document.getElementById("photoNote").textContent = noteText || "No notes available.";
        var modal = new bootstrap.Modal(document.getElementById("photoModal"));
        modal.show();
    }

    document.addEventListener("DOMContentLoaded", loadPhotocards);
</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
