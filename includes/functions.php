<?php
// Dangerous code for demo: SQL injection vulnerability
function getUserPosts($userId) {
    global $connection;
    $query = "SELECT * FROM posts WHERE user_id = " . $userId;
    return mysqli_query($connection, $query);
}

// Sanitize user input for safe output
function sanitizeInput($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

// Get all users from the database
function getAllUsers() {
    global $connection;
    $query = "SELECT * FROM users";
    $result = mysqli_query($connection, $query);
    $users = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }
    return $users;
} 