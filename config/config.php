<?php
// Start session first
session_start();

// Root URL Configuration - Change this for different environments
// define('ROOT_URL', 'http://localhost/ms/acit-hackathon/v105'); // For local development
define('ROOT_URL', 'https://development.shahiupendra.com.np/ms/acit-hackathon/v105'); // For production

// Basic configuration
define('SITE_NAME', 'Hackathon System');
define('DATA_PATH', 'assets/data/');
define('USERS_FILE', DATA_PATH . 'users.json');

// Helper functions
function loadJsonData($file) {
    if (file_exists($file)) {
        return json_decode(file_get_contents($file), true) ?: [];
    }
    return [];
}

function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

function getCurrentUser() {
    if (!isLoggedIn()) return null;
    
    $users = loadJsonData(USERS_FILE);
    foreach ($users as $user) {
        if ($user['id'] == $_SESSION['user_id']) {
            return $user;
        }
    }
    return null;
}

function redirect($path) {
    $url = ROOT_URL . $path;
    header('Location: ' . $url);
    exit();
}

function url($path = '') {
    return ROOT_URL . $path;
}
?>