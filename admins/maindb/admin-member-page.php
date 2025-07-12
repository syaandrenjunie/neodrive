<?php
include("../../include/auth.php"); 

check_role('admin');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Main Dashboard</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    <header class="header-container">
        <div class="logo-title-container">
            <!-- Image will trigger the sidebar -->
            <img src="../../assets/image/clock.png" alt="Logo" class="timer-icon" data-bs-toggle="offcanvas"
            data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">            <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover" 
            href="#">Member Management Dashboard</a></div>
            <div class="header-buttons">
                    <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 
                        link-underline-opacity-75-hover" href="#">List</a>
                    <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 
                        link-underline-opacity-75-hover" href="../member/a-add-member.php">New</a>
                    <a href="adminprofile.php" class="profile-icon">
                        <i class="fa-solid fa-user-circle"></i>
                    </a>

            </div>
    </header><br><br>

    <?php include('../menus-sidebar.php'); ?>

    <div class="member-list">
        <div class="search-container">
            <form action="" method="GET">
                <div class="input-group">
                    <!-- Search Input -->
                    <input type="text" class="form-control" name="search" id="searchInput"
                        placeholder="Search members..."
                        value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>" aria-label="Search members">

                    <!-- Search Icon as Submit Button -->
                    <button type="submit" class="input-group-text btn btn-link" style="color: black">
                        <i class="fa fa-search"></i>
                    </button>

                    <!-- Clear Search Button -->
                    <a href="admin-member-page.php" class="btn btn-secondary input-group-text">Clear Search</a>
                </div>
            </form>

        </div>

        <table class="table table-striped table-hover mt-3">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Member Name</th>
                    <th>Subunit</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $searchTerm = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

                if (!empty($searchTerm)) {
                    $query = "SELECT m.* FROM member m 
                            WHERE m.member_name LIKE '%$searchTerm%' 
                            OR m.subunit LIKE '%$searchTerm%' 
                            OR m.member_type LIKE '%$searchTerm%' 
                            OR m.member_status LIKE '%$searchTerm%'
                            OR m.updated_at LIKE '%$searchTerm%'";

                    if (strtolower($searchTerm) === 'active' || strtolower($searchTerm) === 'inactive') {
                        $query .= " OR m.member_status = '$searchTerm'";
                    }

                    $query .= " ORDER BY m.subunit ASC";
                    } else {
                        $query = "SELECT m.* FROM member m ORDER BY m.updated_at DESC";
                    }

                $result = mysqli_query($conn, $query);
                $i = 1;


                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                            <td>" . $i++ . "</td>
                            <td>{$row['member_name']}</td>
                            <td>{$row['subunit']}</td>
                            <td>{$row['member_type']}</td>
                            <td>{$row['member_status']}</td>

                            <td>
                                <button class='btn btn-sm btn-primary view-member-btn' 
                                    data-bs-toggle='modal' 
                                    data-bs-target='#memberDetailModal' 
                                    data-member_name='{$row['member_name']}'
                                    data-subunit='{$row['subunit']}'
                                    data-member_type='{$row['member_type']}'
                                    data-member_status ='{$row['member_status']}'
                                    data-updated_at ='{$row['updated_at']}'
                                    title='View Member'>
                                    <i class='fa-solid fa-expand'></i>
                                </button>

                
                              <button class='btn btn-sm btn-warning edit-member-btn' 
                                    data-bs-toggle='modal' 
                                    data-bs-target='#editMemberModal' 
                                    data-member_id='{$row['member_id']}'
                                    data-member_name='{$row['member_name']}'
                                    data-member_type='{$row['member_type']}'
                                    title='Edit Member'>
                                    <i class='fa-solid fa-pencil text-white'></i>
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

        <!-- Member Detail Modal -->
        <div class="modal fade" id="memberDetailModal" tabindex="-1" aria-labelledby="memberDetailModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modal-member_name-title"></h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Subunit:</strong> <span id="modal-subunit"></span></p>
                        <p><strong>Updated At:</strong> <span id="modal-updated"></span></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Member Modal -->
        <div class="modal fade" id="editMemberModal" tabindex="-1" aria-labelledby="editMemberModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="editMemberModalLabel">Edit Member</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">
                        <form id="edit-member-form" action="../member/a-update-member.php" method="POST">

                            <!-- Member's Name Select -->
                            <div class="mb-3">
                                <label for="edit-member_name" class="form-label"><strong>Member's Name</strong></label>
                                <input type="text" class="form-control" id="edit-member_name" name="member_name" placeholder="Enter NCT member's name..." required>
                            </div>

                            
                            <!-- member Type -->
                            <div class="mb-3">
                                <label for="edit-member_type" class="form-label"><strong>Member's Type</strong></label>
                                <select class="form-select" id="edit-member_type" name="member_type" placeholder="Choose member's type"
                                    required>
                                    <option value="NCT">NCT</option>
                                    <option value="Other">Other</option>
                                    
                                </select>
                            </div>

                            <!-- Subunit (Wrapped in a container for toggling) -->
                            <div class="mb-3" id="edit-subunit-container">
                                <label for="edit-subunit" class="form-label"><strong>Subunit</strong></label>
                                <select class="form-select" id="edit-subunit" name="subunit" placeholder="Choose subunit">
                                    <option value="NCT Dream">NCT Dream</option>
                                    <option value="NCT 127">NCT 127</option>
                                    <option value="WayV">Wayv</option>
                                    <option value="NCT Wish">NCT Wish</option>
                                </select>
                            </div>
                           
                            <!-- Hidden ID -->
                            <input type="hidden" id="edit-member_id" name="member_id">

                            <!-- Modal Footer -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn custom-save-btn">Save Changes</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.view-member-btn').forEach(button => {
                button.addEventListener('click', function () {
                    document.getElementById('modal-member_name-title').textContent = this.dataset.member_name;
                    document.getElementById('modal-subunit').textContent = this.dataset.subunit;
                    document.getElementById('modal-updated').textContent = this.dataset.updated_at;

                });
            });

            // Get the image element that will trigger the sidebar
            const sidebarToggle = document.getElementById('sidebarToggle');

            // Add click event to trigger sidebar
            sidebarToggle.addEventListener('click', function () {
                const sidebar = new bootstrap.Offcanvas(document.getElementById('offcanvasWithBothOptions'));
                sidebar.show(); // Show the sidebar when the image is clicked
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.edit-member-btn').forEach(button => {
                button.addEventListener('click', function () {
            // Populate the modal fields with current member data
            document.getElementById('edit-member_id').value = this.dataset.member_id;
            document.getElementById('edit-member_name').value = this.dataset.member_name; 
            document.getElementById('edit-subunit').value = this.dataset.subunit;
            document.getElementById('edit-member_type').value = this.dataset.member_type;
            document.getElementById('edit-member_status').value = this.dataset.member_status;

            new bootstrap.Modal(document.getElementById('editMemberModal')).show();
            });
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            const memberTypeField = document.getElementById('edit-member_type');
            const subunitContainer = document.getElementById('edit-subunit-container');

            function toggleSubunit() {
                if (memberTypeField.value === 'NCT') {
                    subunitContainer.style.display = 'block';
                } else {
                    subunitContainer.style.display = 'none';
                }
            }

            // Initial toggle when modal is shown
            document.getElementById('editMemberModal').addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const memberType = button.getAttribute('data-member_type');

                if (memberType === 'NCT') {
                    memberTypeField.value = '1';
                } else {
                    memberTypeField.value = '2';
                }

                toggleSubunit();
            });

            // When user changes dropdown manually
            memberTypeField.addEventListener('change', toggleSubunit);
        });

        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.member-toggle').forEach(function (btn) {
            btn.addEventListener('click', function (e) {
                    e.preventDefault();
                    const url = this.getAttribute('data-url');
                    const action = this.getAttribute('data-action');

                    Swal.fire({
                        title: `Are you sure?`,
                        text: `Do you want to ${action} this member?`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: `Yes, ${action} it!`
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = url;
                        }
                    });
                });
            });
        });

        // Show SweetAlert if status=success in URL
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('status') === 'success') {
            Swal.fire({
                icon: 'success',
                title: 'Status Updated!',
                text: 'Member status changed successfully.',
                showConfirmButton: false,
                timer: 2000
            });

            // Remove status=success from URL (optional, to avoid repeat alert on refresh)
            window.history.replaceState({}, document.title, window.location.pathname);
        }
        
    </script>

    <?php if (isset($_SESSION['success'])): ?>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '<?php echo $_SESSION['success']; ?>',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                });
            </script>
    <?php unset($_SESSION['success']); endif; ?>

    
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

        .btn-primary.view-member-btn {
            background-color: rgb(217, 233, 71) !important;
            border-color: rgb(217, 233, 71) !important;
            color: white !important;
        }

        .btn-primary.view-pc-member:hover {
            background-color: rgb(240, 226, 40) !important;
            border-color: rgb(240, 226, 40) !important;
        }

        .btn-warning.edit-member-btn {
            background-color: rgb(245, 101, 120) !important;
            border-color: rgb(241, 141, 154) !important;
            color: white !important;
        }

        .btn-warning.edit-member-btn:hover {
            background-color: rgb(231, 66, 88) !important;
            border-color: rgb(231, 66, 88) !important;
            color: white !important;
        }

	.btn-warning.confirm-toggle-status {
                background-color: rgb(172, 236, 134) !important;
                border-color: rgb(172, 236, 134) !important;
                color: white !important;
            }

            .btn-success.confirm-toggle-status {
                background-color: rgb(231, 69, 69) !important;
                border-color: rgb(231, 69, 69) !important;
            }
        .custom-save-btn {
            padding: 8px 16px;
            font-size: 1rem;
            background-color: rgb(172, 236, 134);
            color: black;
            border: none;
            transition: background-color 0.3s ease;
        }

        .custom-save-btn:hover {
            background-color: rgb(98, 151, 55);
            color: white;
        }
    </style>
</body>
</html>
