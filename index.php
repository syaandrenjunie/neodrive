<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NeoDrive</title>
    <link rel="stylesheet" href="css/style.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    
        
    <div class="d-flex align-items-center justify-content-between">
        <div>
            <h1>DRIVE YOUR FOCUS,<br>EARN YOUR REWARD</h1><br>
            <h2>Welcome to NEODrive,<br>Your ultimate productivity companion. <br>
                From managing your task with ease to<br> staying motivated with personalized
                rewards.<br>NEODrive helps you to focus, achieve and <br>enjoy every step of your journey!
            </h2><br>
<button type="button" class="custom-btn" onclick="window.location.href='login.php'">Let's Start Now</button>
        </div>
        <img src="assets/image/index1.png" class="rounded ms-3 img-fluid custom-img" alt="Icon">
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <style>

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
        
        .d-flex {
            margin-left: 15px;
            margin-right: 15px;
        }

        h1 {
            font-weight: bold;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-style: italic;
            font-size: 35px;
            color: aliceblue;
        }

        h2 {
            font-size: 27px;
            color: aliceblue;
        }

        .custom-btn {
            --bs-btn-padding-y: 0.5rem;
            --bs-btn-padding-x: 1rem;
            --bs-btn-font-size: 1rem;
            background: linear-gradient(to right,rgb(85, 223, 73),rgb(28, 206, 67));
            border: none;
            color: white;
            font-weight: bold;
            padding: var(--bs-btn-padding-y) var(--bs-btn-padding-x);
            font-size: var(--bs-btn-font-size);
            border-radius: 2px;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
        }

        .custom-btn:hover {
            background: linear-gradient(to right,rgb(74, 211, 104),rgb(59, 216, 96));
            transform: scale(1.05);
        }

        .custom-img {
            max-width: 100%;
            height: auto;
            width: 450px;
        }

        @media (max-width: 768px) {
            .d-flex {
                flex-wrap: wrap;
                justify-content: center;
            }

            .custom-img {
                width: 400px;
                height: 450px;
            }

            .d-flex h1 {
                font-size: 35px;
            }

            .d-flex h2 {
                font-size: 25px;
            }
        }
    </style>
</body>

</html>
