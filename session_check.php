<?php
if (!isset($_SESSION['username'])) {
    header("Location: http://localhost/caaz/index.php");
    exit();
}
?>