<?php
include __DIR__ . '/../database/dbconn.php'; // More reliable path resolution

$current_page = basename($_SERVER['PHP_SELF']);
$current_page_without_query = strtok($current_page, '?');

// Actual count queries
$user_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM users"))['total'];
$pomodoro_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM pomodoro_session"))['total'];
$photocards_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM photocard_library"))['total'];
$quotes_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM quotes_library"))['total'];
$moods_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM mood_checkin"))['total'];
$todolist_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM to_do_list"))['total'];
$chatlogs_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM chat_logs"))['total'];
$report_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM report"))['total'];
$member_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM member"))['total'];

?>


<!-- menus-sidebar.php -->
<div class="offcanvas offcanvas-start custom-offcanvas" data-bs-scroll="true" tabindex="-1"
    id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
    <div class="offcanvas-header">
        <a href="../maindb/admindashboard.php" class="offcanvas-title" id="offcanvasWithBothOptionsLabel"
            style="text-decoration: none; color: black;"     title='Admin Main Dashboard'>
            
            Menu
        </a>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body">
        <div class="row row-cols-1 row-cols-md-1 g-3">
            <!-- Users Card -->
            <div class="col">
                <a href="../maindb/admin-users-page.php" class="card-link text-decoration-none <?php echo ($current_page_without_query == 'admin-users-page.php') ? 'active' : ''; ?>">
                    <div class="card equal-height">
                        <div class="card-body d-flex align-items-center">
                            <i class="fa-solid fa-user-astronaut fa-2x me-3"></i>
                            <div>
                                <h6 class="mb-0"><?php echo $user_count; ?></h6>
                                <small class="text-muted">Users</small>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Pomodoro Card -->
            <div class="col">
                <a href="../maindb/admin-pomodoro-page.php" class="card-link text-decoration-none <?php echo ($current_page_without_query == 'admin-pomodoro-page.php') ? 'active' : ''; ?>">
                    <div class="card equal-height">
                        <div class="card-body d-flex align-items-center">
                            <i class="fa-regular fa-clock fa-2x me-3"></i>
                            <div>
                                <h6 class="mb-0"><?php echo $pomodoro_count; ?></h6>
                                <small class="text-muted">Pomodoro</small>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Photocards Card -->
            <div class="col">
                <a href="../maindb/admin-photocards-page.php" class="card-link text-decoration-none <?php echo ($current_page_without_query == 'admin-photocards-page.php') ? 'active' : ''; ?>">
                    <div class="card equal-height">
                        <div class="card-body d-flex align-items-center">
                            <i class="fa-solid fa-id-card fa-2x me-3"></i>
                            <div>
                                <h6 class="mb-0"><?php echo $photocards_count; ?></h6>
                                <small class="text-muted">Photocards</small>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Quotes Card -->
            <div class="col">
                <a href="../maindb/admin-quotes-page.php" class="card-link text-decoration-none <?php echo ($current_page_without_query == 'admin-quotes-page.php') ? 'active' : ''; ?>">
                    <div class="card equal-height">
                        <div class="card-body d-flex align-items-center">
                            <i class="fa-regular fa-envelope fa-2x me-3"></i>
                            <div>
                                <h6 class="mb-0"><?php echo $quotes_count; ?></h6>
                                <small class="text-muted">Quotes</small>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Moods Card -->
            <div class="col">
                <a href="../maindb/admin-moods-page.php" class="card-link text-decoration-none <?php echo ($current_page_without_query == 'admin-moods-page.php') ? 'active' : ''; ?>">
                    <div class="card equal-height">
                        <div class="card-body d-flex align-items-center">
                            <i class="fa-regular fa-face-laugh-wink fa-2x me-3"></i>
                            <div>
                                <h6 class="mb-0"><?php echo $moods_count; ?></h6>
                                <small class="text-muted">Moods</small>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- To-Do List Card -->
            <div class="col">
                <a href="../maindb/admin-todolist-page.php" class="card-link text-decoration-none <?php echo ($current_page_without_query == 'admin-todolist-page.php') ? 'active' : ''; ?>">
                    <div class="card equal-height">
                        <div class="card-body d-flex align-items-center">
                            <i class="fa-solid fa-list-check fa-2x me-3"></i>
                            <div>
                                <h6 class="mb-0"><?php echo $todolist_count; ?></h6>
                                <small class="text-muted">To-Do List</small>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Chat Logs Card -->
            <div class="col">
                <a href="../maindb/admin-chatlogs-page.php" class="card-link text-decoration-none <?php echo ($current_page_without_query == 'admin-chatlogs-page.php') ? 'active' : ''; ?>">
                    <div class="card equal-height">
                        <div class="card-body d-flex align-items-center">
                            <i class="fa-solid fa-headset fa-2x me-3"></i>
                            <div>
                                <h6 class="mb-0"><?php echo $chatlogs_count; ?></h6>
                                <small class="text-muted">Chat Logs</small>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Report Card -->
            <div class="col">
                <a href="../maindb/admin-report-page.php" class="card-link text-decoration-none <?php echo ($current_page_without_query == 'admin-report-page.php') ? 'active' : ''; ?>">
                    <div class="card equal-height">
                        <div class="card-body d-flex align-items-center">
                            <i class="fa-regular fa-folder fa-2x me-3"></i>
                            <div>
                                <h6 class="mb-0"><?php echo $report_count; ?></h6>
                                <small class="text-muted">Report</small>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Mmeber Card -->
            <div class="col">
                <a href="../maindb/admin-member-page.php" class="card-link text-decoration-none <?php echo ($current_page_without_query == 'admin-member-page.php') ? 'active' : ''; ?>">
                    <div class="card equal-height">
                        <div class="card-body d-flex align-items-center">
                            <i class="fa-solid fa-user-secret fa-2x me-3"></i>
                            <div>
                                <h6 class="mb-0"><?php echo $member_count; ?></h6>
                                <small class="text-muted">Member</small>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Optional: Add CSS for active state -->
<style>
    .active {
        background-color: #007bff; /* Blue background for active item */
        color: white;
    }
</style>
