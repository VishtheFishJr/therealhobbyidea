<?php
require_once __DIR__ . "/bootstrap.php";

if (!isset($_SESSION["user"])) {
    header("Location: /discoverypage.php");
    exit;
}
?>