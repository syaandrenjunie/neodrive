<?php
include("../../include/auth.php");
check_role('admin');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User's Photocard Entry Dashboard</title>
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
                href="#">User's Rewarded Photocard Management</a>
        </div>
        <div class="header-buttons">
            <a class="link-underline link-underline-opacity-0" href="#">Entry</a>
            <a class="link-underline link-underline-opacity-0" href="../maindb/admin-photocards-page.php">Lists</a>
            <a class="link-underline link-underline-opacity-0" href="../pc/a-add-pc.php">New</a>
            <a href="../maindb/adminprofile.php" class="profile-icon">
                <i class="fa-solid fa-user-circle"></i>
            </a>

        </div>
    </header><br><br>

    <?php include('../menus-sidebar.php'); ?>

    <div class="userpc-list">
        <div class="search-container">
            <form action="" method="GET">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" id="searchInput"
                        placeholder="Search user's photocard..."
                        value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>"
                        aria-label="Search user's photocard">

                    <button type="submit" class="input-group-text btn btn-link" style="color: black">
                        <i class="fa fa-search"></i>
                    </button>

                    <a href="a-user-pc.php" class="btn btn-secondary input-group-text">Clear Search</a>
                </div>
            </form>

        </div>
        <table class="table table-striped table-hover mt-3">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Username</th>
                    <th>Photocard Title</th>
                    <th>Member</th>
                    <th>Subunit</th>
                    <th>Type</th>
                    <th>Rewarded At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $searchTerm = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

                $query = "SELECT upc.*, u.username, pc.pc_title, pc.member_name, pc.subunit, pc.pc_type, pc.pc_filepath 
                          FROM user_pccollection upc
                          JOIN users u ON upc.user_id = u.user_id
                          JOIN photocard_library pc ON upc.pc_id = pc.pc_id";

                if (!empty($searchTerm)) {
                    $query .= " WHERE u.username LIKE '%$searchTerm%' 
                                OR pc.pc_title LIKE '%$searchTerm%' 
                                OR pc.member_name LIKE '%$searchTerm%' 
                                OR pc.subunit LIKE '%$searchTerm%' 
                                OR pc.pc_type LIKE '%$searchTerm%'";
                }

                $query .= " ORDER BY upc.rewarded_at DESC";

                $result = mysqli_query($conn, $query);
                $i = 1;

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                                <td>" . $i++ . "</td>
                                <td>{$row['username']}</td>
                                <td>{$row['pc_title']}</td>
                                <td>{$row['member_name']}</td>
                                <td>{$row['subunit']}</td>
                                <td>{$row['pc_type']}</td>
                                <td>{$row['rewarded_at']}</td>
                                <td>
                                    <button class='btn btn-sm btn-primary view-pc-btn'
                                        data-bs-toggle='modal'
                                        data-bs-target='#pcDetailModal'
                                        data-username='{$row['username']}'
                                        data-title='{$row['pc_title']}'
                                        data-member='{$row['member_name']}'
                                        data-subunit='{$row['subunit']}'
                                        data-type='{$row['pc_type']}'
                                        data-img='../../{$row['pc_filepath']}'
                                        data-rewarded='{$row['rewarded_at']}'>
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

        <!-- Modal -->
        <div class="modal fade" id="pcDetailModal" tabindex="-1" aria-labelledby="pcDetailModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content p-3">
                    <div class="modal-header">
                        <h5 class="modal-title">Photocard Details - <span id="pc-username"></span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body row">
                        <div class="col-md-6">
                            <p><strong>Title:</strong> <span id="pc-title"></span></p>
                            <p><strong>Member:</strong> <span id="pc-member"></span></p>
                            <p><strong>Subunit:</strong> <span id="pc-subunit"></span></p>
                            <p><strong>Type:</strong> <span id="pc-type"></span></p>
                            <p><strong>Rewarded At:</strong> <span id="pc-rewarded"></span></p>
                        </div>
                        <div class="col-md-6 text-center">
                            <img id="pc-image" src="" alt="Photocard" class="img-fluid rounded"
                                style="max-height: 250px;">
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.view-pc-btn').forEach(button => {
                button.addEventListener('click', function () {
                    document.getElementById('pc-username').textContent = this.dataset.username;
                    document.getElementById('pc-title').textContent = this.dataset.title;
                    document.getElementById('pc-member').textContent = this.dataset.member;
                    document.getElementById('pc-subunit').textContent = this.dataset.subunit;
                    document.getElementById('pc-type').textContent = this.dataset.type;
                    document.getElementById('pc-rewarded').textContent = this.dataset.rewarded;
                    document.getElementById('pc-image').src = this.dataset.img;
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

        .btn-primary.view-pc-btn {
            background-color:rgb(217, 233, 71) !important;
            border-color: rgb(217, 233, 71)  !important;
            color: white !important;
        }

        .btn-primary.view-pc-btn:hover {
            background-color:rgb(240, 226, 40) !important;
            border-color: rgb(240, 226, 40)  !important;
        }
    </style>
</body>
</ht>