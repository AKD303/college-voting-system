<?php
/**
 * College Voting System - API Router
 * Main entry point for all API requests
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Include configuration
include 'config.php';

// Get the request method and path
$request_method = $_SERVER['REQUEST_METHOD'];
$request_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$request_path = str_replace('/college-voting-system/backend/php/', '', $request_path);
$request_path = str_replace('/backend/php/', '', $request_path);
$request_path = trim($request_path, '/');

// Route the requests
switch ($request_path) {
    // Authentication Routes
    case 'login':
        if ($request_method === 'POST') {
            include 'login.php';
        }
        break;

    case 'register':
        if ($request_method === 'POST') {
            include 'register.php';
        }
        break;

    case 'logout':
        if ($request_method === 'POST' || $request_method === 'GET') {
            include 'logout.php';
        }
        break;

    // API Routes - Users
    case 'api/users':
        if ($request_method === 'GET') {
            include 'api/get_users.php';
        }
        break;

    case 'api/user/update':
        if ($request_method === 'POST') {
            include 'api/update_user.php';
        }
        break;

    // API Routes - Candidates
    case 'api/candidates':
        if ($request_method === 'GET') {
            include 'api/get_candidates.php';
        }
        break;

    // API Routes - Votes
    case 'api/votes':
        if ($request_method === 'GET') {
            include 'api/get_votes.php';
        } else if ($request_method === 'POST') {
            include 'api/add_vote.php';
        }
        break;

    // Health check
    case 'api/health':
        echo json_encode([
            'status' => 'success',
            'message' => 'API is running',
            'timestamp' => date('Y-m-d H:i:s')
        ]);
        break;

    // 404 - Not Found
    default:
        http_response_code(404);
        echo json_encode([
            'status' => 'error',
            'message' => 'Endpoint not found: ' . $request_path
        ]);
        break;
}

$conn->close();
?>
