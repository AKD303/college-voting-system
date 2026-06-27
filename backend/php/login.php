<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Validate input
    if (empty($username) || empty($password)) {
        echo json_encode(['status' => 'error', 'message' => 'Username and password required']);
        exit;
    }

    // Query user
    $sql = "SELECT id, username, password, role, full_name, status FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $conn->error]);
        exit;
    }

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

        // Verify password
        if (password_verify($password, $user['password'])) {
            // Set session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['login_time'] = time();

            // Determine redirect based on role
            $redirect = ($user['role'] == 'admin') ? 'admin-dashboard.html' : 'student-dashboard.html';

            echo json_encode([
                'status' => 'success',
                'message' => 'Login successful',
                'user_id' => $user['id'],
                'username' => $user['username'],
                'role' => $user['role'],
                'full_name' => $user['full_name'],
                'redirect' => $redirect
            ]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid password']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'User not found']);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
$conn->close();
?>
