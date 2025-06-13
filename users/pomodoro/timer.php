<?php
include '../../database/dbconn.php';
include '../todolist//u-todolist.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

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
     link-underline-opacity-75-hover" href="../pc/u-pc-collection.php">Collection</a>
            <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 
     link-underline-opacity-75-hover" href="../quotes/quotes.php">Quotes</a>
            <a href="../profile/profile.php" class="profile-icon">
                <i class="fa-solid fa-user-circle"></i>
            </a>

        </div>

    </header><br><br>
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

    <div class="main-container d-flex flex-row gap-4 justify-content-center align-items-start">
        <!-- Timer Section -->
        <div id="timerContainerGroup" class="d-flex flex-column align-items-center">
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

                        <form id="timerForm" method="POST" action="u-save-timer.php">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="timerModalLabel">Set Timer</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="rounds" class="form-label">Number of Rounds:</label>
                                    <input type="number" id="rounds" name="total_rounds" class="form-control" value="1"
                                        min="1">
                                </div>

                                <div class="mb-3">
                                    <label for="roundTime" class="form-label">Round Duration (minutes):</label>
                                    <input type="number" id="roundTime" name="round_duration" class="form-control"
                                        value="25" min="1">
                                </div>

                                <div class="mb-3">
                                    <label for="breakTime" class="form-label">Break Duration (minutes):</label>
                                    <input type="number" id="breakTime" name="break_duration" class="form-control"
                                        value="5" min="1">
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

            <?php
            include '../../database/dbconn.php';

            if (isset($_GET['add_success']) && $_GET['add_success'] == 1) {
                $user_id = $_SESSION['user_id'] ?? null;
                $session_id = (int) ($_GET['session_id'] ?? 0);

                // Default values (used if session fetch fails)
                $totalRounds = 1;
                $roundDuration = 25 * 60;
                $breakDuration = 5 * 60;

                if ($user_id && $session_id) {
                    $stmt = $conn->prepare("SELECT total_rounds, round_duration, break_duration FROM timer_sessions WHERE session_id = ? AND user_id = ?");
                    $stmt->bind_param("ii", $session_id, $user_id);
                    $stmt->execute();
                    $stmt->bind_result($totalRounds, $roundDuration, $breakDuration);
                    $stmt->fetch();
                    $stmt->close();

                    // Convert durations to seconds
                    $roundDuration *= 60;
                    $breakDuration *= 60;
                }
                ?>

                <div id="timerButtons" style="display:none; margin-top: 20px;">
                    <button id="startRoundBtn" class="btn btn-success">Start Round</button>
                    <button id="startBreakBtn" class="btn btn-warning" disabled>Start Break</button>
                    <button id="pauseBtn" class="btn btn-secondary" disabled>Pause</button>
                    <button id="resetBtn" class="btn btn-danger">Reset</button>
                </div>
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: '🎯 New Pomodoro Session Ready',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });

                    let totalRounds = <?= (int) $totalRounds ?>;
                    let roundTime = <?= (int) $roundDuration ?>;
                    let breakTime = <?= (int) $breakDuration ?>;
                    let currentRound = 1;
                    let timeLeft = roundTime;

                    document.getElementById('rounds').value = totalRounds;
                    document.getElementById('roundTime').value = roundTime / 60;
                    document.getElementById('breakTime').value = breakTime / 60;

                    function updateTimerDisplay(seconds) {
                        const minutes = Math.floor(seconds / 60);
                        const remainingSeconds = seconds % 60;
                        document.getElementById('timer').textContent =
                            `${String(minutes).padStart(2, '0')}:${String(remainingSeconds).padStart(2, '0')}`;
                    }

                    updateTimerDisplay(timeLeft);
                    document.getElementById('roundInfo').innerText = `Set for ${totalRounds} rounds, ${roundTime / 60} min per round, ${breakTime / 60} min break.`;
                    document.getElementById('startRoundBtn').disabled = false;
                    document.getElementById('startBreakBtn').disabled = true;
                    document.getElementById('pauseBtn').disabled = true;
                    document.getElementById('timerButtons').style.display = 'block';
                </script>
            <?php } ?>

            <script>
                const sessionId = <?= isset($_GET['session_id']) ? (int) $_GET['session_id'] : 'null' ?>;

                document.addEventListener("DOMContentLoaded", function () {

                    let totalRounds = 1;
                    let currentRound = 1;
                    let roundTime = 25 * 60; // default 25 min in seconds
                    let breakTime = 5 * 60;  // default 5 min in seconds
                    let timeLeft = 0;
                    let timerInterval = null;
                    let isRound = true; // true means round, false means break
                    let isPaused = false;
                    let timerStartTimestamp = null; // NEW: For persistence

                    // Elements
                    const timerEl = document.getElementById('timer');
                    const roundInfoEl = document.getElementById('roundInfo');
                    const startRoundBtn = document.getElementById('startRoundBtn');
                    const startBreakBtn = document.getElementById('startBreakBtn');
                    const pauseBtn = document.getElementById('pauseBtn');
                    const resetBtn = document.getElementById('resetBtn');
                    const timerButtons = document.getElementById('timerButtons');

                    // ----------- Persistence Functions -----------
                    function saveTimerState() {
                        localStorage.setItem('timerState', JSON.stringify({
                            totalRounds,
                            currentRound,
                            roundTime,
                            breakTime,
                            timeLeft,
                            isRound,
                            isPaused,
                            timerStartTimestamp
                        }));
                    }

                    function restoreTimerState() {
                        const stateStr = localStorage.getItem('timerState');
                        if (!stateStr) return;

                        const state = JSON.parse(stateStr);
                        totalRounds = state.totalRounds;
                        currentRound = state.currentRound;
                        roundTime = state.roundTime;
                        breakTime = state.breakTime;
                        isRound = state.isRound;
                        isPaused = state.isPaused;
                        timerStartTimestamp = state.timerStartTimestamp;

                        if (!timerStartTimestamp) return; // no valid timer started

                        // Calculate timeLeft based on elapsed time
                        if (!isPaused) {
                            const elapsed = Math.floor((Date.now() - timerStartTimestamp) / 1000);
                            timeLeft = Math.max(0, state.timeLeft - elapsed);
                        } else {
                            timeLeft = state.timeLeft;
                        }

                        updateTimerDisplay();

                        // Update UI buttons accordingly
                        startRoundBtn.disabled = !isRound || timeLeft > 0;
                        startBreakBtn.disabled = isRound || timeLeft > 0;
                        pauseBtn.disabled = (timeLeft === 0);
                        pauseBtn.textContent = isPaused ? "Resume" : "Pause";

                        roundInfoEl.textContent = isRound
                            ? `⏳ Round ${currentRound} of ${totalRounds}`
                            : `🛋️ Break after Round ${currentRound}`;

                        // **Start the timer interval if timer is running and time left**
                        if (timeLeft > 0 && !isPaused) {
                            clearInterval(timerInterval);
                            timerInterval = setInterval(timerTick, 1000);
                        }
                    }

                    // Format seconds to mm:ss
                    function formatTime(seconds) {
                        const m = Math.floor(seconds / 60);
                        const s = seconds % 60;
                        return `${String(m).padStart(2, '0')}:${String(s).padStart(2, '0')}`;
                    }

                    // Record completed round via AJAX
                    function recordCompletedRound(roundNumber) {
    fetch('u-record-round.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'round=' + encodeURIComponent(roundNumber) + '&session_id=' + encodeURIComponent(sessionId)
    })
    .then(response => response.text())
    .then(data => {
        console.log('Server response:', data);

        // Optional: Show photocard in SweetAlert if data contains <img>
        if (data.includes("<img")) {
            Swal.fire({
                title: '🎉 You earned a photocard!',
                html: data,
                confirmButtonText: 'Yay!',
                customClass: {
                    popup: 'rounded-lg'
                }
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}


                    // Update Timer display
                    function updateTimerDisplay() {
                        timerEl.textContent = formatTime(timeLeft);
                    }

                    function timerTick() {
    if (!isPaused && timeLeft > 0) {
        timeLeft--;
        updateTimerDisplay();
        saveTimerState();
    }

    if (timeLeft === 0) {
        clearInterval(timerInterval);
        saveTimerState();

        if (isRound) {
            playSound();
            recordCompletedRound(currentRound); // ⬅️ Now this will trigger photocard logic

            if (currentRound >= totalRounds) {
    recordCompletedRound(currentRound); // This will handle both round + photocard
    return;
}


            Swal.fire({
                icon: 'success',
                title: `🎉 Round ${currentRound} complete!`,
                showConfirmButton: true,
                confirmButtonText: 'OK',
                timer: 6000
            });

            startRoundBtn.disabled = true;
            startBreakBtn.disabled = false;
            pauseBtn.disabled = true;
            isRound = false;

        } else {
            // Break complete
            playSound();
            Swal.fire({
                icon: 'info',
                title: `⏱️ Break complete!`,
                text: `Get ready for Round ${currentRound + 1}`,
                showConfirmButton: true,
                timer: 6000
            });

            currentRound++;
            startRoundBtn.disabled = false;
            startBreakBtn.disabled = true;
            pauseBtn.disabled = true;
            isRound = true;
        }

        saveTimerState();
    }
}


                    function startRound() {
                        timeLeft = roundTime;
                        timerStartTimestamp = Date.now();
                        updateTimerDisplay();
                        clearInterval(timerInterval);
                        timerInterval = setInterval(timerTick, 1000);
                        startRoundBtn.disabled = true;
                        startBreakBtn.disabled = true;
                        pauseBtn.disabled = false;
                        roundInfoEl.textContent = `⏳ Round ${currentRound} of ${totalRounds}`;
                        isRound = true;
                        isPaused = false;
                        pauseBtn.textContent = "Pause";
                        saveTimerState();
                    }

                    function startBreak() {
                        timeLeft = breakTime;
                        timerStartTimestamp = Date.now();
                        updateTimerDisplay();
                        clearInterval(timerInterval);
                        timerInterval = setInterval(timerTick, 1000);
                        startRoundBtn.disabled = true;
                        startBreakBtn.disabled = true;
                        pauseBtn.disabled = false;
                        roundInfoEl.textContent = `🛋️ Break after Round ${currentRound}`;
                        isRound = false;
                        isPaused = false;
                        pauseBtn.textContent = "Pause";
                        saveTimerState();
                    }

                    // Pause/Resume Timer
                    function pauseTimer() {
                        if (isPaused) {
                            isPaused = false;
                            timerStartTimestamp = Date.now() - ((roundTime + breakTime - timeLeft) * 1000);
                            pauseBtn.textContent = "Pause";
                            timerInterval = setInterval(timerTick, 1000);
                        } else {
                            isPaused = true;
                            clearInterval(timerInterval);
                            pauseBtn.textContent = "Resume";
                        }
                        saveTimerState();
                    }

                    // Reset Timer
                    function resetTimer() {
                        clearInterval(timerInterval);
                        currentRound = 1;
                        timeLeft = 0;
                        timerStartTimestamp = null;
                        updateTimerDisplay();
                        roundInfoEl.textContent = `Timer reset. Set your rounds and times.`;
                        startRoundBtn.disabled = false;
                        startBreakBtn.disabled = true;
                        pauseBtn.disabled = true;
                        pauseBtn.textContent = "Pause";
                        isPaused = false;
                        isRound = true;
                        localStorage.removeItem('timerState');
                    }

                    function playSound() {
                        const sound = document.getElementById('alarmSound');
                        if (sound) {
                            sound.currentTime = 0;
                            sound.play().catch(e => console.error("Sound play blocked or failed:", e));
                        }
                    }
                    startRoundBtn.addEventListener('click', startRound);
                    startBreakBtn.addEventListener('click', startBreak);
                    pauseBtn.addEventListener('click', pauseTimer);
                    resetBtn.addEventListener('click', resetTimer);

                    // Restore timer state on page load
                    restoreTimerState();

                    // Save timer state before leaving page
                    window.addEventListener('beforeunload', saveTimerState);

                    // Show timer buttons only after user sets timer successfully
                    <?php if (isset($_GET['add_success']) && $_GET['add_success'] == 1): ?>
                        timerButtons.style.display = 'block';
                        // Set initial values from PHP variables
                        totalRounds = <?= (int) $totalRounds ?>;
                        roundTime = <?= (int) $roundDuration ?>;
                        breakTime = <?= (int) $breakDuration ?>;
                        currentRound = 1;
                        timeLeft = 0;
                        updateTimerDisplay();
                        roundInfoEl.textContent = `Set for ${totalRounds} rounds, ${roundTime / 60} min per round, ${breakTime / 60} min break.`;
                        startRoundBtn.disabled = false;
                        startBreakBtn.disabled = true;
                        pauseBtn.disabled = true;
                    <?php else: ?>
                        timerButtons.style.display = 'none';
                    <?php endif; ?>
                });
            </script>

            <audio id="alarmSound" src="../../assets/sounds/jaemin_mwoya.mp3" preload="auto"></audio>

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
                        WHERE t.user_id = $user_id AND t.task_status = 'active'
                        ORDER BY 
                            t.is_completed ASC,  -- incomplete (0) first, completed (1) last
                        CASE p.level_name
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
                                <div class="task-info">
                                    <span class="task-name <?= $row['is_completed'] ? 'completed-task' : '' ?>"
                                        onclick="toggleDetails(this)">
                                        <?= htmlspecialchars($row['task_name']) ?> (<?= ucfirst($row['level_name']) ?>)
                                    </span>

                                    <div class="task-details" style="color: <?= $row['is_completed'] ? 'white' : 'initial' ?>;">
                                        <?= nl2br(htmlspecialchars($row['task_details'])) ?>
                                    </div>
                                </div>

                                <div class="buttons">
                                    <button type="button" class="btn btn-link text-warning p-0" data-bs-toggle="modal"
                                        data-bs-target="#editTaskModal<?= $row['task_id'] ?>" title="Edit Task">
                                        <i class="fas fa-pencil-alt text-warning" style="opacity: 0.6;"></i>
                                    </button>

                                    <form method="POST" action="../todolist/u-delete-task.php" style="display:inline;"
                                        class="delete-task-form" data-task-id="<?= $row['task_id'] ?>"
                                        data-task-name="<?= htmlspecialchars($row['task_name']) ?>">
                                        <input type="hidden" name="taskID" value="<?= $row['task_id'] ?>">
                                        <button type="submit" class="btn btn-link text-danger p-0 delete-task-btn"
                                            title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>

                                    <form method="POST" action="../todolist/u-complete-task.php" style="display:inline;">
                                        <input type="hidden" name="taskID" value="<?= $row['task_id'] ?>">
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

        <?php if (isset($_SESSION['message'])): ?>
            <script>
                Swal.fire({
                    icon: <?= strpos($_SESSION['message'], 'successfully') !== false ? "'success'" : "'error'" ?>,
                    title: <?= strpos($_SESSION['message'], 'successfully') !== false ? "'Success!'" : "'Oops!'" ?>,
                    text: <?= json_encode($_SESSION['message']) ?>,
                    confirmButtonText: 'OK'
                });
            </script>
            <?php
            unset($_SESSION['message']);
        endif;
        ?>

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


        <?php
        // Reset result pointer and fetch rows again to generate modals
        mysqli_data_seek($result, 0);
        while ($row = mysqli_fetch_assoc($result)):
            ?>
            <div class="modal fade" id="editTaskModal<?= $row['task_id'] ?>" tabindex="-1"
                aria-labelledby="editTaskModalLabel<?= $row['task_id'] ?>" aria-hidden="true">
                <div class="modal-dialog">
                    <form method="POST" action="../todolist/u-edit-task.php">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editTaskModalLabel<?= $row['task_id'] ?>">Edit Task</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                                <input type="hidden" name="task_id" value="<?= $row['task_id'] ?>">

                                <div class="mb-3">
                                    <label for="editTaskName<?= $row['task_id'] ?>" class="form-label">Task Name</label>
                                    <input type="text" class="form-control" id="editTaskName<?= $row['task_id'] ?>"
                                        name="task_name" value="<?= htmlspecialchars($row['task_name']) ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label for="editTaskDetails<?= $row['task_id'] ?>" class="form-label">Task
                                        Details</label>
                                    <textarea class="form-control" id="editTaskDetails<?= $row['task_id'] ?>"
                                        name="task_details"><?= htmlspecialchars($row['task_details']) ?></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="editPriority<?= $row['task_id'] ?>" class="form-label">Priority
                                        Level</label>
                                    <select class="form-select" id="editPriority<?= $row['task_id'] ?>" name="priority"
                                        required>
                                        <?php foreach ($priorityLevels as $level): ?>
                                            <option value="<?= $level['priority_id'] ?>"
                                                <?= $level['level_name'] === $row['level_name'] ? 'selected' : '' ?>>
                                                <?= ucfirst($level['level_name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        <?php endwhile; ?>

        <?php if (isset($_GET['edit_success']) && $_GET['edit_success'] == 1): ?>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Task updated!',
                    text: 'Your task was edited successfully.',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                });
            </script>
        <?php endif; ?>


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
                    fetch('u-update-task.php', {
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

            }
        }

        document.addEventListener('DOMContentLoaded', function () {
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

        document.getElementById('timerButtons').style.display = 'block';


    </script>


    <style>
        .completed-task {
            text-decoration: line-through;
            color: darkred;
        }

        input[type="text"],
        textarea,
        select {
            background - color: #fff;
            color: #000;
            border: 2px solid #ccc;
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
            border - color: rgb(0, 255, 76);
            box-shadow: 0 0 8px rgb(107, 250, 88);
            outline: none;
        }
    </style>


</body>

</html>