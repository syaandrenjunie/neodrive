<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mood Check-In Management Dashboard</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    <header class="header-container">
        <div class="logo-title-container">
            <img src="../../assets/image/timer2.png" alt="Logo" class="timer-icon" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">
            <a class="link-underline link-underline-opacity-0" href="#">Mood Check-In Main Dashboard</a>
        </div>
        <div class="header-buttons">
            <a class="link-underline link-underline-opacity-0" href="#">Lists</a>
            <a class="link-underline link-underline-opacity-0" href="../mood/a-list-notes.php">Notes</a>

            <a href="adminprofile.php" class="profile-icon">
                <i class="fa-solid fa-user-circle"></i>
            </a>
        </div>
    </header><br>

    <!-- Include Sidebar -->
    <?php include('../menus-sidebar.php'); ?>

    <div class="mnotes-list">
        <div class="search-container">
            <form action="" method="GET">
                <div class="input-group">
                    <!-- Search Input -->
                    <input type="text" class="form-control" name="search" id="searchInput"
                        placeholder="Search mindful notes..."
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

                // If there is no search term, it will just show all users.
                $query = "SELECT m.*, 
                 u.username, 
                 n.m_notes 
          FROM mood_checkin m
          JOIN users u ON m.user_id = u.user_id
          JOIN mindful_notes n ON m.mindful_note_id = n.mnotes_id";



                if (!empty($searchTerm)) {
                    $query .= " WHERE user_note LIKE '%$searchTerm%' 
                               OR mood_type LIKE '%$searchTerm%' 
                               OR mood_status LIKE '%$searchTerm%' 
                               OR mindful_note_id LIKE '%$searchTerm%' 
                               OR checkin_at LIKE '%$searchTerm%'
                               OR updated_at LIKE '%$searchTerm%'";

                    // Check if the search term exactly matches 'active' or 'inactive'
                    if (strtolower($searchTerm) === 'Active' || strtolower($searchTerm) === 'Inactive') {
                        $query .= " OR mood_status = '$searchTerm'";
                    }
                }

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
            data-m_notes='{$row['user_note']}'
            data-mood_type='{$row['mood_type']}'
            data-mnotes_status='{$row['mood_status']}'
            data-updated='{$row['checkin_at']}'
            data-username='{$row['username']}'
            data-mindful_note='{$row['m_notes']}'
            title='View Mood Checkin'>
            <i class='fa-solid fa-expand'></i>
        </button>

        <button class='btn btn-sm btn-warning edit-notes-btn' 
            data-bs-toggle='modal' 
            data-bs-target='#editNotesModal' 
            data-mindful_note_id='{$row['mindful_note_id']}'
            data-m_notes='{$row['m_notes']}'
            data-mood_type='{$row['mood_type']}'
            data-mnotes_status='{$row['mood_status']}'
            title='Edit Notes'>
            <i class='fa-solid fa-pencil text-white'></i>
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

        <!-- View Notes Modal -->
        <div class="modal fade" id="notesDetailModal" tabindex="-1" aria-labelledby="notesDetailModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Mindful Note Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Note:</strong> <span id="modal-m_notes"></span></p>
                        <p><strong>Mood Type:</strong> <span id="modal-mood_type"></span></p>
                        <p><strong>Status:</strong> <span id="modal-mnotes_status"></span></p>
                        <p><strong>Created At:</strong> <span id="modal-created"></span></p>
                        <p><strong>Updated At:</strong> <span id="modal-updated"></span></p>
                    </div>
                </div>
            </div>
        </div>


        <!-- Edit Notes Modal -->
        <div class="modal fade" id="editNotesModal" tabindex="-1" aria-labelledby="editNotesModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="update-notes.php" method="POST">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Mindful Note</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="mnotes_id" id="edit-mnotes_id">
                            <div class="mb-3">
                                <label for="edit-m_notes" class="form-label">Note</label>
                                <textarea class="form-control" name="m_notes" id="edit-m_notes" rows="3"
                                    required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="edit-mood_type" class="form-label">Mood Type</label>
                                <input type="text" class="form-control" name="mood_type" id="edit-mood_type" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit-mnotes_status" class="form-label">Status</label>
                                <select class="form-control" name="mnotes_status" id="edit-mnotes_status" required>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
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

        <!-- Bootstrap JS (with Popper) -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

        <!-- Custom JavaScript for Sidebar Toggle -->
        <script>
            // Get the image element that will trigger the sidebar
            const sidebarToggle = document.getElementById('sidebarToggle');

            // Add click event to trigger sidebar
            sidebarToggle.addEventListener('click', function () {
                const sidebar = new bootstrap.Offcanvas(document.getElementById('offcanvasWithBothOptions'));
                sidebar.show(); // Show the sidebar when the image is clicked
            });


        </script>

        <style>
            .search-container {
                margin-bottom: 10px;
                display: flex;
                justify-content: flex-start;
                /* Align to the left */
            }

            .search-form {
                width: 800px;
                max-width: 600px;
                /* Adjust width as needed */
            }

            .modal-lg {
                max-width: 60%;
                /* Adjust the width as needed */
            }
        </style>
</body>

</html>