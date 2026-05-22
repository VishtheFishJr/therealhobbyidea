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

    if (empty($name) || empty($description)) {
        $message = "All fields are required.";
    } else {

        $slug = slugify($name);

        if (empty($slug)) {
            $message = "Invalid club name.";
        } else {

            /* IMPORTANT:
               Store ONLY slug, not full URL */
            $page_link = $slug;

            $image = "images/default.jpg";

            $stmt = $conn->prepare(
                "INSERT INTO clubs (name, description, page_link, image)
                 VALUES (?, ?, ?, ?)"
            );

            if (!$stmt) {
                die("SQL Error: " . $conn->error);
            }

            $stmt->bind_param("ssss", $name, $description, $page_link, $image);

            if ($stmt->execute()) {

                /* Create folder */
                $dir = "/var/www/html/clubs/" . $slug;

                if (!file_exists($dir)) {
                    mkdir($dir, 0775, true);
                }

                /* Create index.php */
                $file = $dir . "/index.php";

                $safeName = htmlspecialchars($name);
                $safeDesc = htmlspecialchars($description);

                $content = "<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<title>$safeName Club</title>
<style>
body {
    margin:0;
    font-family:Arial;
    background:#0f111a;
    color:white;
    display:flex;
    align-items:center;
    justify-content:center;
    height:100vh;
    text-align:center;
}
.box {
    background:#1a2233;
    padding:40px;
    border-radius:20px;
    max-width:500px;
}
a {
    display:inline-block;
    margin-top:20px;
    padding:12px 20px;
    background:#338bff;
    color:white;
    text-decoration:none;
    border-radius:10px;
}
</style>
</head>
<body>

<div class='box'>
    <h1>$safeName Club</h1>
    <p>$safeDesc</p>

    <!-- FIXED HOME LINK -->
    <a href='https://vishthefishjr.me/index.php'>Back to Home</a>
</div>

</body>
</html>";

                file_put_contents($file, $content);

                header("Location: index.php");
                exit;

            } else {
                $message = "Insert failed: " . $stmt->error;
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
            margin: 10px 0 20px;
            padding: 14px;
            background: #131b2a;
            border: none;
            color: white;
            border-radius: 12px;
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
            background: linear-gradient(90deg, #338bff, #4eb0ff);
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
            A subdomain will be created automatically: <br>
            <code>name.vishthefishjr.me</code>
        </div>

                <?php if ($message) { ?>
            <div class="error"><?php echo $message; ?></div>
                <?php } ?>

        <form method="POST">
            <input name="name" placeholder="Club Name" required>
            <textarea name="description" placeholder="Club Description" required></textarea>
            <button type="submit">Create Club</button>
        </form>

    </div>

</body>

</html>