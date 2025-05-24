<?php
// Include the database connection
include('database/dbconn.php');

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from the form
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Secure password hashing

    // Insert data into the users table
    $sql = "INSERT INTO users (username, email, password, user_status) VALUES ('$username', '$email', '$password', 'active')";

    if ($conn->query($sql) === TRUE) {
        // Redirect after successful signup
        header("Location: users/pomodoro/timer.php");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Page</title>
    <link rel="stylesheet" href="css/style.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

</head>

<body>
    <header class="header-container">
        <div class="logo-title-container">
            <img src="assets/image/clock.png" alt="Logo">
            <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 
                link-underline-opacity-75-hover" href="#">Registration Form</a>
        </div>
        <div class="header-buttons">

            <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 
                link-underline-opacity-75-hover" href="login.php">Log In</a>
        </div>
    </header>

    <div class="container mt-5">
        <form class="custom-form" method="POST" action="signup2.php">
            <span>Register Now!</span>

            <div class="row mb-3">
                <label for="inputUsername3" class="col-sm-2 col-form-label">Username</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputUsername3" name="username" required>
                </div>
            </div>
            <div class="row mb-3">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control" id="inputEmail3" name="email" required>
                </div>
            </div>
            <div class="row mb-3">
                <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
                <div class="col-sm-10 position-relative">
                    <input type="password" id="inputPassword5" class="form-control" name="password" aria-describedby="passwordHelpBlock" required>
                    <i class="fa-regular fa-eye-slash position-absolute" id="togglePassword" style="right: 20px; top: 12px; cursor: pointer;"></i>
                    <div id="passwordHelpBlock" class="form-text">
                        Your password must be 8-20 characters long, contain letters and numbers, and must not contain spaces,
                        special characters, or emoji.
                    </div>
                </div>
            </div>
                <!-- <fieldset class="row mb-3">
            <legend class="col-form-label col-sm-2 pt-0">Radios</legend>
            <div class="col-sm-10">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios1" value="option1"
                        checked>
                    <label class="form-check-label" for="gridRadios1">
                        First radio
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios2" value="option2">
                    <label class="form-check-label" for="gridRadios2">
                        Second radio
                    </label>
                </div>
                <div class="form-check disabled">
                    <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios3" value="option3"
                        disabled>
                    <label class="form-check-label" for="gridRadios3">
                        Third disabled radio
                    </label>
                </div>
            </div>
        </fieldset> -->
                <!-- <div class="row mb-3">
                    <div class="col-sm-10 offset-sm-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="gridCheck1">
                            <label class="form-check-label" for="gridCheck1">
                                Example checkbox
                            </label>
                        </div>
                    </div>
                </div> -->
                <div class="mb-3 text-end">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
        </form>
    </div>
    <script>
        // Toggle password visibility
        const togglePassword = document.getElementById("togglePassword");
        const password = document.getElementById("inputPassword5");
        togglePassword.addEventListener("click", function () {
            // Toggle the type attribute of the password field
            const type = password.type === "password" ? "text" : "password";
            password.type = type;
            this.classList.toggle("fa-eye");
            this.classList.toggle("fa-eye-slash");
        });
    </script>
    <style>
        /* .custom-form {
            max-width: 700px;
            margin: auto;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }  */

        .custom-form span {
            font-weight: bold;
            font-size: 20px;
            color: red;
            text-align: center;
        }

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
    </style>
</body>

</html>