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

$show_unmarked_alert = false;

if (isset($_SESSION['unmarked_task']) && $_SESSION['unmarked_task'] === true) {
    $show_unmarked_alert = true;
    unset($_SESSION['unmarked_task']);
}

// Fetch priority levels from the database
$priorityQuery = "SELECT * FROM priority_levels";
$priorityResult = mysqli_query($conn, $priorityQuery);
if (!$priorityResult) {
    die('Error fetching priority levels: ' . mysqli_error($conn));
}

$priorityLevels = [];
while ($row = mysqli_fetch_assoc($priorityResult)) {
    $priorityLevels[] = $row;
}

// Handle task creation (POST request)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['task_name'])) {
    $task_name = mysqli_real_escape_string($conn, $_POST['task_name']);
    $task_details = mysqli_real_escape_string($conn, $_POST['task_details']);
    $priority_id = $_POST['priority']; // Priority ID selected from dropdown

    // Insert the new task into the to_do_list table
    $sql = "INSERT INTO to_do_list (user_id, task_name, task_details, priority_id) VALUES ('$user_id', '$task_name', '$task_details', '$priority_id')";
    if (mysqli_query($conn, $sql)) {
        // Set session flag to indicate success
        $_SESSION['task_success'] = true; // set flag
        header("Location: " . $_SERVER['PHP_SELF']); // redirect to avoid form resubmission
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Round Timer</title>
    <link rel="stylesheet" href="../../css/style.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</head>


<body>


    <header class="header-container">
        <div class="logo-title-container">
            <img src="../../assets/image/clock.png" alt="Logo neodrive">
            <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 
                link-underline-opacity-75-hover" href="#">Timer</a>
        </div>
        <div class="header-buttons">
            <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 
     link-underline-opacity-75-hover" href="#">NeoSpace</a>
            <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 
     link-underline-opacity-75-hover" href="../pc/pccollection.php">Collection</a>
            <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 
     link-underline-opacity-75-hover" href="../quotes/quotes.php">Quotes</a>
            <a href="../profile/profile.php" class="profile-icon">
                <i class="fa-solid fa-user-circle"></i>
            </a>

        </div>

    </header><br>
    <?php if (isset($_SESSION['task_success']) && $_SESSION['task_success']): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Task added successfully!',
                showConfirmButton: false,
                timer: 1500
            });
        </script>
        <?php unset($_SESSION['task_success']); ?>
    <?php endif; ?>

    <div class="main-container d-flex justify-content-center align-items-start">
        <!-- Timer Section -->
        <div id="timerContainerGroup">
            <div id="roundInfo"></div>
            <div class="timer">
                <div id="timerContainer">
                    <span id="timer">00:00</span>
                </div>
            </div>
            <!-- Button trigger modal -->

            <button type="button" class="btn btn-primary d-block mx-auto" data-bs-toggle="modal"
                data-bs-target="#timerModal">
                Set Timer
            </button>


            <!-- Modal -->
            <div class="modal fade" id="timerModal" tabindex="-1" aria-labelledby="timerModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="timerModalLabel">Set Timer</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <form id="timerForm">
                                <div class="mb-3">
                                    <label for="rounds" class="form-label">Number of Rounds:</label>
                                    <input type="number" id="rounds" class="form-control" value="1" min="1">
                                </div>

                                <div class="mb-3">
                                    <label for="roundTime" class="form-label">Round Duration (minutes):</label>
                                    <input type="number" id="roundTime" class="form-control" value="25" min="1">
                                </div>

                                <div class="mb-3">
                                    <label for="breakTime" class="form-label">Break Duration (minutes):</label>
                                    <input type="number" id="breakTime" class="form-control" value="5" min="1">
                                </div>
                            </form>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" onclick="saveTimerSettings()">Save</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="btn timer-btn mt-3" id="timerButtons" style="display: none;">
                <button type="button" class="btn btn-success" id="startRoundBtn" onclick="startRound()" disabled>
                    Start Round
                </button>
                <button type="button" class="btn btn-warning" id="pauseBtn" onclick="pauseTimer()" disabled>
                    Pause
                </button>
                <button type="button" class="btn btn-warning" id="startBreakBtn" onclick="startBreak()" disabled>
                    Start Break
                </button>
                <button type="button" class="btn btn-danger" onclick="resetTimer()">
                    Reset
                </button>
            </div>
        </div>

        <div class="container mt-4">
            <div class="todo-container">
                <h2 style="color: white;">To-Do List</h2>
                <form method="POST" action="">
                    <input type="text" id="taskName" name="task_name" class="form-control mb-2" placeholder="Task Name"
                        required>
                    <textarea id="taskDetails" name="task_details" class="form-control mb-2"
                        placeholder="Task Details (Optional)"></textarea>

                    <!-- Priority Dropdown with Placeholder -->
                    <select id="priority" name="priority" class="form-select mb-2" required>
                        <option value="" disabled selected hidden>Choose Priority Level</option>
                        <?php foreach ($priorityLevels as $level): ?>
                            <option value="<?= $level['priority_id'] ?>"><?= ucfirst($level['level_name']) ?></option>
                        <?php endforeach; ?>
                    </select>

                    <button type="submit" class="btn btn-primary">Add Task</button>
                </form>

                <div id="taskList" class="mt-3">
                    <?php
                    $query = "SELECT t.task_id, t.task_name, t.task_details, t.is_completed, p.level_name 
FROM to_do_list t
JOIN priority_levels p ON t.priority_id = p.priority_id
WHERE t.user_id = $user_id
ORDER BY 
  t.is_completed ASC,  -- Uncompleted tasks first (0 = false)
  CASE p.level_name     -- Sort by priority: High > Medium > Low
    WHEN 'High' THEN 1
    WHEN 'Medium' THEN 2
    WHEN 'Low' THEN 3
    ELSE 4
  END";

                    $result = mysqli_query($conn, $query);

                    if (mysqli_num_rows($result) > 0):
                        while ($row = mysqli_fetch_assoc($result)):
                            $isChecked = $row['is_completed'] ? 'checked' : '';
                            ?>
                            <div class="task">
                                <span class="task-name <?= $row['is_completed'] ? 'completed-task' : '' ?>"
                                    onclick="toggleDetails(this)">
                                    <?= htmlspecialchars($row['task_name']) ?> (<?= ucfirst($row['level_name']) ?>)
                                </span>

                               <div class="task-details" style="display: block; color: <?= $row['is_completed'] ? 'white' : 'initial' ?>;">
    <?= nl2br(htmlspecialchars($row['task_details'])) ?>
</div>

                                <div class="buttons">
                                    <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#editTaskModal<?= $row['task_id'] ?>">
                                        Edit
                                    </button>
                                    <button class="btn btn-danger btn-sm" onclick="deleteTask(this)">Delete</button>
                                    <form method="POST" action="../todolist/u-complete-task.php" style="display:inline;">
                                        <input type="hidden" name="taskID" value="<?= $row['task_id'] ?>">
                                        <!-- Hidden field to pass the task ID -->
                                        <input type="checkbox" name="is_completed" value="1" onchange="this.form.submit()"
                                            <?= $isChecked ? 'checked' : '' ?>>
                                    </form>

                                </div>
                            </div>
                            <?php
                        endwhile;
                    else:
                        echo "<p>No tasks available.</p>";
                    endif;
                    ?>

                </div>
            </div>
        </div>

        <?php if (isset($_SESSION['task_completed']) && $_SESSION['task_completed']): ?>
            <script>
                Swal.fire({
                    title: "🎉 Congrats!",
                    text: "You've completed a task!",
                    icon: "success",
                    confirmButtonText: "Nice!"
                });
            </script>
            <?php unset($_SESSION['task_completed']); // Unset session flag to prevent it from showing again ?>
        <?php endif; ?>


        <!-- Edit Task Modal -->
        <div class="modal fade" id="editTaskModal<?= $row['task_id'] ?>" tabindex="-1"
            aria-labelledby="editTaskLabel<?= $task['task_id'] ?>" aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" action="update_task.php">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editTaskLabel<?= $task['task_id'] ?>">Edit Task</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="task_id" value="<?= $task['task_id'] ?>">
                            <input type="text" name="task_name" class="form-control"
                                value="<?= htmlspecialchars($task['task_name']) ?>" required>
                            <textarea name="task_details"
                                class="form-control mt-2"><?= htmlspecialchars($task['task_details']) ?></textarea>
                            <select name="priority" class="form-select mt-2">
                                <?php foreach ($priorityLevels as $level): ?>
                                    <option value="<?= $level['priority_id'] ?>"
                                        <?= $task['priority_id'] == $level['priority_id'] ? 'selected' : '' ?>>
                                        <?= ucfirst($level['level_name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Save Changes</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
    </div>


    <!-- Bootstrap JavaScript (Required for Modal) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="../../script.js"></script>
    <script>
        function markCompleted(checkbox) {
            const taskID = checkbox.getAttribute('data-task-id');

            // Only trigger SweetAlert and update if checkbox is checked
            if (checkbox.checked) {
                Swal.fire({
                    title: "🎉 Congrats!",
                    text: "You've completed a task!",
                    icon: "success",
                    confirmButtonText: "Nice!"
                });.then(() => {
                    // Send update to PHP
                    fetch('update_task.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: `taskID=${taskID}`
                    })
                        .then(response => response.text())
                        .then(data => {
                            console.log(data); // Optional: log success message
                            // You can also reload the page or update UI here
                        });
                });
            } else {
                // Optional: handle unchecking if needed
                // (e.g., you could revert the checkbox, show a different alert, etc.)
            }
        }

       document.addEventListener('DOMContentLoaded', function() {
    <?php if ($show_unmarked_alert): ?>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: 'You have successfully unmarked the task.',
            timer: 2000,
            showConfirmButton: false
        });
    <?php endif; ?>
});
    </script>

    <style>
        .completed-task {
            text-decoration: line-through;
            color: white;
        }

        
        /* Base style with white background */
        input[type="text"],
        textarea,
        select {
            background-color: #fff;
            /* White background */
            color: #000;
            /* Black text for contrast */
            border: 2px solid #ccc;
            /* Light gray default border */
            border-radius: 5px;
            padding: 10px;
            transition: 0.3s ease;
        }

        /* Neon border effect on focus or hover */
        input[type="text"]:focus,
        input[type="text"]:hover,
        textarea:focus,
        textarea:hover,
        select:focus,
        select:hover {
            border-color: rgb(0, 255, 76);
            /* Neon blue border */
box-shadow: 0 0 8px rgb(107, 250, 88); /* ✅ fixed */
            /* Neon glow effect */
            outline: none;
        }
    </style>


</body>

</html>