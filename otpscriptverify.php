<?php
session_start();
require_once('includes/db.php');
require_once('session_check.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $enteredOTP = array_map('intval', $_POST['otp']);
    $username = $_SESSION['username'];
    $query = "SELECT otp FROM users WHERE username = ?";
    $stmt = $mysqli->prepare($query);

    if ($stmt) {
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->bind_result($storedOTP);
        $stmt->fetch();
        $stmt->close();

        if (!empty($storedOTP)) {
            $storedOTP = array_map('intval', str_split($storedOTP));

            if ($enteredOTP === $storedOTP) {
                echo '<script>alert("OTP Verified Successfully!");';
                echo 'window.location.href = "admin/dashboard.php";</script>';
                exit();
            } else {
                echo '<script>alert("Incorrect OTP! Please try again.");';
                echo 'window.history.back();</script>';
            }
        } else {
            echo '<script>alert("User not found!");';
            echo 'window.history.back();</script>';
        }
    } else {
        echo '<script>alert("Error in preparing statement!");';
        echo 'window.history.back();</script>';
    }
} else {
    echo '<script>alert("Invalid Request!");';
    echo 'window.history.back();</script>';
}
?>