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
        }

        .topbar {

            position: fixed;

            top: 0;

            width: 100%;

            padding: 18px 34px;

            display: flex;

            justify-content: space-between;

            align-items: center;

            background: #10131add;

            backdrop-filter: blur(12px);

            z-index: 100;

        }

        .brand {

            font-size: 1.5rem;

            font-weight: 900;

            color: #8dc7ff;

        }

        .auth {

            display: flex;

            gap: 10px;

        }

        .auth a {

            text-decoration: none;

            color: white;

            padding: 10px 15px;

            border-radius: 12px;

            background: #1f2937;

        }

        .container {

            max-width: 1400px;

            margin: auto;

            padding: 140px 30px 70px;

        }

        h1 {

            font-size: 3rem;

            margin-bottom: 10px;

        }

        .subtitle {

            color: #9ca3af;

            margin-bottom: 55px;

        }

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

            background: #1a2233;

            border-radius: 22px;

            overflow: hidden;

            display: flex;

            flex-direction: column;

            transition: .25s;

        }

        .card:hover {

            transform:
                translateY(-6px);

        }

        /* IMAGE */

        .club-image {

            width: 100%;

            height: 250px;

            /* SHOW FULL IMAGE */

            object-fit: contain;

            background: #141b28;

            display: block;

            padding: 12px;

        }

        /* CONTENT */

        .content {

            padding: 22px;

        }

        .content h3 {

            font-size: 1.5rem;

            margin-bottom: 10px;

            font-weight: 900;

        }

        .content p {

            color: #d5d5d5;

            line-height: 1.6;

            margin-bottom: 18px;

        }

        /* BUTTON */

        .enter {

            display: inline-block;

            padding: 12px 18px;

            border-radius: 12px;

            text-decoration: none;

            font-weight: 800;

            color: white;

            background: #338bff;

        }

        .enter:hover {

            background: #4da0ff;

        }

        .tag {

            margin-top: 55px;

            color: #7f8794;

            text-align: center;

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

            Join communities built around creativity and skill.

        </div>

        <div class="grid">

            <?php while ($club = $result->fetch_assoc()) {

                $image = "";

                switch ($club["color_class"]) {

                    case "blue":
                        $image = "images/Cardistry.jpg";
                        break;

                    case "green":
                        $image = "images/Rubix.jpg";
                        break;

                    case "yellow":
                        $image = "images/Lego.jpg";
                        break;

                    case "purple":
                        $image = "images/Keyboard.jpg";
                        break;

                    case "red":
                        $image = "images/Guitar.jpg";
                        break;

                    case "pink":
                        $image = "images/Yoyo.jpg";
                        break;

                    case "cyan":
                        $image = "images/Photography.jpg";
                        break;

                    case "orange":
                        $image = "images/Code.jpg";
                        break;

                    default:
                        $image = "images/Code.jpg";

                }

                ?>

                <div class="card">

                    <img class="club-image" src="<?php echo $image; ?>">

                    <div class="content">

                        <h3>

                            <?php echo $club["name"]; ?>

                        </h3>

                        <p>

                            <?php echo $club["description"]; ?>

                        </p>

                        <a class="enter" href="<?php echo $club["page_link"]; ?>">

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