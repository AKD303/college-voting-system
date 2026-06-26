<?php
include 'config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $conn->real_escape_string($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // Validate input
    if (empty($username) || empty($password)) {
        echo json_encode(['status' => 'error', 'message' => 'Username and password required']);
        exit;
    }

    // Query user
    $sql = "SELECT id, username, password, role, full_name, status FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // Check if user is active
        if ($user['status'] != 'active') {
            echo json_encode(['status' => 'error', 'message' => 'Account inactive']);
            exit;
        }

        // Verify password (bcrypt)
        if (password_verify($password, $user['password'])) {
            // Set session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['login_time'] = time();

            // Log session
            $token = bin2hex(random_bytes(32));
            $ip = $_SERVER['REMOTE_ADDR'];
            $user_agent = $_SERVER['HTTP_USER_AGENT'];
            $expires = date('Y-m-d H:i:s', strtotime('+30 minutes'));

            $sql_session = "INSERT INTO sessions (user_id, token, ip_address, user_agent, expires_at) VALUES (?, ?, ?, ?, ?)";
            $stmt_session = $conn->prepare($sql_session);
            $stmt_session->bind_param("issss", $user['id'], $token, $ip, $user_agent, $expires);
            $stmt_session->execute();

            echo json_encode([
                'status' => 'success',
                'message' => 'Login successful',
                'user_id' => $user['id'],
                'username' => $user['username'],
                'role' => $user['role']
            ]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid password']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'User not found']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
