<?php
include("../../include/auth.php");
include '../../database/dbconn.php';
check_role('admin');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Management Main Dashboard</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>
    <header class="header-container">
        <div class="logo-title-container">
            <img src="../../assets/image/clock.png" alt="Logo" class="timer-icon" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">
            <a class="link-offset-2 link-underline link-underline-opacity-0" href="#">Reports Management Dashboard</a>
        </div>
        <div class="header-buttons">
            <a class="link-underline link-underline-opacity-0" href="../report/a-create-report.php">New</a>
            <a class="link-underline link-underline-opacity-0" href="#">Lists</a>
            <a href="adminprofile.php" class="profile-icon">
                <i class="fa-solid fa-user-circle"></i>
            </a>
        </div>
    </header><br><br>

    <!-- Include Sidebar -->
    <?php include('../menus-sidebar.php'); ?>

    <div class="report-list">
        <div class="search-container mb-4">
            <form action="" method="GET">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" id="searchInput"
                        placeholder="Search reports..."
                        value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"
                        aria-label="Search reports">

                    <button type="submit" class="input-group-text btn btn-link" style="color: black">
                        <i class="fa fa-search"></i>
                    </button>

                    <a href="admin-report-page.php" class="btn btn-secondary input-group-text">Clear Search</a>
                </div>
            </form>
        </div>


        <table class="table table-striped table-hover mt-3">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Report Type</th>
                    <th>Status</th>
                    <th>Generated At</th>
                    <th>Parameters</th>
                    <th>File</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include '../../database/dbconn.php';

                $searchTerm = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

                $query = "SELECT * FROM report";

                if (!empty($searchTerm)) {
                    $query .= " WHERE report_type LIKE '%$searchTerm%' 
                        OR report_status LIKE '%$searchTerm%' 
                        OR generated_at LIKE '%$searchTerm%' 
                        OR parameters LIKE '%$searchTerm%'";
                }

                $query .= " ORDER BY generated_at DESC";

                $result = mysqli_query($conn, $query);
                $i = 1;

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                    <td>" . $i++ . "</td>
                    <td>{$row['report_type']}</td>
                    <td>{$row['report_status']}</td>
                    <td>{$row['generated_at']}</td>
                    <td class='text-wrap' style='max-width: 300px;'>" . htmlspecialchars($row['parameters']) . "</td>
                    <td><a class='btn btn-sm btn-outline-primary' href='{$row['report_filepath']}' target='_blank'>View PDF</a></td>
                    <td>
                        <!-- Update Button triggers modal -->
                            <button class='btn btn-sm btn-warning update-status-btn' 
                                data-bs-toggle='modal' 
                                data-bs-target='#statusModal' 
                                data-report-id='{$row['report_id']}' 
                                data-current-status='{$row['report_status']}' 
                                title='Update Status'>
                                <i class='fa-solid fa-rotate'></i>
                            </button>


                        <form method='POST' action='../report/a-delete-report.php' class='d-inline ms-2'>
                            <input type='hidden' name='report_id' value='{$row['report_id']}'>
                            <input type='hidden' name='filepath' value='{$row['report_filepath']}'>
                            <button type='submit' class='btn btn-sm btn-danger' onclick='return confirm('Delete this report?')' title='Delete Report'>
                                <i class='fa-solid fa-trash'></i>
                            </button>
                        </form>

                    </td>
                </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7' class='text-center'>No record found</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Status Update Modal -->
        <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered custom-modal-width">
                <div class="modal-content">
                    <form method="POST" action="../report/a-update-status.php">
                        <div class="modal-header">
                            <h5 class="modal-title" id="statusModalLabel">Update Report Status</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="report_id" id="modal-report-id">

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="new_status" id="statusActive"
                                    value="Active">
                                <label class="form-check-label" for="statusActive">
                                    Active
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="new_status" id="statusInactive"
                                    value="Inactive">
                                <label class="form-check-label" for="statusInactive">
                                    Inactive
                                </label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </div>
    <?php if (isset($_SESSION['success'])): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '<?php echo $_SESSION['success']; ?>',
                timer: 2000,
                showConfirmButton: false
            });
        </script>
    <?php unset($_SESSION['success']); endif; ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const sidebarToggle = document.getElementById('sidebarToggle');
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function () {
                const sidebar = new bootstrap.Offcanvas(document.getElementById('offcanvasWithBothOptions'));
                sidebar.show();
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            const statusModal = document.getElementById('statusModal');
            const reportIdInput = document.getElementById('modal-report-id');
            const activeRadio = document.getElementById('statusActive');
            const inactiveRadio = document.getElementById('statusInactive');

            document.querySelectorAll('.update-status-btn').forEach(button => {
                button.addEventListener('click', () => {
                    const reportId = button.getAttribute('data-report-id');
                    const currentStatus = button.getAttribute('data-current-status');

                    reportIdInput.value = reportId;
                    if (currentStatus === 'Active') {
                        activeRadio.checked = true;
                    } else if (currentStatus === 'Inactive') {
                        inactiveRadio.checked = true;
                    }
                });
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
            max-width: 100%;
        }

        .btn-warning.update-status-btn {
            background-color: rgb(217, 233, 71) !important;
            border-color: rgb(217, 233, 71) !important;
            color: white !important;
        }

        .btn-btn-warning.update-status-btnhover {
            background-color: rgb(240, 226, 40) !important;
            border-color: rgb(240, 226, 40) !important;
        }

        .btn-danger {
            background-color: rgb(245, 101, 120) !important;
            border-color: rgb(241, 141, 154) !important;
            color: white !important;
        }

        .btn-danger:hover {
            background-color: rgb(231, 66, 88) !important;
            border-color: rgb(231, 66, 88) !important;
            color: white !important;
        }

    </style>
</body>

</html>