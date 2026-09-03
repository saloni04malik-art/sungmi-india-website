<?php

session_start();

require_once "includes/db.php";

if (isset($_SESSION['admin_id'])) {
    header("Location: dashboard.php");
    exit;
}

$error = "";

if (isset($_POST['login'])) {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if ($email == "" || $password == "") {

        $error = "Please enter email and password.";

    } else {

        $sql = "SELECT id, name, email, password
                FROM admins
                WHERE email = ? AND status = 1
                LIMIT 1";

        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param($stmt, "s", $email);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) == 1) {

            $admin = mysqli_fetch_assoc($result);

            if (password_verify($password, $admin['password'])) {

                session_regenerate_id(true);

                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_name'] = $admin['name'];
                $_SESSION['admin_email'] = $admin['email'];

                header("Location: dashboard.php");
                exit;

            } else {

                $error = "Invalid email or password.";
            }

        } else {

            $error = "Invalid email or password.";
        }

        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Login — Sungmi India</title>

    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #0f172a;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            color: #f8fafc;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            padding: 24px;
        }

        .login-card {
            background-color: #1e293b;
            border: 1px solid #334155;
            border-radius: 12px;
            padding: 40px 36px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3), 0 8px 10px -6px rgba(0, 0, 0, 0.3);
        }

        .login-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .login-brand {
            font-size: 22px;
            font-weight: 700;
            letter-spacing: 0.5px;
            color: #ffffff;
            margin: 0 0 6px 0;
        }

        .login-subtitle {
            font-size: 14px;
            color: #94a3b8;
            margin: 0;
        }

        .login-alert {
            background-color: rgba(239, 68, 68, 0.12);
            border: 1px solid rgba(239, 68, 68, 0.35);
            color: #fca5a5;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 14px;
            line-height: 1.4;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .login-alert svg {
            flex-shrink: 0;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #cbd5e1;
            margin-bottom: 8px;
            letter-spacing: 0.3px;
        }

        .form-control {
            width: 100%;
            padding: 12px 14px;
            font-size: 14px;
            line-height: 1.5;
            background-color: #0f172a;
            border: 1px solid #334155;
            border-radius: 8px;
            color: #ffffff;
            box-sizing: border-box;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25);
        }

        .form-control::placeholder {
            color: #64748b;
        }

        .btn-login {
            width: 100%;
            padding: 13px;
            font-size: 15px;
            font-weight: 600;
            color: #ffffff;
            background-color: #2563eb;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.15s ease, transform 0.05s ease;
            margin-top: 10px;
        }

        .btn-login:hover {
            background-color: #1d4ed8;
        }

        .btn-login:active {
            background-color: #1e40af;
            transform: scale(0.99);
        }

        .login-footer {
            text-align: center;
            margin-top: 24px;
            font-size: 12px;
            color: #64748b;
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 28px 20px;
            }
        }
    </style>
</head>

<body>

    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h1 class="login-brand">Sungmi India</h1>
                <p class="login-subtitle">Admin Panel Authentication</p>
            </div>

            <?php if ($error != "") { ?>
                <div class="login-alert" role="alert">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                    <span><?php echo htmlspecialchars($error); ?></span>
                </div>
            <?php } ?>

            <form method="POST">

                <div class="form-group">
                    <label class="form-label" for="login-email">Email Address</label>
                    <input type="email" id="login-email" name="email" class="form-control" placeholder="name@sungmi.in" autocomplete="off" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="login-password">Password</label>
                    <input type="password" id="login-password" name="password" class="form-control" placeholder="••••••••" autocomplete="off" required>
                </div>

                <button type="submit" name="login" class="btn-login">
                    Login
                </button>

            </form>
        </div>

        <div class="login-footer">
            &copy; <?php echo date('Y'); ?> Sungmi India. All rights reserved.
        </div>
    </div>

</body>
</html>