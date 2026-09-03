<?php

header('Content-Type: application/json; charset=UTF-8');

require_once __DIR__ . '/admin/includes/db.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/PHPMailer/src/Exception.php';
require_once __DIR__ . '/PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/PHPMailer/src/SMTP.php';


/* Only POST requests */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);

    echo json_encode([
        'success' => false,
        'message' => 'Method Not Allowed'
    ]);

    exit;
}


/* Get form data */
$fullName = trim($_POST['name'] ?? '');
$companyName = trim($_POST['company'] ?? '');
$email = trim($_POST['email'] ?? '');
$countryCode = trim($_POST['country_code'] ?? '+91');
$phone = trim($_POST['phone'] ?? '');

$vesselName = trim($_POST['vessel'] ?? '');
$projectType = trim($_POST['project_type'] ?? '');
$productReq = trim($_POST['product_required'] ?? '');
$location = trim($_POST['location'] ?? '');
$startDate = trim($_POST['start_date'] ?? '');
$message = trim($_POST['message'] ?? '');

$errors = [];


/* Validation */

if ($fullName === '') {
    $errors['name'] = 'Full name is required.';
} elseif (strlen($fullName) < 2) {
    $errors['name'] = 'Please enter a valid full name.';
}


if ($companyName === '') {
    $errors['company'] = 'Company name is required.';
}


if ($email === '') {
    $errors['email'] = 'Email address is required.';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Please enter a valid email address.';
}


if ($phone === '') {

    $errors['phone'] = 'Mobile number is required.';

} else {

    $cleanPhone = preg_replace('/[^\d]/', '', $phone);

    if (strlen($cleanPhone) < 6 || strlen($cleanPhone) > 15) {
        $errors['phone'] = 'Please enter a valid phone number.';
    }
}


if ($projectType === '') {
    $errors['project_type'] = 'Please select a project type.';
}


if ($productReq === '') {
    $errors['product_required'] = 'Please select the product/solution required.';
}


if ($message === '') {

    $errors['message'] = 'Please describe your project requirement.';

} elseif (strlen($message) < 10) {

    $errors['message'] = 'Please provide at least 10 characters describing your requirement.';
}


/* Return validation errors */

if (!empty($errors)) {

    http_response_code(422);

    echo json_encode([
        'success' => false,
        'message' => 'Please correct the highlighted errors.',
        'errors' => $errors
    ]);

    exit;
}


/* Find product ID */

$productId = null;

$productMap = [
    'Fire Resistant Doors' => 'FIRE RESISTANT DOORS',
    'Wall Panels' => 'WALL PANELS',
    'Ceiling Panels' => 'CEILING PANELS',
    'Wet Units / Toilet Modules' => 'MARINE WET UNITS',
    'Modular Cabins' => 'MODULAR CABINS'
];

if (isset($productMap[$productReq])) {

    $productName = $productMap[$productReq];

    $productStmt = mysqli_prepare(
        $conn,
        "SELECT id FROM products
         WHERE name = ?
         AND status = 1
         AND is_deleted = 0
         LIMIT 1"
    );

    mysqli_stmt_bind_param(
        $productStmt,
        "s",
        $productName
    );

    mysqli_stmt_execute($productStmt);

    $productResult = mysqli_stmt_get_result($productStmt);

    if ($productRow = mysqli_fetch_assoc($productResult)) {
        $productId = (int) $productRow['id'];
    }

    mysqli_stmt_close($productStmt);
}


/* Build requirement text */

$requirement = $message;

if ($vesselName !== '') {
    $requirement .= "\n\nVessel Name: " . $vesselName;
}

if ($location !== '') {
    $requirement .= "\nLocation: " . $location;
}

if ($startDate !== '') {
    $requirement .= "\nExpected Start Date: " . $startDate;
}


/* Save enquiry */

$sql = "INSERT INTO project_enquiries
        (
            full_name,
            company_name,
            email,
            mobile,
            product_id,
            project_type,
            requirement,
            status,
            is_deleted
        )
        VALUES (?, ?, ?, ?, ?, ?, ?, 0, 0)";

$stmt = mysqli_prepare($conn, $sql);

$mobile = $countryCode . ' ' . $phone;

mysqli_stmt_bind_param(
    $stmt,
    "ssssiss",
    $fullName,
    $companyName,
    $email,
    $mobile,
    $productId,
    $projectType,
    $requirement
);

if (!mysqli_stmt_execute($stmt)) {

    mysqli_stmt_close($stmt);

    http_response_code(500);

    echo json_encode([
        'success' => false,
        'message' => 'Unable to submit your enquiry. Please try again later.'
    ]);

    exit;
}

$enquiryId = mysqli_insert_id($conn);

mysqli_stmt_close($stmt);


/* Get current admin email */

$adminResult = mysqli_query(
    $conn,
    "SELECT email
     FROM admins
     WHERE status = 1
     LIMIT 1"
);

$adminRow = mysqli_fetch_assoc($adminResult);

$adminEmail = $adminRow['email'] ?? '';


/* Send email */

$emailSent = false;

if ($adminEmail !== '') {

    $mail = new PHPMailer(true);

    try {

        $mail->isSMTP();
        $mail->Host = getenv('SMTP_HOST') ?: 'smtp.gmail.com';
        $mail->SMTPAuth = true;

        $mail->Username = getenv('SMTP_USER') ?: '';
        $mail->Password = getenv('SMTP_PASS') ?: '';

        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = (int)(getenv('SMTP_PORT') ?: 587);

        $mail->setFrom(
            getenv('SMTP_FROM_EMAIL') ?: (getenv('SMTP_USER') ?: 'info@sungmi.co.in'),
            getenv('SMTP_FROM_NAME') ?: 'Sungmi India Website'
        );

        $mail->addAddress($adminEmail);

        $mail->Subject = 'New Project Enquiry - Sungmi India';

        $mail->Body =
            "A new project enquiry has been received.\n\n" .

            "Name: " . $fullName . "\n" .
            "Company: " . $companyName . "\n" .
            "Email: " . $email . "\n" .
            "Mobile: " . $mobile . "\n" .
            "Product: " . $productReq . "\n" .
            "Project Type: " . $projectType . "\n" .
            "Vessel Name: " . ($vesselName ?: 'N/A') . "\n" .
            "Location: " . ($location ?: 'N/A') . "\n" .
            "Expected Start Date: " . ($startDate ?: 'N/A') . "\n\n" .

            "Requirement:\n" .
            $message;

        $mail->send();

        $emailSent = true;

    } catch (Exception $e) {

        $emailSent = false;
    }
}


/* Final response */

echo json_encode([
    'success' => true,
    'enquiry_id' => $enquiryId,
    'message' => "Thank you, {$fullName}! Your project enquiry has been submitted successfully."
]);