<?php

require_once "../includes/auth.php";
require_once "../includes/db.php";
require_once "../includes/header.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: listing.php");
    exit;
}

$id = (int) $_GET['id'];

$sql = "SELECT
            e.*,
            p.name AS product_name
        FROM project_enquiries e
        LEFT JOIN products p ON e.product_id = p.id
        WHERE e.id = $id
        AND e.is_deleted = 0
        LIMIT 1";

$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) === 0) {
    header("Location: listing.php");
    exit;
}

$enquiry = mysqli_fetch_assoc($result);

function getStatus($status)
{
    switch ($status) {
        case 0:
            return "New";
        case 1:
            return "Contacted";
        case 2:
            return "In Progress";
        case 3:
            return "Closed";
        default:
            return "Unknown";
    }
}
?>

<style>
    .enquiry-view-container {
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

    .enquiry-card {
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
        margin-bottom: 28px;
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
        background-color: #ecfdf5;
        color: #047857;
        border: 1px solid #a7f3d0;
    }

    .requirement-box {
        background-color: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 18px 20px;
        font-size: 14px;
        line-height: 1.6;
        color: #374151;
        margin-bottom: 28px;
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

        .enquiry-card,
        .status-update-card {
            padding: 20px 18px;
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

<div class="enquiry-view-container">

    <div class="view-header-bar">
        <div>
            <h1>Enquiry Details</h1>
            <p>Review customer requirements, project specifications and manage enquiry status.</p>
        </div>
        <a href="listing.php" class="btn-back-link">
            &larr; Back to Enquiries
        </a>
    </div>

    <div class="enquiry-card">

        <!-- Contact & Company Section -->
        <h2 class="section-title">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
            </svg>
            <span>Customer &amp; Company Information</span>
        </h2>

        <div class="details-grid">
            <div class="detail-item">
                <span class="detail-label">Full Name</span>
                <span class="detail-value"><?php echo htmlspecialchars($enquiry['full_name']); ?></span>
            </div>

            <div class="detail-item">
                <span class="detail-label">Company Name</span>
                <span class="detail-value"><?php echo htmlspecialchars($enquiry['company_name']); ?></span>
            </div>

            <div class="detail-item">
                <span class="detail-label">Email Address</span>
                <span class="detail-value">
                    <a href="mailto:<?php echo htmlspecialchars($enquiry['email']); ?>">
                        <?php echo htmlspecialchars($enquiry['email']); ?>
                    </a>
                </span>
            </div>

            <div class="detail-item">
                <span class="detail-label">Mobile Number</span>
                <span class="detail-value">
                    <a href="tel:<?php echo htmlspecialchars($enquiry['mobile']); ?>">
                        <?php echo htmlspecialchars($enquiry['mobile']); ?>
                    </a>
                </span>
            </div>
        </div>

        <!-- Project Details Section -->
        <h2 class="section-title">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
            </svg>
            <span>Project &amp; Product Details</span>
        </h2>

        <div class="details-grid">
            <div class="detail-item">
                <span class="detail-label">Product Selected</span>
                <span class="detail-value">
                    <?php echo $enquiry['product_name'] ? htmlspecialchars($enquiry['product_name']) : 'N/A'; ?>
                </span>
            </div>

            <div class="detail-item">
                <span class="detail-label">Project Type</span>
                <span class="detail-value"><?php echo htmlspecialchars($enquiry['project_type']); ?></span>
            </div>

            <div class="detail-item">
                <span class="detail-label">Submitted On</span>
                <span class="detail-value">
                    <?php echo date('d M Y, h:i A', strtotime($enquiry['created_at'])); ?>
                </span>
            </div>

            <div class="detail-item">
                <span class="detail-label">Current Status</span>
                <div class="detail-value">
                    <span class="status-badge status-badge-<?php echo (int) $enquiry['status']; ?>">
                        <?php echo htmlspecialchars(getStatus($enquiry['status'])); ?>
                    </span>
                </div>
            </div>
        </div>

        <!-- Requirement Section -->
        <h2 class="section-title">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                <polyline points="14 2 14 8 20 8"></polyline>
                <line x1="16" y1="13" x2="8" y2="13"></line>
                <line x1="16" y1="17" x2="8" y2="17"></line>
                <polyline points="10 9 9 9 8 9"></polyline>
            </svg>
            <span>Project Requirement &amp; Specifications</span>
        </h2>

        <div class="requirement-box">
            <?php echo nl2br(htmlspecialchars($enquiry['requirement'])); ?>
        </div>

    </div>

    <!-- Status Management Card -->
    <div class="status-update-card">
        <h2 class="section-title" style="margin-bottom: 16px;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="9 11 12 14 22 4"></polyline>
                <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
            </svg>
            <span>Update Status</span>
        </h2>

        <form method="POST" action="status.php">
            <input type="hidden" name="id" value="<?php echo $enquiry['id']; ?>">

            <div class="status-form-row">
                <label for="status" class="detail-label" style="margin: 0; font-size: 13px;">Change Status:</label>
                <select name="status" id="status" class="status-select" required>
                    <option value="0" <?php echo $enquiry['status'] == 0 ? 'selected' : ''; ?>>
                        New
                    </option>
                    <option value="1" <?php echo $enquiry['status'] == 1 ? 'selected' : ''; ?>>
                        Contacted
                    </option>
                    <option value="2" <?php echo $enquiry['status'] == 2 ? 'selected' : ''; ?>>
                        In Progress
                    </option>
                    <option value="3" <?php echo $enquiry['status'] == 3 ? 'selected' : ''; ?>>
                        Closed
                    </option>
                </select>

                <button type="submit" class="btn-update-status">
                    Update Status
                </button>

                <a href="listing.php" class="btn-cancel-action">
                    Back to Enquiries
                </a>
            </div>
        </form>
    </div>

</div>

<?php
include "../includes/footer.php";
?>