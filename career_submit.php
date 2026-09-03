<?php

header('Content-Type: application/json; charset=UTF-8');

require_once __DIR__ . '/admin/includes/db.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/PHPMailer/src/Exception.php';
require_once __DIR__ . '/PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/PHPMailer/src/SMTP.php';


/* =========================
   REQUEST CHECK
========================= */

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);

    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method.'
    ]);

    exit;
}


/* =========================
   FORM DATA
========================= */

$fullName       = trim($_POST['name'] ?? '');
$email          = trim($_POST['email'] ?? '');
$mobile         = trim($_POST['phone'] ?? '');
$areaOfInterest = trim($_POST['area_of_interest'] ?? '');
$message        = trim($_POST['message'] ?? '');
$roleTitle      = trim($_POST['role_title'] ?? '');

$errors = [];


/* =========================
   VALIDATION
========================= */

if ($fullName === '') {
    $errors['name'] = 'Full name is required.';
}

if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Please enter a valid email address.';
}

if ($mobile === '') {
    $errors['phone'] = 'Mobile number is required.';
}

if ($areaOfInterest === '') {
    $errors['area_of_interest'] = 'Area of interest is required.';
}

if (!isset($_FILES['resume'])) {
    $errors['resume'] = 'Please upload your CV.';
}

if (!empty($errors)) {

    http_response_code(422);

    echo json_encode([
        'success' => false,
        'message' => 'Please correct the highlighted fields.',
        'errors' => $errors
    ]);

    exit;
}


/* =========================
   CV VALIDATION
========================= */

$cv = $_FILES['resume'];

if ($cv['error'] !== UPLOAD_ERR_OK) {

    echo json_encode([
        'success' => false,
        'message' => 'CV upload failed. Please try again.'
    ]);

    exit;
}

if ($cv['size'] > 10 * 1024 * 1024) {

    echo json_encode([
        'success' => false,
        'message' => 'CV size must not exceed 10MB.'
    ]);

    exit;
}

$originalFileName = $cv['name'];

$extension = strtolower(
    pathinfo($originalFileName, PATHINFO_EXTENSION)
);

$allowedExtensions = [
    'pdf',
    'doc',
    'docx'
];

if (!in_array($extension, $allowedExtensions, true)) {

    echo json_encode([
        'success' => false,
        'message' => 'Only PDF, DOC and DOCX files are allowed.'
    ]);

    exit;
}


/* =========================
   MIME VALIDATION
========================= */

$finfo = finfo_open(FILEINFO_MIME_TYPE);

$mimeType = finfo_file(
    $finfo,
    $cv['tmp_name']
);

finfo_close($finfo);

$allowedMimeTypes = [
    'application/pdf',
    'application/msword',
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
];

if (!in_array($mimeType, $allowedMimeTypes, true)) {

    echo json_encode([
        'success' => false,
        'message' => 'Invalid CV file type.'
    ]);

    exit;
}


/* =========================
   FIND JOB ROLE
========================= */

$jobRoleId = null;

if ($roleTitle !== '') {

    $roleStmt = mysqli_prepare(
        $conn,
        "SELECT id
         FROM job_roles
         WHERE title = ?
         AND status = 1
         AND is_deleted = 0
         LIMIT 1"
    );

    if ($roleStmt) {

        mysqli_stmt_bind_param(
            $roleStmt,
            "s",
            $roleTitle
        );

        mysqli_stmt_execute($roleStmt);

        $roleResult = mysqli_stmt_get_result($roleStmt);

        if ($roleRow = mysqli_fetch_assoc($roleResult)) {
            $jobRoleId = (int)$roleRow['id'];
        }

        mysqli_stmt_close($roleStmt);
    }
}


/* =========================
   UPLOAD DIRECTORY
========================= */

$uploadDirectory = __DIR__ . '/admin/uploads/cvs/';

if (!is_dir($uploadDirectory)) {

    if (!mkdir($uploadDirectory, 0755, true)) {

        echo json_encode([
            'success' => false,
            'message' => 'Unable to create CV upload directory.'
        ]);

        exit;
    }
}


/* =========================
   SAVE CV
========================= */

$newFileName =
    bin2hex(random_bytes(16)) .
    '.' .
    $extension;

$physicalPath =
    $uploadDirectory .
    $newFileName;

if (!move_uploaded_file(
    $cv['tmp_name'],
    $physicalPath
)) {

    echo json_encode([
        'success' => false,
        'message' => 'Unable to save CV file.'
    ]);

    exit;
}

$dbCvPath =
    'admin/uploads/cvs/' .
    $newFileName;


/* =========================
   DATABASE INSERT
========================= */

if ($jobRoleId === null) {

    /*
     * IMPORTANT:
     * Explicit NULL is inserted.
     * This avoids converting NULL to 0.
     */

    $sql = "
        INSERT INTO job_applications
        (
            job_role_id,
            full_name,
            email,
            mobile,
            area_of_interest,
            cv_path,
            message,
            status,
            is_deleted
        )
        VALUES
        (
            NULL,
            ?,
            ?,
            ?,
            ?,
            ?,
            ?,
            0,
            0
        )
    ";

    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {

        if (file_exists($physicalPath)) {
            unlink($physicalPath);
        }

        echo json_encode([
            'success' => false,
            'message' => 'Database error: ' . mysqli_error($conn)
        ]);

        exit;
    }

    mysqli_stmt_bind_param(
        $stmt,
        "ssssss",
        $fullName,
        $email,
        $mobile,
        $areaOfInterest,
        $dbCvPath,
        $message
    );

} else {

    /*
     * Specific job role selected.
     */

    $sql = "
        INSERT INTO job_applications
        (
            job_role_id,
            full_name,
            email,
            mobile,
            area_of_interest,
            cv_path,
            message,
            status,
            is_deleted
        )
        VALUES
        (
            ?,
            ?,
            ?,
            ?,
            ?,
            ?,
            ?,
            0,
            0
        )
    ";

    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {

        if (file_exists($physicalPath)) {
            unlink($physicalPath);
        }

        echo json_encode([
            'success' => false,
            'message' => 'Database error: ' . mysqli_error($conn)
        ]);

        exit;
    }

    mysqli_stmt_bind_param(
        $stmt,
        "issssss",
        $jobRoleId,
        $fullName,
        $email,
        $mobile,
        $areaOfInterest,
        $dbCvPath,
        $message
    );
}


/* =========================
   EXECUTE INSERT
========================= */

if (!mysqli_stmt_execute($stmt)) {

    $error = mysqli_stmt_error($stmt);

    mysqli_stmt_close($stmt);

    if (file_exists($physicalPath)) {
        unlink($physicalPath);
    }

    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $error
    ]);

    exit;
}

$applicationId = mysqli_insert_id($conn);

mysqli_stmt_close($stmt);


/* =========================
   GET CURRENT ADMIN EMAIL
========================= */

$adminEmail = '';

$adminResult = mysqli_query(
    $conn,
    "SELECT email
     FROM admins
     WHERE status = 1
     LIMIT 1"
);

if ($adminResult) {

    $adminRow = mysqli_fetch_assoc($adminResult);

    if ($adminRow) {
        $adminEmail = $adminRow['email'];
    }
}


/* =========================
   SEND EMAIL
========================= */

if ($adminEmail !== '') {

    $mail = new PHPMailer(true);

    try {

        $mail->isSMTP();

        $mail->Host = getenv('SMTP_HOST') ?: 'smtp.gmail.com';

        $mail->SMTPAuth = true;

        $mail->Username = getenv('SMTP_USER') ?: '';

        $mail->Password = getenv('SMTP_PASS') ?: '';

        $mail->SMTPSecure =
            PHPMailer::ENCRYPTION_STARTTLS;

        $mail->Port = (int)(getenv('SMTP_PORT') ?: 587);

        $mail->setFrom(
            getenv('SMTP_FROM_EMAIL') ?: (getenv('SMTP_USER') ?: 'info@sungmi.co.in'),
            getenv('SMTP_FROM_NAME') ?: 'Sungmi India Website'
        );

        /*
         * Current active admin receives email
         */

        $mail->addAddress($adminEmail);

        /*
         * Attach CV
         */

        $mail->addAttachment(
            $physicalPath,
            $originalFileName
        );

        $mail->isHTML(false);

        $mail->Subject =
            'New Job Application - Sungmi India';

        $mail->Body =
            "A new job application has been received.\n\n" .

            "Application ID: " .
            $applicationId .
            "\n" .

            "Name: " .
            $fullName .
            "\n" .

            "Email: " .
            $email .
            "\n" .

            "Mobile: " .
            $mobile .
            "\n" .

            "Area of Interest: " .
            $areaOfInterest .
            "\n" .

            "Applied Role: " .
            ($roleTitle ?: 'General Application') .
            "\n\n" .

            "Message:\n" .
            ($message ?: 'N/A');

        $mail->send();

    } catch (Exception $e) {

        error_log(
            'Job Application Email Error: ' .
            $mail->ErrorInfo
        );
    }
}


/* =========================
   SUCCESS
========================= */

echo json_encode([
    'success' => true,
    'application_id' => $applicationId,
    'message' =>
        'Thank you, ' .
        $fullName .
        '! Your application has been submitted successfully.'
]);

exit;