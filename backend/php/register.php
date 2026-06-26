<?php
include 'config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $conn->real_escape_string($_POST['username'] ?? '');
    $email = $conn->real_escape_string($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $full_name = $conn->real_escape_string($_POST['full_name'] ?? '');
    $enrollment_number = $conn->real_escape_string($_POST['enrollment_number'] ?? '');
    $department = $conn->real_escape_string($_POST['department'] ?? '');

    // Validate input
    if (empty($username) || empty($email) || empty($password) || empty($full_name)) {
        echo json_encode(['status' => 'error', 'message' => 'All fields required']);
        exit;
    }

    // Password validation
    if (strlen($password) < 8) {
        echo json_encode(['status' => 'error', 'message' => 'Password must be at least 8 characters']);
        exit;
    }

    if ($password !== $confirm_password) {
        echo json_encode(['status' => 'error', 'message' => 'Passwords do not match']);
        exit;
    }

    // Email validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid email format']);
        exit;
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 10]);

    // Insert user
    $sql = "INSERT INTO users (username, email, password, full_name, enrollment_number, department, role, status) 
            VALUES (?, ?, ?, ?, ?, ?, 'student', 'active')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $username, $email, $hashed_password, $full_name, $enrollment_number, $department);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Registration successful. Please login.']);
    } else {
        if (strpos($stmt->error, 'username') !== false) {
            echo json_encode(['status' => 'error', 'message' => 'Username already exists']);
        } else if (strpos($stmt->error, 'email') !== false) {
            echo json_encode(['status' => 'error', 'message' => 'Email already exists']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Registration failed']);
        }
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
