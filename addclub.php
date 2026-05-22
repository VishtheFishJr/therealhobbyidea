<?php
session_start();

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

            $image = "images/default.jpg";

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

                $content = <<<PHP
<!DOCTYPE html>
<html>
<head>

<title>{$safeName}</title>

<style>

body{
margin:0;
font-family:Inter,sans-serif;
background:#10131a;
color:white;

display:flex;

justify-content:center;

align-items:center;

height:100vh;

}

.card{

background:#1a2233;

padding:40px;

border-radius:24px;

text-align:center;

max-width:600px;

}

a{

display:inline-block;

margin-top:24px;

padding:12px 20px;

background:#338bff;

color:white;

text-decoration:none;

border-radius:12px;

}

</style>

</head>

<body>

<div class="card">

<h1>{$safeName}</h1>

<p>{$safeDesc}</p>

<a href="https://vishthefishjr.me/index.php">
Back to Home
</a>

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