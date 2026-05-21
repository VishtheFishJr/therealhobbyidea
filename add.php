<?php
session_start();

include "db.php";

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name =
        trim($_POST["name"]);

    $description =
        trim($_POST["description"]);

    $page =
        trim($_POST["page_link"]);

    $image =
        "images/default.jpg";

    $stmt =
        $conn->prepare(
            "INSERT INTO clubs
(name, description, page_link, image)
VALUES (?, ?, ?, ?)"
        );

    $stmt->bind_param(
        "ssss",
        $name,
        $description,
        $page,
        $image
    );

    if ($stmt->execute()) {

        header("Location: index.php");
        exit;

    }

    $message =
        "Failed to create club.";

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

            min-height: 100vh;

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

            margin-top: 10px;

            margin-bottom: 20px;

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

            background:
                linear-gradient(90deg,
                    #338bff,
                    #4eb0ff);

            color: white;

            cursor: pointer;

        }

        .note {

            margin-bottom: 20px;

            color: #9ca3af;

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

            Admin will add an image soon.

        </div>

                <?php if ($message) { ?>

            <div class="error">

                                <?php echo $message; ?>

            </div>

                <?php } ?>

        <form method="POST">

            <input name="name" placeholder="Club Name" required>

            <textarea name="description" placeholder="Club Description" required></textarea>

            <input name="page_link" placeholder="clubpage.php" required>

            <button type="submit">

                Create Club

            </button>

        </form>

    </div>

</body>

</html>