<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include "db.php";

$sql = "SELECT * FROM clubs";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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

        /* CLEAN BACKGROUND */

        body {
            background: #10131a;
            color: white;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* TOP */

        .topbar {
            position: fixed;

            top: 0;
            left: 0;

            width: 100%;

            padding: 18px 36px;

            display: flex;
            justify-content: space-between;
            align-items: center;

            background: rgba(16, 19, 26, .85);

            backdrop-filter: blur(14px);

            border-bottom: 1px solid rgba(255, 255, 255, .08);

            z-index: 1000;
        }

        /* CLEANER LOGO */

        .brand {

            font-size: 1.45rem;

            font-weight: 900;

            letter-spacing: .5px;

            background:
                linear-gradient(90deg,
                    #ffffff,
                    #8fd3ff);

            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;

        }

        /* BUTTONS */

        .auth {
            display: flex;
            gap: 10px;
        }

        .auth a {

            text-decoration: none;

            color: white;

            padding: 10px 16px;

            border-radius: 12px;

            background: #1b2230;

            border: 1px solid rgba(255, 255, 255, .08);

            transition: .25s;

        }

        .auth a:hover {

            background: #243044;

            transform: translateY(-2px);

        }

        /* MAIN */

        .container {

            max-width: 1400px;

            margin: auto;

            padding:

                140px 30px 80px;

            text-align: center;

        }

        h1 {

            font-size: 3.4rem;

            font-weight: 900;

            color: white;

            margin-bottom: 14px;

        }

        .subtitle {

            color: #a9b0bf;

            font-size: 1.05rem;

            margin-bottom: 55px;

        }

        /* GRID */

        .grid {

            display: grid;

            grid-template-columns:
                repeat(4, 1fr);

            gap: 24px;

        }

        @media(max-width:1100px) {

            .grid {
                grid-template-columns:
                    repeat(2, 1fr);
            }

        }

        @media(max-width:650px) {

            .grid {
                grid-template-columns: 1fr;
            }

        }

        /* CARD */

        .card {

            position: relative;

            padding: 28px;

            border-radius: 26px;

            text-align: left;

            overflow: hidden;

            border:

                1px solid rgba(255, 255, 255, .10);

            transition: .28s;

        }

        /* brighter hover */

        .card:hover {

            transform:
                translateY(-10px);

            box-shadow:
                0 18px 50px rgba(0, 0, 0, .35);

        }

        /* COLORS */

        .blue {
            background:
                linear-gradient(135deg,
                    #149dff,
                    #246dff);
        }

        .green {
            background:
                linear-gradient(135deg,
                    #00d47b,
                    #00995c);
        }

        .yellow {
            background:
                linear-gradient(135deg,
                    #ffcf3f,
                    #ff9d00);
        }

        .purple {
            background:
                linear-gradient(135deg,
                    #9a6cff,
                    #6940ff);
        }

        .red {
            background:
                linear-gradient(135deg,
                    #ff5b76,
                    #ff3131);
        }

        .pink {
            background:
                linear-gradient(135deg,
                    #ff52bd,
                    #d3007b);
        }

        .cyan {
            background:
                linear-gradient(135deg,
                    #00e5ff,
                    #0088ff);
        }

        .orange {
            background:
                linear-gradient(135deg,
                    #ff9f43,
                    #ff6a00);
        }

        /* CARD TEXT */

        .card h3 {

            font-size: 1.45rem;

            font-weight: 900;

            color: white;

            margin-bottom: 10px;

            text-shadow:
                0 2px 8px rgba(0, 0, 0, .25);

        }

        .card p {

            color:

                rgba(255,
                    255,
                    255,
                    .97);

            font-size: 1rem;

            line-height: 1.6;

            font-weight: 600;

            margin-bottom: 22px;

        }

        /* BUTTON */

        .enter {

            display: inline-block;

            padding:

                12px 18px;

            border-radius: 14px;

            text-decoration: none;

            font-weight: 800;

            color: white;

            background:

                rgba(0,
                    0,
                    0,
                    .20);

            border:

                1px solid rgba(255, 255, 255, .18);

            transition: .22s;

        }

        .enter:hover {

            transform:

                scale(1.05);

            background:

                rgba(0,
                    0,
                    0,
                    .32);

        }

        /* FOOTER */

        .tag {

            margin-top: 60px;

            color: #7e8898;

        }
    </style>

</head>

<body>

    <div class="topbar">

        <div class="brand">
            HobbyHub
        </div>

        <div class="auth">

            <a href="login.html">
                Log In
            </a>

            <a href="signup.html">
                Sign Up
            </a>

        </div>

    </div>

    <div class="container">

        <h1>
            Active Hobby Clubs
        </h1>

        <div class="subtitle">

            Join vibrant communities built around creativity, skill, and competition.

        </div>

        <div class="grid">

                        <?php while ($club = $result->fetch_assoc()) { ?>

                <div class="card <?php echo $club['color_class']; ?>">

                    <h3>

                                                <?php echo $club['name']; ?>

                    </h3>

                    <p>

                                                <?php echo $club['description']; ?>

                    </p>

                    <a class="enter" href="<?php echo $club['page_link']; ?>">

                        Enter Club

                    </a>

                </div>

                        <?php } ?>

        </div>

        <div class="tag">

            New clubs are added constantly — join the movement.

        </div>

    </div>

</body>

</html>