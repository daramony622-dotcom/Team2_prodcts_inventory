<?php
// authentication/register_process.php

// Return JSON response for AJAX
header('Content-Type: application/json');

// Include your database connection setup from config/database.php
require_once '../config/database.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and grab POST parameters
    $username = trim($_POST['username'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // 1. Basic Server-side Validation
    if (empty($username) || empty($email) || empty($password)) {
        echo json_encode([
            'success' => false, 
            'message' => 'Please fill in all required fields.'
        ]);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode([
            'success' => false, 
            'message' => 'Invalid email address format.'
        ]);
        exit;
    }

    try {
        // 2. Check if the email already exists in the `users` table
        $checkStmt = $pdo->prepare("SELECT id FROM users WHERE email = :email LIMIT 1");
        $checkStmt->execute([':email' => $email]);

        if ($checkStmt->fetch()) {
            echo json_encode([
                'success' => false, 
                'message' => 'An account with this email address already exists.'
            ]);
            exit;
        }

        // 3. Hash the password securely
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // 4. Insert the new user (default role set to 'Staff' as per your SQL schema)
        $insertStmt = $pdo->prepare("
            INSERT INTO users (username, email, password, role) 
            VALUES (:username, :email, :password, 'Staff')
        ");

        $executed = $insertStmt->execute([
            ':username' => $username,
            ':email'    => $email,
            ':password' => $hashedPassword
        ]);

        if ($executed) {
            echo json_encode([
                'success' => true, 
                'message' => 'Account created successfully! Redirecting to login...'
            ]);
        } else {
            echo json_encode([
                'success' => false, 
                'message' => 'Failed to register account. Please try again.'
            ]);
        }

    } catch (PDOException $e) {
        // Log $e->getMessage() internally in production instead of outputting direct errors
        echo json_encode([
            'success' => false, 
            'message' => 'Database error: ' . $e->getMessage()
        ]);
    }
} else {
    // Block non-POST requests
    echo json_encode([
        'success' => false, 
        'message' => 'Invalid request method.'
    ]);
}