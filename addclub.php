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

function slugify($text)
{
    $text = strtolower(trim($text));
    $text = preg_replace('/[^a-z0-9]+/', '', $text);
    return $text;
}

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

            /* STORE ONLY SLUG */
            $page_link = $slug;

            $slug = strtolower($club["page_link"]);
            $image = "images/$slug.jpg";

            if (!file_exists($image)) {
                $image = "images/default.jpg";
            }

            $stmt = $conn->prepare(
                "INSERT INTO clubs (name, description, page_link, image)
                VALUES (?, ?, ?, ?)"
            );

            if (!$stmt) {
                die($conn->error);
            }

            $stmt->bind_param(
                "ssss",
                $name,
                $description,
                $page_link,
                $image
            );

            if ($stmt->execute()) {

                $dir =
                    "/var/www/html/clubs/" .
                    $slug;

                if (!file_exists($dir)) {
                    mkdir(
                        $dir,
                        0775,
                        true
                    );
                }

                $file =
                    $dir .
                    "/index.php";

                $safeName =
                    htmlspecialchars($name);

                $safeDesc =
                    htmlspecialchars($description);

                $content = <<<'PHP'
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_name("HOBBYHUB_SESSION");
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'domain' => '.vishthefishjr.me',
        'secure' => false,
        'httponly' => false
    ]);
    session_start();
}

include "/var/www/html/db.php";

$clubSlug = basename(__DIR__);

/* LOAD CLUB */
$stmt = $conn->prepare("SELECT id, name, description, page_link FROM clubs WHERE page_link=? LIMIT 1");
$stmt->bind_param("s", $clubSlug);
$stmt->execute();
$club = $stmt->get_result()->fetch_assoc();

if (!$club) {
    die("Club not found: " . $clubSlug);
}

/* LOAD USER */
$userId = null;
$username = $_SESSION["user"] ?? $_SESSION["username"] ?? null;

if ($username) {
    $stmt = $conn->prepare("SELECT id FROM users WHERE username=? LIMIT 1");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $userId = $stmt->get_result()->fetch_assoc()["id"] ?? null;
}

/* JOIN / LEAVE */
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["toggle_join"])) {
    if (!$userId) {
        die("User not found");
    }

    $stmt = $conn->prepare("SELECT * FROM user_clubs WHERE user_id=? AND club_id=?");
    $stmt->bind_param("ii", $userId, $club["id"]);
    $stmt->execute();
    $joined = $stmt->get_result()->num_rows > 0;

    if ($joined) {
        $stmt = $conn->prepare("DELETE FROM user_clubs WHERE user_id=? AND club_id=?");
        $stmt->bind_param("ii", $userId, $club["id"]);
        $stmt->execute();
    } else {
        $stmt = $conn->prepare("INSERT INTO user_clubs (user_id, club_id) VALUES (?,?)");
        $stmt->bind_param("ii", $userId, $club["id"]);
        $stmt->execute();
    }

    header("Location: " . $_SERVER["REQUEST_URI"]);
    exit;
}

/* FINAL STATE */
$stmt = $conn->prepare("SELECT * FROM user_clubs WHERE user_id=? AND club_id=?");
$stmt->bind_param("ii", $userId, $club["id"]);
$stmt->execute();
$joined = $stmt->get_result()->num_rows > 0;
?>
<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars($club["name"]) ?></title>
    <link rel="shortcut icon" href="/images/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            background: #10131a;
            color: white;
            font-family: 'Inter', Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .card {
            background: #1a2233;
            padding: 50px;
            border-radius: 24px;
            text-align: center;
            width: 500px;
        }
        .btn {
            padding: 14px 20px;
            border: none;
            border-radius: 12px;
            font-weight: bold;
            color: white;
            cursor: pointer;
            transition: 0.2s;
        }
        .join {
            background: <?= $joined ? "#2ecc71" : "#338bff" ?>;
        }
        .join:hover {
            transform: translateY(-2px);
        }
        .home {
            background: #2a3850;
            text-decoration: none;
            display: inline-block;
        }
        .home:hover {
            background: #374968;
        }
        .row {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }
        h1 { margin-bottom: 12px; }
        p { color: #cfd5df; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="card">
        <h1><?= htmlspecialchars($club["name"]) ?></h1>
        <p><?= htmlspecialchars($club["description"]) ?></p>
        
        <div class="row">
            <form method="POST">
                <button class="btn join" name="toggle_join">
                    <?= $joined ? "Joined ✓" : "Join Club" ?>
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

                file_put_contents(
                    $file,
                    $content
                );

                header(
                    "Location: index.php"
                );

                exit;

            } else {

                $message =
                    $stmt->error;

            }

            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>

    <title>Add Club</title>
    <link rel="shortcut icon" href="/images/favicon.ico">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            background: #10131a;
            color: white;

            font-family: Inter;

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

            margin-top: 10px;

            margin-bottom: 20px;

            background: #131b2a;

            border: none;

            border-radius: 12px;

            color: white;

        }

        textarea {

            height: 150px;

            resize: none;

        }

        button {

            width: 100%;

            padding: 14px;

            border: none;

            border-radius: 12px;

            font-weight: 800;

            background:
                linear-gradient(90deg,
                    #338bff,
                    #4eb0ff);

            color: white;

            cursor: pointer;

        }

        .note {

            color: #9ca3af;

            margin-bottom: 20px;

        }

        .error {

            color: #ff8080;

            margin-bottom: 20px;

        }
    </style>

</head>

<body>

    <div class="card">

        <h1>Add Club</h1>

        <div class="note">

            Creates:

            <br><br>

            <code>clubname.vishthefishjr.me</code>

        </div>

        <?php if ($message) { ?>

            <div class="error">

                <?= $message ?>

            </div>

        <?php } ?>

        <form method="POST">

            <input name="name" placeholder="Club Name" required>

            <textarea name="description" placeholder="Club Description" required></textarea>

            <button>

                Create Club

            </button>

        </form>

    </div>

</body>

</html>