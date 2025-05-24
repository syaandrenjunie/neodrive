<?php
include("../../include/auth.php"); // Include the authentication file

// Check if the user is an admin
check_role('admin');

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile</title>
  <link rel="stylesheet" href="../../css/style.css">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

</head>

<body>
  <header class="header-container">
  <div class="logo-title-container">
            <!-- Timer image linked to sidebar toggle -->
            <img src="../../assets/image/clock.png" alt="Logo" class="timer-icon" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">
            <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 
                link-underline-opacity-75-hover" href="#">Admin Profile</a>
        </div>
    <div class="header-buttons">
      <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 
            link-underline-opacity-75-hover" href="timer.php">NeoSpace</a>
      <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 
            link-underline-opacity-75-hover" href="#">Collection</a>
      <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 
            link-underline-opacity-75-hover" href="quotes.php">Quotes</a>
      <div class="dropdown">
        <button class="btn dropdown-toggle" type="button" id="profileDropdown" data-bs-toggle="dropdown"
          aria-expanded="false">
          <i class="fa-solid fa-user-circle"></i>
        </button>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
          <li><a class="dropdown-item" href="profile.php">My Profile</a></li>
          <li><a class="dropdown-item" href="../../logout.php">Logout</a></li>
          </ul>
      </div>

    </div>
  </header>

  <!-- Include Sidebar -->
  <?php include('../menus-sidebar.php'); ?>

   <!-- Bootstrap JS Bundle with Popper -->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <div class="row g-4 mt-0 mb-4 px-2">
    <div class="col-md-4">
      <div class="profile-details text-center mb-3">
        <img src="../assets/image/default-profile.png" alt="Profile Picture" class="profile-pic mb-3">
        <h4 class="mb-2">Username</h4>
        <p class="mb-1"><strong>Email:</strong> user@example.com</p>
        <p><strong>Bias:</strong> Mark Lee</p>

        <!-- Edit Profile Icon -->
        <p class="mt-3 text-center">
          <!-- Pencil Icon to trigger modal -->
          <button type="button" class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#editProfileModal">
            <i class="bi bi-pencil-square"></i> Edit Profile
          </button>
        </p>
      </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel"
      aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <!-- Form to edit profile -->
            <form>
              <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" value="Username">
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" value="user@example.com">
              </div>
              <div class="mb-3">
                <label for="bias" class="form-label">Bias (Favorite NCT member)</label>
                <input type="text" class="form-control" id="bias" value="Mark Lee">
              </div>
              <div class="mb-3">
                <label for="profilePic" class="form-label">Profile Picture</label>
                <input type="file" class="form-control" id="profilePic">
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </div>
    </div>


  </div>
 
  

<!-- Custom JavaScript for Sidebar Toggle -->
<script>
    // Get the image element that will trigger the sidebar
    const sidebarToggle = document.getElementById('sidebarToggle');

    // Add click event to trigger sidebar
    sidebarToggle.addEventListener('click', function () {
        const sidebar = new bootstrap.Offcanvas(document.getElementById('offcanvasWithBothOptions'));
        sidebar.show(); // Show the sidebar when the image is clicked
    });
</script>


  <style>
    .profile-details,
    .session-history,
    .todo-history {
      background-color: #f9f9f9;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
      height: 100%;
    }

    .profile-details {
      background-color: #f9f9f9;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
      height: auto;
      /* Don't fix height */
      min-height: 250px;
      /* Optional */
      text-align: center;
    }

    .profile-pic {
      width: 120px;
      height: 120px;
      object-fit: cover;
      border-radius: 50%;
      border: 3px solid #dcdcdc;
      display: inline-block;
    }

   
    .header-buttons .dropdown {
      display: inline-block;
      gap: 5px;
    }
  </style>

</body>

</html>