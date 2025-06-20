<?php
include("../../include/auth.php");

check_role('admin');

include '../../database/dbconn.php';

// Fetch all members with member_type 'NCT'
$membersQuery = "SELECT member_name FROM member WHERE member_type = 'NCT' ORDER BY member_name ASC";
$membersResult = mysqli_query($conn, $membersQuery);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Photocards Management Main Dashboard</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    <header class="header-container">
        <div class="logo-title-container">
            <img src="../../assets/image/clock.png" alt="Logo" class="timer-icon" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">
            <a class="link-underline link-underline-opacity-0" href="#">Photocards Management Dashboard</a>
        </div>
        <div class="header-buttons">
            <a class="link-underline link-underline-opacity-0" href="../pc/a-user-pc.php">Entry</a>
            <a class="link-underline link-underline-opacity-0" href="#">Lists</a>
            <a class="link-underline link-underline-opacity-0" href="../pc/a-add-pc.php">New</a>
            <a href="adminprofile.php" class="profile-icon">
                <i class="fa-solid fa-user-circle"></i>
            </a>
        </div>
    </header><br><br>

    <?php include('../menus-sidebar.php'); ?>

    <div class="pc-list">
        <div class="search-container">
            <form action="" method="GET">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" id="searchInput"
                        placeholder="Search photocards..."
                        value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>"
                        aria-label="Search photocards">

                    <button type="submit" class="input-group-text btn btn-link" style="color: black">
                        <i class="fa fa-search"></i>
                    </button>

                    <a href="admin-photocards-page.php" class="btn btn-secondary input-group-text">Clear Search</a>
                </div>
            </form>

        </div>

        <table class="table table-striped table-hover mt-3">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Member Name</th>
                    <th>Subunit</th>
                    <th>PC Type</th>
                    <th>PC Title</th>
                    <th>Status</th>
                    <th>Updated At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include '../../database/dbconn.php';
                $searchTerm = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

                if (!empty($searchTerm)) {
                    $query = "SELECT * FROM photocard_library 
                                WHERE pc_title LIKE '%$searchTerm%' 
                                OR member_name LIKE '%$searchTerm%' 
                                OR subunit LIKE '%$searchTerm%' 
                                OR pc_type LIKE '%$searchTerm%' 
                                OR pc_status LIKE '%$searchTerm%' 
                                OR created_at LIKE '%$searchTerm%' 
                                OR updated_at LIKE '%$searchTerm%'";

                    if (strtolower($searchTerm) === 'Active' || strtolower($searchTerm) === 'Inactive') {
                        $query .= " OR pc_status = '$searchTerm'";
                    }

                    $query .= " ORDER BY updated_at DESC";
                } else {
                    $query = "SELECT * FROM photocard_library ORDER BY updated_at DESC";
                }

                $result = mysqli_query($conn, $query);
                $i = 1;


                // If there are results, loop through and display them
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                            <td>" . $i++ . "</td>
                            <td class='text-wrap' style='max-width: 300px;'>{$row['member_name']}</td>
                            <td>{$row['subunit']}</td>
                            <td>{$row['pc_type']}</td>
                            <td>{$row['pc_title']}</td>
                            <td>{$row['pc_status']}</td>
                            <td>{$row['updated_at']}</td>
                            <td>
                                <!-- View Button -->
                                <button class='btn btn-sm btn-primary view-pc-btn' 
                                    data-bs-toggle='modal' 
                                    data-bs-target='#pcDetailModal' 
                                    data-member_name='{$row['member_name']}'
                                    data-pc_filepath='{$row['pc_filepath']}'
                                    data-subunit='{$row['subunit']}'
                                    data-pc_type='{$row['pc_type']}'
                                    data-pc_title='{$row['pc_title']}'
                                    data-pc_status ='{$row['pc_status']}'
                                    data-created_at='{$row['created_at']}'
                                    data-updated_at='{$row['updated_at']}'
                                    title='View Photocards'>
                                    <i class='fa-solid fa-expand'></i>
                                </button>
                                <!-- Edit Button -->
                                <button class='btn btn-sm btn-warning edit-pc-btn' 
                                    data-bs-toggle='modal' 
                                    data-bs-target='#pcEditModal' 
                                    data-pc_id='{$row['pc_id']}'
                                    data-pc_filepath='{$row['pc_filepath']}'
                                    data-member_name='{$row['member_name']}'
                                    data-subunit='{$row['subunit']}'
                                    data-pc_type='{$row['pc_type']}'
                                    data-pc_title='{$row['pc_title']}'
                                    data-pc_status='{$row['pc_status']}'
                                    title='Edit Photocards'>
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

        <!-- PC Detail Modal -->
        <div class="modal fade" id="pcDetailModal" tabindex="-1" aria-labelledby="pcDetailModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modal-member_name-title"></h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex justify-content-center mb-3">
                            <img id="modal-pc_image" src="" alt="Photocard Image" class="img-fluid rounded"
                                style="max-height: 200px;">
                        </div>
                        <p><strong>Subunit:</strong> <span id="modal-subunit"></span></p>
                        <p><strong>PC Type:</strong> <span id="modal-pc_type"></span></p>
                        <p><strong>PC Title:</strong> <span id="modal-pc_title"></span></p>
                        <p><strong>PC Status:</strong> <span id="modal-pc_status"></span></p>
                        <p><strong>Created At:</strong> <span id="modal-created_at"></span></p>
                        <p><strong>Updated At:</strong> <span id="modal-updated_at"></span></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit PC Modal -->
        <div class="modal fade" id="pcEditModal" tabindex="-1" aria-labelledby="pcEditModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="pcEditModalLabel">Edit Photocards</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">
                        <form action="../pc/a-update-pc.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="pc_id" id="edit-pc_id" value="">
                            <input type="hidden" name="current_pc_filepath" id="current_pc_filepath" value="">

                            <!-- Show current photocard image -->
                            <div class="d-flex justify-content-center mb-3">
                                <img id="edit-pc_image_preview" src="" alt="Photocard Image" class="img-fluid rounded"
                                    style="max-height: 200px;">
                            </div>

                            <!-- File input to change image -->
                            <div class="mb-3">
                                <label for="edit-pc_filepath" class="form-label"><strong>Photocard
                                        Image</strong></label>
                                <input type="file" class="form-control" id="edit-pc_filepath" name="pc_filepath">
                                <small class="form-text text-muted">Leave empty to keep existing image.</small>
                            </div>


                            <!-- Member's Name Select -->
                            <div class="mb-3">
                                <label for="edit-member_name" class="form-label"><strong>Member's Name</strong></label>
                                <select class="form-select" id="edit-member_name" name="member_name"
                                    onchange="toggleOtherInput()" required>
                                    <option value="" disabled selected>Choose NCT member...</option>
                                    <?php
                                    if ($membersResult && mysqli_num_rows($membersResult) > 0) {
                                        while ($member = mysqli_fetch_assoc($membersResult)) {
                                            // Use htmlspecialchars to avoid XSS issues
                                            $name = htmlspecialchars($member['member_name']);
                                            echo "<option value=\"$name\">$name</option>";
                                        }
                                    } else {
                                        echo "<option disabled>No NCT members found</option>";
                                    }
                                    ?>
                                </select>

                            </div>

                            <!-- PC Type -->
                            <div class="mb-3">
                                <label for="edit-subunit" class="form-label"><strong>Subunit</strong></label>
                                <select class="form-select" id="edit-subunit" name="subunit"
                                    placeholder="Choose subunit" required>
                                    <option value="" disabled selected>Choose subunit..</option>
                                    <option value="NCT">NCT</option>
                                    <option value="NCT127">NCT 127</option>
                                    <option value="NCTDREAM">NCT Dream</option>
                                    <option value="NCTWISH">NCT Wish</option>
                                    <option value="WAYV">WayV</option>

                                </select>
                            </div>

                            <!-- PC Type -->
                            <div class="mb-3">
                                <label for="edit-pc_type" class="form-label"><strong>PC Type</strong></label>
                                <select class="form-select" id="edit-pc_type" name="pc_type"
                                    placeholder="Choose PC type" required>
                                    <option value="" disabled selected>Choose PC type...</option>
                                    <option value="1">Common</option>
                                    <option value="2">Rare</option>
                                    <option value="3">Exclusive</option>
                                </select>
                            </div>

                            <!-- PC TitleText -->
                            <div class="mb-3">
                                <label for="edit-pc_title" class="form-label"><strong>PC Title</strong></label>
                                <input type="text" class="form-control" id="edit-pc_title" name="pc_title" required>
                            </div>

                            <!-- Status -->
                            <div class="mb-3">
                                <label for="edit-pc_status" class="form-label"><strong>Status</strong></label>
                                <select class="form-control" id="edit-pc_status" name="pc_status" required>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>

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

    <?php
    if (isset($_SESSION['swal'])) {
        $swal = $_SESSION['swal'];
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
            Swal.fire({
                icon: '{$swal['type']}',
                title: '{$swal['title']}',
                text: '{$swal['text']}'
            });
        </script>";
        unset($_SESSION['swal']);
    }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const sidebarToggle = document.getElementById('sidebarToggle');

            sidebarToggle.addEventListener('click', function () {
                const sidebar = new bootstrap.Offcanvas(document.getElementById('offcanvasWithBothOptions'));
                sidebar.show();
            });

        });

        document.addEventListener('DOMContentLoaded', function () {
            const editButtons = document.querySelectorAll('.edit-pc-btn');

            editButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const pcId = this.getAttribute('data-pc_id');
                    const pcFilePath = this.getAttribute('data-pc_filepath');
                    const memberName = this.getAttribute('data-member_name');
                    const subunit = this.getAttribute('data-subunit');
                    const pcType = this.getAttribute('data-pc_type');
                    const pcTitle = this.getAttribute('data-pc_title');
                    const pcStatus = this.getAttribute('data-pc_status');

                    // Populate input fields
                    document.getElementById('edit-pc_id').value = pcId;
                    document.getElementById('current_pc_filepath').value = pcFilePath;
                    document.getElementById('edit-pc_title').value = pcTitle;
                    document.getElementById('edit-member_name').value = memberName;
                    document.getElementById('edit-subunit').value = subunit;
                    document.getElementById('edit-pc_type').value = pcType;
                    document.getElementById('edit-pc_status').value = pcStatus;

                    // Show the photocard image
                    const imgElement = document.getElementById('edit-pc_image_preview');
                    if (pcFilePath) {
                        imgElement.src = "../../" + pcFilePath;
                        imgElement.style.display = 'block';
                    } else {
                        imgElement.style.display = 'none';
                    }
                });
            });
        });

        document.querySelectorAll('.edit-pc-btn').forEach(button => {
            button.addEventListener('click', function () {
                // ... other fields ...
                document.getElementById('current_pc_filepath').value = this.getAttribute('data-pc_filepath');
            });
        });

        //VIEW Modal
        document.addEventListener('DOMContentLoaded', function () {
            const viewButtons = document.querySelectorAll('.view-pc-btn');

            viewButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const memberName = this.getAttribute('data-member_name');
                    const pcFilepath = this.getAttribute('data-pc_filepath');
                    const subunit = this.getAttribute('data-subunit');
                    const pcType = this.getAttribute('data-pc_type');
                    const pcTitle = this.getAttribute('data-pc_title');
                    const pcStatus = this.getAttribute('data-pc_status');
                    const createdAt = this.getAttribute('data-created_at');
                    const updatedAt = this.getAttribute('data-updated_at');

                    // Set the modal content
                    document.getElementById('modal-member_name-title').textContent = memberName;
                    document.getElementById('modal-subunit').textContent = subunit;
                    document.getElementById('modal-pc_type').textContent = pcType;
                    document.getElementById('modal-pc_title').textContent = pcTitle;
                    document.getElementById('modal-pc_status').textContent = pcStatus;
                    document.getElementById('modal-created_at').textContent = createdAt;
                    document.getElementById('modal-updated_at').textContent = updatedAt;

                    // Update the image preview if the file path exists
                    const imageElement = document.getElementById('modal-pc_image');
                    if (pcFilepath) {
                        imageElement.src = `../../${pcFilepath}`;
                        imageElement.style.display = 'block'; // Ensure image is shown
                    } else {
                        imageElement.style.display = 'none'; // Hide image if there's no path
                    }
                });
            });
        });

        const urlParams = new URLSearchParams(window.location.search);
        const status = urlParams.get('status');

        if (status === 'success') {
            Swal.fire({
                icon: 'success',
                title: '✅ Photocard updated!',
                text: 'Everything went smoothly 🎉',
                showConfirmButton: false,
                timer: 1800
            });
        } else if (status === 'error') {
            Swal.fire({
                icon: 'error',
                title: '❌ Update failed!',
                text: 'Something went wrong. Please try again 😔'
            });
        } else if (status === 'invalid_image') {
            Swal.fire({
                icon: 'warning',
                title: '⚠️ Invalid Image',
                text: 'Please upload a valid image (jpg, jpeg, png, webp, < 5MB) 📷'
            });
        } else if (status === 'upload_fail') {
            Swal.fire({
                icon: 'error',
                title: '🚫 Upload Failed',
                text: 'There was an error uploading the image 😓'
            });
        }

        // Clean the URL without reloading
        if (status) {
            window.history.replaceState({}, document.title, window.location.pathname);
        }

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
            max-width: 50%;
        }

        .btn-primary.view-pc-btn {
            background-color: rgb(217, 233, 71) !important;
            border-color: rgb(217, 233, 71) !important;
            color: white !important;
        }

        .btn-primary.view-pc-btn:hover {
            background-color: rgb(240, 226, 40) !important;
            border-color: rgb(240, 226, 40) !important;
        }

        .btn-warning.edit-pc-btn {
            background-color: rgb(245, 101, 120) !important;
            border-color: rgb(241, 141, 154) !important;
            color: white !important;
        }

        .btn-warning.edit-pc-btn:hover {
            background-color: rgb(231, 66, 88) !important;
            border-color: rgb(231, 66, 88) !important;
            color: white !important;
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