<?php
include 'config.php';

header('Content-Type: application/json');

// Destroy session
session_destroy();

// Clear all session data
$_SESSION = [];

// Delete session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

echo json_encode([
    'status' => 'success',
    'message' => 'Logged out successfully',
    'redirect' => 'index.html'
]);

$conn->close();
?>
