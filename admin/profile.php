<?php

require_once "includes/auth.php";
require_once "includes/db.php";



$admin_id = $_SESSION['admin_id'];

$message = "";
$error = "";

/* Get current admin details */
$sql = "SELECT name, email, password FROM admins WHERE id = ? AND status = 1 LIMIT 1";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $admin_id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$admin = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);

if (!$admin) {
    session_destroy();
    header("Location: login.php");
    exit;
}


/* Update profile */
if (isset($_POST['update_profile'])) {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);

    if ($name == "" || $email == "") {

        $error = "Name and email are required.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $error = "Please enter a valid email address.";

    } else {

        /* Check if email is already used */
        $sql = "SELECT id FROM admins WHERE email = ? AND id != ? LIMIT 1";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "si", $email, $admin_id);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {

            $error = "This email is already being used.";

        } else {

            $sql = "UPDATE admins 
                    SET name = ?, email = ?
                    WHERE id = ?";

            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ssi", $name, $email, $admin_id);

            if (mysqli_stmt_execute($stmt)) {

                $_SESSION['admin_name'] = $name;
                $_SESSION['admin_email'] = $email;

                $admin['name'] = $name;
                $admin['email'] = $email;

                $message = "Profile updated successfully.";

            } else {

                $error = "Unable to update profile.";
            }
        }

        mysqli_stmt_close($stmt);
    }
}


/* Change password */
if (isset($_POST['change_password'])) {

    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($current_password == "" || $new_password == "" || $confirm_password == "") {

        $error = "All password fields are required.";

    } elseif (!password_verify($current_password, $admin['password'])) {

        $error = "Current password is incorrect.";

    } elseif ($new_password != $confirm_password) {

        $error = "New passwords do not match.";

    } elseif (strlen($new_password) < 8) {

        $error = "New password must be at least 8 characters.";

    } else {

        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        $sql = "UPDATE admins 
                SET password = ?
                WHERE id = ?";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "si", $hashed_password, $admin_id);

        if (mysqli_stmt_execute($stmt)) {

            $admin['password'] = $hashed_password;

            $message = "Password changed successfully.";

        } else {

            $error = "Unable to change password.";
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

    <title>Admin Profile — Sungmi India</title>

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

        .profile-wrapper {
            width: 100%;
            max-width: 620px;
            padding: 32px 20px;
            box-sizing: border-box;
        }

        .profile-card {
            background-color: #1e293b;
            border: 1px solid #334155;
            border-radius: 12px;
            padding: 36px 32px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3), 0 8px 10px -6px rgba(0, 0, 0, 0.3);
        }

        .profile-header {
            margin-bottom: 28px;
            border-bottom: 1px solid #334155;
            padding-bottom: 20px;
        }

        .profile-header h1 {
            font-size: 24px;
            font-weight: 700;
            color: #ffffff;
            margin: 0 0 6px 0;
            letter-spacing: 0.3px;
        }

        .profile-header p {
            font-size: 14px;
            color: #94a3b8;
            margin: 0;
        }

        .profile-alert-success {
            background-color: rgba(16, 185, 129, 0.12);
            border: 1px solid rgba(16, 185, 129, 0.35);
            color: #6ee7b7;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .profile-alert-error {
            background-color: rgba(239, 68, 68, 0.12);
            border: 1px solid rgba(239, 68, 68, 0.35);
            color: #fca5a5;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .profile-section-title {
            font-size: 17px;
            font-weight: 600;
            color: #f1f5f9;
            margin: 0 0 18px 0;
            letter-spacing: 0.2px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #cbd5e1;
            margin-bottom: 7px;
            letter-spacing: 0.3px;
        }

        .form-control {
            width: 100%;
            height: 44px;
            padding: 0 14px;
            font-size: 14px;
            line-height: 44px;
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

        .btn-primary-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            height: 42px;
            padding: 0 24px;
            font-size: 14px;
            font-weight: 600;
            color: #ffffff;
            background-color: #2563eb;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.15s ease, transform 0.05s ease;
            margin-top: 4px;
        }

        .btn-primary-action:hover {
            background-color: #1d4ed8;
        }

        .btn-primary-action:active {
            background-color: #1e40af;
            transform: scale(0.99);
        }

        .section-divider {
            border: 0;
            border-top: 1px solid #334155;
            margin: 32px 0 28px;
        }

        .profile-actions-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 32px;
            padding-top: 24px;
            border-top: 1px solid #334155;
        }

        .btn-secondary-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 14px;
            font-weight: 500;
            color: #94a3b8;
            text-decoration: none;
            padding: 9px 16px;
            background-color: transparent;
            border: 1px solid #334155;
            border-radius: 8px;
            transition: color 0.15s ease, border-color 0.15s ease, background-color 0.15s ease;
        }

        .btn-secondary-link:hover {
            color: #ffffff;
            border-color: #475569;
            background-color: #334155;
        }

        .btn-logout-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 14px;
            font-weight: 500;
            color: #f87171;
            text-decoration: none;
            padding: 9px 16px;
            background-color: transparent;
            border: 1px solid rgba(239, 68, 68, 0.35);
            border-radius: 8px;
            transition: color 0.15s ease, background-color 0.15s ease;
        }

        .btn-logout-link:hover {
            color: #ffffff;
            background-color: rgba(239, 68, 68, 0.2);
        }

        @media (max-width: 540px) {
            .profile-card {
                padding: 24px 20px;
            }

            .profile-actions-footer {
                flex-direction: column;
                gap: 12px;
                align-items: stretch;
            }

            .btn-secondary-link,
            .btn-logout-link {
                justify-content: center;
            }
        }
    </style>

</head>

<body>

    <div class="profile-wrapper">
        <div class="profile-card">

            <div class="profile-header">
                <h1>Admin Profile</h1>
                <p>Manage your account credentials and personal information</p>
            </div>

            <?php if ($message != "") { ?>
                <div class="profile-alert-success" role="alert">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                    <span><?php echo htmlspecialchars($message); ?></span>
                </div>
            <?php } ?>

            <?php if ($error != "") { ?>
                <div class="profile-alert-error" role="alert">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                    <span><?php echo htmlspecialchars($error); ?></span>
                </div>
            <?php } ?>

            <!-- Profile Information Section -->
            <h2 class="profile-section-title">Profile Information</h2>

            <form method="POST">

                <div class="form-group">
                    <label class="form-label" for="profile-name">Name</label>
                    <input
                        type="text"
                        id="profile-name"
                        class="form-control"
                        name="name"
                        value="<?php echo htmlspecialchars($admin['name']); ?>"
                        required
                    >
                </div>

                <div class="form-group">
                    <label class="form-label" for="profile-email">Email Address</label>
                    <input
                        type="email"
                        id="profile-email"
                        class="form-control"
                        name="email"
                        value="<?php echo htmlspecialchars($admin['email']); ?>"
                        required
                    >
                </div>

                <button type="submit" name="update_profile" class="btn-primary-action">
                    Update Profile
                </button>

            </form>

            <hr class="section-divider">

            <!-- Change Password Section -->
            <h2 class="profile-section-title">Change Password</h2>

            <form method="POST">

                <div class="form-group">
                    <label class="form-label" for="current-password">Current Password</label>
                    <input
                        type="password"
                        id="current-password"
                        class="form-control"
                        name="current_password"
                        required
                    >
                </div>

                <div class="form-group">
                    <label class="form-label" for="new-password">New Password</label>
                    <input
                        type="password"
                        id="new-password"
                        class="form-control"
                        name="new_password"
                        required
                    >
                </div>

                <div class="form-group">
                    <label class="form-label" for="confirm-password">Confirm New Password</label>
                    <input
                        type="password"
                        id="confirm-password"
                        class="form-control"
                        name="confirm_password"
                        required
                    >
                </div>

                <button type="submit" name="change_password" class="btn-primary-action">
                    Change Password
                </button>

            </form>

            <!-- Bottom Secondary Actions -->
            <div class="profile-actions-footer">
                <a href="dashboard.php" class="btn-secondary-link">
                    &larr; Back to Dashboard
                </a>
                <a href="logout.php" class="btn-logout-link">
                    Logout
                </a>
            </div>

        </div>
    </div>

</body>

</html>

