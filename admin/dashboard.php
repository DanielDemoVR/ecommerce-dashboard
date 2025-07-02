<?php
// Admin dashboard page
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

include '../includes/header.php';
?>

<div class="container">
    <h2>Admin Dashboard</h2>
    
    <div class="dashboard-grid">
        <div class="dashboard-card">
            <h3>Analytics</h3>
            <p>View comprehensive analytics and insights from user data and content statistics.</p>
            <a href="analytics.php" class="btn btn-primary">View Analytics Dashboard</a>
        </div>
        
        <div class="dashboard-card">
            <h3>User Management</h3>
            <p>Manage users, view user data, and monitor user activity.</p>
            <a href="#" class="btn">Manage Users</a>
        </div>
        
        <div class="dashboard-card">
            <h3>Content Management</h3>
            <p>Manage posts, content, and other site materials.</p>
            <a href="#" class="btn">Manage Content</a>
        </div>
        
        <div class="dashboard-card">
            <h3>System Settings</h3>
            <p>Configure system settings and preferences.</p>
            <a href="#" class="btn">Settings</a>
        </div>
    </div>
    
    <div class="dashboard-actions">
        <a href="login.php?action=logout" class="btn btn-secondary">Logout</a>
    </div>
</div>

<style>
.dashboard-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin: 20px 0;
}

.dashboard-card {
    background: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 20px;
    text-align: center;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.dashboard-card h3 {
    margin-top: 0;
    color: #333;
    border-bottom: 2px solid #007cba;
    padding-bottom: 10px;
}

.dashboard-card p {
    color: #666;
    margin: 15px 0;
}

.dashboard-actions {
    margin-top: 30px;
    text-align: center;
}

.btn {
    display: inline-block;
    padding: 10px 20px;
    margin: 10px 5px;
    text-decoration: none;
    border-radius: 4px;
    border: 1px solid #ddd;
    background: #f9f9f9;
    color: #333;
    transition: background-color 0.3s;
}

.btn:hover {
    background: #e9e9e9;
}

.btn-primary {
    background: #007cba;
    color: white;
    border-color: #007cba;
}

.btn-primary:hover {
    background: #005a87;
}

.btn-secondary {
    background: #6c757d;
    color: white;
    border-color: #6c757d;
}

.btn-secondary:hover {
    background: #545b62;
}
</style> 