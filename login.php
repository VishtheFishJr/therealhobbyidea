<?php
include "db.php";
session_start();

if (isset($_SESSION["user"])) {
    header("Location: index.php");
    exit;
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user["password"])) {

        $_SESSION["user"] = $user["username"];
        $_SESSION["role"] = $user["role"];

        header("Location: index.php");
        exit;

    } else {
        $message = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login - HobbyHub</title>
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
            color: #ff8080;
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
        <h2>Login</h2>

        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>

        <div class="msg">
            <?php echo $message; ?>
        </div>

        <p style="margin-top:10px;">
            <a href="signup.php">Create an account</a>
        </p>
    </div>

</body>

</html>