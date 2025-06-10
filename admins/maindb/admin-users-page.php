<?php

include("../../include/auth.php"); // Include the authentication file

// Check if the user is an admin
check_role('admin');

include '../../database/dbconn.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Management Main Dashboard</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    <header class="header-container">
        <div class="logo-title-container">
            <img src="../../assets/image/clock.png" alt="Logo" class="timer-icon" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">
            <a class="link-underline link-underline-opacity-0" href="#">Users Management Dashboard</a>
        </div>
        <div class="header-buttons">
            
            <a href="adminprofile.php" class="profile-icon">
                <i class="fa-solid fa-user-circle"></i>
            </a>
        </div>
    </header><br><br>

    <?php include('../menus-sidebar.php'); ?>

    <div class="user-list">
        <div class="search-container">
            <form action="" method="GET">
                <div class="input-group">
                    <!-- Search Input -->
                    <input type="text" class="form-control" name="search" id="searchInput" placeholder="Search users..."
                        value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>" aria-label="Search users">

                    <!-- Search Icon as Submit Button -->
                    <button type="submit" class="input-group-text btn btn-link" style="color: black">
                        <i class="fa fa-search"></i>
                    </button>

                    <!-- Clear Search Button -->
                    <a href="admin-users-page.php" class="btn btn-secondary input-group-text">Clear Search</a>
                </div>

            </form>
        </div>

        <table class="table table-striped table-hover mt-3">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Bias</th>
                    <th>Profile Picture</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $searchTerm = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

                // If there is no search term, it will just show all users.
                $query = "SELECT * FROM users ORDER BY updated_at DESC";


                if (!empty($searchTerm)) {
                    $query .= " WHERE username LIKE '%$searchTerm%' 
                               OR email LIKE '%$searchTerm%' 
                               OR user_roles LIKE '%$searchTerm%' 
                               OR bias LIKE '%$searchTerm%'
                               OR created_at LIKE '%$searchTerm%'";

                    // Check if the search term exactly matches 'active' or 'inactive'
                    if (strtolower($searchTerm) === 'active' || strtolower($searchTerm) === 'inactive') {
                        $query .= " OR user_status = '$searchTerm'";
                    }
                }

                $result = mysqli_query($conn, $query);
                $i = 1;

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                            <td>" . $i++ . "</td>
                            <td>{$row['username']}</td>
                            <td>{$row['email']}</td>
                            <td>{$row['user_roles']}</td>
                            <td>{$row['bias']}</td>
                            <td><img src='../../assets/profile/{$row['profile_picture']}' alt='Profile' width='50' class='rounded-circle'></td>
                            <td>{$row['user_status']}</td>
                            <td>{$row['created_at']}</td>
                            <td>
                                <button class='btn btn-sm btn-primary view-user-btn' 
                                    data-bs-toggle='modal' 
                                    data-bs-target='#userDetailModal' 
                                    data-username='{$row['username']}'
                                    data-email='{$row['email']}'
                                    data-role='{$row['user_roles']}'
                                    data-bias='{$row['bias']}'
                                    data-picture='../../assets/profile/{$row['profile_picture']}'
                                    data-status='{$row['user_status']}'
                                    data-created='{$row['created_at']}'
                                    data-updated='{$row['updated_at']}'
                                    title='View User'>
                                    <i class='fa-solid fa-expand'></i>
                                </button>
                
                                <a href='../users/deactivate-user.php?id={$row['user_id']}' 
                                   class='btn btn-sm " . ($row['user_status'] === 'active' ? 'btn-warning' : 'btn-success') . "' 
                                   title='" . ($row['user_status'] === 'active' ? 'Deactivate' : 'Activate') . " User'
                                   onclick='return confirm(\"Are you sure you want to " . ($row['user_status'] === 'active' ? 'deactivate' : 'activate') . " this user?\");'>
                                   <i class='fa-solid " . ($row['user_status'] === 'active' ? 'fa-user-slash' : 'fa-user-check') . "'></i>
                                </a>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='9' style='text-align: center;'>No record found</td></tr>";
                }

                ?>
            </tbody>
        </table>

        <!-- User Detail Modal -->
        <div class="modal fade" id="userDetailModal" tabindex="-1" aria-labelledby="userDetailModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="userDetailModalLabel">User Details</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Name:</strong> <span id="modal-username"></span></p>
                        <p><strong>Email:</strong> <span id="modal-email"></span></p>
                        <p><strong>Role:</strong> <span id="modal-role"></span></p>
                        <p><strong>Bias:</strong> <span id="modal-bias"></span></p>
                        <p><strong>Status:</strong> <span id="modal-status"></span></p>
                        <p><strong>Created At:</strong> <span id="modal-created"></span></p>
                        <p><strong>Profile Picture:</strong><br>
                            <img id="modal-picture" src="" alt="Profile Picture" class="img-fluid rounded" width="100">
                        </p>
                        <p><strong>Updated At:</strong> <span id="modal-updated"></span></p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap JS (with Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Modal Fill Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.view-user-btn').forEach(button => {
                button.addEventListener('click', function () {
                    document.getElementById('modal-username').textContent = this.dataset.username;
                    document.getElementById('modal-email').textContent = this.dataset.email;
                    document.getElementById('modal-role').textContent = this.dataset.role;
                    document.getElementById('modal-bias').textContent = this.dataset.bias;
                    document.getElementById('modal-status').textContent = this.dataset.status;
                    document.getElementById('modal-created').textContent = this.dataset.created;
                    document.getElementById('modal-updated').textContent = this.dataset.updated;
                    document.getElementById('modal-picture').src = this.dataset.picture;
                });
            });

            // Get the image element that will trigger the sidebar
            const sidebarToggle = document.getElementById('sidebarToggle');

            // Add click event to trigger sidebar
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
            /* Align to the left */
        }

        .search-form {
            width: 800px;
            max-width: 600px;
            /* Adjust width as needed */
        }

        
    </style>

</body>

</html>