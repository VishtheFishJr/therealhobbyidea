<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include "db.php";

$sql = "SELECT * FROM clubs";
$result = $conn->query($sql);

?>

<?php
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
            background:
                radial-gradient(circle at top, rgba(255, 255, 255, 0.08), transparent 35%),
                linear-gradient(to bottom, #090909, #050505 40%, #000000);

            color: #f5f5f5;
            min-height: 100vh;
            overflow-x: hidden;
        }

        body::before {
            content: "";
            position: fixed;
            inset: 0;

            background:
                radial-gradient(circle at 20% 20%, rgba(255, 255, 255, 0.05), transparent 25%),
                radial-gradient(circle at 80% 10%, rgba(255, 255, 255, 0.04), transparent 25%),
                radial-gradient(circle at 50% 100%, rgba(255, 255, 255, 0.03), transparent 35%);

            pointer-events: none;
        }

        .topbar {
            position: fixed;
            top: 0;
            width: 100%;
            padding: 16px 34px;

            display: flex;
            justify-content: space-between;
            align-items: center;

            background: rgba(15, 15, 15, 0.55);

            backdrop-filter: blur(16px);

            border-bottom: 1px solid rgba(255, 255, 255, 0.08);

            z-index: 1000;
        }

        .brand {
            font-size: 1.3rem;
            font-weight: 800;

            letter-spacing: 1px;

            background: linear-gradient(to right, #ffffff, #8e8e8e);

            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .auth {
            display: flex;
            gap: 14px;
        }

        .auth a {
            text-decoration: none;
            color: #e5e5e5;

            padding: 10px 16px;
            border-radius: 12px;

            background: rgba(255, 255, 255, 0.04);

            border: 1px solid rgba(255, 255, 255, 0.1);

            transition: 0.3s ease;
        }

        .container {
            max-width: 1450px;
            margin: auto;

            padding: 140px 40px 70px;

            text-align: center;
        }

        h1 {
            font-size: 3.5rem;
            font-weight: 800;

            margin-bottom: 12px;

            background: linear-gradient(to right, #ffffff, #8f8f8f);

            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .subtitle {
            color: #9ca3af;
            font-size: 1rem;
            margin-bottom: 55px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
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

        .card {
            position: relative;

            background:
                linear-gradient(to bottom,
                    rgba(255, 255, 255, 0.08),
                    rgba(255, 255, 255, 0.03));

            border: 1px solid rgba(255, 255, 255, 0.1);

            border-radius: 24px;

            padding: 26px;

            text-align: left;

            overflow: hidden;

            backdrop-filter: blur(18px);

            transition: 0.35s ease;
        }

        .card:hover {
            transform: translateY(-8px) scale(1.01);

            border-color: rgba(255, 255, 255, 0.25);

            box-shadow:
                0 0 30px rgba(255, 255, 255, 0.08),
                0 0 80px rgba(255, 255, 255, 0.04);
        }

        .card h3 {
            font-size: 1.2rem;
            margin-bottom: 8px;
        }

        .card p {
            color: #b5b5b5;
            font-size: 0.95rem;

            line-height: 1.5;

            margin-bottom: 20px;
        }

        .enter {
            display: inline-block;

            padding: 11px 16px;

            border-radius: 12px;

            text-decoration: none;

            color: white;

            font-weight: 600;

            background: rgba(255, 255, 255, 0.05);

            border: 1px solid rgba(255, 255, 255, 0.12);

            transition: 0.3s ease;
        }

        .blue .enter:hover {
            box-shadow: 0 0 18px #38bdf8;
            border-color: #38bdf8;
        }

        .green .enter:hover {
            box-shadow: 0 0 18px #22c55e;
            border-color: #22c55e;
        }

        .yellow .enter:hover {
            box-shadow: 0 0 18px #facc15;
            border-color: #facc15;
        }

        .purple .enter:hover {
            box-shadow: 0 0 18px #c084fc;
            border-color: #c084fc;
        }

        .red .enter:hover {
            box-shadow: 0 0 18px #ef4444;
            border-color: #ef4444;
        }

        .pink .enter:hover {
            box-shadow: 0 0 18px #ec4899;
            border-color: #ec4899;
        }

        .cyan .enter:hover {
            box-shadow: 0 0 18px #06b6d4;
            border-color: #06b6d4;
        }

        .orange .enter:hover {
            box-shadow: 0 0 18px #fb923c;
            border-color: #fb923c;
        }

        .tag {
            margin-top: 55px;
            color: #71717a;
            font-size: 0.95rem;
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
            Join communities built around real skills, creativity, and competition.
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
            More clubs unlock as the community grows.
        </div>

    </div>

</body>

</html>