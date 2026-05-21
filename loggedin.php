<?php
session_start();

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>HobbyHub</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: Inter;
            background: #10131a;
            color: white;
        }

        .topbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;

            padding: 16px 28px;
            box-sizing: border-box;

            background: #10131add;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);

            z-index: 1000;
        }

        .brand {
            font-weight: 900;
            font-size: 1.4rem;
        }

        .logout {
            text-decoration: none;
            background: #1d2635;
            padding: 10px 14px;
            border-radius: 10px;
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.08);
            transition: 0.2s;
        }

        .logout:hover {
            background: #2a3850;
        }

        .container {
            padding-top: 120px;
            text-align: center;
        }

        h1 {
            font-size: 2.6rem;
            font-weight: 900;
        }

        .card {
            margin-top: 30px;
            display: inline-block;
            padding: 20px 30px;
            background: #1a2233;
            border-radius: 16px;
            color: #cfd5df;
        }
    </style>
</head>

<body>

    <div class="topbar">
        <div class="brand">HobbyHub</div>

        <a class="logout" href="logout.php">Logout</a>
    </div>

    <div class="container">

        <h1>
            Welcome to HobbyHub, <?php echo htmlspecialchars($_SESSION["user"]); ?>
        </h1>

        <div class="card">
            You are successfully logged in.
        </div>

    </div>

</body>

</html>