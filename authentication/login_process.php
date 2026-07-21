<?php
session_start();
header('Content-Type: application/json');

// ភ្ជាប់ទៅកាន់ Database Connection File របស់អ្នក
require_once '../config/database.php'; 

// ពិនិត្យមើល Request Method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

// ទទួលទិន្នន័យពី AJAX Request
$action   = $_POST['action'] ?? '';
$email    = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

// ពិនិត្យមើល Action
if ($action === 'login') {
    
    // Validate Input
    if (empty($email) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'Please fill in all fields.']);
        exit;
    }

    try {
        // Query រកមើល User តាមរយៈ Email ($conn ជា mysqli ឬ pdo ដែលអ្នកបាន set ក្នុង database.php)
        $stmt = $conn->prepare("SELECT id, username, email, password, role FROM users WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($user = $result->fetch_assoc()) {
            
            // ផ្ទៀងផ្ទាត់ Password (ប្រើ password_verify ប្រសិនបើ Hash Password ពេល Register)
            if (password_verify($password, $user['password']) || $password === $user['password']) {
                
                // រក្សាទុក Session
                $_SESSION['user_id']   = $user['id'];
                $_SESSION['username']  = $user['username'];
                $_SESSION['user_role'] = $user['role'];

                echo json_encode([
                    'success' => true,
                    'message' => 'Login successful!',
                    'role'    => $user['role']
                ]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Invalid email or password.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid email or password.']);
        }

        $stmt->close();
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }

} else {
    echo json_encode(['success' => false, 'message' => 'Invalid action.']);
}