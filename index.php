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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>HobbyHub</title>

    <link rel="shortcut icon" href="./favicon.ico" type="image/x-icon">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Inter", sans-serif;
        }

        body {
            min-height: 100vh;
            color: white;
            overflow-x: hidden;

            background: radial-gradient(circle at top, #1a1a1a, #000);
        }

        /* soft glow background */
        body::before {
            content: "";
            position: fixed;
            inset: 0;
            background:
                radial-gradient(circle at 20% 20%, rgba(56, 189, 248, 0.15), transparent 40%),
                radial-gradient(circle at 80% 10%, rgba(192, 132, 252, 0.12), transparent 40%),
                radial-gradient(circle at 50% 90%, rgba(34, 197, 94, 0.10), transparent 50%);
            pointer-events: none;
        }

        /* TOPBAR */
        .topbar {
            position: fixed;
            top: 0;
            width: 100%;
            padding: 16px 34px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(10, 10, 10, 0.6);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            z-index: 1000;
        }

        .brand {
            font-size: 1.3rem;
            font-weight: 900;
            background: linear-gradient(to right, #fff, #aaa);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .auth a {
            text-decoration: none;
            color: white;
            padding: 10px 14px;
            margin-left: 10px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.12);
            transition: 0.3s;
        }

        .auth a:hover {
            transform: translateY(-2px);
            border-color: rgba(255, 255, 255, 0.3);
        }

        /* MAIN */
        .container {
            max-width: 1300px;
            margin: auto;
            padding: 140px 20px 70px;
            text-align: center;
        }

        h1 {
            font-size: 3.2rem;
            font-weight: 900;
            margin-bottom: 10px;
            background: linear-gradient(to right, #fff, #999);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .subtitle {
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 50px;
            font-size: 1.05rem;
        }

        /* GRID */
        .grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 22px;
        }

        @media (max-width: 1100px) {
            .grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 650px) {
            .grid {
                grid-template-columns: 1fr;
            }
        }

        /* CARD BASE */
        .card {
            position: relative;
            padding: 24px;
            border-radius: 22px;
            text-align: left;

            border: 1px solid rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(14px);

            transition: 0.3s ease;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-10px) scale(1.02);
            border-color: rgba(255, 255, 255, 0.35);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
        }

        /* COLOR CARDS */
        .blue {
            background: linear-gradient(135deg, rgba(56, 189, 248, 0.18), rgba(255, 255, 255, 0.03));
        }

        .green {
            background: linear-gradient(135deg, rgba(34, 197, 94, 0.18), rgba(255, 255, 255, 0.03));
        }

        .yellow {
            background: linear-gradient(135deg, rgba(250, 204, 21, 0.18), rgba(255, 255, 255, 0.03));
        }

        .purple {
            background: linear-gradient(135deg, rgba(192, 132, 252, 0.18), rgba(255, 255, 255, 0.03));
        }

        .red {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.18), rgba(255, 255, 255, 0.03));
        }

        .pink {
            background: linear-gradient(135deg, rgba(236, 72, 153, 0.18), rgba(255, 255, 255, 0.03));
        }

        .cyan {
            background: linear-gradient(135deg, rgba(6, 182, 212, 0.18), rgba(255, 255, 255, 0.03));
        }

        .orange {
            background: linear-gradient(135deg, rgba(251, 146, 60, 0.18), rgba(255, 255, 255, 0.03));
        }

        /* TEXT */
        .card h3 {
            font-size: 1.3rem;
            font-weight: 800;
            margin-bottom: 6px;
        }

        .card p {
            color: rgba(255, 255, 255, 0.75);
            font-size: 0.95rem;
            margin-bottom: 18px;
            line-height: 1.5;
        }

        /* BUTTON */
        .enter {
            display: inline-block;
            padding: 10px 14px;
            border-radius: 14px;
            text-decoration: none;
            color: white;
            font-weight: 700;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.15);
            transition: 0.3s;
        }

        .enter:hover {
            transform: translateY(-2px);
            border-color: white;
        }

        /* glow dot */
        .card::after {
            content: "";
            position: absolute;
            top: -40px;
            right: -40px;
            width: 120px;
            height: 120px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.25), transparent 70%);
            opacity: 0.6;
        }

        .tag {
            margin-top: 50px;
            color: rgba(255, 255, 255, 0.5);
        }
    </style>
</head>

<body>

    <div class="topbar">
        <div class="brand">HobbyHub</div>

        <div class="auth">
            <a href="login.html">Log In</a>
            <a href="signup.html">Sign Up</a>
        </div>
    </div>

    <div class="container">

        <h1>Active Hobby Clubs</h1>

        <div class="subtitle">
            Join communities built around creativity, skill, and competition.
        </div>

        <div class="grid">

            <?php while ($club = $result->fetch_assoc()) { ?>

                <div class="card <?php echo $club['color_class']; ?>">

                    <h3><?php echo $club['name']; ?></h3>

                    <p><?php echo $club['description']; ?></p>

                    <a class="enter" href="<?php echo $club['page_link']; ?>">
                        Enter Club
                    </a>

                </div>

            <?php } ?>

        </div>

        <div class="tag">
            More clubs unlock as the community grows.
        </div>

    </div>

</body>

</html>