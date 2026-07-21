<?php
header('Content-Type: application/json');

require_once __DIR__ . '../config/config.php';
require_once __DIR__ . '../includes/auth.php'; // safe — just functions now

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

            login($user); // sets session, regenerates ID

            $redirect = strtolower($user['role']) === 'Admin'
                ? '/Team2_prodcts_inventory/dashboard/index.php'
                : '/Team2_prodcts_inventory/client/pages/index.php';

            echo json_encode([
                'success'  => true,
                'message'  => 'Login successful!',
                'role'     => $user['role'],
                'redirect' => $redirect
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid email or password.']);
        }

    } catch (PDOException $e) {
        error_log('Login error: ' . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Something went wrong. Please try again.']);
    }

} else {
    echo json_encode(['success' => false, 'message' => 'Invalid action.']);
}