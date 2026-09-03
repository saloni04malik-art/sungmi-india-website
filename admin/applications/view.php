<?php

require '../includes/auth.php';
require '../includes/db.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    header("Location: listing.php");
    exit;
}


$stmt = mysqli_prepare(
    $conn,
    "SELECT
        ja.*,
        jr.title AS job_role
     FROM job_applications ja
     LEFT JOIN job_roles jr
        ON ja.job_role_id = jr.id
     WHERE ja.id = ?
       AND ja.is_deleted = 0
     LIMIT 1"
);

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$application = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);


if (!$application) {
    header("Location: listing.php");
    exit;
}


function getStatusName($status)
{
    switch ((int) $status) {

        case 0:
            return 'New';

        case 1:
            return 'Reviewed';

        case 2:
            return 'Shortlisted';

        case 3:
            return 'Rejected';

        case 4:
            return 'Hired';

        default:
            return 'Unknown';
    }
}

include '../includes/header.php';

?>

<style>
    .application-view-container {
        max-width: 880px;
    }

    .view-header-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 12px;
    }

    .view-header-bar h1 {
        margin: 0 0 4px 0;
        font-size: 24px;
        font-weight: 700;
        color: #111827;
    }

    .view-header-bar p {
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

    .app-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 30px 28px;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
        margin-bottom: 24px;
    }

    .section-title {
        font-size: 16px;
        font-weight: 700;
        color: #111827;
        margin: 0 0 18px 0;
        padding-bottom: 10px;
        border-bottom: 1px solid #f3f4f6;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .details-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 24px;
    }

    .detail-item {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .detail-label {
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #6b7280;
    }

    .detail-value {
        font-size: 15px;
        font-weight: 500;
        color: #111827;
        word-break: break-word;
    }

    .detail-value a {
        color: #2563eb;
        text-decoration: none;
    }

    .detail-value a:hover {
        text-decoration: underline;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        width: fit-content;
    }

    .status-badge-0 {
        background-color: #eff6ff;
        color: #1d4ed8;
        border: 1px solid #bfdbfe;
    }

    .status-badge-1 {
        background-color: #f5f3ff;
        color: #6d28d9;
        border: 1px solid #ddd6fe;
    }

    .status-badge-2 {
        background-color: #fffbeb;
        color: #b45309;
        border: 1px solid #fde68a;
    }

    .status-badge-3 {
        background-color: #fef2f2;
        color: #b91c1c;
        border: 1px solid #fecaca;
    }

    .status-badge-4 {
        background-color: #ecfdf5;
        color: #047857;
        border: 1px solid #a7f3d0;
    }

    .message-box {
        background-color: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 18px 20px;
        font-size: 14px;
        line-height: 1.6;
        color: #374151;
        margin-bottom: 24px;
    }

    .cv-download-box {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 16px 20px;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 12px;
    }

    .cv-info-wrapper {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .cv-icon-box {
        width: 42px;
        height: 42px;
        background-color: #eff6ff;
        border: 1px solid #bfdbfe;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #2563eb;
    }

    .btn-download-cv {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        height: 40px;
        padding: 0 18px;
        font-size: 13px;
        font-weight: 600;
        color: #ffffff;
        background-color: #0284c7;
        border: none;
        border-radius: 8px;
        text-decoration: none;
        transition: background-color 0.15s ease;
    }

    .btn-download-cv:hover {
        background-color: #0369a1;
    }

    .status-update-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 24px 28px;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
    }

    .status-form-row {
        display: flex;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
    }

    .status-select {
        height: 44px;
        padding: 0 14px;
        font-size: 14px;
        background-color: #ffffff;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        color: #111827;
        min-width: 220px;
        cursor: pointer;
        transition: border-color 0.15s ease, box-shadow 0.15s ease;
    }

    .status-select:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
    }

    .btn-update-status {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        height: 44px;
        padding: 0 24px;
        font-size: 14px;
        font-weight: 600;
        color: #ffffff;
        background-color: #2563eb;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.15s ease, transform 0.05s ease;
    }

    .btn-update-status:hover {
        background-color: #1d4ed8;
    }

    .btn-update-status:active {
        background-color: #1e40af;
        transform: scale(0.99);
    }

    .btn-cancel-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        height: 44px;
        padding: 0 18px;
        font-size: 14px;
        font-weight: 500;
        color: #4b5563;
        background-color: #f3f4f6;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        text-decoration: none;
        transition: background-color 0.15s ease, color 0.15s ease;
    }

    .btn-cancel-action:hover {
        background-color: #e5e7eb;
        color: #111827;
    }

    @media (max-width: 640px) {
        .details-grid {
            grid-template-columns: 1fr;
        }

        .app-card,
        .status-update-card {
            padding: 20px 18px;
        }

        .cv-download-box {
            flex-direction: column;
            align-items: flex-start;
        }

        .status-form-row {
            flex-direction: column;
            align-items: stretch;
        }

        .status-select,
        .btn-update-status,
        .btn-cancel-action {
            width: 100%;
            box-sizing: border-box;
        }
    }
</style>

<div class="application-view-container">

    <div class="view-header-bar">
        <div>
            <h1>Application Details</h1>
            <p>Review candidate details, applied position and update application status.</p>
        </div>
        <a href="listing.php" class="btn-back-link">
            &larr; Back to Applications
        </a>
    </div>

    <div class="app-card">

        <!-- Applicant Details Section -->
        <h2 class="section-title">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
            </svg>
            <span>Applicant Information</span>
        </h2>

        <div class="details-grid">
            <div class="detail-item">
                <span class="detail-label">Full Name</span>
                <span class="detail-value"><?php echo htmlspecialchars($application['full_name']); ?></span>
            </div>

            <div class="detail-item">
                <span class="detail-label">Email Address</span>
                <span class="detail-value">
                    <a href="mailto:<?php echo htmlspecialchars($application['email']); ?>">
                        <?php echo htmlspecialchars($application['email']); ?>
                    </a>
                </span>
            </div>

            <div class="detail-item">
                <span class="detail-label">Mobile Number</span>
                <span class="detail-value">
                    <a href="tel:<?php echo htmlspecialchars($application['mobile']); ?>">
                        <?php echo htmlspecialchars($application['mobile']); ?>
                    </a>
                </span>
            </div>

            <div class="detail-item">
                <span class="detail-label">Area of Interest</span>
                <span class="detail-value"><?php echo htmlspecialchars($application['area_of_interest']); ?></span>
            </div>

            <div class="detail-item">
                <span class="detail-label">Applied Role</span>
                <span class="detail-value">
                    <?php echo htmlspecialchars($application['job_role'] ?: 'General Application'); ?>
                </span>
            </div>

            <div class="detail-item">
                <span class="detail-label">Application Date</span>
                <span class="detail-value">
                    <?php echo date('d M Y, h:i A', strtotime($application['created_at'])); ?>
                </span>
            </div>

            <div class="detail-item">
                <span class="detail-label">Current Status</span>
                <div class="detail-value">
                    <span class="status-badge status-badge-<?php echo (int) $application['status']; ?>">
                        <?php echo htmlspecialchars(getStatusName($application['status'])); ?>
                    </span>
                </div>
            </div>
        </div>

        <!-- Message / Introduction -->
        <h2 class="section-title">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
            </svg>
            <span>Message / Introduction</span>
        </h2>

        <div class="message-box">
            <?php if (!empty($application['message'])): ?>
                <?php echo nl2br(htmlspecialchars($application['message'])); ?>
            <?php else: ?>
                <span style="color: #9ca3af; font-style: italic;">No message provided by candidate.</span>
            <?php endif; ?>
        </div>

        <!-- CV / Resume Section -->
        <h2 class="section-title">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                <polyline points="14 2 14 8 20 8"></polyline>
                <line x1="16" y1="13" x2="8" y2="13"></line>
                <line x1="16" y1="17" x2="8" y2="17"></line>
                <polyline points="10 9 9 9 8 9"></polyline>
            </svg>
            <span>Curriculum Vitae (CV / Resume)</span>
        </h2>

        <div class="cv-download-box">
            <div class="cv-info-wrapper">
                <div class="cv-icon-box">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                    </svg>
                </div>
                <div>
                    <div style="font-size: 14px; font-weight: 600; color: #1e293b;">
                        <?php echo htmlspecialchars($application['full_name']); ?> — Resume
                    </div>
                    <div style="font-size: 12px; color: #64748b;">
                        Candidate attached document
                    </div>
                </div>
            </div>

            <a href="download_cv.php?id=<?php echo (int) $application['id']; ?>" class="btn-download-cv">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                    <polyline points="7 10 12 15 17 10"></polyline>
                    <line x1="12" y1="15" x2="12" y2="3"></line>
                </svg>
                <span>Download CV</span>
            </a>
        </div>

    </div>

    <!-- Status Management Card -->
    <div class="status-update-card">
        <h2 class="section-title" style="margin-bottom: 16px;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="9 11 12 14 22 4"></polyline>
                <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
            </svg>
            <span>Update Application Status</span>
        </h2>

        <form method="POST" action="status.php">
            <input type="hidden" name="id" value="<?php echo (int) $application['id']; ?>">

            <div class="status-form-row">
                <label for="status" class="detail-label" style="margin: 0; font-size: 13px;">Status Decision:</label>
                <select name="status" id="status" class="status-select" required>
                    <option value="0" <?php echo $application['status'] == 0 ? 'selected' : ''; ?>>
                        New
                    </option>
                    <option value="1" <?php echo $application['status'] == 1 ? 'selected' : ''; ?>>
                        Reviewed
                    </option>
                    <option value="2" <?php echo $application['status'] == 2 ? 'selected' : ''; ?>>
                        Shortlisted
                    </option>
                    <option value="3" <?php echo $application['status'] == 3 ? 'selected' : ''; ?>>
                        Rejected
                    </option>
                    <option value="4" <?php echo $application['status'] == 4 ? 'selected' : ''; ?>>
                        Hired
                    </option>
                </select>

                <button type="submit" class="btn-update-status">
                    Update Status
                </button>

                <a href="listing.php" class="btn-cancel-action">
                    Back to Applications
                </a>
            </div>
        </form>
    </div>

</div>

<?php include '../includes/footer.php'; ?>