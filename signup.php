<?php
include "db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    if (!empty($username) && !empty($password)) {

        // Check if username already exists
        $check = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $check->bind_param("s", $username);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {
            $message = "Username already taken.";
        } else {

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $role = "user";

            $sql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $username, $hashedPassword, $role);

            if ($stmt->execute()) {
                $message = "Account created! You can now log in.";
            } else {
                $message = "Error creating account.";
            }
        }

    } else {
        $message = "Please fill all fields.";
    }
}
?>

<!DOCTYPE html>
<html>


</html>