<?php

function parseCSVFile($filename) {
    $data = [];
    if (($handle = fopen($filename, "r")) !== FALSE) {
        $headers = null;
        while (($line = fgets($handle)) !== FALSE) {
            $line = trim($line);
            if (empty($line) || $line[0] === '#') {
                continue;
            }
            if ($headers === null) {
                $headers = str_getcsv($line);
            } else {
                $row = str_getcsv($line);
                if (count($row) === count($headers) && !empty($row[0])) {
                    $data[] = array_combine($headers, $row);
                }
            }
        }
        fclose($handle);
    }
    return $data;
}

function getUserAnalytics() {
    $usersFile = __DIR__ . '/../data/users.csv';
    $users = parseCSVFile($usersFile);
    
    $analytics = [
        'total_users' => count($users),
        'users_by_domain' => [],
        'recent_activity' => []
    ];
    
    foreach ($users as $user) {
        if (isset($user['email']) && !empty($user['email'])) {
            $domain = substr(strrchr($user['email'], "@"), 1);
            if (!isset($analytics['users_by_domain'][$domain])) {
                $analytics['users_by_domain'][$domain] = 0;
            }
            $analytics['users_by_domain'][$domain]++;
        }
    }
    
    return $analytics;
}

function getPostAnalytics() {
    $postsFile = __DIR__ . '/../data/posts.json';
    $posts = [];
    
    if (file_exists($postsFile)) {
        $jsonContent = file_get_contents($postsFile);
        $posts = json_decode($jsonContent, true) ?: [];
    }
    
    $analytics = [
        'total_posts' => count($posts),
        'posts_by_user' => []
    ];
    
    foreach ($posts as $post) {
        if (isset($post['user_id'])) {
            $userId = $post['user_id'];
            if (!isset($analytics['posts_by_user'][$userId])) {
                $analytics['posts_by_user'][$userId] = 0;
            }
            $analytics['posts_by_user'][$userId]++;
        }
    }
    
    return $analytics;
}

function generateAnalyticsReport() {
    $userAnalytics = getUserAnalytics();
    $postAnalytics = getPostAnalytics();
    
    return [
        'users' => $userAnalytics,
        'posts' => $postAnalytics,
        'generated_at' => date('Y-m-d H:i:s')
    ];
}
