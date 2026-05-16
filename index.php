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

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Inter", sans-serif;
        }

        body {
            min-height: 100vh;
            overflow-x: hidden;
            color: #fff;

            background: linear-gradient(135deg, #0f172a, #1e1b4b, #0ea5e9);
        }

        /* MORE COLORFUL BACKGROUND GLOWS */
        body::before {
            content: "";
            position: fixed;
            inset: 0;

            background:
                radial-gradient(circle at 10% 10%, rgba(255, 0, 128, 0.35), transparent 40%),
                radial-gradient(circle at 80% 20%, rgba(0, 255, 255, 0.25), transparent 40%),
                radial-gradient(circle at 40% 80%, rgba(255, 255, 0, 0.20), transparent 45%),
                radial-gradient(circle at 90% 90%, rgba(0, 255, 100, 0.20), transparent 45%);

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

            background: rgba(10, 10, 20, 0.6);
            backdrop-filter: blur(18px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .brand {
            font-size: 1.4rem;
            font-weight: 900;

            background: linear-gradient(to right, #ff00cc, #00ffff, #ffff00);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .auth a {
            text-decoration: none;
            color: white;
            margin-left: 10px;
            padding: 10px 14px;
            border-radius: 12px;

            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: 0.25s;
        }

        .auth a:hover {
            transform: scale(1.05);
            background: rgba(255, 255, 255, 0.15);
        }

        /* MAIN */
        .container {
            max-width: 1300px;
            margin: auto;
            padding: 140px 20px 70px;
            text-align: center;
        }

        h1 {
            font-size: 3.4rem;
            font-weight: 900;

            background: linear-gradient(to right, #ff4d6d, #4cc9f0, #facc15);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .subtitle {
            margin-top: 10px;
            margin-bottom: 50px;
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.85);
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

        /* CARD */
        .card {
            position: relative;
            padding: 24px;
            border-radius: 24px;

            backdrop-filter: blur(14px);

            border: 1px solid rgba(255, 255, 255, 0.2);

            transition: 0.25s ease;

            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-12px) scale(1.03);
            filter: brightness(1.15);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
        }

        /* BRIGHTER CLASSES */
        .blue {
            background: linear-gradient(135deg, #00c6ff, #0072ff);
        }

        .green {
            background: linear-gradient(135deg, #00f260, #0575e6);
        }

        .yellow {
            background: linear-gradient(135deg, #fceabb, #f8b500);
        }

        .purple {
            background: linear-gradient(135deg, #a18cd1, #fbc2eb);
        }

        .red {
            background: linear-gradient(135deg, #ff416c, #ff4b2b);
        }

        .pink {
            background: linear-gradient(135deg, #ff0099, #493240);
        }

        .cyan {
            background: linear-gradient(135deg, #00dbde, #fc00ff);
        }

        .orange {
            background: linear-gradient(135deg, #f7971e, #ffd200);
        }

        /* TEXT */
        .card h3 {
            font-size: 1.4rem;
            font-weight: 900;
            margin-bottom: 6px;
        }

        .card p {
            font-size: 0.95rem;
            opacity: 0.9;
            margin-bottom: 18px;
        }

        /* BUTTON */
        .enter {
            display: inline-block;
            padding: 11px 16px;
            border-radius: 14px;

            font-weight: 800;
            text-decoration: none;
            color: #fff;

            background: rgba(0, 0, 0, 0.25);
            border: 1px solid rgba(255, 255, 255, 0.25);

            transition: 0.2s;
        }

        .enter:hover {
            background: rgba(0, 0, 0, 0.4);
            transform: scale(1.05);
        }

        /* TAG */
        .tag {
            margin-top: 55px;
            opacity: 0.7;
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
            Join vibrant communities built around creativity, skill, and competition 🚀
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
            New clubs are added constantly — join the movement 🌟
        </div>

    </div>

</body>

</html>