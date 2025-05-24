<?php
// Include the database connection
include('database/dbconn.php');

// Start the session
session_start();


// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the input values
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query the database for the user with the given email
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email); // "s" denotes the type of the parameter (string)
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the user exists
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['user_roles'] = $user['user_roles']; // assuming your table has this column

            // Redirect based on role
            if ($user['user_roles'] === 'admin') {
                header("Location: admins/maindb/admindashboard.php");
            } else if ($user['user_roles'] === 'user') {
                header("Location: users/pomodoro/timer.php");
            } else {
                // Default redirection if role is unknown
                header("Location: index.php");
            }
            exit;
        } else {
            $error_message = "Invalid password.";
        }
    } else {
        $error_message = "No account found with that email address.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="css/style.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

</head>

<body>
    


    <div class="form-container" id="formContainer">
        <div class="form-tabs d-flex">
            <div class="tab login-tab active" onclick="showLogin()">Login</div>
            <div class="tab signup-tab" onclick="showSignup()">Sign Up</div>
        </div>

        <div class="forms">
            <!-- Login Form -->
            <form method="POST" action="login.php" class="form login-form">
                <h3 class="text-center mb-4">Welcome Back</h3>
                <input type="email" name="email" class="form-control mb-3" placeholder="Email" required>
                <div class="position-relative">
                    <input type="password" name="password" id="loginPassword" class="form-control mb-3"
                        placeholder="Password" required>
                    <i class="fa-regular fa-eye-slash position-absolute" id="toggleLoginPassword"
                        style="right: 20px; top: 12px; cursor: pointer;"></i>
                </div>

                <button type="submit" class="btn btn-success w-100">Login</button>
            </form>

            <!-- Signup Form -->
            <form method="POST" action="signup2.php" class="form signup-form">
                <h3 class="text-center mb-4">Create Your Account</h3>
                <input type="text" name="username" class="form-control mb-3" placeholder="Username" required>
                <input type="email" name="email" class="form-control mb-3" placeholder="Email" required>
                <div class="position-relative">
                    <input type="password" name="password" id="signupPassword" class="form-control mb-3"
                        placeholder="Password" required>
                    <i class="fa-regular fa-eye-slash position-absolute" id="toggleSignupPassword"
                        style="right: 20px; top: 12px; cursor: pointer;"></i>
                </div>
                <button type="submit" class="btn btn-primary w-100">Sign Up</button>
            </form>
        </div>

        <!-- Error Message -->
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger mt-3 text-center"><?php echo $error_message; ?></div>
        <?php endif; ?>
    </div>

    <style>
        .btn-primary {
            background: linear-gradient(to right, #28a745, #218838);
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px;
            font-size: 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
        }

        .btn-primary:hover {
            background: linear-gradient(to right, #218838, #1e7e34);
            transform: scale(1.05);
        }

        .text-success.fw-bold:hover {
            text-decoration: underline;
        }

        .form-container {
            width: 400px;
            margin: 50px auto;
            padding: 0;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            background: rgba(255, 255, 255);
            overflow: hidden;
            position: relative;
        }

        .form-tabs {
            display: flex;
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
        }

        .tab {
            flex: 1;
            text-align: center;
            padding: 12px 0;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s ease, color 0.3s ease;
            border-bottom: 3px solid transparent;
        }

        .tab.active,
        .tab:hover {
            background-color: #ffffff;
            color: #28a745;
            border-bottom: 3px solid #28a745;
        }

        .forms {
            display: flex;
            transition: transform 0.5s ease-in-out;
            width: 200%;
        }

        .form {
            width: 50%;
            padding: 30px;
            box-sizing: border-box;
        }

        .signup-active .forms {
            transform: translateX(-50%);
        }

         body::before {
    content: "";
    position: fixed; /* use fixed to keep it from scrolling */
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: url("assets/image/space.jpg");
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    background-attachment: fixed;
    opacity: 80%; /* adjust this value to control transparency */
    z-index: -1; /* puts it behind all content */
  }
    </style>
    <script>
        function showSignup() {
            document.getElementById("formContainer").classList.add("signup-active");
            document.querySelector(".login-tab").classList.remove("active");
            document.querySelector(".signup-tab").classList.add("active");
        }

        function showLogin() {
            document.getElementById("formContainer").classList.remove("signup-active");
            document.querySelector(".signup-tab").classList.remove("active");
            document.querySelector(".login-tab").classList.add("active");
        }

        // Toggle login password
        const toggleLoginPassword = document.getElementById("toggleLoginPassword");
        const loginPassword = document.getElementById("loginPassword");

        toggleLoginPassword.addEventListener("click", function () {
            const type = loginPassword.getAttribute("type") === "password" ? "text" : "password";
            loginPassword.setAttribute("type", type);
            this.classList.toggle("fa-eye");
            this.classList.toggle("fa-eye-slash");
        });

        // Toggle signup password
        const toggleSignupPassword = document.getElementById("toggleSignupPassword");
        const signupPassword = document.getElementById("signupPassword");

        toggleSignupPassword.addEventListener("click", function () {
            const type = signupPassword.getAttribute("type") === "password" ? "text" : "password";
            signupPassword.setAttribute("type", type);
            this.classList.toggle("fa-eye");
            this.classList.toggle("fa-eye-slash");
        });
    </script>


</body>

</html>