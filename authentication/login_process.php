<?php
header('Content-Type: application/json');

// Fix: Added missing directory slashes (/) to prevent path lookup failures
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/session.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

$action   = $_POST['action'] ?? '';
$email    = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if ($action === 'login') {

    if (empty($email) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'Please fill in all fields.']);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Invalid email format.']);
        exit;
    }

    try {
        $stmt = $pdo->prepare("SELECT id, username, email, password, role FROM users WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {

            // Sets session data and regenerates ID securely
            login($user);

            // Role-based redirection path logic
            $redirect = strtolower($user['role']) === 'admin'
                ? '../dashboard/index.php'
                : '../client/pages/index.php';

            echo json_encode([
                'success'  => true,
                'message'  => 'Login successful!',
                'role'     => $user['role'],
                'redirect' => $redirect
            ]);
            exit;

        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid email or password.']);
            exit;
        }

    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'DEBUG ERROR: ' . $e->getMessage()]);
        exit;
    }

} else {
    echo json_encode(['success' => false, 'message' => 'Invalid action.']);
    exit;
}