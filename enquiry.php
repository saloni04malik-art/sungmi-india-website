<?php
/**
 * SUNGMI INDIA PRIVATE LIMITED - PROJECT ENQUIRY HANDLER
 * Handles AJAX form submissions, input sanitization, file uploads, 
 * validation, and persists submissions.
 */

header('Content-Type: application/json; charset=UTF-8');

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method Not Allowed']);
    exit;
}

$errors = [];

// 1. Sanitize and Extract Fields
$fullName      = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS) ?? '');
$companyName   = trim(filter_input(INPUT_POST, 'company', FILTER_SANITIZE_SPECIAL_CHARS) ?? '');
$email         = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL) ?? '');
$countryCode   = trim(filter_input(INPUT_POST, 'country_code', FILTER_SANITIZE_SPECIAL_CHARS) ?? '+91');
$phone         = trim(filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_SPECIAL_CHARS) ?? '');
$vesselName    = trim(filter_input(INPUT_POST, 'vessel', FILTER_SANITIZE_SPECIAL_CHARS) ?? '');
$projectType   = trim(filter_input(INPUT_POST, 'project_type', FILTER_SANITIZE_SPECIAL_CHARS) ?? '');
$productReq    = trim(filter_input(INPUT_POST, 'product_required', FILTER_SANITIZE_SPECIAL_CHARS) ?? '');
$location      = trim(filter_input(INPUT_POST, 'location', FILTER_SANITIZE_SPECIAL_CHARS) ?? '');
$startDate     = trim(filter_input(INPUT_POST, 'start_date', FILTER_SANITIZE_SPECIAL_CHARS) ?? '');
$message       = trim(filter_input(INPUT_POST, 'message', FILTER_SANITIZE_SPECIAL_CHARS) ?? '');

// 2. Validate Required Fields
if (empty($fullName)) {
    $errors['name'] = 'Full name is required.';
} elseif (strlen($fullName) < 2) {
    $errors['name'] = 'Please enter a valid full name.';
}

if (empty($companyName)) {
    $errors['company'] = 'Company name is required.';
}

if (empty($email)) {
    $errors['email'] = 'Email address is required.';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Please enter a valid email address.';
}

if (empty($phone)) {
    $errors['phone'] = 'Mobile number is required.';
} else {
    // Basic international phone digits validation (between 6 and 15 digits)
    $cleanPhone = preg_replace('/[^\d]/', '', $phone);
    if (strlen($cleanPhone) < 6 || strlen($cleanPhone) > 15) {
        $errors['phone'] = 'Please enter a valid phone number.';
    }
}

if (empty($projectType)) {
    $errors['project_type'] = 'Please select a project type.';
}

if (empty($productReq)) {
    $errors['product_required'] = 'Please select the product/solution required.';
}

if (empty($message)) {
    $errors['message'] = 'Please describe your project requirement.';
} elseif (strlen($message) < 10) {
    $errors['message'] = 'Please provide at least 10 characters describing your requirement.';
}

// 3. Handle File Uploads (Optional Documents)
$uploadedFiles = [];
$allowedExtensions = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'];
$maxFileSize = 10 * 1024 * 1024; // 10MB per file

if (!empty($_FILES['documents']['name'][0])) {
    $uploadDir = __DIR__ . '/uploads/enquiries/';
    if (!is_dir($uploadDir)) {
        @mkdir($uploadDir, 0755, true);
    }

    $fileCount = count($_FILES['documents']['name']);
    for ($i = 0; $i < $fileCount; $i++) {
        if ($_FILES['documents']['error'][$i] === UPLOAD_ERR_OK) {
            $fileName = $_FILES['documents']['name'][$i];
            $fileSize = $_FILES['documents']['size'][$i];
            $tmpPath  = $_FILES['documents']['tmp_name'][$i];
            $fileExt  = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            if (!in_array($fileExt, $allowedExtensions)) {
                $errors['documents'] = "File '{$fileName}' has an invalid format. Allowed: PDF, DOC, DOCX, JPG, PNG.";
                break;
            }

            if ($fileSize > $maxFileSize) {
                $errors['documents'] = "File '{$fileName}' exceeds the 10MB limit.";
                break;
            }

            // Generate safe unique filename
            $safeName = time() . '_' . uniqid() . '_' . preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $fileName);
            $destination = $uploadDir . $safeName;

            if (move_uploaded_file($tmpPath, $destination)) {
                $uploadedFiles[] = [
                    'original_name' => $fileName,
                    'saved_name'    => $safeName,
                    'size'          => $fileSize,
                    'path'          => 'uploads/enquiries/' . $safeName
                ];
            }
        }
    }
}

// 4. Return Validation Errors if any
if (!empty($errors)) {
    http_response_code(422);
    echo json_encode([
        'success' => false,
        'message' => 'Please correct the highlighted errors.',
        'errors'  => $errors
    ]);
    exit;
}

// 5. Store Enquiry Record
$enquiryRecord = [
    'id'           => 'ENQ-' . strtoupper(uniqid()),
    'timestamp'    => date('Y-m-d H:i:s'),
    'name'         => $fullName,
    'company'      => $companyName,
    'email'        => $email,
    'phone'        => $countryCode . ' ' . $phone,
    'vessel_name'  => $vesselName,
    'project_type' => $projectType,
    'product'      => $productReq,
    'location'     => $location,
    'start_date'   => $startDate,
    'message'      => $message,
    'files'        => $uploadedFiles,
    'ip'           => $_SERVER['REMOTE_ADDR'] ?? 'unknown'
];

$dataDir = __DIR__ . '/data/';
if (!is_dir($dataDir)) {
    @mkdir($dataDir, 0755, true);
}

$dataFile = $dataDir . 'enquiries.json';
$existingData = [];
if (file_exists($dataFile)) {
    $existingData = json_decode(file_get_contents($dataFile), true) ?? [];
}
$existingData[] = $enquiryRecord;
file_put_contents($dataFile, json_encode($existingData, JSON_PRETTY_PRINT));

// 6. Return Success Response
echo json_encode([
    'success' => true,
    'enquiry_id' => $enquiryRecord['id'],
    'message' => "Thank you, {$fullName}! Your project enquiry has been submitted successfully. Our marine engineering team will review your specifications and contact you shortly."
]);
