<?php
include '../../database/dbconn.php';
include 'u-checkin-mood.php'; ?>


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
            <a href="../pc/u-pc-collection.php">Collection</a>
            <a href="../quotes/quotes.php">Quotes</a>
            <a href="../profile/profile.php" class="profile-icon"><i class="fa-solid fa-user-circle"></i></a>
        </div>
    </header>

    <br>

    <div class="container-fluid mt-4 px-3">
        <div class="row">
            <div class="col-md-6">
                <div class="card p-4 shadow-sm mood-container">
                    <h2 class="mb-4">🎼 Mood Check-In</h2>
                    <form method="POST" action="">

                        <div class="mb-3">
                            <label class="form-label">How are you feeling today?</label>
                            <div class="mood-selector">
                                <input type="radio" id="happy_jae" name="mood_type" value="happy">
                                <label for="happy_jae">
                                    <img src="../../assets/image/jae.png" alt="Happy - Jaehyun" title="Happy - Jaehyun"
                                        data-bs-toggle="tooltip" data-bs-placement="top" class="mood-img img-fluid" />
                                </label>

                                <input type="radio" id="relieved_jun" name="mood_type" value="relieved">
                                <label for="relieved_jun">
                                    <img src="../../assets/image/chilljun.png" alt="Motivated - Xiaojun"
                                        title="Relieved - Xiaojun" data-bs-toggle="tooltip" data-bs-placement="top"
                                        class="mood-img img-fluid" />
                                </label>

                                <input type="radio" id="motivated_mark" name="mood_type" value="motivated">
                                <label for="motivated_mark">
                                    <img src="../../assets/image/markmot.png" alt="Motivated - Mark"
                                        title="Motivated - Mark" data-bs-toggle="tooltip" data-bs-placement="top"
                                        class="mood-img img-fluid" />
                                </label>

                                <input type="radio" id="sad_renjun" name="mood_type" value="sad">
                                <label for="sad_renjun">
                                    <img src="../../assets/image/rjsad.png" alt="Sad - Renjun" title="Sad - Renjun"
                                        data-bs-toggle="tooltip" data-bs-placement="top" class="mood-img img-fluid" />
                                </label>

                                <input type="radio" id="stressed_nana" name="mood_type" value="stressed">
                                <label for="stressed_nana">
                                    <img src="../../assets/image/nanastress.png" alt="Stressed - Jaemin"
                                        title="Stressed - Jaemin" data-bs-toggle="tooltip" data-bs-placement="top"
                                        class="mood-img img-fluid" />
                                </label>

                                <input type="radio" id="scared_doyoung" name="mood_type" value="scared">
                                <label for="scared_doyoung">
                                    <img src="../../assets/image/doyscared.png" alt="Scared - Doyoung"
                                        title="Scared - Doyoung" data-bs-toggle="tooltip" data-bs-placement="top"
                                        class="mood-img img-fluid" />
                                </label>
                            </div>
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
<div class="modal fade" id="checkInModal" tabindex="-1" aria-labelledby="checkInModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="checkInModalLabel"><?= htmlspecialchars($mood_type) ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6><em><?= htmlspecialchars($mindful_note) ?></em></h6><br>
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
                <div class="card p-4 shadow-sm mood-container">
                    <h2 class="mb-4">🍁 Mood Check-In Records</h2>

                    <?php if ($result_all_checkins->num_rows > 0): ?>
                        <div class="d-flex flex-column gap-3">
                            <?php while ($checkin = $result_all_checkins->fetch_assoc()): ?>
                                <div class="flip-card" onclick="this.classList.toggle('flipped')">
                                    <div class="flip-card-inner">
                                        <div class="flip-card-front mood-<?= strtolower($checkin['mood_type']) ?>">
                                            <?= htmlspecialchars($checkin['mood_type']); ?>
                                        </div>
                                        <div class="flip-card-back ">
                                            <p ><strong>Note:</strong> <?= htmlspecialchars($checkin['user_note']); ?></p>
                                            <p><strong>Checked In:</strong> <?= date("F j, Y, g:i a", strtotime($checkin['checkin_at'])); ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
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

        // Enable all tooltips on the page
        document.addEventListener('DOMContentLoaded', function () {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.forEach(function (tooltipTriggerEl) {
                new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
    <style>
        .mood-container {
            max-width: 600px;
            margin: 0 auto;/* Center the container horizontally */
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            width: 100%;
        }

        .modal-body img {
            max-height: 300px;
            width: auto;
            display: block; /* Center the image */
            margin: 0 auto;
        }

        .mood-selector {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 8px;
        }

        .mood-selector input[type="radio"] {
            display: none;
        }

        .mood-selector label {
            cursor: pointer;
        }

        .mood-selector img.mood-img {
            width: 70px;
            height: 79px;
            border-radius: 50%;
            object-fit: cover;
            transition: transform 0.2s ease;
        }

        .mood-selector input[type="radio"]:checked+label img {
            transform: scale(1.15);
            border: 2px solid #b3fc16;
        }

        .mood-img {
            width: 80px;
            height: 80px;
            object-fit: contain;
            cursor: pointer;
            transition: transform 0.3s;
        }

        .mood-img:hover {
            transform: scale(1.1);
        }


        textarea {
            display: block;
            width: 100%;
            height: 100px;
            resize: vertical;
        }

        .mood-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .flip-card {
            background-color: transparent;
            width: 100%;
            height: 50px;
            /* Increase this if it's too small */
            perspective: 1000px;
        }

        .flip-card-inner {
            position: relative;
            width: 100%;
            height: 100%;
            transition: transform 0.8s;
            transform-style: preserve-3d;
        }

        .flip-card.flipped .flip-card-inner {
            transform: rotateY(180deg);
        }

        .flip-card-front,
        .flip-card-back {
            position: absolute;
            width: 100%;
            height: 50px;
            /* Must be equal to flip-card height */
            backface-visibility: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 1rem;
            border-radius: 10px;
        }

        .flip-card-back {
            transform: rotateY(180deg);
            background-color: #f8f9fa;
        }


        /* Optional mood type color coding */
        .mood-happy {
            background-color: #FFD700;
            color: #000;
        }

        .mood-sad {
            background-color: #6495ED;
        }

        .mood-stressed {
            background-color: #FF6347;
        }

        .mood-relieved {
            background-color: #20B2AA;
        }

        .mood-motivated {
            background-color: rgb(43, 226, 150);
        }

        .mood-scared {
            background-color: rgb(87, 17, 153);
        }
    </style>
</body>

</html>