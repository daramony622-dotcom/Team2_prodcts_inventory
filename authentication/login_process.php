<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/auth.php';

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

    try {
        $stmt = $pdo->prepare("SELECT id, username, email, password, role FROM users WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {

            login($user);

            // Exact path alignment according to your folder structure:
            $redirect = strtolower($user['role']) === 'admin'
                ? BASE_URL . '/inventory/dashboard/index.php'
                : BASE_URL . '/client/pages/index.php';

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
        echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
        exit;
    }

} else {
    echo json_encode(['success' => false, 'message' => 'Invalid action.']);
    exit;
}