<?php
session_start();

//unset la session
if (isset($_SESSION["user"])) {
    unset($_SESSION["user"]);
}

session_destroy();

header("Location: connection.php");
exit();
?>
