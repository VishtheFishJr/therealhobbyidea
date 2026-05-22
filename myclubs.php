<?php

session_start();

include "db.php";

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET["leave"])) {
    $user = $conn->prepare("SELECT id FROM users WHERE username=?");
    $user->bind_param("s", $_SESSION["user"]);
    $user->execute();
    $userId = $user->get_result()->fetch_assoc()["id"];

    $club = intval($_GET["leave"]);
    $leave = $conn->prepare("DELETE FROM user_clubs WHERE user_id=? AND club_id=?");
    $leave->bind_param("ii", $userId, $club);
    $leave->execute();

    header("Location: myclubs.php");
    exit;
}

$user = $conn->prepare("SELECT id FROM users WHERE username=?");
$user->bind_param("s", $_SESSION["user"]);
$user->execute();
$userId = $user->get_result()->fetch_assoc()["id"];

$stmt = $conn->prepare("SELECT clubs.* FROM clubs JOIN user_clubs ON user_clubs.club_id=clubs.id WHERE user_clubs.user_id=?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html>
<head>
    <title>My Clubs</title>
    <link rel="shortcut icon" href="./favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Inter", sans-serif;
        }

        body {
            background: #10131a;
            color: white;
            padding: 40px;
        }

        .container {
            max-width: 1000px;
            margin: auto;
        }

        h1 {
            font-size: 2.5rem;
            font-weight: 900;
            margin-bottom: 20px;
        }

        .back-link {
            display: inline-block;
            margin-bottom: 40px;
            color: #8fcfff;
            text-decoration: none;
            font-weight: 600;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .card {
            background: #1a2233;
            padding: 24px;
            margin-bottom: 20px;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, .06);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-content h2 {
            font-size: 1.5rem;
            font-weight: 800;
            margin-bottom: 8px;
        }

        .card-content p {
            color: #cfd5df;
        }

        .actions {
            display: flex;
            gap: 12px;
        }

        .actions a {
            padding: 12px 24px;
            background: #338bff;
            color: white;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 700;
            transition: 0.2s;
        }

        .actions a:hover {
            transform: translateY(-2px);
        }

        .actions .leave {
            background: #d92b2b;
        }
    </style>
</head>
<body>

<div class="container">
    <a class="back-link" href="index.php">← Back to Home</a>
    
    <h1>My Clubs</h1>

    <?php if ($result->num_rows === 0) { ?>
        <p>You haven't joined any clubs yet.</p>
    <?php } ?>

    <?php
    while ($c = $result->fetch_assoc()) {
        $link = trim($c["page_link"]);
        if (!preg_match('/^https?:\/\//i', $link)) {
            $link = "https://" . $link . ".vishthefishjr.me";
        }
    ?>
    <div class="card">
        <div class="card-content">
            <h2><?= htmlspecialchars($c["name"]) ?></h2>
            <p><?= htmlspecialchars($c["description"]) ?></p>
        </div>
        <div class="actions">
            <a href="<?= htmlspecialchars($link) ?>">Open</a>
            <a class="leave" href="?leave=<?= $c["id"] ?>">Leave</a>
        </div>
    </div>
    <?php } ?>
</div>

</body>
</html>
