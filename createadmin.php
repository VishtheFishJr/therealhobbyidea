<?php
include "db.php";

$username = "admin";
$password = password_hash("admin123", PASSWORD_DEFAULT);
$role = "admin";

/*
Check if admin already exists to avoid duplicates
*/
$check = $conn->prepare("SELECT id FROM users WHERE username = ?");
$check->bind_param("s", $username);
$check->execute();
$result = $check->get_result();

if ($result->num_rows > 0) {
    die("Admin already exists.");
}

$sql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $username, $password, $role);

if ($stmt->execute()) {
    echo "Admin created successfully.";
} else {
    echo "Error: " . $conn->error;
}
?>