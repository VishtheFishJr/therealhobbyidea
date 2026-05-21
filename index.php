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
            overflow-x: hidden;
        }

        /* TOP BAR */

        .topbar {

            position: fixed;

            top: 0;

            left: 0;

            width: 100%;

            padding: 18px 36px;

            display: flex;

            justify-content: space-between;

            align-items: center;

            background: rgba(16, 19, 26, .92);

            backdrop-filter: blur(12px);

            border-bottom: 1px solid rgba(255, 255, 255, .08);

            z-index: 1000;

        }

        .brand {

            font-size: 1.45rem;

            font-weight: 900;

            letter-spacing: .4px;

            background:
                linear-gradient(90deg,
                    white,
                    #85bfff);

            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;

        }

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

            transition: .2s;

        }

        .auth a:hover {

            background: #28344a;

            transform: translateY(-2px);

        }

        /* MAIN */

        .container {

            max-width: 1400px;

            margin: auto;

            padding: 140px 30px 80px;

            text-align: center;

        }

        h1 {

            font-size: 3.3rem;

            font-weight: 900;

            color: white;

            margin-bottom: 12px;

        }

        .subtitle {

            color: #aeb7c4;

            font-size: 1.05rem;

            margin-bottom: 55px;

        }

        /* GRID */

        .grid {

            display: grid;

            grid-template-columns: repeat(4, 1fr);

            gap: 24px;

        }

        @media(max-width:1100px) {

            .grid {
                grid-template-columns: repeat(2, 1fr);
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

            min-height: 330px;

            padding: 28px;

            border-radius: 26px;

            display: flex;

            flex-direction: column;

            justify-content: flex-end;

            overflow: hidden;

            background-size: contain;
            background-position: center;
            background-repeat: no-repeat;

            border: 1px solid rgba(255, 255, 255, .08);

            transition: .3s;

        }

        .card:hover {

            transform:
                translateY(-10px);

            box-shadow:
                0 20px 50px rgba(0, 0, 0, .45);

        }

        .card h3 {

            font-size: 1.55rem;

            font-weight: 900;

            color: white;

            margin-bottom: 10px;

            text-shadow:
                0 5px 20px rgba(0, 0, 0, .9);

        }

        .card p {

            font-size: 1rem;

            line-height: 1.55;

            font-weight: 600;

            color: white;

            margin-bottom: 20px;

            text-shadow:
                0 2px 10px rgba(0, 0, 0, .95);

        }

        /* BUTTON */

        .enter {

            display: inline-block;

            width: max-content;

            padding: 12px 18px;

            border-radius: 14px;

            text-decoration: none;

            font-weight: 800;

            color: white;

            background:

                rgba(0, 0, 0, .45);

            backdrop-filter: blur(10px);

            border:

                1px solid rgba(255, 255, 255, .18);

            transition: .2s;

        }

        .enter:hover {

            background:

                rgba(0, 0, 0, .65);

        }

        /* FOOTER */

        .tag {

            margin-top: 60px;

            color: #80899b;

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

            <?php while ($club = $result->fetch_assoc()) {

                $image = "";

                switch ($club["color_class"]) {

                    case "blue":
                        $image = "Cardistry.jpg";
                        break;

                    case "green":
                        $image = "Rubix.jpg";
                        break;

                    case "yellow":
                        $image = "Lego.jpg";
                        break;

                    case "purple":
                        $image = "Keyboard.jpg";
                        break;

                    case "red":
                        $image = "Guitar.jpg";
                        break;

                    case "pink":
                        $image = "Yoyo.jpg";
                        break;

                    case "cyan":
                        $image = "Photography.jpg";
                        break;

                    case "orange":
                        $image = "Code.jpg";
                        break;

                    default:
                        $image = "Code.jpg";

                }

                ?>

                <div class="card" style="

background:

linear-gradient(
rgba(0,0,0,.10),
rgba(0,0,0,.65)
),

url('<?php echo $image; ?>');

">

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

            <?php } ?>

        </div>

        <div class="tag">

            New clubs are added constantly — join the movement.

        </div>

    </div>

</body>

</html>