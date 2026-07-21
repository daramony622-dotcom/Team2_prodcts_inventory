<?php
session_start();
if (isset($_SESSION['user_id'])) {
    if (strtolower($_SESSION['role'] ?? '') === 'admin') {
        header('Location: ../admin/dashboard.php');
    } else {
        header('Location: ../client/index.php');
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | ETEC Center</title>
    <!-- Adjust CSS path based on your folder location or root -->
    <link rel="stylesheet" href="../css/style.css">
    <!-- Using jQuery CDN for reliability -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>
<div class="login-wrapper">
    <div class="login-box">
        <h2>Create Account</h2>
        <p>Simple register page</p>

        <div id="alertBox"></div>

        <form id="registerForm">
            <div class="form-group">
                <label>Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%">Register</button>
        </form>

        <p style="margin-top:14px; text-align:center;">
            Already have account? <a href="login.php">Login</a>
        </p>
    </div>
</div>

<script>
$('#registerForm').on('submit', function (e) {
    e.preventDefault();

    $.ajax({
        url: 'register_process.php', // Updated to match file structure
        method: 'POST',
        dataType: 'json',
        data: {
            username: $('#username').val(),
            email: $('#email').val(),
            password: $('#password').val()
        },
        success: function (res) {
            if (res.success) {
                $('#alertBox').html('<div class="alert alert-success">' + res.message + '</div>');
                setTimeout(function () {
                    window.location.href = 'login.php';
                }, 800);
            } else {
                $('#alertBox').html('<div class="alert alert-danger">' + res.message + '</div>');
            }
        },
        error: function () {
            $('#alertBox').html('<div class="alert alert-danger">An error occurred while processing your request.</div>');
        }
    });
});
</script>
</body>
</html>