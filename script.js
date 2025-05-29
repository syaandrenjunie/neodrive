let totalRounds, roundTime, breakTime, currentRound = 1, isRunning = false, isBreak = false, timeLeft, interval;
let isPaused = false; // Track pause state

function saveTimerSettings() {
    totalRounds = parseInt(document.getElementById('rounds').value);
    roundTime = parseInt(document.getElementById('roundTime').value) * 60;
    breakTime = parseInt(document.getElementById('breakTime').value) * 60;

    timeLeft = roundTime;
    updateTimerDisplay(timeLeft);

    // Update round info and enable buttons
    document.getElementById('roundInfo').innerText = `Set for ${totalRounds} rounds, ${roundTime / 60} min per round, ${breakTime / 60} min break.`;
    document.getElementById('startRoundBtn').disabled = false;
    document.getElementById('startBreakBtn').disabled = true;
    document.getElementById('pauseBtn').disabled = true;
    document.getElementById('timerButtons').style.display = 'block';

    // Hide modal
    let modal = bootstrap.Modal.getInstance(document.getElementById('timerModal'));
    modal.hide();

    // Send to database
fetch('users/pomodoro/u-save-timer.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `total_rounds=${totalRounds}&round_duration=${roundTime}&break_duration=${breakTime}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'New Pomodoro session is ready!',
                showConfirmButton: false,
                timer: 1800
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error saving session',
                text: data.error
            });
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Connection error',
            text: error
        });
    });
}


function startRound() {
    if (isRunning) return;
    isRunning = true;
    isBreak = false;
    isPaused = false;
    timeLeft = timeLeft || roundTime; // Continue from paused time
    document.getElementById('pauseBtn').disabled = false; // Enable pause button
    countdown();
}

function startBreak() {
    if (isRunning) return;
    isRunning = true;
    isBreak = true;
    isPaused = false;
    timeLeft = timeLeft || breakTime; // Continue from paused time
    document.getElementById('pauseBtn').disabled = false; // Enable pause button
    countdown();
}

function pauseTimer() {
    if (!isRunning) return;

    if (!isPaused) {
        clearInterval(interval);
        isPaused = true;
        document.getElementById('pauseBtn').innerText = "Resume";
    } else {
        isPaused = false;
        document.getElementById('pauseBtn').innerText = "Pause";
        countdown(); // Resume countdown
    }
}

function countdown() {
    clearInterval(interval);
    interval = setInterval(() => {
        if (!isPaused) { // Only update timer when not paused
            if (timeLeft > 0) {
                timeLeft--;
                updateTimerDisplay(timeLeft);
            } else {
                clearInterval(interval);
                isRunning = false;
                document.getElementById('pauseBtn').disabled = true; // Disable pause button
                document.getElementById('pauseBtn').innerText = "Pause"; // Reset pause text
                isPaused = false;

                if (isBreak) {
                    alert("Break over! Click 'Start Round' to continue.");
                } else {
                    alert(`Round ${currentRound} complete! Click 'Start Break' for a break.`);
                    if (currentRound < totalRounds) {
                        currentRound++;
                        document.getElementById('roundInfo').innerText = `Round ${currentRound} of ${totalRounds}`;
                        document.getElementById('startBreakBtn').disabled = false;
                    } else {
                        document.getElementById('roundInfo').innerText = "All rounds completed!";
                    }
                }
            }
        }
    }, 1000);
}

function updateTimerDisplay(time) {
    let minutes = Math.floor(time / 60);
    let seconds = time % 60;
    document.getElementById('timer').innerText = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
}

function resetTimer() {
    clearInterval(interval);
    isRunning = false;
    isPaused = false;
    currentRound = 1;
    timeLeft = roundTime;
    document.getElementById('roundInfo').innerText = "";
    document.getElementById('timer').innerText = "00:00";
    document.getElementById('startRoundBtn').disabled = false;
    document.getElementById('startBreakBtn').disabled = true;
    document.getElementById('pauseBtn').disabled = true;
    document.getElementById('pauseBtn').innerText = "Pause"; // Reset pause text
}


let currentEditTask = null;

// Convert priority value (from select input) to priority_id in DB
function getPriorityId(priority) {
    switch(priority) {
        case "1": return 1; // Low
        case "2": return 2; // Medium
        case "3": return 3; // High
        default: return 1;
    }
}

function addTask() {
    let name = document.getElementById("taskName").value;
    let details = document.getElementById("taskDetails").value;
    let priority = document.getElementById("priority").value;

    if (!name) return;

    // Get the priority_id from the function
    let priority_id = getPriorityId(priority);

    // Send to database
    fetch('../../todolist/u-add-task.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            task_name: name,
            task_details: details,
            priority_id: priority_id
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Get the task ID from the response
            const taskId = data.task_id;
    
            // Show success SweetAlert
            Swal.fire({
                title: 'Success!',
                text: 'Task has been added.',
                icon: 'success',
                confirmButtonText: 'OK'
            });
    
            // Add task visually
            let taskDiv = document.createElement("div");
            taskDiv.classList.add("task");
            taskDiv.innerHTML = `
                <span class="task-name" onclick="toggleDetails(this)">${name} (${priority})</span>
                <div class="task-details" style="display: block;">${details}</div>
                <div class="buttons">
                    <button class="btn btn-warning btn-sm" onclick="openEditModal(this)">Edit</button>
                    <button class="btn btn-danger btn-sm" onclick="deleteTask(this)">Delete</button>
                    <input type="checkbox" data-task-id="${taskId}" onclick="markCompleted(this)">
                </div>
            `;
            document.getElementById("taskList").appendChild(taskDiv);
    
            // Clear inputs
            document.getElementById("taskName").value = "";
            document.getElementById("taskDetails").value = "";
        } else {
            Swal.fire({
                title: 'Error!',
                text: data.error || 'Failed to add task.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            title: 'Error!',
            text: 'Something went wrong.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    });
}


function toggleDetails(element) {
    let details = element.nextElementSibling;
    details.style.display = details.style.display === "none" ? "block" : "none";
}

function openEditModal(button) {
    currentEditTask = button.parentElement.parentElement;
    let taskName = currentEditTask.querySelector(".task-name").textContent.split(" (")[0];
    let details = currentEditTask.querySelector(".task-details").textContent; 
    let priority = currentEditTask.querySelector(".task-name").textContent.match(/\((.*?)\)/)[1];
    
    document.getElementById("editTaskName").value = taskName;
    document.getElementById("editTaskDetails").value = details;
    document.getElementById("editPriority").value = priority;
    
    new bootstrap.Modal(document.getElementById("editModal")).show();
}

function saveTaskEdit() {
    if (!currentEditTask) return;
    
    let newName = document.getElementById("editTaskName").value;
    let newDetails = document.getElementById("editTaskDetails").value;
    let newPriority = document.getElementById("editPriority").value;

    currentEditTask.querySelector(".task-name").textContent = `${newName} (${newPriority})`;
    currentEditTask.querySelector(".task-details").textContent = newDetails; 

    bootstrap.Modal.getInstance(document.getElementById("editModal")).hide();
}

if (window.location.search.includes('edit_success=1')) {
        const url = new URL(window.location);
        url.searchParams.delete('edit_success');
        window.history.replaceState({}, document.title, url);
    }
    
document.addEventListener('DOMContentLoaded', function () {
    // Select all delete forms
    const deleteForms = document.querySelectorAll('.delete-task-form');

    deleteForms.forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault(); // Stop immediate submission

            const taskId = form.getAttribute('data-task-id');
            const taskName = form.getAttribute('data-task-name');

            Swal.fire({
                title: `Are you sure you want to delete this task "${taskName}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it',
                cancelButtonText: 'No, cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Are you absolutely sure?',
                        text: "You won't be able to undo this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, delete permanently',
                        cancelButtonText: 'No, keep it',
                    }).then((secondResult) => {
                        if (secondResult.isConfirmed) {
                            form.submit(); // submit form for real now
                        }
                    });
                }
            });
        });
    });
});



function markCompleted(checkbox) {
    let taskDiv = checkbox.parentElement.parentElement;
    taskDiv.classList.toggle("completed", checkbox.checked);

    let taskId = checkbox.getAttribute("data-task-id");
    let isCompleted = checkbox.checked ? 1 : 0;

    fetch('../../todolist/u-complete-task.php', {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `task_id=${taskId}&is_completed=${isCompleted}`
    })
    .then(response => response.text())
    .then(data => {
        console.log("Server response:", data);
        if (isCompleted === 1) {
            Swal.fire({
                title: "🎉 Congrats!",
                text: "You've completed a task!",
                icon: "success",
                confirmButtonText: "Nice!"
            });
        }
    })
    .catch(error => {
        console.error("Error updating task status:", error);
    });
}
