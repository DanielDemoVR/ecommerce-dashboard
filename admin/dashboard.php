<?php
// Admin dashboard page
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

echo '<h2>Admin Dashboard</h2>'; 