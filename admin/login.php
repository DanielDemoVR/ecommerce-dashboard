<?php
require_once '../includes/functions.php';

function validateUser($username, $password) {
    if (empty($username) || empty($password)) {
        return false;
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
        $error = "Invalid username or password";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h2>Admin Login</h2>
        
        <?php if (isset($error)): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <form method="POST" action="login.php">
            <div>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
        
        <p>Demo credentials: admin / admin</p>
    </div>
</body>
</html> 