<?php

require_once "../includes/auth.php";
require_once "../includes/db.php";


if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {

    header("Location: listing.php");
    exit;
}


$id = (int) $_GET['id'];

$error = "";


/* Get client */

$sql = "SELECT *
        FROM clients
        WHERE id = ? AND is_deleted = 0
        LIMIT 1";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "i", $id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$client = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);


if (!$client) {

    header("Location: listing.php");
    exit;
}


/* Update client */

if (isset($_POST['update_client'])) {

    $name = trim($_POST['name']);
    $status = isset($_POST['status']) ? 1 : 0;


    if ($name == "") {

        $error = "Client name is required.";

    } else {

        $logo_path = $client['logo'];


        /* Replace logo */

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


                        /*
                         * Delete old uploaded logo only.
                         *
                         * Existing website assets are NOT deleted.
                         */

                        if (
                            !empty($client['logo']) &&
                            strpos($client['logo'], 'admin/uploads/clients/') === 0
                        ) {

                            $old_file = "../../" . $client['logo'];

                            if (file_exists($old_file)) {

                                unlink($old_file);

                            }
                        }


                        $logo_path = "admin/uploads/clients/" . $file_name;

                    } else {

                        $error = "Unable to save logo.";
                    }
                }
            }
        }


        if ($error == "") {

            $sql = "UPDATE clients
                    SET name = ?,
                        logo = ?,
                        status = ?
                    WHERE id = ? AND is_deleted = 0";

            $stmt = mysqli_prepare($conn, $sql);

            mysqli_stmt_bind_param(
                $stmt,
                "ssii",
                $name,
                $logo_path,
                $status,
                $id
            );


            if (mysqli_stmt_execute($stmt)) {

                mysqli_stmt_close($stmt);

                header("Location: listing.php");
                exit;

            } else {

                mysqli_stmt_close($stmt);

                $error = "Unable to update client.";
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

    .logo-preview-box {
        background-color: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 16px;
    }

    .current-logo-wrapper {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 16px;
        padding-bottom: 16px;
        border-bottom: 1px solid #e5e7eb;
    }

    .logo-thumb-container {
        width: 140px;
        height: 75px;
        background-color: #ffffff;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 8px;
        box-sizing: border-box;
    }

    .current-logo-thumb {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .current-logo-meta {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .logo-meta-tag {
        display: inline-block;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        color: #2563eb;
        background-color: #eff6ff;
        padding: 2px 8px;
        border-radius: 4px;
        width: fit-content;
    }

    .logo-meta-path {
        font-size: 13px;
        color: #4b5563;
        font-family: monospace;
    }

    .no-logo-placeholder {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px;
        background-color: #ffffff;
        border: 1px dashed #d1d5db;
        border-radius: 6px;
        color: #9ca3af;
        font-size: 13px;
        margin-bottom: 14px;
    }

    .form-file-input {
        width: 100%;
        padding: 9px 12px;
        font-size: 14px;
        background-color: #ffffff;
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

        .current-logo-wrapper {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>

<div class="client-form-container">

    <div class="form-header-bar">
        <div>
            <h1>Edit Client</h1>
            <p>Update client name, corporate logo and website visibility.</p>
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
                    value="<?php echo htmlspecialchars($client['name']); ?>"
                    placeholder="e.g. Cochin Shipyard, L&T Shipbuilding"
                    required
                >
            </div>

            <div class="form-group">
                <label class="form-label">Client Logo</label>
                <div class="logo-preview-box">
                    <?php if (!empty($client['logo'])) { ?>
                        <div class="current-logo-wrapper">
                            <div class="logo-thumb-container">
                                <img
                                    src="../../<?php echo htmlspecialchars($client['logo']); ?>"
                                    class="current-logo-thumb"
                                    alt="<?php echo htmlspecialchars($client['name']); ?>"
                                >
                            </div>
                            <div class="current-logo-meta">
                                <span class="logo-meta-tag">Current Logo</span>
                                <span class="logo-meta-path"><?php echo htmlspecialchars(basename($client['logo'])); ?></span>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="no-logo-placeholder">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                <polyline points="21 15 16 10 5 21"></polyline>
                            </svg>
                            <span>No logo currently attached for this client</span>
                        </div>
                    <?php } ?>

                    <div class="replace-logo-wrapper">
                        <label class="form-label" for="client-logo" style="font-size: 12px; color: #6b7280; margin-bottom: 6px;">
                            <?php echo !empty($client['logo']) ? 'Upload New Logo to Replace' : 'Upload Client Logo'; ?>
                        </label>
                        <input
                            type="file"
                            id="client-logo"
                            name="logo"
                            class="form-file-input"
                            accept=".jpg,.jpeg,.png,.webp"
                        >
                        <div class="form-hint">Accepted formats: JPG, PNG, WEBP (Max: 5 MB). Leave empty to keep existing logo.</div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="status-checkbox-label" for="client-status">
                    <input
                        type="checkbox"
                        id="client-status"
                        name="status"
                        value="1"
                        <?php echo $client['status'] == 1 ? 'checked' : ''; ?>
                    >
                    <span>Active (Displayed on public website)</span>
                </label>
            </div>

            <div class="form-actions-bar">
                <button type="submit" name="update_client" class="btn-submit-client">
                    Update Client
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