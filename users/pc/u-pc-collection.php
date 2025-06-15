<?php
// Include DB connection and session start
include '../../database/dbconn.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user's rewarded photocards
$stmt = $conn->prepare("
    SELECT pl.pc_filepath, pl.pc_title, pl.pc_type
    FROM user_pccollection uc
    JOIN photocard_library pl ON uc.pc_id = pl.pc_id
    WHERE uc.user_id = ?
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$photocards = [];
$type_counts = ['Common' => 0, 'Rare' => 0, 'Exclusive' => 0];

while ($row = $result->fetch_assoc()) {
    $photocards[] = [
        'pc_filepath' => '../../' . $row['pc_filepath'],
        'pc_title' => $row['pc_title'],
        'pc_type' => $row['pc_type']
    ];
    $type_counts[$row['pc_type']]++;
}


$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Photocard Collection</title>
    <link rel="stylesheet" href="../../css/style.css">
    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>

    <header class="header-container">
        <div class="logo-title-container">
            <img src="../../assets/image/clock.png" alt="Logo">
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
    </header><br><br>

    <!-- PC Type preview -->
    <div class="row row-cols-1 row-cols-md-3 g-4 mb-4">
        <div class="col">
            <div class="card h-100  bg-common">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <i class="fa-solid fa-star text-secondary  me-3"></i>
                        <h5 class="card-title mb-0">Common</h5>
                    </div>
                    <span class="fs-5 "><?php echo $type_counts['Common']; ?></span>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card h-100 bg-rare">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <i class="fa-solid fa-gem text-warning  me-3"></i>
                        <h5 class="card-title mb-0">Rare</h5>
                    </div>
                    <span class="fs-5"><?php echo $type_counts['Rare']; ?></span>
                </div>

            </div>
        </div>

        <div class="col">
            <div class="card h-100 bg-exclusive">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <i class="fa-solid fa-crown text-danger  me-3"></i>
                        <h5 class="card-title mb-0">Exclusive</h5>
                    </div>
                    <span class="fs-5 "><?php echo $type_counts['Exclusive']; ?></span>
                </div>
            </div>
        </div>
    </div>


    <div class="row" id="photocardGrid" class="px-4">
        <!-- Dynamic photocard display -->
    </div>

    <!-- Modal -->
    <div class="modal fade" id="photoModal" tabindex="-1" aria-labelledby="photoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="photoModalLabel">Photocard Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" class="modal-img" src="" alt="Photocard">
                </div>
            </div>
        </div>
    </div>

    <script>
        const photocards = <?php echo json_encode($photocards); ?>;

        function loadPhotocards() {
            const grid = document.getElementById("photocardGrid");
            grid.innerHTML = "";

            if (photocards.length === 0) {
                grid.innerHTML = "<p class='text-center'>You haven't earned any photocards yet. Keep focusing!</p>";
                return;
            }

            photocards.forEach(photo => {
                const col = document.createElement("div");
                col.className = "col-6 col-md-3 col-lg-2 mb-3";


                col.innerHTML = `
            <div class="flip-card">
                <div class="flip-card-inner">
                    <div class="flip-card-front">
                        <img src="${photo.pc_filepath}" alt="${photo.pc_title}" class="photocard-front">
                    </div>
                    <div class="flip-card-back d-flex flex-column justify-content-center align-items-center">
                        <h6 class="text-center px-2">${photo.pc_title}</h6>
                        <span class="badge bg-info text-dark">${photo.pc_type}</span>
                    </div>
                </div>
            </div>`;


                grid.appendChild(col);
            });
        }

        function openPhotoModal(imageSrc) {
            document.getElementById("modalImage").src = imageSrc;
            const modal = new bootstrap.Modal(document.getElementById("photoModal"));
            modal.show();
        }

        document.addEventListener("DOMContentLoaded", loadPhotocards);
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .photocard-front {
            border: 2px solid #ffffff;
            border-radius: 12px;
        }

        .flip-card {
            background-color: transparent;
            width: 100%;
            perspective: 1000px;
            cursor: pointer;
        }

        .flip-card-inner {
            position: relative;
            width: 95%;
            padding-top: 120%;
            /* shorter height */
            /* For aspect ratio */
            transition: transform 0.6s;
            transform-style: preserve-3d;
        }

        .flip-card:hover .flip-card-inner {
            transform: rotateY(180deg);
        }

        .flip-card-front,
        .flip-card-back {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .flip-card-front img,
        .flip-card-back img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .flip-card-back {
            transform: rotateY(180deg);
            background-color: #ffffff;
            color: #333;
            text-align: center;
            padding: 10px;
        }

        .flip-card-back h6 {
            font-weight: bold;
            font-size: 1rem;
        }

        .bg-common,
        .bg-rare,
        .bg-exclusive {
            background-color: rgb(215, 252, 194);
            box-shadow: 0 10px 30px rgb(180, 241, 172);
            color: #333;

        }
    </style>

</body>

</html>