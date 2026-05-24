<?php
if (session_status() === PHP_SESSION_NONE) {
    session_name("HOBBYHUB_SESSION");
    session_set_cookie_params([
        "lifetime" => 0,
        "path" => "/",
        "domain" => ".vishthefishjr.me",
        "secure" => false,
        "httponly" => true
    ]);

    session_start();
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

include "db.php";

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}

$message = "";

/* =========================
   SLUG FUNCTION
   ========================= */
function slugify($text)
{
    $text = strtolower(trim($text));
    $text = preg_replace('/[^a-z0-9]+/', '', $text);
    return $text;
}

/* =========================
   CREATE CLUB
   ========================= */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"]);
    $description = trim($_POST["description"]);

    if (!$name || !$description) {
        $message = "All fields are required.";
    } else {

        $slug = slugify($name);

        if (!$slug) {
            $message = "Invalid club name.";
        } else {

            /* FINAL VALUES */
            $page_link = $slug;

            $imagePath = "/images/$slug.jpg";
            $serverPath = $_SERVER['DOCUMENT_ROOT'] . $imagePath;

            if (!file_exists($serverPath)) {
                $imagePath = "/images/default.jpg";
            }

            /* =========================
               INSERT INTO DATABASE
               ========================= */
            $stmt = $conn->prepare("
                INSERT INTO clubs (name, description, page_link, image)
                VALUES (?, ?, ?, ?)
            ");

            if (!$stmt) {
                die($conn->error);
            }

            $stmt->bind_param(
                "ssss",
                $name,
                $description,
                $page_link,
                $imagePath
            );

            if ($stmt->execute()) {

                /* =========================
                   CREATE CLUB FOLDER
                   ========================= */
                $dir = "/var/www/html/clubs/" . $slug;

                if (!file_exists($dir)) {
                    mkdir($dir, 0775, true);
                }

                $file = $dir . "/index.php";

                /* =========================
                   CLUB PAGE TEMPLATE
                   ========================= */
                $content = <<<PHP
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "/var/www/html/db.php";

\$clubSlug = basename(__DIR__);

/* LOAD CLUB */
\$stmt = \$conn->prepare("SELECT * FROM clubs WHERE page_link=? LIMIT 1");
\$stmt->bind_param("s", \$clubSlug);
\$stmt->execute();
\$club = \$stmt->get_result()->fetch_assoc();

if (!\$club) {
    die("Club not found: " . \$clubSlug);
}

/* LOAD USER */
\$userId = null;
\$username = \$_SESSION["user"] ?? null;

if (\$username) {
    \$stmt = \$conn->prepare("SELECT id FROM users WHERE username=? LIMIT 1");
    \$stmt->bind_param("s", \$username);
    \$stmt->execute();
    \$row = \$stmt->get_result()->fetch_assoc();
    \$userId = \$row["id"] ?? null;
}

/* CHECK JOIN */
\$joined = false;

if (\$userId) {
    \$stmt = \$conn->prepare("SELECT 1 FROM user_clubs WHERE user_id=? AND club_id=? LIMIT 1");
    \$stmt->bind_param("ii", \$userId, \$club["id"]);
    \$stmt->execute();
    \$joined = \$stmt->get_result()->num_rows > 0;
}

/* HANDLE JOIN/LEAVE */
if (\$_SERVER["REQUEST_METHOD"] === "POST" && isset(\$_POST["toggle_join"])) {

    if (\$userId) {

        if (\$joined) {
            \$stmt = \$conn->prepare("DELETE FROM user_clubs WHERE user_id=? AND club_id=?");
            \$stmt->bind_param("ii", \$userId, \$club["id"]);
            \$stmt->execute();
        } else {
            \$stmt = \$conn->prepare("INSERT INTO user_clubs (user_id, club_id) VALUES (?, ?)");
            \$stmt->bind_param("ii", \$userId, \$club["id"]);
            \$stmt->execute();
        }

    }

    header("Location: " . \$_SERVER["REQUEST_URI"]);
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title><?= htmlspecialchars(\$club["name"]) ?></title>

<style>
body{
    margin:0;
    background:#10131a;
    color:white;
    font-family:Arial;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}
.card{
    background:#1a2233;
    padding:50px;
    border-radius:24px;
    text-align:center;
    width:500px;
}
.btn{
    padding:14px 20px;
    border:none;
    border-radius:12px;
    font-weight:bold;
    color:white;
    cursor:pointer;
}
.join{
    background:<?= \$joined ? "#2ecc71" : "#338bff" ?>;
}
.home{
    background:#2a3850;
    text-decoration:none;
    display:inline-block;
}
.row{
    display:flex;
    justify-content:center;
    gap:10px;
}
</style>
</head>

<body>

<div class="card">

<h1><?= htmlspecialchars(\$club["name"]) ?></h1>
<p><?= htmlspecialchars(\$club["description"]) ?></p>

<div class="row">

<form method="POST">
<button class="btn join" name="toggle_join">
<?= \$joined ? "Joined ✓" : "Join Club" ?>
</button>
</form>

<a class="btn home" href="https://vishthefishjr.me/index.php">
Back Home
</a>

</div>

</div>

</body>
</html>
PHP;

                file_put_contents($file, $content);

                header("Location: index.php");
                exit;

            } else {
                $message = $stmt->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Add Club</title>

    <style>
        body {
            background: #10131a;
            color: white;
            font-family: Arial;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .card {
            width: 500px;
            background: #1a2233;
            padding: 40px;
            border-radius: 24px;
        }

        input,
        textarea {
            width: 100%;
            padding: 14px;
            margin: 10px 0 20px;
            background: #131b2a;
            border: none;
            border-radius: 12px;
            color: white;
        }

        button {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 12px;
            font-weight: 800;
            background: linear-gradient(90deg, #338bff, #4eb0ff);
            color: white;
            cursor: pointer;
        }

        .error {
            color: #ff8080;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>

    <div class="card">

        <h1>Add Club</h1>

        <?php if ($message): ?>
            <div class="error"><?= $message ?></div>
        <?php endif; ?>

        <form method="POST">
            <input name="name" placeholder="Club Name" required>
            <textarea name="description" placeholder="Club Description" required></textarea>
            <button>Create Club</button>
        </form>

    </div>

</body>

</html>