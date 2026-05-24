<?php
if (session_status() === PHP_SESSION_NONE) {
    session_name("HOBBYHUB_SESSION");
    session_set_cookie_params([
        "lifetime" => 0,
        "path" => "/",
        "domain" => ".vishthefishjr.me",
        "secure" => false,
        "httponly" => false
    ]);

    session_start();
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

include "db.php";

/* =========================
   SUBDOMAIN ROUTING LOGIC
   ========================= */

$host = $_SERVER['HTTP_HOST']; // guitar.vishthefishjr.me
$parts = explode('.', $host);

/* detect subdomain */
$subdomain = null;

if (count($parts) >= 3) {
    $subdomain = $parts[0];
}

/* if subdomain exists and not main site */
if ($subdomain && $subdomain !== "www" && $subdomain !== "vishthefishjr") {

    $clubPath = __DIR__ . "/clubs/" . $subdomain . "/index.php";

    if (file_exists($clubPath)) {
        include $clubPath;
        exit;
    } else {
        // optional: show 404 or redirect
        header("Location: /index.php");
        exit;
    }
}

/* =========================
   FORCE LOGIN (MAIN SITE ONLY)
   ========================= */

if (!isset($_SESSION["user"])) {
    header("Location: discoverypage.php");
    exit;
}

/* ADMIN DELETE */
if (
    isset($_GET["delete"]) &&
    isset($_SESSION["role"]) &&
    $_SESSION["role"] === "admin"
) {

    $id = intval($_GET["delete"]);

    /* get slug first */
    $stmt = $conn->prepare("SELECT page_link FROM clubs WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($club = $result->fetch_assoc()) {
        $slug = basename($club["page_link"]);

        /* delete db row */
        $delete = $conn->prepare("DELETE FROM clubs WHERE id=?");
        $delete->bind_param("i", $id);
        $delete->execute();

        /* delete folder */
        $dir = "/var/www/html/clubs/" . $slug;

        if (is_dir($dir)) {
            foreach (glob("$dir/*") as $file) {
                unlink($file);
            }
            rmdir($dir);
        }
    }

    header("Location: index.php");
    exit;
}

/* JOIN CLUB */
if (isset($_GET["join"]) && isset($_SESSION["user"])) {
    $userStmt = $conn->prepare("SELECT id FROM users WHERE username=?");
    $userStmt->bind_param("s", $_SESSION["user"]);
    $userStmt->execute();
    $userId = $userStmt->get_result()->fetch_assoc()["id"];

    $clubId = intval($_GET["join"]);
    $join = $conn->prepare("INSERT IGNORE INTO user_clubs (user_id, club_id) VALUES (?,?)");
    $join->bind_param("ii", $userId, $clubId);
    $join->execute();

    header("Location: myclubs.php");
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

            overflow-x: hidden;
        }

        .topbar {

            position: fixed;

            top: 0;
            left: 0;

            width: 100%;

            padding: 10px 34px;

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

            transition: .2s;

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

            color: #000000ff;

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
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .content h3 {

            font-size: 1.45rem;

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

        .enter,
        .remove {

            flex: 1;

            text-align: center;

            padding: 12px;

            border-radius: 12px;

            text-decoration: none;

            font-weight: 800;

            color: white;

        }

        .enter {

            background:
                linear-gradient(90deg,
                    #338bff,
                    #4eb0ff);

        }

        .remove {

            background:
                linear-gradient(90deg,
                    #d92b2b,
                    #ff6363);

        }

        .enter:hover,
        .remove:hover {

            transform:
                translateY(-2px);

        }

        .tag {

            margin-top: 60px;

            color: #7d8697;

        }

        .add-club {

            display: inline-block;

            margin-top: 30px;

            padding: 14px 26px;

            border-radius: 14px;

            text-decoration: none;

            font-weight: 900;

            color: white;

            background:
                linear-gradient(90deg,
                    #338bff,
                    #4eb0ff);

        }
    </style>

</head>

<body>

    <div class="topbar">

        <div class="brand">

            HobbyHub

        </div>

        <div class="auth">

            <a href="myclubs.php">

                My Clubs

            </a>

            <a href="logout.php">

                Logout

            </a>

        </div>

    </div>

    <div class="container">

        <h1>

            Welcome to HobbyHub,

            <?php
            echo htmlspecialchars(
                $_SESSION["user"]
            );
            ?>

        </h1>

        <div class="subtitle">

            Join communities built around creativity,
            skill, and competition.

        </div>

        <div class="grid">

            <?php while (
                $club =
                $result->fetch_assoc()
            ) {

                $image =
                    !empty(
                    $club["image"]
                )

                    ?

                    $club["image"]

                    :

                    "images/default.jpg";

                ?>

                <div class="card">

                    <img class="club-image" src="<?php
                    echo htmlspecialchars(
                        $image
                    );
                    ?>" alt="Club">

                    <div class="content">

                        <h3>

                            <?php
                            echo htmlspecialchars(
                                $club["name"]
                            );
                            ?>

                        </h3>

                        <p>

                            <?php
                            echo htmlspecialchars(
                                $club["description"]
                            );
                            ?>

                        </p>

                        <div class="button-row">

                            <?php
                            $clubUrl = trim($club["page_link"]);

                            /* Generate subdomain if slug stored */
                            if (!preg_match('/^https?:\/\//i', $clubUrl)) {
                                $clubUrl = "https://" . $clubUrl . ".vishthefishjr.me";
                            }
                            ?>

                            <a class="enter" href="<?= htmlspecialchars($clubUrl) ?>">
                                Explore Club
                            </a>

                            <?php
                            if (
                                isset(
                                $_SESSION["role"]
                            )

                                &&

                                $_SESSION["role"]
                                ===

                                "admin"
                            ) {
                                ?>

                                <a class="remove" href="index.php?delete=<?php
                                echo $club["id"];
                                ?>" onclick="return confirm('Delete this club?')">

                                    Remove Club

                                </a>

                            <?php } ?>

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