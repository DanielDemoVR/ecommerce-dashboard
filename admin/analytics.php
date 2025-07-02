<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

include '../includes/header.php';
include '../includes/analytics.php';

$report = generateAnalyticsReport();
?>

<div class="container">
    <h2>Analytics Dashboard</h2>
    
    <div class="analytics-grid">
        <div class="analytics-card">
            <h3>User Statistics</h3>
            <div class="stat-item">
                <span class="stat-label">Total Users:</span>
                <span class="stat-value"><?php echo $report['users']['total_users']; ?></span>
            </div>
            
            <h4>Users by Email Domain</h4>
            <?php if (!empty($report['users']['users_by_domain'])): ?>
                <div class="domain-stats">
                    <?php foreach ($report['users']['users_by_domain'] as $domain => $count): ?>
                        <div class="domain-item">
                            <span class="domain-name"><?php echo htmlspecialchars($domain); ?></span>
                            <span class="domain-count"><?php echo $count; ?> user(s)</span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>No email domain data available</p>
            <?php endif; ?>
        </div>
        
        <div class="analytics-card">
            <h3>Content Statistics</h3>
            <div class="stat-item">
                <span class="stat-label">Total Posts:</span>
                <span class="stat-value"><?php echo $report['posts']['total_posts']; ?></span>
            </div>
            
            <h4>Posts by User</h4>
            <?php if (!empty($report['posts']['posts_by_user'])): ?>
                <div class="user-posts-stats">
                    <?php foreach ($report['posts']['posts_by_user'] as $userId => $count): ?>
                        <div class="user-posts-item">
                            <span class="user-id">User ID <?php echo htmlspecialchars($userId); ?>:</span>
                            <span class="posts-count"><?php echo $count; ?> post(s)</span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>No post data available</p>
            <?php endif; ?>
        </div>
        
        <div class="analytics-card">
            <h3>Data Sources</h3>
            <div class="data-source">
                <strong>Users CSV:</strong> /data/users.csv
            </div>
            <div class="data-source">
                <strong>Posts JSON:</strong> /data/posts.json
            </div>
            <div class="report-timestamp">
                <small>Report generated: <?php echo $report['generated_at']; ?></small>
            </div>
        </div>
    </div>
    
    <div class="analytics-actions">
        <a href="dashboard.php" class="btn">Back to Dashboard</a>
        <a href="analytics.php" class="btn btn-primary">Refresh Analytics</a>
    </div>
</div>

<style>
.analytics-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    margin: 20px 0;
}

.analytics-card {
    background: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.analytics-card h3 {
    margin-top: 0;
    color: #333;
    border-bottom: 2px solid #007cba;
    padding-bottom: 10px;
}

.analytics-card h4 {
    margin: 15px 0 10px 0;
    color: #555;
}

.stat-item {
    display: flex;
    justify-content: space-between;
    margin: 10px 0;
    padding: 10px;
    background: white;
    border-radius: 4px;
}

.stat-label {
    font-weight: bold;
    color: #666;
}

.stat-value {
    font-size: 1.2em;
    font-weight: bold;
    color: #007cba;
}

.domain-stats, .user-posts-stats {
    background: white;
    border-radius: 4px;
    padding: 10px;
}

.domain-item, .user-posts-item {
    display: flex;
    justify-content: space-between;
    padding: 5px 0;
    border-bottom: 1px solid #eee;
}

.domain-item:last-child, .user-posts-item:last-child {
    border-bottom: none;
}

.domain-name, .user-id {
    color: #333;
}

.domain-count, .posts-count {
    color: #007cba;
    font-weight: bold;
}

.data-source {
    margin: 10px 0;
    padding: 8px;
    background: white;
    border-radius: 4px;
    font-family: monospace;
}

.report-timestamp {
    margin-top: 15px;
    text-align: center;
    color: #666;
}

.analytics-actions {
    margin-top: 30px;
    text-align: center;
}

.btn {
    display: inline-block;
    padding: 10px 20px;
    margin: 0 10px;
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
</style>
