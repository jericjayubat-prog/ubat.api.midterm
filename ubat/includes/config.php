<?php
// === Count total registered users ===
function count_users() {
    $file = __DIR__ . '/../users.json';
    if (!file_exists($file)) return 0;
    $data = json_decode(file_get_contents($file), true);
    return is_array($data) ? count($data) : 0;
}

// === Global conversion stats ===
function get_stats() {
    $file = __DIR__ . '/../stats.json';
    if (!file_exists($file)) {
        return ['total_conversions' => 0];
    }
    $data = json_decode(file_get_contents($file), true);
    return is_array($data) ? $data : ['total_conversions' => 0];
}

function increment_conversions() {
    $file = __DIR__ . '/../stats.json';
    $stats = get_stats();
    $stats['total_conversions']++;
    file_put_contents($file, json_encode($stats, JSON_PRETTY_PRINT));
}


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('USERS_FILE', __DIR__ . '/../users.json');

// Ensure users.json exists
if (!file_exists(USERS_FILE)) {
    file_put_contents(USERS_FILE, json_encode(new stdClass(), JSON_PRETTY_PRINT));
}

/* ---------- Helper Functions ---------- */

// Load users from JSON file
function load_users() {
    $json = file_get_contents(USERS_FILE);
    $data = json_decode($json, true);
    return is_array($data) ? $data : [];
}

// Save users to JSON file
function save_users($users) {
    file_put_contents(USERS_FILE, json_encode($users, JSON_PRETTY_PRINT));
}

// CSRF token generator
function csrf_token() {
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(16));
    }
    return $_SESSION['csrf'];
}

// Verify CSRF token
function check_csrf($token) {
    return isset($_SESSION['csrf']) && hash_equals($_SESSION['csrf'], $token);
}

// Flash messages (temporary session messages)
function flash($key, $value = null) {
    if ($value === null) {
        if (!empty($_SESSION['_flash'][$key])) {
            $val = $_SESSION['_flash'][$key];
            unset($_SESSION['_flash'][$key]);
            return $val;
        }
        return null;
    }
    $_SESSION['_flash'][$key] = $value;
}

// Get current logged-in user data
function current_user() {
    if (empty($_SESSION['user'])) return null;
    $users = load_users();
    $email = $_SESSION['user'];
    return $users[$email] ?? null;
}

// Require user to be logged in
function require_login() {
    if (empty($_SESSION['user'])) {
        header('Location: /login.php');
        exit;
    }
}
