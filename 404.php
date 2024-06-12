<?php require_once  "inc/init.php" ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 Error</title>
    <style>
        body {
            background-color: #f1f1f1;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            text-align: center;
        }

        h1 {
            font-size: 36px;
            color: #333;
            margin-bottom: 20px;
        }

        p {
            font-size: 18px;
            color: #666;
            margin-bottom: 20px;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>404 Error</h1>
        <p>Oops! The page you're looking for doesn't exist.</p>
        <?php
        if (isset($_SESSION['logged_username'])) {
            $user = User::findUsername($pdo, $_SESSION['logged_username']);
            if ($user->role == "admin") {
                echo "<p>Go back to <a href=\"../billy/admin/home_admin.php\">admin page</a>.</p>";
            } else {
                echo "<p>Go back to <a href=\"index.php\">home page</a>.</p>";
            }
        }else{
            echo "<p>Go back to <a href=\"index.php\">home page</a>.</p>";
        }
        ?>
    </div>
</body>

</html>