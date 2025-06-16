<?php
include("../../include/auth.php");
check_role('admin');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Main Dashboard</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <header class="header-container">
        <div class="logo-title-container">
            <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 
        link-underline-opacity-75-hover" href="#">Admin Main Dashboard</a>
        </div>
        <div class="header-buttons">
            <a href="adminprofile.php" class="profile-icon">
                <i class="fa-solid fa-user-circle"></i>
            </a>
        </div>
    </header>

    <?php include('../menus-sidebar.php'); ?>

    <div class="main-content">
        <div class="container-fluid">

            <!-- 🔹 ROW 1: Mood Chart + Photocard Pie -->
            <div class="row">

                <!-- 🧾 Pomodoro Session Summary Cards -->
                <div class="d-flex flex-wrap justify-content-start gap-2 mb-4" id="pomodoroSummaryCards"></div>

                <!-- 🍩 Pomodoro Session Status Distribution -->
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header custom-header text-white">Pomodoro Session Status</div>
                        <div class="card-body">
                            <canvas id="pomodoroStatusChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- 📈 Task Completion Trend Over Time -->
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header custom-header text-white">Task Completion Trend</div>
                        <div class="card-body">
                            <canvas id="taskTrendChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 🔹 ROW 2: Task Completion Line + Quote Type Bar -->
            <div class="row">
                <!-- 😀 Mood Check-ins -->
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header custom-header text-white">Mood Check-ins</div>
                        <div class="card-body">
                            <canvas id="moodChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- 🖼️ Photocard Types Collected -->
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header custom-header text-white">Photocard Collection</div>
                        <div class="card-body">
                            <canvas id="photocardChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 🔹 ROW 3: Pomodoro Session Bar + Summary Cards -->
            <div class="row">
                <!-- 🧾 Pomodoro Sessions Completed per User -->
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header custom-header text-white">Pomodoro Sessions per User</div>
                        <div class="card-body">
                            <canvas id="pomodoroUserChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- 💬 Pinned Quote Types by Users -->
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header custom-header text-white">Pinned Quote Types</div>
                        <div class="card-body">
                            <canvas id="quoteTypeBarChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- JS Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // 📊 Mood Chart
            fetch('../chart/mood-chart.php')
                .then(res => res.json())
                .then(data => {
                    const moodColors = {
                        "Happy": "rgb(243, 121, 168)",       // mood-happy
                        "Sad": "rgb(121, 185, 96)",          // mood-sad
                        "Stressed": "rgb(207, 79, 100)",     // mood-stressed
                        "Relieved": "rgb(136, 202, 74)",     // mood-relieved
                        "Motivated": "rgb(92, 182, 57)",     // mood-motivated
                        "Scared": "rgb(179, 41, 87)"         // mood-scared
                    };

                    // Map each label to its corresponding color
                    const colors = data.labels.map(label => moodColors[label] || '#999');

                    new Chart(document.getElementById('moodChart'), {
                        type: 'bar',
                        data: {
                            labels: data.labels,
                            datasets: [{
                                label: 'Check-ins',
                                data: data.data,
                                backgroundColor: colors
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: { legend: { display: false } },
                            scales: {
                                x: { title: { display: true, text: 'Mood' } },
                                y: { beginAtZero: true, title: { display: true, text: 'Check-ins' } }
                            }
                        }
                    });
                });


            // 🖼️ Photocard Collection
            fetch('../chart/pc-chart.php')
                .then(res => res.json())
                .then(data => {
                    new Chart(document.getElementById('photocardChart'), {
                        type: 'pie',
                        data: {
                            labels: data.labels,
                            datasets: [{
                                data: data.data,
                                backgroundColor: ['#a0dc70', '#ff77a5', '#fdff75']
                            }]
                        }
                    });
                });

            // 📈 Task Completion Trend
            fetch('../chart/task-chart.php')
                .then(res => res.json())
                .then(data => {
                    new Chart(document.getElementById('taskTrendChart'), {
                        type: 'line',
                        data: {
                            labels: data.labels,
                            datasets: [{
                                label: 'Tasks Completed',
                                data: data.data,
                                borderColor: 'rgb(230, 116, 154)',
                                backgroundColor: 'rgb(219, 201, 213)',
                                fill: true,
                                tension: 0.4
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: { legend: { display: true } },
                            scales: {
                                x: { title: { display: true, text: 'Date' } },
                                y: { beginAtZero: true, title: { display: true, text: 'Completed Tasks' } }
                            }
                        }
                    });
                });

            // 💬 Pinned Quote Types
            fetch('../chart/user-quotes.php')
                .then(res => res.json())
                .then(data => {
                    new Chart(document.getElementById('quoteTypeBarChart'), {
                        type: 'bar',
                        data: {
                            labels: data.labels,
                            datasets: [{
                                label: 'Pinned Quotes',
                                data: data.data,
                                backgroundColor: '#a0dc70',
                                borderColor: '#73d128',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: { legend: { display: false } },
                            scales: {
                                x: { title: { display: true, text: 'Quote Type' } },
                                y: { beginAtZero: true, title: { display: true, text: 'Count' } }
                            }
                        }
                    });
                });

            // 🧾 Pomodoro Sessions by User
            fetch('../chart/pomodoro-user-chart.php')
                .then(res => res.json())
                .then(data => {
                    new Chart(document.getElementById('pomodoroUserChart'), {
                        type: 'bar',
                        data: {
                            labels: data.labels,
                            datasets: [{
                                label: 'Completed Sessions',
                                data: data.data,
                                backgroundColor: '#f8ff8c',

                            }]
                        },
                        options: {
                            indexAxis: 'y',
                            responsive: true,
                            plugins: { legend: { display: false } }
                        }
                    });
                });

            // Summary Cards - Pomodoro Completed Sessions
            fetch('../chart/pomodoro-user-summary.php')
                .then(res => res.json())
                .then(data => {
                    const container = document.getElementById('pomodoroSummaryCards');
                    container.innerHTML = '';
                    data.forEach(user => {
                        const cardBody = `
                <div class="p-3 rounded text-black" style="width: 18%; background-color: rgb(179, 228, 123);">
                <h6 class="mb-1">${user.username}</h6>
                <small class="text-muted">Completed Sessions: ${user.session_count}</small>
              </div>`;
                        container.innerHTML += cardBody;
                    });
                });

            // 🍩 Pomodoro Status Doughnut
            fetch('../chart/pomodoro-status.php')
                .then(res => res.json())
                .then(data => {
                    new Chart(document.getElementById('pomodoroStatusChart'), {
                        type: 'doughnut',
                        data: {
                            labels: data.labels,
                            datasets: [{
                                data: data.data,
                                backgroundColor: ['#a0dc70', '#fdff75', '#fb7985'],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: { legend: { position: 'bottom' } }
                        }
                    });
                });
        });
    </script>

    <style>
        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        .static-sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: rgb(243, 247, 237);
            padding: 20px 10px;
            overflow-y: auto;
            border-right: 1px solid #ddd;
            z-index: 1030;
        }

        .header-container {
            position: sticky;
            top: 0;
            left: 0;
            width: calc(100% - 250px);
            margin-left: 250px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1040;
        }

        .header-buttons {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            min-width: 80px;
        }

        .main-content {
            margin-left: 250px;
            margin-top: 60px;
            padding: 20px;
        }

        #photocardChart {
            width: 250px !important;
            height: 250px !important;
            margin: 0 auto;
        }

        #pomodoroStatusChart {
            width: 300px !important;
            height: 300px !important;
            margin: 0 auto;
        }

        .custom-header {
            background-color: rgb(255, 166, 200);
            color: white;
        }

        .main-content {
            margin-left: 250px;
            margin-top: 0; 
            padding: 20px;
            }

    </style>
</body>

</html>