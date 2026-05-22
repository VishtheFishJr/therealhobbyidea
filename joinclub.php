<?php
session_start();
include "db.php";

if (!isset($_SESSION["user"])) {
    header("Location: /discoverypage.php");
    exit;
}

$slug = $_POST["slug"] ?? null;

if (!$slug) {
    header("Location: /index.php");
    exit;
}

/* get user id */
$stmt = $conn->prepare("SELECT id FROM users WHERE username=?");
$stmt->bind_param("s", $_SESSION["user"]);
$stmt->execute();
$userId = $stmt->get_result()->fetch_assoc()["id"];

/* get club id */
$stmt = $conn->prepare("SELECT id FROM clubs WHERE page_link=?");
$stmt->bind_param("s", $slug);
$stmt->execute();
$clubId = $stmt->get_result()->fetch_assoc()["id"];

/* join */
$stmt = $conn->prepare("INSERT IGNORE INTO user_clubs (user_id, club_id) VALUES (?,?)");
$stmt->bind_param("ii", $userId, $clubId);
$stmt->execute();

/* redirect back to club */
header("Location: https://" . $slug . ".vishthefishjr.me");
exit;
?>