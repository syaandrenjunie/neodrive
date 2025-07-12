<?php
include("../../include/auth.php"); 

check_role('admin');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mood Check-In Management Dashboard</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>
    <header class="header-container">
        <div class="logo-title-container">
            <img src="../../assets/image/clock.png" alt="Logo" class="timer-icon" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">
            <a class="link-underline link-underline-opacity-0" href="#">Mood Check-In Management Dashboard</a>
        </div>
        <div class="header-buttons">
            <a class="link-underline link-underline-opacity-0" href="#">Lists</a>
            <a class="link-underline link-underline-opacity-0" href="../mood/a-list-notes.php">Notes</a>
            <a class="link-underline link-underline-opacity-0" href="../mood/a-add-notes.php">New</a>


            <a href="adminprofile.php" class="profile-icon">
                <i class="fa-solid fa-user-circle"></i>
            </a>
        </div>
    </header><br><br>

    <!-- Include Sidebar -->
    <?php include('../menus-sidebar.php'); ?>

    <div class="mnotes-list">
        <div class="search-container">
            <form action="" method="GET">
                <div class="input-group">
                    <!-- Search Input -->
                    <input type="text" class="form-control" name="search" id="searchInput"
                        placeholder="Search mood checkin..."
                        value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>"
                        aria-label="Search mindful notes">

                    <!-- Search Icon as Submit Button -->
                    <button type="submit" class="input-group-text btn btn-link" style="color: black">
                        <i class="fa fa-search"></i>
                    </button>

                    <!-- Clear Search Button -->
                    <a href="admin-moods-page.php" class="btn btn-secondary input-group-text">Clear Search</a>
                </div>
            </form>

        </div>

        <table class="table table-striped table-hover mt-3">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Mood's Type</th>
                    <th>User Notes</th>
                    <th>Status</th>
                    <th>Check-in At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php

                $searchTerm = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

                $query = "SELECT m.*, 
                    u.username, 
                    n.m_notes 
                    FROM mood_checkin m
                    JOIN users u ON m.user_id = u.user_id
                    JOIN mindful_notes n ON m.mindful_note_id = n.mnotes_id";

                if (!empty($searchTerm)) {
                    $query .= " WHERE m.user_note LIKE '%$searchTerm%' 
                                OR m.mood_type LIKE '%$searchTerm%' 
                                OR m.mood_status LIKE '%$searchTerm%' 
                                OR m.mindful_note_id LIKE '%$searchTerm%' 
                                OR m.checkin_at LIKE '%$searchTerm%' 
                                OR u.username LIKE '%$searchTerm%' 
                                OR n.m_notes LIKE '%$searchTerm%'";

                }

                $query .= " ORDER BY m.checkin_at DESC";

                $result = mysqli_query($conn, $query);
                $i = 1;


                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                            <td>" . $i++ . "</td>
                            <td>{$row['mood_type']}</td>
                            <td class='text-wrap' style='max-width: 300px;'>{$row['user_note']}</td>
                            <td>{$row['mood_status']}</td>
                            <td>{$row['checkin_at']}</td>
                            <td> <!-- This was missing -->
                                
                                <button class='btn btn-sm btn-primary view-moods-btn' 
                                    data-bs-toggle='modal' 
                                    data-bs-target='#moodsDetailModal' 
                                    data-username='{$row['username']}'
                                    data-mood_type='{$row['mood_type']}'
                                    data-user_note='{$row['user_note']}'
                                    data-m_notes='{$row['m_notes']}'
                                    data-mood_status='{$row['mood_status']}'
                                    data-checkin_at='{$row['checkin_at']}'
                                    title='View Mood Checkin'>
                                    <i class='fa-solid fa-expand'></i>
                                </button>
                                
                                

                            </td> <!-- Make sure this td wraps both buttons -->
                        </tr>";

                    }
                } else {
                    echo "<tr><td colspan='9' style='text-align: center;'>No record found</td></tr>";
                }

                ?>
            </tbody>
        </table>


        <!-- View Mood Check-In Modal -->
        <div class="modal fade" id="moodsDetailModal" tabindex="-1" aria-labelledby="moodsDetailModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="moodsDetailModalLabel">Mood Check-In Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Checked-in by:</strong> <span id="modal-username"></span></p>
                        <p><strong>Mood Type:</strong> <span id="modal-mood_type"></span></p>
                        <p><strong>User Note:</strong> <span id="modal-user_note"></span></p>
                        <p><strong>Mindful Note:</strong> <span id="modal-m_notes"></span></p>
                        <p><strong>Status:</strong> <span id="modal-mood_status"></span></p>
                        <p><strong>Check-In At:</strong> <span id="modal-checkin_at"></span></p>
                    </div>
                </div>
            </div>
        </div>


        <!-- Edit Mood Check-In Modal -->
        <div class="modal fade" id="editMoodModal" tabindex="-1" aria-labelledby="editMoodModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="editMoodForm" method="POST" action="update_mood.php">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editMoodModalLabel">Edit Mood Check-In</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <!-- Hidden ID input -->
                            <input type="hidden" name="mood_id" id="edit-mood-id">

                            <div class="mb-3">
                                <label for="edit-username" class="form-label"><strong>Checked-in by:</strong></label>
                                <input type="text" class="form-control" id="edit-username" name="username" disabled>
                            </div>

                            <div class="mb-3">
                                <label for="edit-mood-type" class="form-label"><strong>Mood Type:</strong></label>
                                <input type="text" class="form-control" id="edit-mood-type" name="mood_type" disabled>
                            </div>

                            <div class="mb-3">
                                <label for="edit-user-note" class="form-label"><strong>User Note:</strong></label>
                                <textarea class="form-control" id="edit-user-note" name="user_note" rows="3"
                                    disabled></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="edit-mindful-note" class="form-label"><strong>Mindful Note:</strong></label>
                                <textarea class="form-control" id="edit-mindful-note" name="mindful_note" rows="3"
                                    disabled></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="edit-status" class="form-label"><strong>Status:</strong></label>
                                <select class="form-select" id="edit-status" name="mood_status">
                                    <option value="Active">Active</option>
                                    <option value="Archived">Archived</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="edit-updated" class="form-label"><strong>Updated At:</strong></label>
                                <input type="text" class="form-control" id="edit-updated" name="updated_at" disabled>
                            </div>

                            <div class="mb-3">
                                <label for="edit-checkin" class="form-label"><strong>Check-In At:</strong></label>
                                <input type="text" class="form-control" id="edit-checkin" name="checkin-at" disabled>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php if (isset($_GET['status_changed']) && $_GET['status_changed'] === 'success'): ?>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Status Updated',
                    text: 'Mood Check-In status has been updated successfully.',
                    confirmButtonColor: '#3085d6'
                });
            </script>
        <?php endif; ?>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            // Get the image element that will trigger the sidebar
            const sidebarToggle = document.getElementById('sidebarToggle');

            // Add click event to trigger sidebar
            sidebarToggle.addEventListener('click', function () {
                const sidebar = new bootstrap.Offcanvas(document.getElementById('offcanvasWithBothOptions'));
                sidebar.show(); // Show the sidebar when the image is clicked
            });

        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const viewButtons = document.querySelectorAll('.view-moods-btn');

                viewButtons.forEach(button => {
                    button.addEventListener('click', function () {
                        document.getElementById('modal-username').innerText = this.dataset.username;
                        document.getElementById('modal-mood_type').innerText = this.dataset.mood_type;
                        document.getElementById('modal-user_note').innerText = this.dataset.user_note;
                        document.getElementById('modal-m_notes').innerText = this.dataset.m_notes;
                        document.getElementById('modal-mood_status').innerText = this.dataset.mood_status;
                        document.getElementById('modal-checkin_at').innerText = this.dataset.checkin_at;
                    });
                });
            });

            document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('.confirm-toggle-status').forEach(button => {
                    button.addEventListener('click', function () {
                        const moodId = this.getAttribute('data-id');
                        const currentStatus = this.getAttribute('data-status');
                        const actionText = currentStatus === 'Active' ? 'deactivate' : 'activate';

                        Swal.fire({
                            title: `Are you sure you want to ${actionText}?`,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: `Yes, ${actionText} it!`
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = `../mood/a-deactivate-mood.php?id=${moodId}`;
                            }
                        });
                    });
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
                max-width: 45%;
            }

            .btn-primary.view-moods-btn {
                background-color: rgb(217, 233, 71) !important;
                border-color: rgb(217, 233, 71) !important;
                color: white !important;
            }

            .btn-primary.view-moods-btn:hover {
                background-color: rgb(240, 226, 40) !important;
                border-color: rgb(240, 226, 40) !important;
            }

            .btn-warning.confirm-toggle-status {
                background-color: rgb(245, 101, 120) !important;
                border-color: rgb(241, 141, 154) !important;
                color: white !important;
            }

            .btn-success.confirm-toggle-status {
                background-color: rgb(211, 40, 77) !important;
                border-color: rgb(211, 40, 77) !important;
            }
        </style>
</body>

</html>