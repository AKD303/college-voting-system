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
$request_path = trim($request_path, '/');\n\n// Route the requests\nswitch ($request_path) {\n    // Authentication Routes\n    case 'login':\n        if ($request_method === 'POST') {\n            include 'login.php';\n        }\n        break;\n\n    case 'register':\n        if ($request_method === 'POST') {\n            include 'register.php';\n        }\n        break;\n\n    case 'logout':\n        if ($request_method === 'POST' || $request_method === 'GET') {\n            include 'logout.php';\n        }\n        break;\n\n    // API Routes - Users\n    case 'api/users':\n        if ($request_method === 'GET') {\n            include 'api/get_users.php';\n        }\n        break;\n\n    case 'api/user/update':\n        if ($request_method === 'POST') {\n            include 'api/update_user.php';\n        }\n        break;\n\n    // API Routes - Candidates\n    case 'api/candidates':\n        if ($request_method === 'GET') {\n            include 'api/get_candidates.php';\n        }\n        break;\n\n    // API Routes - Votes\n    case 'api/votes':\n        if ($request_method === 'GET') {\n            include 'api/get_votes.php';\n        } else if ($request_method === 'POST') {\n            include 'api/add_vote.php';\n        }\n        break;\n\n    // Health check\n    case 'api/health':\n        echo json_encode([\n            'status' => 'success',\n            'message' => 'API is running',\n            'timestamp' => date('Y-m-d H:i:s')\n        ]);\n        break;\n\n    // 404 - Not Found\n    default:\n        http_response_code(404);\n        echo json_encode([\n            'status' => 'error',\n            'message' => 'Endpoint not found: ' . $request_path\n        ]);\n        break;\n}\n\n$conn->close();\n?>\n"