<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "db.php";

/* =========================
   LOAD CLUBS (DATA ONLY)
   ========================= */
$sql = "SELECT id, name, description, page_link FROM clubs";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HobbyHub</title>

    <link rel="shortcut icon" href="/images/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Inter", sans-serif;
        }

        body {
            background:
                linear-gradient(rgba(16, 19, 26, .35),
                    rgba(16, 19, 26, .50)),
                url("/images/indexlanding.png");

            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;

            color: white;
            min-height: 100vh;
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
            border-bottom: 1px solid rgba(255, 255, 255, .08);
            z-index: 1000;
        }

        .brand {
            font-size: 1.5rem;
            font-weight: 900;
            background: linear-gradient(90deg, #fff, #8fcfff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .auth a {
            text-decoration: none;
            color: white;
            padding: 10px 16px;
            border-radius: 12px;
            background: #1d2635;
            margin-left: 12px;
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
            font-size: 3rem;
            font-weight: 900;
            margin-bottom: 12px;
        }

        .subtitle {
            color: #9aa3b2;
            margin-bottom: 60px;
        }

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

        .card {
            background: rgba(26, 34, 51, 0.72);
            border-radius: 24px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            border: 1px solid rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
        }

        .club-image {
            width: 100%;
            height: 250px;
            object-fit: cover;
            background: #131b2a;
        }

        .content {
            padding: 22px;
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .content h3 {
            font-size: 1.4rem;
            font-weight: 900;
            margin-bottom: 10px;
        }

        .content p {
            color: #cfd5df;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .button-row {
            display: flex;
            gap: 10px;
            margin-top: auto;
        }

        .enter {
            flex: 1;
            text-align: center;
            padding: 12px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 800;
            color: white;
            background: linear-gradient(90deg, #338bff, #4eb0ff);
        }

        .enter:hover {
            transform: translateY(-2px);
        }

        .tag {
            margin-top: 60px;
            color: #9aa3b2;
        }

        .add-club {
            display: inline-block;
            margin-top: 30px;
            padding: 14px 26px;
            border-radius: 14px;
            font-weight: 900;
            color: white;
            background: linear-gradient(90deg, #338bff, #4eb0ff);
            text-decoration: none;
        }
    </style>
</head>

<body>

    <div class="topbar">
        <div class="brand">HobbyHub</div>
        <div class="auth">
            <a href="myclubs.php">My Clubs</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <div class="container">

        <h1>Welcome to HobbyHub</h1>

        <div class="subtitle">
            Join communities built around creativity, skill, and competition.
        </div>

        <div class="grid">

            <?php while ($club = $result->fetch_assoc()) {

                $slug = $club["page_link"];

                /* FILE-BASED IMAGE SYSTEM */
                $imagePath = "/images/$slug.jpg";
                $serverPath = $_SERVER['DOCUMENT_ROOT'] . $imagePath;

                if (!file_exists($serverPath)) {
                    $imagePath = "/images/default.jpg";
                }
                ?>

                <div class="card">

                    <img class="club-image" src="<?= htmlspecialchars($imagePath) ?>" alt="Club">

                    <div class="content">

                        <h3><?= htmlspecialchars($club["name"]) ?></h3>

                        <p><?= htmlspecialchars($club["description"]) ?></p>

                        <div class="button-row">

                            <?php
                            $url = $slug . ".vishthefishjr.me";
                            $url = "https://" . $url;
                            ?>

                            <a class="enter" href="<?= htmlspecialchars($url) ?>">
                                Explore Club
                            </a>

                        </div>

                    </div>

                </div>

            <?php } ?>

        </div>

        <div class="tag">
            New clubs are added constantly.
        </div>

        <a class="add-club" href="addclub.php">
            + Add a Club
        </a>

    </div>

</body>

</html>