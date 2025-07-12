<?php
include '../../database/dbconn.php';
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: ../../login.php");
  exit();
}

// Retrieve the user ID from the session
$user_id = $_SESSION['user_id'];

// Fetch user data
$user_query = "SELECT username, email, bias FROM users WHERE user_id = ?";
$user_stmt = $conn->prepare($user_query);
$user_stmt->bind_param("i", $user_id);
$user_stmt->execute();
$user_result = $user_stmt->get_result();
$user_data = $user_result->fetch_assoc();

// Fetch completed to-do tasks
$todo_query = "SELECT task_name, updated_at FROM to_do_list WHERE user_id = ? AND is_completed = 1 ORDER BY updated_at DESC";
$todo_stmt = $conn->prepare($todo_query);
$todo_stmt->bind_param("i", $user_id);
$todo_stmt->execute();
$todo_result = $todo_stmt->get_result();

// Fetch completed Pomodoro sessions
$session_query = "SELECT total_rounds, completed_rounds, started_at, ended_at FROM timer_sessions WHERE user_id = ? AND status = 'completed' ORDER BY ended_at DESC";
$session_stmt = $conn->prepare($session_query);
$session_stmt->bind_param("i", $user_id);
$session_stmt->execute();
$session_result = $session_stmt->get_result();

// Fetch members for the bias dropdown
$bias_list = [];
$bias_query = "SELECT member_name FROM member ORDER BY member_name ASC";
$result = mysqli_query($conn, $bias_query);
if ($result) {
  while ($row = mysqli_fetch_assoc($result)) {
    $bias_list[] = $row['member_name'];
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile</title>
  <link rel="stylesheet" href="../../css/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
  <header class="header-container">
    <div class="logo-title-container">
      <img src="../../assets/image/clock.png" alt="Logo">
      <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 
            link-underline-opacity-75-hover" href="admindashboard.php">Your Profile</a>
    </div>
    <div class="header-buttons">
        <div class="dropdown">
        <button class="btn dropdown-toggle" type="button" id="profileDropdown" data-bs-toggle="dropdown"
          aria-expanded="false">
          <i class="fa-solid fa-user-circle"></i>
        </button>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
          <li><a class="dropdown-item" href="#">My Profile</a></li>
          <li><a class="dropdown-item" href="../../logout.php">Logout</a></li>
        </ul>
      </div>

    </div>
  </header><br>
    
  <?php include('../menus-sidebar.php'); ?>

  <?php if (isset($_SESSION['success_message'])): ?>
    <script>
      Swal.fire({
        icon: 'success',
        title: 'Success',
        text: '<?php echo $_SESSION['success_message']; ?>',
        confirmButtonColor: '#28a745'
      });
    </script>
    <?php unset($_SESSION['success_message']); ?>
  <?php endif; ?>

  <?php if (isset($_SESSION['error_message'])): ?>
    <script>
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: '<?php echo $_SESSION['error_message']; ?>',
        confirmButtonColor: '#dc3545'
      });
    </script>
    <?php unset($_SESSION['error_message']); ?>
  <?php endif; ?>


  <div class="row g-4 mt-0 mb-4 px-2">
    <div class="col-md-4">
      <div class="profile-details rounded p-4 position-relative"
        style="background-color: rgb(215, 252, 194); color: #333; box-shadow: 0 10px 30px rgb(169, 255, 158);">
        <div class="profile-pic-container mx-auto position-relative mb-3">
          <?php
          $default_picture = '../../assets/image/IMG_1197.JPG';
          $profile_picture = !empty($user_data['profile_picture']) ? '../../' . $user_data['profile_picture'] : $default_picture;
          ?>
          <img src="<?php echo htmlspecialchars($profile_picture); ?>" alt="Profile Picture" class="profile-pic">
          <span class="edit-icon" data-bs-toggle="modal" data-bs-target="#editProfileModal">
            <i class="bi bi-pencil-fill"></i>
          </span>
        </div>
        <h4 class="mb-2"><?php echo htmlspecialchars($user_data['username']); ?></h4>
        <p class="mb-1"><i class="bi bi-envelope me-1"></i><strong>Email:</strong>
          <?php echo htmlspecialchars($user_data['email']); ?></p>
        <p><i class="bi bi-star me-1"></i><strong>Bias:</strong> <?php echo htmlspecialchars($user_data['bias']); ?></p>

        <p class="mt-3 text-center">
          <button type="button" class="custom-btn" data-bs-toggle="modal" data-bs-target="#editProfileModal">
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
            <form action="u-update-profile.php" method="POST" enctype="multipart/form-data">
              <div class="mb-3">
                <label for="username" class="form-label text-success"><strong>Username</strong></label>
                <input type="text" class="form-control" id="username" name="username"
                  value="<?php echo htmlspecialchars($user_data['username']); ?>">

              </div>

              <div class="mb-3">
                <label for="email" class="form-label text-success"><strong>Email address</strong></label>
                <input type="email" class="form-control" id="email" name="email"
                  value="<?php echo htmlspecialchars($user_data['email']); ?>">

              </div>

              <div class="mb-3">
                <label for="bias" class="form-label text-success"><strong>Bias</strong></label>
                <select class="form-select" id="bias" name="bias">
                  <option value="">-- Select Bias --</option>
                  <?php foreach ($bias_list as $bias_name): ?>
                    <option value="<?php echo htmlspecialchars($bias_name); ?>" <?php if ($user_data['bias'] === $bias_name)
                         echo 'selected'; ?>>
                      <?php echo htmlspecialchars($bias_name); ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="mb-3">
                <label for="profilePic" class="form-label text-success"><strong>Profile Picture</strong></label>
                <input type="file" class="form-control" name="profilePic" accept="image/*">

              </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn custom-save-btn">Save Changes</button>
          </div>
          </form>
        </div>
      </div>
    </div>

    



  </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    

    const sidebarToggle = document.getElementById('sidebarToggle');
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function () {
                const sidebar = new bootstrap.Offcanvas(document.getElementById('offcanvasWithBothOptions'));
                sidebar.show();
            });
        }

    
    
  </script>

  <style>
    .profile-details,
    .session-history,
    .todo-history {
      background-color: rgb(249, 249, 249);
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
      height: 100%;
      transition: transform 0.3s ease, box-shadow 0.3s ease;

    }

    .profile-details:hover,
    .session-history:hover,
    .todo-history:hover { 
      transform: scale(1.03);
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }


    .profile-details {
      background-color: #f9f9f9;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
      height: auto;
      min-height: 250px;
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

    .profile-pic-container {
      width: 130px;
      height: 130px;
      position: relative;
    }

    .profile-pic {
      width: 100%;
      height: 100%;
      object-fit: cover;
      border-radius: 50%;
      border: 3px solid #dcdcdc;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .profile-pic-container:hover .profile-pic {
      transform: scale(1.05);
      box-shadow: 0 0 15px rgba(0, 123, 255, 0.3);
    }

    .edit-icon {
      position: absolute;
      bottom: 5px;
      right: 5px;
      background-color: white;
      border: 1px solid #ccc;
      border-radius: 50%;
      padding: 6px;
      font-size: 14px;
      cursor: pointer;
      display: none;
      transition: background-color 0.2s;
    }

    .profile-pic-container:hover .edit-icon {
      display: block;
    }

    .edit-icon:hover {
      background-color: #f0f0f0;
    }

    .completed-item {
      background-color: rgb(215, 252, 194);
      border: none;
      border-bottom: 1px solid #a3d9a5;
    }

    .custom-blend {
      background-color: transparent;
      border-color: rgb(215, 252, 194);
      border: none;
      border-bottom: 1px solid #a3d9a5;
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