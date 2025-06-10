<?php
include __DIR__ . '/../database/dbconn.php';

$current_page = basename($_SERVER['PHP_SELF']);
$current_page_without_query = strtok($current_page, '?');
$static_sidebar = ($current_page === 'admindashboard.php');

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
<div class="<?php echo $static_sidebar ? 'static-sidebar' : 'offcanvas offcanvas-start custom-offcanvas'; ?>"
     <?php if (!$static_sidebar): ?>
         data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel"
     <?php endif; ?>>
    
    <div class="offcanvas-header">
        <a href="../maindb/admindashboard.php" class="offcanvas-title" id="offcanvasWithBothOptionsLabel"
           style="text-decoration: none; color: black;" title="Admin Main Dashboard">
            Menu
        </a>
        <?php if (!$static_sidebar): ?>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        <?php endif; ?>
    </div>

    <div class="offcanvas-body">
        <div class="row row-cols-1 row-cols-md-1 g-3">

            <!-- Sidebar Items Below -->
            <?php
            $sidebar_items = [
                ['href' => 'admin-users-page.php', 'icon' => 'fa-user-astronaut', 'label' => 'Users', 'count' => $user_count],
                ['href' => 'admin-pomodoro-page.php', 'icon' => 'fa-clock', 'label' => 'Pomodoro', 'count' => $pomodoro_count],
                ['href' => 'admin-photocards-page.php', 'icon' => 'fa-id-card', 'label' => 'Photocards', 'count' => $photocards_count],
                ['href' => 'admin-quotes-page.php', 'icon' => 'fa-envelope', 'label' => 'Quotes', 'count' => $quotes_count],
                ['href' => 'admin-moods-page.php', 'icon' => 'fa-face-laugh-wink', 'label' => 'Moods', 'count' => $moods_count],
                ['href' => 'admin-todolist-page.php', 'icon' => 'fa-list-check', 'label' => 'To-Do List', 'count' => $todolist_count],
                ['href' => 'admin-chatlogs-page.php', 'icon' => 'fa-headset', 'label' => 'Chat Logs', 'count' => $chatlogs_count],
                ['href' => 'admin-report-page.php', 'icon' => 'fa-folder', 'label' => 'Report', 'count' => $report_count],
                ['href' => 'admin-member-page.php', 'icon' => 'fa-user-secret', 'label' => 'Member', 'count' => $member_count],
            ];

            foreach ($sidebar_items as $item):
                $is_active = ($current_page_without_query === $item['href']) ? 'active' : '';
            ?>
                <div class="col">
                    <a href="../maindb/<?php echo $item['href']; ?>" class="card-link text-decoration-none <?php echo $is_active; ?>">
                        <div class="card equal-height">
                            <div class="card-body d-flex align-items-center">
                                <i class="fa-solid <?php echo $item['icon']; ?> fa-2x me-3"></i>
                                <div>
                                    <h6 class="mb-0"><?php echo $item['count']; ?></h6>
                                    <small class="text-muted"><?php echo $item['label']; ?></small>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Styles -->
<style>
    .active {
        background-color: #007bff;
        color: white;
    }

    .static-sidebar {
        width: 300px;
        position: fixed;
        height: 100vh;
        background: #f8f9fa;
        padding: 1rem;
        overflow-y: auto;
        z-index: 1030; /* same as Bootstrap's offcanvas */
        border-right: 1px solid #dee2e6;
    }
</style>
