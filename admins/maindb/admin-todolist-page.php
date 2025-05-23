<?php
include("../../include/auth.php"); // Include the authentication file

// Check if the user is an admin
check_role('admin');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do-Lists Main Dashboard</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    <header class="header-container">
        <div class="logo-title-container">
            <!-- Image will trigger the sidebar -->
            <img src="../../assets/image/timer2.png" alt="Logo" class="timer-icon" data-bs-toggle="offcanvas"
            data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">            <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover" 
            href="#">To-Do-Lists Management Dashboard</a></div>
            <div class="header-buttons">
            <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 
     link-underline-opacity-75-hover" href="timer.php">NeoSpace</a>
            <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 
     link-underline-opacity-75-hover" href="#">Collection</a>
            <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 
     link-underline-opacity-75-hover" href="quotes.php">Quotes</a>
            <a href="adminprofile.php" class="profile-icon">
                <i class="fa-solid fa-user-circle"></i>
            </a>

        </div>
    </header><br>

    <!-- Include Sidebar -->
    <?php include('../menus-sidebar.php'); ?>

    <div class="todo-list">
        <div class="search-container">
            <form action="" method="GET">
                <div class="input-group">
                    <!-- Search Input -->
                    <input type="text" class="form-control" name="search" id="searchInput"
                        placeholder="Search to-do-list..."
                        value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>"
                        aria-label="Search to-do-list">

                    <!-- Search Icon as Submit Button -->
                    <button type="submit" class="input-group-text btn btn-link" style="color: black">
                        <i class="fa fa-search"></i>
                    </button>

                    <!-- Clear Search Button -->
                    <a href="admin-todolist-page.php" class="btn btn-secondary input-group-text">Clear Search</a>
                </div>
            </form>

        </div>
    <table class="table table-striped table-hover mt-3">
    <thead>
        <tr>
            <th>#</th>
            <th>Task Name</th>
            <th>Priority</th>
            <th>Username</th>
            <th>Status</th>
            <th>Updated At</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $searchTerm = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

        // Base query
        $query = "SELECT t.*, u.username, p.level_name, t.task_details
          FROM to_do_list t 
          JOIN users u ON t.user_id = u.user_id 
          JOIN priority_levels p ON t.priority_id = p.priority_id
          ORDER BY t.updated_at DESC";

                  
        // Apply search term if available
        if (!empty($searchTerm)) {
            $query .= " WHERE t.task_name LIKE '%$searchTerm%' 
                        OR u.username LIKE '%$searchTerm%' 
                        OR p.level_name LIKE '%$searchTerm%' 
                        OR t.is_completed LIKE '%$searchTerm%' 
                        OR t.updated_at LIKE '%$searchTerm%'";
        }

        $result = mysqli_query($conn, $query);
        $i = 1; // <-- Add this line before the loop

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                    <td>" . $i++ . "</td>
                    <td class='text-wrap' style='max-width: 300px;'>{$row['task_name']}</td>
                    <td>{$row['level_name']}</td>
                    <td>{$row['username']}</td>
                    <td>" . ($row['is_completed'] ? 'Completed' : 'Pending') . "</td>
                    <td>{$row['updated_at']}</td>
                    <td>
                        <button class='btn btn-sm btn-primary view-task-btn' 
    data-bs-toggle='modal' 
    data-bs-target='#taskDetailModal' 
    data-task_name='{$row['task_name']}'
    data-task_details='{$row['task_details']}'
    data-username='{$row['username']}'
    data-priority='{$row['level_name']}'
    data-status='{$row['is_completed']}'
    data-created='{$row['created_at']}'
    data-updated='{$row['updated_at']}'
    title='View Task'>
    <i class='fa-solid fa-expand'></i>
</button>


                        <button class='btn btn-sm btn-warning edit-task-btn' 
                            data-bs-toggle='modal' 
                            data-bs-target='#editTaskModal' 
                            data-task_id='{$row['task_id']}'
                            data-task_name='{$row['task_name']}'
                            data-priority='{$row['level_name']}'
                            data-status='{$row['is_completed']}'
                            title='Edit Task'>
                            <i class='fa-solid fa-pencil text-white'></i>
                        </button>
                    </td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='7' style='text-align: center;'>No record found</td></tr>";
        }
        ?>
    </tbody>
</table>

<!-- Task Detail Modal -->
<div class="modal fade" id="taskDetailModal" tabindex="-1" aria-labelledby="taskDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modal-task_name-title"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

            <p style="margin-bottom: 2px;"><strong>Task Name:</strong></p>
            <p style="margin-top: 0;"><em id="modal-task_name"></em></p>

            <p><strong>Task Details:</strong> <span id="modal-task_details"></span></p>

                <p><strong>Priority:</strong> <span id="modal-priority"></span></p>

                

                <p><strong>Status:</strong> <span id="modal-status"></span></p>
                <p><strong>Created At:</strong> <span id="modal-created"></span></p>
                <p><strong>Updated At:</strong> <span id="modal-updated"></span></p>
                
            </div>
        </div>
    </div>
</div>

<!-- Edit Task Modal -->
<div class="modal fade" id="taskEditModal" tabindex="-1" aria-labelledby="taskEditModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="taskEditModalLabel">Edit Task</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="edit-task-form" action="../tasks/a-update-task.php" method="POST">
                    <!-- Task Name -->
                    <div class="mb-3">
                        <label for="edit-task_name" class="form-label"><strong>Task Name</strong></label>
                        <input type="text" class="form-control" id="edit-task_name" name="task_name" required>
                    </div>

                    <!-- Task Details -->
                    <div class="mb-3">
                        <label for="edit-task_details" class="form-label"><strong>Task Details</strong></label>
                        <textarea class="form-control" id="edit-task_details" name="task_details" rows="4" required></textarea>
                    </div>

                    <!-- Priority -->
                    <div class="mb-3">
                        <label for="edit-priority" class="form-label"><strong>Priority</strong></label>
                        <select class="form-select" id="edit-priority" name="priority_id" required>
                            <option value="" disabled selected>Choose priority...</option>
                            <option value="1">Low</option>
                            <option value="2">Medium</option>
                            <option value="3">High</option>
                        </select>
                    </div>

                    <!-- Status -->
                    <div class="mb-3">
                        <label for="edit-status" class="form-label"><strong>Status</strong></label>
                        <select class="form-control" id="edit-status" name="is_completed" required>
                            <option value="0">Incomplete</option>
                            <option value="1">Completed</option>
                        </select>
                    </div>

                    <!-- Hidden Task ID -->
                    <input type="hidden" id="edit-task_id" name="task_id">

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Task</button>
                    </div>
                </form>
            </div>
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
        sidebarToggle.addEventListener('click', function() {
            const sidebar = new bootstrap.Offcanvas(document.getElementById('offcanvasWithBothOptions'));
            sidebar.show(); // Show the sidebar when the image is clicked
        });
        document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.view-task-btn').forEach(button => {
        button.addEventListener('click', function () {
            document.getElementById('modal-task_name-title').textContent = this.dataset.task_name;
            document.getElementById('modal-task_name').textContent = this.dataset.task_name;
            document.getElementById('modal-task_details').textContent = this.dataset.task_details; // Ensure this line exists
            document.getElementById('modal-priority').textContent = this.dataset.priority;
            document.getElementById('modal-status').textContent = this.dataset.status === '1' ? 'Completed' : 'Incomplete';
            document.getElementById('modal-created').textContent = this.dataset.created;
            document.getElementById('modal-updated').textContent = this.dataset.updated;
        });
    });
});



    document.querySelectorAll('.edit-task-btn').forEach(button => {
        button.addEventListener('click', function () {
            document.getElementById('edit-task_id').value = this.dataset.task_id;
            document.getElementById('edit-task_name').value = this.dataset.task_name;
            document.getElementById('edit-task_details').value = this.dataset.task_details;
            document.getElementById('edit-priority').value = this.dataset.priority;
            document.getElementById('edit-status').value = this.dataset.status;

            new bootstrap.Modal(document.getElementById('taskEditModal')).show();
        });
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

        .modal-lg {
            max-width: 60%;
            /* Adjust the width as needed */
        }
    </style>
</body>
</html>
