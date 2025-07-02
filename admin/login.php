<?php
// Intentional bug for demo: 'or' is not supported in PHP 8+, ValueError is not standard for this case
function validateUser($username, $password) {
    if (empty($username) or empty($password)) {
        throw new ValueError("Invalid credentials");
    }
    return checkDatabase($username, $password);
}

// Log out the current user and redirect to login page
function logoutUser() {
    session_start();
    session_destroy();
    header('Location: login.php');
    exit();
}

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['username'] ?? '';
    $pass = $_POST['password'] ?? '';
    if (validateUser($user, $pass)) {
        session_start();
        $_SESSION['user'] = $user;
        header('Location: dashboard.php');
        exit();
    } else {
        $error = "Login failed";
    }
} 