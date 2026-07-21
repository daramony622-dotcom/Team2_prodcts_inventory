<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/session.php';


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

$action   = $_POST['action'] ?? '';
$email    = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';


if ($action === 'register') {

    $username         = trim($_POST['username'] ?? '');
    $email            = trim($_POST['email'] ?? '');
    $password         = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // 1. Required fields
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        echo json_encode(['success' => false, 'message' => 'Please fill in all fields.']);
        exit;
    }

    // 2. Valid email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Invalid email format.']);
        exit;
    }

    // 3. Passwords match
    if ($password !== $confirm_password) {
        echo json_encode(['success' => false, 'message' => 'Passwords do not match.']);
        exit;
    }

    // 4. Minimum password strength
    if (strlen($password) < 8) {
        echo json_encode(['success' => false, 'message' => 'Password must be at least 8 characters.']);
        exit;
    }

    try {
        // 5. Check email isn't already taken
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);

        if ($stmt->fetch()) {
            echo json_encode(['success' => false, 'message' => 'Email is already registered.']);
            exit;
        }

        // 6. Hash password and insert
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare(
            "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)"
        );
        $stmt->execute([$username, $email, $hashed_password, 'Client']); // default role

        echo json_encode([
            'success' => true,
            'message' => 'Account created successfully! You can now log in.'
        ]);

    } catch (PDOException $e) {
        error_log('Register error: ' . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Something went wrong. Please try again.']);
    }

} else {
    echo json_encode(['success' => false, 'message' => 'Invalid action.']);
}
?>