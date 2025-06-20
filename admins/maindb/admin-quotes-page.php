<?php
include("../../include/auth.php"); 

check_role('admin');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quotes Management Dashboard</title>
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
            <a class="link-underline link-underline-opacity-0" href="#">Quotes Management Dashboard</a>
        </div>
        <div class="header-buttons">
            <a class="link-underline link-underline-opacity-0" href="#">Lists</a>
            <a class="link-underline link-underline-opacity-0" href="../quotes/a-add-quotes.php">New</a>
            <a href="adminprofile.php" class="profile-icon">
                <i class="fa-solid fa-user-circle"></i>
            </a>
        </div>
    </header><br><br>

    <!-- Include Sidebar -->
    <?php include('../menus-sidebar.php'); ?>
    <?php
    // Check if status parameter is set in the URL
    if (isset($_GET['status'])) {
        $status = $_GET['status'];
        if ($status == 'success') {
            echo "
                <script>
                    Swal.fire({
                        title: 'Success!',
                        text: 'The quote has been updated successfully.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                </script>
            ";
        } elseif ($status == 'error') {
            echo "
                <script>
                    Swal.fire({
                        title: 'Error!',
                        text: 'There was an error updating the quote.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                </script>
            ";
        }
    }
    ?>

    <div class="quotes-list">
        <div class="search-container">
            <form action="" method="GET">
                <div class="input-group">
                    <!-- Search Input -->
                    <input type="text" class="form-control" name="search" id="searchInput"
                        placeholder="Search quotes..."
                        value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>" aria-label="Search quotes">

                    <!-- Search Icon as Submit Button -->
                    <button type="submit" class="input-group-text btn btn-link" style="color: black">
                        <i class="fa fa-search"></i>
                    </button>

                    <!-- Clear Search Button -->
                    <a href="admin-quotes-page.php" class="btn btn-secondary input-group-text">Clear Search</a>
                </div>
            </form>

        </div>

        <table class="table table-striped table-hover mt-3">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Quotes Text</th>
                    <th>Member Name</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Updated At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $searchTerm = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

                // Base query
                $query = "SELECT q.*, m.member_name FROM quotes_library q 
                        JOIN member m ON q.member_id = m.member_id";

                // Apply search term if available
                if (!empty($searchTerm)) {
                    $query .= " WHERE q.quotes_text LIKE '%$searchTerm%' 
                                OR m.member_name LIKE '%$searchTerm%' 
                                OR q.type LIKE '%$searchTerm%' 
                                OR q.quotes_status LIKE '%$searchTerm%' 
                                OR q.updated_at LIKE '%$searchTerm%'";

                    // Optional: If search term is exactly 'Active' or 'Inactive'
                    if (strtolower($searchTerm) === 'active' || strtolower($searchTerm) === 'inactive') {
                        $query .= " OR q.quotes_status = '$searchTerm'";
                    }
                }

                // ✅ Now add ORDER BY at the end
                $query .= " ORDER BY q.updated_at DESC";

                $result = mysqli_query($conn, $query);
                $i = 1;



                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                            <td>" . $i++ . "</td>
                            <td class='text-wrap' style='max-width: 300px;'>{$row['quotes_text']}</td>
                            <td>{$row['member_name']}</td>
                            <td>{$row['type']}</td>
                            <td>{$row['quotes_status']}</td>
                            <td>{$row['updated_at']}</td>
                            <td>
                                <button class='btn btn-sm btn-primary view-quote-btn' 
                                    data-bs-toggle='modal' 
                                    data-bs-target='#quotesDetailModal' 
                                    data-quotes_text='{$row['quotes_text']}'
                                    data-member_name='{$row['member_name']}'
                                    data-type='{$row['type']}'
                                    data-quotes_status ='{$row['quotes_status']}'
                                    data-created='{$row['created_at']}'
                                    data-updated='{$row['updated_at']}'
                                    title='View Quotes'>
                                    <i class='fa-solid fa-expand'></i>
                                </button>
                
                              <button class='btn btn-sm btn-warning edit-quote-btn' 
                                    data-bs-toggle='modal' 
                                    data-bs-target='#editQuoteModal' 
                                    data-quotes_id='{$row['quotes_id']}'
                                    data-quotes_text='{$row['quotes_text']}'
                                    data-member_name='{$row['member_name']}'
                                    data-type='{$row['type']}'
                                    data-quotes_status='{$row['quotes_status']}'
                                    title='Edit Quotes'>
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

        <!-- Quotes Detail Modal -->
        <div class="modal fade" id="quotesDetailModal" tabindex="-1" aria-labelledby="quotesDetailModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modal-member_name-title"></h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Quotes Type:</strong> <span id="modal-type"></span></p>

                        <p style="margin-bottom: 2px;"><strong>Quotes Text:</strong></p>
                        <p style="margin-top: 0;"><em id="modal-quotes_text"></em></p>

                        <p><strong>Status:</strong> <span id="modal-quotes_status"></span></p>
                        <p><strong>Created At:</strong> <span id="modal-created"></span></p>
                        <p><strong>Updated At:</strong> <span id="modal-updated"></span></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Quotes Modal -->
        <div class="modal fade" id="quotesEditModal" tabindex="-1" aria-labelledby="quotesEditModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="quotesEditModalLabel">Edit Quote</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">
                        <form id="edit-quote-form" action="../quotes/a-update-quotes.php" method="POST">

                            <!-- Member's Name Select -->
                            <div class="mb-3">
                                <label for="edit-member_name" class="form-label"><strong>Member's Name</strong></label>
                                <select class="form-select" id="edit-member_name" name="member_id" onchange="toggleOtherInput()" required>
                                    <option value="" disabled selected>Choose NCT member...</option>
                                    <?php
                                    include '../../database/dbconn.php';
                                    $result = mysqli_query($conn, "SELECT member_id, member_name FROM member");
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<option value='{$row['member_id']}'>{$row['member_name']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <!-- Other Member Input -->
                            <div class="mb-3" id="otherFigureRow" style="display: none;">
                                <label for="otherFigureInput" class="form-label"><strong>Figure's Name</strong></label>
                                <input type="text" class="form-control" id="otherFigureInput" name="other_figure_name"
                                    placeholder="Enter figure's name">
                            </div>

                            <!-- Quote Type -->
                            <div class="mb-3">
                                <label for="edit-type" class="form-label"><strong>Quote Type</strong></label>
                                <select class="form-select" id="edit-type" name="type" placeholder="Choose quote type"
                                    required>
                                    <option value="" disabled selected>Choose quote type...</option>
                                    <!-- Add your options here -->
                                    <option value="1">Motivational</option>
                                    <option value="2">Funny</option>
                                    <option value="3">Philosophical</option>
                                    <option value="4">Romantic</option>
                                    <option value="5">Lyrics</option>
                                </select>
                            </div>

                            <!-- Quote Text -->
                            <div class="mb-3">
                                <label for="edit-quotes_text" class="form-label"><strong>Quote Text</strong></label>
                                <textarea class="form-control" id="edit-quotes_text" name="quotes_text" rows="4"
                                    required></textarea>
                            </div>

                            <!-- Status -->
                            <div class="mb-3">
                                <label for="edit-quotes_status" class="form-label"><strong>Status</strong></label>
                                <select class="form-control" id="edit-quotes_status" name="quotes_status" required>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>

                            <!-- Hidden ID -->
                            <input type="hidden" id="edit-quotes_id" name="quotes_id">

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

    <!-- Bootstrap JS (with Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JavaScript for Sidebar Toggle -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.view-quote-btn').forEach(button => {
                button.addEventListener('click', function () {
                    document.getElementById('modal-member_name-title').textContent = this.dataset.member_name;
                    document.getElementById('modal-type').textContent = this.dataset.type;
                    document.getElementById('modal-quotes_text').textContent = this.dataset.quotes_text;
                    document.getElementById('modal-quotes_status').textContent = this.dataset.quotes_status;
                    document.getElementById('modal-created').textContent = this.dataset.created;
                    document.getElementById('modal-updated').textContent = this.dataset.updated;

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
    document.querySelectorAll('.edit-quote-btn').forEach(button => {
        button.addEventListener('click', function () {
            // Populate the modal fields with current quote data
            document.getElementById('edit-quotes_id').value = this.dataset.quotes_id;
            document.getElementById('edit-member_name').value = this.dataset.member_id; // Update to member_id
            document.getElementById('edit-type').value = this.dataset.type;
            document.getElementById('edit-quotes_text').value = this.dataset.quotes_text;
            document.getElementById('edit-quotes_status').value = this.dataset.quotes_status;

            // If the member name is 'Other', show the custom input field
            if (this.dataset.member_name === 'Other') {
                document.getElementById('otherFigureRow').style.display = 'block';
                document.getElementById('otherFigureInput').value = this.dataset.other_figure_name || ''; // If available
            } else {
                document.getElementById('otherFigureRow').style.display = 'none';
            }

            // Show the modal
            new bootstrap.Modal(document.getElementById('quotesEditModal')).show();
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
            max-width: 45%;
        }

        .btn-primary.view-quote-btn {
            background-color:rgb(217, 233, 71) !important;
            border-color: rgb(217, 233, 71)  !important;
            color: white !important;
        }

        .btn-primary.view-quote-btn:hover {
            background-color:rgb(240, 226, 40) !important;
            border-color: rgb(240, 226, 40)  !important;
        }

        .btn-warning.edit-quote-btn {
            background-color: rgb(245, 101, 120) !important;
            border-color: rgb(241, 141, 154) !important;
            color: white !important;
        }

        .btn-warning.edit-quote-btn:hover {
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