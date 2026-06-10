<?php
include "session.php";

$currentUsername = $_SESSION["user"];

$stmt = $conn->prepare("SELECT id FROM users WHERE username=?");
$stmt->bind_param("s", $currentUsername);
$stmt->execute();
$currentUserId = $stmt->get_result()->fetch_assoc()["id"];

$users = $conn->prepare("
    SELECT id, username
    FROM users
    WHERE id != ?
    ORDER BY username
");
$users->bind_param("i", $currentUserId);
$users->execute();
$userList = $users->get_result();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Messages</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            height: 100vh;
        }

        .sidebar {
            width: 250px;
            border-right: 1px solid #ddd;
            overflow-y: auto;
        }

        .user {
            padding: 15px;
            cursor: pointer;
            border-bottom: 1px solid #eee;
        }

        .user:hover {
            background: #f5f5f5;
        }

        .chat {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        #messages {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
        }

        .message {
            margin-bottom: 10px;
        }

        .you {
            text-align: right;
        }

        .input {
            display: flex;
            border-top: 1px solid #ddd;
        }

        .input input {
            flex: 1;
            padding: 12px;
            border: none;
        }

        .input button {
            width: 120px;
        }
    </style>
</head>

<body>

    <div class="sidebar">

        <?php while ($user = $userList->fetch_assoc()): ?>

            <div class="user" onclick="openChat(<?= $user['id'] ?>)">
                <?= htmlspecialchars($user['username']) ?>
            </div>

        <?php endwhile; ?>

    </div>

    <div class="chat">

        <div id="messages">
            Select a user
        </div>

        <div class="input">
            <input type="text" id="message">
            <button onclick="sendMessage()">Send</button>
        </div>

    </div>

    <script>

        let selectedUser = null;

        function openChat(userId) {
            selectedUser = userId;
            loadMessages();
        }

        function loadMessages() {

            if (!selectedUser) return;

            fetch("load_messages.php?user=" + selectedUser)
                .then(r => r.text())
                .then(html => {
                    document.getElementById("messages").innerHTML = html;
                    document.getElementById("messages").scrollTop =
                        document.getElementById("messages").scrollHeight;
                });
        }

        function sendMessage() {

            if (!selectedUser) return;

            let msg = document.getElementById("message").value;

            fetch("send_message.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body:
                    "receiver=" + selectedUser +
                    "&message=" + encodeURIComponent(msg)
            })
                .then(() => {
                    document.getElementById("message").value = "";
                    loadMessages();
                });
        }

        setInterval(loadMessages, 2000);

        document.getElementById("message").addEventListener("keypress", function (e) {
            if (e.key === "Enter") {
                sendMessage();
            }
        });

    </script>

</body>

</html>