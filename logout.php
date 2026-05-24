<?php
if (session_status() === PHP_SESSION_NONE) {
    session_name("HOBBYHUB_SESSION");
    session_set_cookie_params([
        "lifetime" => 0,
        "path" => "/",
        "domain" => ".vishthefishjr.me",
        "secure" => false,
        "httponly" => true
    ]);

    session_start();
}
session_unset();
session_destroy();

header("Location: login.php");
exit;
?>