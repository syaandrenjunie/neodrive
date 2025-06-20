<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Welcome | NeoDrive</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(120deg,rgb(72, 173, 42),rgb(234, 245, 76));
      color: #fff;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      padding: 20px;
    }

    h1 {
      font-size: 3rem;
      font-weight: bold;
    }

    p {
      font-size: 1.2rem;
      margin-bottom: 30px;
    }

    .btn-custom {
      background-color: #28a745;
      border: none;
      padding: 10px 20px;
      font-size: 1.1rem;
      color: white;
      border-radius: 5px;
      transition: all 0.3s ease;
    }

    .btn-custom:hover {
      background-color: #218838;
      transform: scale(1.05);
    }

    @media (max-width: 768px) {
      h1 {
        font-size: 2rem;
      }

      p {
        font-size: 1rem;
      }
    }
  </style>
</head>
<body>
  <div>
    <h1>Welcome to NeoDrive</h1>
    <p>Your ultimate productivity companion. Track your focus, earn rewards, and stay motivated.</p>
    <a href="login.php" class="btn btn-custom">Get Started</a>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
