<?php
function checkDatabase($username, $password) {
    include '../includes/analytics.php';
    $users = parseCSVFile('../data/users.csv');
    foreach ($users as $user) {
        if ($user['username'] === $username) {
            return true;
        }
    }
    return false;
}

function validateUser($username, $password) {
    if (empty($username) || empty($password)) {
        return false;
    }
    return checkDatabase($username, $password);
}

function logoutUser() {
    session_start();
    session_destroy();
    header('Location: login.php');
    exit();
}

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    logoutUser();
}

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
?>

<?php include '../includes/header.php'; ?>

<div class="container">
    <h2>Admin Login</h2>
    
    <?php if (isset($error)): ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    
    <form method="POST" action="login.php" class="login-form">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
        </div>
        
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
    
    <div class="demo-info">
        <p><strong>Demo Login:</strong> Use username "admin" with any password</p>
    </div>
</div>

<style>
.login-form {
    max-width: 400px;
    margin: 20px auto;
    padding: 20px;
    background: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 8px;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: #333;
}

.form-group input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
}

.form-group input:focus {
    outline: none;
    border-color: #007cba;
    box-shadow: 0 0 5px rgba(0, 124, 186, 0.3);
}

.error {
    background: #f8d7da;
    color: #721c24;
    padding: 10px;
    border: 1px solid #f5c6cb;
    border-radius: 4px;
    margin-bottom: 15px;
}

.demo-info {
    text-align: center;
    margin-top: 20px;
    padding: 15px;
    background: #d1ecf1;
    border: 1px solid #bee5eb;
    border-radius: 4px;
    color: #0c5460;
}
</style> 