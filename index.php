<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

include "db.php";

/* Force login */
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}

/* Load clubs */
$sql = "SELECT * FROM clubs";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>HobbyHub</title>

    <link rel="shortcut icon" href="./favicon.ico">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Inter", sans-serif;
        }

        body {
            background: #10131a;
            color: white;
            min-height: 100vh;
            overflow-x: hidden;
        }

        .topbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            padding: 18px 34px;

            display: flex;
            justify-content: space-between;
            align-items: center;

            background: #10131add;

            backdrop-filter: blur(12px);

            border-bottom:
                1px solid rgba(255, 255, 255, .08);

            z-index: 1000;
        }

        .brand {
            font-size: 1.5rem;
            font-weight: 900;

            background:
                linear-gradient(90deg,
                    #ffffff,
                    #8fcfff);

            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .auth a {
            text-decoration: none;

            color: white;

            padding: 10px 16px;

            border-radius: 12px;

            background: #1d2635;

            border:
                1px solid rgba(255, 255, 255, .08);
        }

        .auth a:hover {
            background: #2a3850;
        }

        .container {
            max-width: 1400px;

            margin: auto;

            padding: 140px 30px 80px;

            text-align: center;
        }

        h1 {
            font-size: 3.2rem;
            font-weight: 900;

            margin-bottom: 12px;
        }

        .subtitle {
            color: #9ca3af;

            margin-bottom: 60px;
        }

        .grid {
            display: grid;

            grid-template-columns:
                repeat(4, 1fr);

            gap: 24px;

            text-align: left;
        }

        @media(max-width:1100px) {

            .grid {
                grid-template-columns:
                    repeat(2, 1fr);
            }

        }

        @media(max-width:650px) {

            .grid {
                grid-template-columns:
                    1fr;
            }

        }

        .card {

            background: #1a2233;

            border-radius: 24px;

            overflow: hidden;

            display: flex;

            flex-direction: column;

            transition: .25s;

            border:
                1px solid rgba(255, 255, 255, .06);

        }

        .card:hover {

            transform:
                translateY(-6px);

            box-shadow:
                0 20px 50px rgba(0, 0, 0, .35);

        }

        .club-image {

            width: 100%;

            height: 250px;

            object-fit: contain;

            background: #131b2a;

            padding: 12px;

            display: block;

        }

        .content {
            padding: 22px;
        }

        .content h3 {

            font-size: 1.45rem;

            font-weight: 900;

            margin-bottom: 10px;

        }

        .content p {

            color: #cfd5df;

            line-height: 1.6;

            margin-bottom: 18px;

        }

        .enter {

            display: inline-block;

            padding: 12px 18px;

            border-radius: 12px;

            text-decoration: none;

            font-weight: 800;

            color: white;

            background:
                linear-gradient(90deg,
                    #338bff,
                    #4eb0ff);

        }

        .enter:hover {
            transform:
                translateY(-2px);
        }

        .tag {

            margin-top: 60px;

            color: #7d8697;

        }
    </style>

</head>

<body>

    <div class="topbar">

        <div class="brand">
            HobbyHub
        </div>

        <div class="auth">
            <a href="logout.php">
                Logout
            </a>
        </div>

    </div>

    <div class="container">

        <h1>
            Welcome to HobbyHub,
            <?php echo htmlspecialchars($_SESSION["user"]); ?>
        </h1>

        <div class="subtitle">
            Join communities built around creativity, skill, and competition.
        </div>

        <div class="grid">

            <?php while ($club = $result->fetch_assoc()) { ?>

                <?php
                $image = !empty($club["images"])
                    ? $club["images"]
                    : "images/default.jpg";
                ?>

                <div class="card">

                    <img class="club-image" src="<?php echo htmlspecialchars($image); ?>"
                        alt="<?php echo htmlspecialchars($club["name"] ?? "Club"); ?>">

                    <div class="content">

                        <h3>
                            <?php echo htmlspecialchars($club["name"] ?? "Unnamed Club"); ?>
                        </h3>

                        <p>
                            <?php echo htmlspecialchars($club["description"] ?? ""); ?>
                        </p>

                        <a class="enter" href="<?php echo htmlspecialchars($club["page_link"] ?? "#"); ?>">
                            Enter Club
                        </a>

                    </div>

                </div>

            <?php } ?>

        </div>

        <div class="tag">
            New clubs are added constantly.
        </div>

    </div>

</body>

</html>