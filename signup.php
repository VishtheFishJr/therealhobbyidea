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

<head>
    <title>Sign Up - HobbyHub</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            background: #10131a;
            color: white;
            font-family: Inter;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .box {
            background: #1a2233;
            padding: 30px;
            border-radius: 16px;
            width: 320px;
        }

        input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 10px;
            border: none;
            background: #0f1420;
            color: white;
        }

        button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 10px;
            background: #4eb0ff;
            color: white;
            font-weight: 700;
            cursor: pointer;
        }

        .msg {
            margin-top: 10px;
            color: #9ca3af;
            font-size: 0.9rem;
        }

        a {
            color: #8fcfff;
            text-decoration: none;
        }
    </style>
</head>

<body>

    <div class="box">
        <h2>Sign Up</h2>

        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Create Account</button>
        </form>

        <div class="msg">
            <?php echo $message; ?>
        </div>

        <p style="margin-top:10px;">
            <a href="login.php">Already have an account?</a>
        </p>
    </div>

</body>

</html>