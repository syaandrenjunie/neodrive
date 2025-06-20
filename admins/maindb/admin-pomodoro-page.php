<?php
include("../../include/auth.php");
check_role('admin');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pomodoro Management Main Dashboard</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    <header class="header-container">
        <div class="logo-title-container">
            <!-- Image will trigger the sidebar -->
            <img src="../../assets/image/clock.png" alt="Logo" class="timer-icon" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions"> <a
                class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover"
                href="#">Pomodoro Management Dashboard</a>
        </div>
        <div class="header-buttons">
            
            <a href="adminprofile.php" class="profile-icon">
                <i class="fa-solid fa-user-circle"></i>
            </a>

        </div>
    </header><br><br>

    <!-- Include Sidebar -->
    <?php include('../menus-sidebar.php'); ?>

    <div class="pomodoro-list">
        <div class="search-container">
            <form action="" method="GET">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" id="searchInput"
                        placeholder="Search pomodoro..."
                        value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>"
                        aria-label="Search pomodoro">

                    <!-- Search Icon as Submit Button -->
                    <button type="submit" class="input-group-text btn btn-link" style="color: black">
                        <i class="fa fa-search"></i>
                    </button>

                    <!-- Clear Search Button -->
                    <a href="admin-pomodoro-page.php" class="btn btn-secondary input-group-text">Clear Search</a>
                </div>
            </form>

        </div>
        <table class="table table-striped table-hover mt-3">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Username</th>
                    <th class="text-center">Pomodoro Duration</th>
                        <th class="text-center">Total Pomodoro Round</th>
                        <th class="text-center">Completed Pomodoro Round</th>
                        <th>Status</th>
                        <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $searchTerm = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

                $query = "SELECT ts.*, u.username 
                            FROM timer_sessions ts
                            JOIN users u ON ts.user_id = u.user_id";

                        if (!empty($searchTerm)) {
                            $query .= " WHERE u.username LIKE '%$searchTerm%' 
                        OR ts.status LIKE '%$searchTerm%' 
                        OR ts.started_at LIKE '%$searchTerm%' 
                        OR ts.ended_at LIKE '%$searchTerm%'";

                    // Optional: match exact status (you can skip this since LIKE already matches)
                    $statusMatch = strtolower($searchTerm);
                    if (in_array($statusMatch, ['completed', 'in_progress', 'cancelled'])) {
                        $query .= " OR ts.status = '$statusMatch'";
                    }
                }

                $query .= " ORDER BY ts.started_at DESC"; // ✅ Always add ORDER BY at the end
                
                $result = mysqli_query($conn, $query);

                $i = 1; // <-- Add this line before the loop
                

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                                    <td>" . $i++ . "</td>
                                    <td class='text-wrap' style='max-width: 300px;'>{$row['username']}</td>
                                    <td class='text-center'>{$row['round_duration']}</td>
                                    <td class='text-center'>{$row['total_rounds']}</td>
                                    <td class='text-center'>{$row['completed_rounds']}</td>
                                    <td>{$row['status']}</td>
                                    <td>
                                        <button class='btn btn-sm btn-primary view-pom-btn' 
                                            data-bs-toggle='modal' 
                                            data-bs-target='#pomodoroDetailModal' 
                                            data-username='{$row['username']}'
                                            data-round_duration='{$row['round_duration']}'
                                            data-break_duration='{$row['break_duration']}'
                                            data-total_rounds ='{$row['total_rounds']}'
                                            data-created_at ='{$row['created_at']}'
                                            data-started_at='{$row['started_at']}'
                                            data-ended_at='{$row['ended_at']}'
                                            data-status ='{$row['status']}'
                                            title='View Pomodoro '>
                                            <i class='fa-solid fa-expand'></i>
                                        </button>
                                    </td>
                                </tr>";

                    }
                } else {
                    echo "<tr><td colspan='9' style='text-align: center;'>No record found</td></tr>";
                }

                ?>
            </tbody>
        </table>

        <!-- Pomodoro Detail Modal -->
        <div class="modal fade" id="pomodoroDetailModal" tabindex="-1" aria-labelledby="pomodoroDetailModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-username fs-5" id="modal-username-title"></h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Pomodoro Duration</strong> <span id="modal-round_duration"></span></p>
                        <p><strong>Break Duration</strong><span id="modal-break_duration"></span></p>
                        <p><strong>Total Pomodoro Round:</strong> <span id="modal-total_rounds"></span></p>
                        <p><strong>Created At:</strong> <span id="modal-created_at"></span></p>
                        <p><strong>Started At:</strong> <span id="modal-started_at"></span></p>
                        <p><strong>Ended At:</strong> <span id="modal-ended_at"></span></p>
                        <p><strong>Status:</strong> <span id="modal-status"></span></p>

                    </div>
                </div>
            </div>
        </div>

    </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.view-pom-btn').forEach(button => {
                button.addEventListener('click', function () {
                    document.getElementById('modal-username-title').textContent = this.dataset.username;
                    document.getElementById('modal-round_duration').textContent = this.dataset.round_duration;
                    document.getElementById('modal-break_duration').textContent = this.dataset.break_duration;
                    document.getElementById('modal-total_rounds').textContent = this.dataset.total_rounds;
                    document.getElementById('modal-created_at').textContent = this.dataset.created_at;
                    document.getElementById('modal-started_at').textContent = this.dataset.started_at;
                    document.getElementById('modal-ended_at').textContent = this.dataset.ended_at;
                    document.getElementById('modal-status').textContent = this.dataset.status;


                });
            });

            const sidebarToggle = document.getElementById('sidebarToggle');

            sidebarToggle.addEventListener('click', function () {
                const sidebar = new bootstrap.Offcanvas(document.getElementById('offcanvasWithBothOptions'));
                sidebar.show(); // Show the sidebar when the image is clicked
            });
        });
    </script>

    <style>
        .search-container {
            margin-bottom: 10px;
            display: flex;
            justify-content: flex-start;
        }

        .search-form {
            width: 800px;
            max-width: 600px;
        }

        .modal-lg {
            max-width: 60%;
        }

        .btn-primary.view-pom-btn {
            background-color:rgb(217, 233, 71) !important;
            border-color: rgb(217, 233, 71)  !important;
            color: white !important;
        }

        .btn-primary.view-pom-btn:hover {
            background-color:rgb(240, 226, 40) !important;
            border-color: rgb(240, 226, 40)  !important;
        }

    </style>
</body>
</ht>