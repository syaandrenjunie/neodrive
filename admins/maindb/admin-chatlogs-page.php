<?php
include("../../include/auth.php");
check_role('admin');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pomodoro Main Dashboard</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    <header class="header-container">
        <div class="logo-title-container">
            <img src="../../assets/image/clock.png" alt="Logo" class="timer-icon" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions"> <a
                class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover"
                href="#">Chat Logs Management Dashboard</a>
        </div>
        <div class="header-buttons">
            
            <a href="adminprofile.php" class="profile-icon">
                <i class="fa-solid fa-user-circle"></i>
            </a>

        </div>
    </header><br><br>

    <?php include('../menus-sidebar.php'); ?>

    <div class="chatlog-list">
        <div class="search-container">
            <form action="" method="GET">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" id="searchInput"
                        placeholder="Search chatlog..."
                        value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>"
                        aria-label="Search chatlog">

                    <button type="submit" class="input-group-text btn btn-link" style="color: black">
                        <i class="fa fa-search"></i>
                    </button>

                    <a href="admin-chatlogs-page.php" class="btn btn-secondary input-group-text">Clear Search</a>
                </div>
            </form>

        </div>
        <table class="table table-striped table-hover mt-3">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Username</th>
                    <th>Message</th>
                    <th>Response</th>
                    <th>Sent At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $searchTerm = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

                // Base query to get chat logs with usernames
                $query = "SELECT cl.*, u.username 
                        FROM chat_logs cl
                        JOIN users u ON cl.user_id = u.user_id";

                // Add search condition if search term is provided
                if (!empty($searchTerm)) {
                    $query .= " WHERE u.username LIKE '%$searchTerm%' 
                                OR cl.message LIKE '%$searchTerm%' 
                                OR cl.response LIKE '%$searchTerm%'";
                }

                $query .= " ORDER BY cl.sent_at DESC";
                $result = mysqli_query($conn, $query);

                $i = 1;

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                            <td>" . $i++ . "</td>
                            <td class='text-wrap' style='max-width: 300px;'>{$row['username']}</td>
                            <td class='text-wrap' style='max-width: 300px;'>{$row['message']}</td>
                            <td class='text-wrap' style='max-width: 300px;'>{$row['response']}</td>
                            <td>{$row['sent_at']}</td>
                            <td>
                                <button class='btn btn-sm btn-primary view-chatlog-btn'
                                    data-bs-toggle='modal'
                                    data-bs-target='#chatLogDetailModal'
                                    data-username='{$row['username']}'
                                    data-message='" . htmlspecialchars($row['message'], ENT_QUOTES) . "'
                                    data-response='" . htmlspecialchars($row['response'], ENT_QUOTES) . "'
                                    data-sent_at='{$row['sent_at']}'
                                    title='View Chat Log'>
                                            <i class='fa-solid fa-expand'></i>
                                </button>
                            </td>
                        </tr>";


                    }
                } else {
                    echo "<tr><td colspan='9' style='text-align: center;'>No record found</td></tr>";
                }

                ?>
            </tbody>
        </table>

        <div class="modal fade" id="chatLogDetailModal" tabindex="-1" aria-labelledby="chatLogDetailModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Chat Log Details - <span id="chatlog-username"></span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Message:</strong> <span id="chatlog-message"></span></p>
                        <p><strong>Response:</strong> <span id="chatlog-response"></span></p>
                        <p><strong>Sent At:</strong> <span id="chatlog-sent_at"></span></p>
                    </div>
                </div>
            </div>
        </div>


    </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.view-chatlog-btn').forEach(button => {
                button.addEventListener('click', function () {
                    document.getElementById('chatlog-username').textContent = this.dataset.username;
                    document.getElementById('chatlog-message').textContent = this.dataset.message;
                    document.getElementById('chatlog-response').textContent = this.dataset.response;
                    document.getElementById('chatlog-sent_at').textContent = this.dataset.sent_at;
                });
            });

            const sidebarToggle = document.getElementById('sidebarToggle');

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
        }

        .search-form {
            width: 800px;
            max-width: 600px;
        }

        .modal-lg {
            max-width: 60%;
        }
    </style>
</body>
</ht>