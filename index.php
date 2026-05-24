<?php
if (session_status() === PHP_SESSION_NONE) {
    session_name("HOBBYHUB_SESSION");
    session_start();
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

include "db.php";

/* =========================
   SUBDOMAIN ROUTING LOGIC
   ========================= */

$host = $_SERVER['HTTP_HOST'];
$parts = explode('.', $host);

$subdomain = null;

if (count($parts) >= 3) {
    $subdomain = $parts[0];
}

if ($subdomain && $subdomain !== "www" && $subdomain !== "vishthefishjr") {

    $clubPath = __DIR__ . "/clubs/" . $subdomain . "/index.php";

    if (file_exists($clubPath)) {
        include $clubPath;
        exit;
    } else {
        header("Location: /index.php");
        exit;
    }
}

/* LOGIN CHECK */
if (!isset($_SESSION["user"])) {
    header("Location: discoverypage.php");
    exit;
}

/* GET CLUBS */
$sql = "SELECT * FROM clubs";
$result = $conn->query($sql);

/* slugify helper for image filenames */
function slugify($text)
{
    $text = strtolower(trim($text));
    return preg_replace('/[^a-z0-9]+/', '', $text);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>HobbyHub</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Inter;
        }

        body {
            background: linear-gradient(rgba(16, 19, 26, 0.35), rgba(16, 19, 26, 0.5)),
                url("/images/indexlanding.png");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: white;
            min-height: 100vh;
        }

        .topbar {
            position: fixed;
            width: 100%;
            padding: 18px 34px;
            display: flex;
            justify-content: space-between;
            background: #10131add;
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .brand {
            font-weight: 900;
            font-size: 1.5rem;
        }

        .auth a {
            margin-left: 10px;
            padding: 10px 16px;
            background: #1d2635;
            border-radius: 12px;
            text-decoration: none;
            color: white;
        }

        .container {
            padding: 140px 30px;
            max-width: 1400px;
            margin: auto;
            text-align: center;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
            text-align: left;
        }

        @media(max-width:1000px) {
            .grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media(max-width:600px) {
            .grid {
                grid-template-columns: 1fr;
            }
        }

        .card {
            background: rgba(26, 34, 51, 0.72);
            border-radius: 24px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .club-image {
            width: 100%;
            height: 240px;
            object-fit: cover;
            background: #131b2a;
        }

        .content {
            padding: 20px;
        }

        .enter {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 14px;
            background: #338bff;
            border-radius: 10px;
            color: white;
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

        <h1>Welcome, <?= htmlspecialchars($_SESSION["user"]) ?></h1>

        <div class="grid">

            <?php while ($club = $result->fetch_assoc()) { ?>

                <?php
                $slug = slugify($club["name"]);
                $imagePath = "/images/" . $slug . ".jpg";

                if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $imagePath)) {
                    $imagePath = "/images/default.jpg";
                }

                $clubUrl = trim($club["page_link"]);
                if (!preg_match('/^https?:\/\//i', $clubUrl)) {
                    $clubUrl = "https://" . $clubUrl . ".vishthefishjr.me";
                }
                ?>

                <div class="card">

                    <img class="club-image" src="<?= htmlspecialchars($imagePath) ?>">

                    <div class="content">
                        <h3><?= htmlspecialchars($club["name"]) ?></h3>
                        <p><?= htmlspecialchars($club["description"]) ?></p>

                        <a class="enter" href="<?= htmlspecialchars($clubUrl) ?>">
                            Enter Club
                        </a>
                    </div>

                </div>

            <?php } ?>

        </div>

    </div>

</body>

</html>