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

function checkDatabase($username, $password) {
    $csvFile = __DIR__ . '/../data/users.csv';
    
    if (!file_exists($csvFile)) {
        return false;
    }
    
    $handle = fopen($csvFile, 'r');
    
    while (($line = fgetcsv($handle)) !== false) {
        if (!empty($line[0]) && $line[0][0] !== '#') {
            break;
        }
    }
    
    while (($row = fgetcsv($handle)) !== false) {
        if (count($row) >= 4) {
            $csvUsername = trim($row[1]);
            $csvPassword = trim($row[3]);
            if ($csvUsername === $username && $csvPassword === $password) {
                fclose($handle);
                return true;
            }
        }
    }
    
    fclose($handle);
    return false;
}       