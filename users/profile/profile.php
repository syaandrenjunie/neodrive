<?php
// Include DB connection and session start
include '../../database/dbconn.php';
session_start();

// Check if the user is logged in by verifying session data
if (!isset($_SESSION['user_id'])) {
  // Redirect to login if the user is not logged in
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
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />



</head>

<body>
  <header class="header-container">
    <div class="logo-title-container">
      <img src="../../assets/image/clock.png" alt="Logo">
      <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 
            link-underline-opacity-75-hover" href="#">Your Profile</a>
    </div>
    <div class="header-buttons">
      <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 
            link-underline-opacity-75-hover" href="../pomodoro/timer.php">NeoSpace</a>
      <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 
            link-underline-opacity-75-hover" href="../pc/u-pc-collection.php">Collection</a>
      <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 
            link-underline-opacity-75-hover" href="../quotes/quotes.php">Quotes</a>
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

  <div class="row g-4 mt-0 mb-4 px-2">
    <div class="col-md-4">
      <div class="profile-details shadow-sm rounded p-4 bg-white position-relative">
        <div class="profile-pic-container mx-auto position-relative mb-3">
          <img src="../../assets/image/IMG_1197.JPG" alt="" class="profile-pic">
          <span class="edit-icon" data-bs-toggle="modal" data-bs-target="#editProfileModal">
            <i class="bi bi-pencil-fill"></i>
          </span>
        </div>
        <h4 class="mb-2"><?php echo htmlspecialchars($user_data['username']); ?></h4>
        <p class="mb-1"><i class="bi bi-envelope me-1"></i><strong>Email:</strong>
          <?php echo htmlspecialchars($user_data['email']); ?></p>
        <p><i class="bi bi-star me-1"></i><strong>Bias:</strong> <?php echo htmlspecialchars($user_data['bias']); ?></p>

        <p class="mt-3 text-center">
          <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
            data-bs-target="#editProfileModal">
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
                <input type="text" class="form-control" id="username"
                  value="<?php echo htmlspecialchars($user_data['username']); ?>">
              </div>

              <div class="mb-3">
                <label for="email" class="form-label text-success"><strong>Email address</strong></label>
                <input type="email" class="form-control" id="email"
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
                <input type="file" class="form-control" id="profilePic">
              </div>
            </form>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="session-history shadow-sm rounded p-4 bg-white">
        <h5 class="text-center mb-4 fw-bold text-dark">
          <i class="bi bi-hourglass-bottom me-2"></i>Completed Sessions
        </h5>

        <?php if ($session_result->num_rows > 0): ?>
          <ul class="list-group list-group-flush">
            <?php while ($session = $session_result->fetch_assoc()): ?>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                  Completed <?php echo htmlspecialchars($session['completed_rounds']); ?>
                  round<?php echo ($session['completed_rounds'] > 1) ? 's' : ''; ?>
                </div>
                <span class="badge bg-success rounded-pill small">
                  <?php echo date("M d", strtotime($session['ended_at'])); ?>
                </span>
              </li>
            <?php endwhile; ?>
          </ul>
        <?php else: ?>
          <p class="text-muted text-center">No completed sessions yet.</p>
        <?php endif; ?>
      </div>
    </div>


    <div class="col-md-4">
      <div class="todo-history shadow-sm rounded p-4 bg-white">
        <h5 class="text-center mb-4 fw-bold text-dark">
          <i class="bi bi-check-circle-fill me-2"></i>Completed Tasks
        </h5>

        <?php if ($todo_result->num_rows > 0): ?>
          <ul class="list-group list-group-flush">
            <?php while ($task = $todo_result->fetch_assoc()): ?>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <div class="text-truncate" style="max-width: 70%;">
                  <?php echo htmlspecialchars($task['task_name']); ?>
                </div>
                <span class="badge bg-success rounded-pill small">
                  <?php echo date("M d", strtotime($task['updated_at'])); ?>
                </span>
              </li>
            <?php endwhile; ?>
          </ul>
        <?php else: ?>
          <p class="text-muted text-center">No completed tasks yet.</p>
        <?php endif; ?>
      </div>
    </div>



  </div>
  </div>
  <!-- Bootstrap JS Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


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
      /* Slightly enlarge */
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
      /* Optional: glow effect */
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
  </style>

</body>

</html>