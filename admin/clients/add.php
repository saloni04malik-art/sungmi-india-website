<?php

require_once "../includes/auth.php";
require_once "../includes/db.php";

$error = "";

if (isset($_POST['add_client'])) {

    $name = trim($_POST['name']);
    $status = isset($_POST['status']) ? 1 : 0;

    if ($name == "") {

        $error = "Client name is required.";

    } else {

        $logo_path = null;


        /* Logo upload */

        if (
            isset($_FILES['logo']) &&
            $_FILES['logo']['error'] != UPLOAD_ERR_NO_FILE
        ) {

            if ($_FILES['logo']['error'] != UPLOAD_ERR_OK) {

                $error = "Logo upload failed.";

            } elseif ($_FILES['logo']['size'] > 5 * 1024 * 1024) {

                $error = "Logo must be less than 5 MB.";

            } else {

                $tmp_name = $_FILES['logo']['tmp_name'];

                $image_info = getimagesize($tmp_name);

                $allowed_types = [
                    'image/jpeg' => 'jpg',
                    'image/png'  => 'png',
                    'image/webp' => 'webp'
                ];


                if (
                    $image_info === false ||
                    !isset($allowed_types[$image_info['mime']])
                ) {

                    $error = "Only JPG, PNG and WEBP images are allowed.";

                } else {

                    $file_name = bin2hex(random_bytes(8))
                        . "."
                        . $allowed_types[$image_info['mime']];

                    $upload_directory = "../uploads/clients/";


                    if (!is_dir($upload_directory)) {
                        mkdir($upload_directory, 0755, true);
                    }


                    $destination = $upload_directory . $file_name;


                    if (move_uploaded_file($tmp_name, $destination)) {

                        $logo_path = "admin/uploads/clients/" . $file_name;

                    } else {

                        $error = "Unable to save logo.";

                    }
                }
            }
        }


        if ($error == "") {

            $sql = "INSERT INTO clients
                    (name, logo, status, is_deleted)
                    VALUES (?, ?, ?, 0)";

            $stmt = mysqli_prepare($conn, $sql);

            mysqli_stmt_bind_param(
                $stmt,
                "ssi",
                $name,
                $logo_path,
                $status
            );


            if (mysqli_stmt_execute($stmt)) {

                mysqli_stmt_close($stmt);

                header("Location: listing.php");
                exit;

            } else {

                mysqli_stmt_close($stmt);

                $error = "Unable to add client.";
            }
        }
    }
}


require_once "../includes/header.php";

?>

<style>
    .client-form-container {
        max-width: 700px;
    }

    .form-header-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 12px;
    }

    .form-header-bar h1 {
        margin: 0 0 4px 0;
        font-size: 24px;
        font-weight: 700;
        color: #111827;
    }

    .form-header-bar p {
        margin: 0;
        font-size: 14px;
        color: #6b7280;
    }

    .btn-back-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 14px;
        font-weight: 500;
        color: #4b5563;
        background-color: #ffffff;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        padding: 8px 14px;
        text-decoration: none;
        transition: background-color 0.15s ease, color 0.15s ease;
    }

    .btn-back-link:hover {
        background-color: #f3f4f6;
        color: #111827;
    }

    .client-form-alert {
        background-color: #fef2f2;
        border: 1px solid #fecaca;
        color: #b91c1c;
        padding: 12px 16px;
        border-radius: 8px;
        font-size: 14px;
        margin-bottom: 22px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .client-form-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 32px 28px;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
    }

    .form-group {
        margin-bottom: 22px;
    }

    .form-label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 7px;
        letter-spacing: 0.2px;
    }

    .form-label .required-mark {
        color: #ef4444;
        margin-left: 2px;
    }

    .form-control {
        width: 100%;
        height: 44px;
        padding: 0 14px;
        font-size: 14px;
        background-color: #ffffff;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        color: #111827;
        box-sizing: border-box;
        transition: border-color 0.15s ease, box-shadow 0.15s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
    }

    .form-hint {
        font-size: 12px;
        color: #6b7280;
        margin-top: 5px;
    }

    .form-file-input {
        width: 100%;
        padding: 9px 12px;
        font-size: 14px;
        background-color: #f9fafb;
        border: 1px dashed #d1d5db;
        border-radius: 8px;
        box-sizing: border-box;
        cursor: pointer;
    }

    .form-file-input:focus {
        outline: none;
        border-color: #2563eb;
    }

    .status-checkbox-label {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 500;
        color: #1f2937;
        user-select: none;
    }

    .status-checkbox-label input[type="checkbox"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
        accent-color: #2563eb;
    }

    .form-actions-bar {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-top: 30px;
        padding-top: 22px;
        border-top: 1px solid #e5e7eb;
    }

    .btn-submit-client {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        height: 44px;
        padding: 0 28px;
        font-size: 14px;
        font-weight: 600;
        color: #ffffff;
        background-color: #2563eb;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.15s ease, transform 0.05s ease;
    }

    .btn-submit-client:hover {
        background-color: #1d4ed8;
    }

    .btn-submit-client:active {
        background-color: #1e40af;
        transform: scale(0.99);
    }

    .btn-cancel-client {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        height: 44px;
        padding: 0 20px;
        font-size: 14px;
        font-weight: 500;
        color: #4b5563;
        background-color: #f3f4f6;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        text-decoration: none;
        transition: background-color 0.15s ease, color 0.15s ease;
    }

    .btn-cancel-client:hover {
        background-color: #e5e7eb;
        color: #111827;
    }

    @media (max-width: 580px) {
        .client-form-card {
            padding: 22px 18px;
        }
    }
</style>

<div class="client-form-container">

    <div class="form-header-bar">
        <div>
            <h1>Add Client</h1>
            <p>Add a new trusted partner or marine client to the website portfolio.</p>
        </div>
        <a href="listing.php" class="btn-back-link">
            &larr; Back to Clients
        </a>
    </div>

    <?php if ($error != "") { ?>
        <div class="client-form-alert" role="alert">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="8" x2="12" y2="12"></line>
                <line x1="12" y1="16" x2="12.01" y2="16"></line>
            </svg>
            <span><?php echo htmlspecialchars($error); ?></span>
        </div>
    <?php } ?>

    <div class="client-form-card">

        <form method="POST" enctype="multipart/form-data">

            <div class="form-group">
                <label class="form-label" for="client-name">
                    Client Name <span class="required-mark">*</span>
                </label>
                <input
                    type="text"
                    id="client-name"
                    name="name"
                    class="form-control"
                    placeholder="e.g. Cochin Shipyard, L&T Shipbuilding"
                    required
                >
            </div>

            <div class="form-group">
                <label class="form-label" for="client-logo">Client Logo</label>
                <input
                    type="file"
                    id="client-logo"
                    name="logo"
                    class="form-file-input"
                    accept=".jpg,.jpeg,.png,.webp"
                >
                <div class="form-hint">Accepted formats: JPG, PNG, WEBP (Max: 5 MB). Transparent PNG recommended.</div>
            </div>

            <div class="form-group">
                <label class="status-checkbox-label" for="client-status">
                    <input
                        type="checkbox"
                        id="client-status"
                        name="status"
                        value="1"
                        checked
                    >
                    <span>Active (Displayed on public website)</span>
                </label>
            </div>

            <div class="form-actions-bar">
                <button type="submit" name="add_client" class="btn-submit-client">
                    Save Client
                </button>
                <a href="listing.php" class="btn-cancel-client">
                    Cancel
                </a>
            </div>

        </form>

    </div>

</div>

</main>
</div>
</div>

</body>
</html>