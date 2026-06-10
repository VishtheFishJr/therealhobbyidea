<?php
// Session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// DB
require_once __DIR__ . "/db.php";
?>