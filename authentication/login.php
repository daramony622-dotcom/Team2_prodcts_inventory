<?php
session_start();

// ប្រសិនបើធ្លាប់ Login រួចហើយ ឱ្យ Redirect ទៅតាម Role
if (isset($_SESSION['user_id'])) {
    if (strtolower($_SESSION['user_role'] ?? '') === 'admin') {
        header('Location: admin/dashboard.php');
    } else {
        header('Location: client/index.php');
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | ETEC Center</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="jquery/jquery-3.7.1.min.js"></script>
</head>
<body>

<div class="login-wrapper">
    <div class="login-box">
        <h2>ETEC Center</h2>
        <p>Login to manage category and product</p>

        <div id="alertBox"></div>

        <form id="loginForm">
            <div class="form-group">
                <label>Email</label>
                <input type="email" id="email" name="email" value="admin@etec.com" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" id="password" name="password" value="admin123" required>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%">Login</button>
        </form>

        <p style="margin-top:14px; text-align:center;">
            No account? <a href="register.php">Register</a>
        </p>
    </div>
</div>

<script>
$(document).ready(function () {
    $('#loginForm').on('submit', function (e) {
        e.preventDefault();

        $.ajax({
            url: 'api/auth_handler.php',
            method: 'POST',
            dataType: 'json',
            data: {
                action: 'login',
                email: $('#email').val(),
                password: $('#password').val()
            },
            success: function (res) {
                if (res.success) {
                    var role = (res.role || '').toLowerCase();
                    window.location.href = (role === 'admin') ? 'admin/dashboard.php' : 'client/index.php';
                } else {
                    $('#alertBox').html('<div class="alert alert-error">' + res.message + '</div>');
                }
            },
            error: function () {
                $('#alertBox').html('<div class="alert alert-error">Something went wrong. Please try again!</div>');
            }
        });
    });
});
</script>

</body>
</html>