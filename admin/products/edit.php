
<?php

require_once "../includes/auth.php";
require_once "../includes/db.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = (int) $_GET['id'];

$error = "";
$message = "";


/* Get product */

$sql = "SELECT *
        FROM products
        WHERE id = ? AND is_deleted = 0
        LIMIT 1";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "i", $id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$product = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);


if (!$product) {
    header("Location: index.php");
    exit;
}


/* Get features */

$sql = "SELECT id, feature, display_order
        FROM product_features
        WHERE product_id = ?
        ORDER BY display_order ASC, id ASC";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "i", $id);

mysqli_stmt_execute($stmt);

$features_result = mysqli_stmt_get_result($stmt);

$existing_features = [];

while ($row = mysqli_fetch_assoc($features_result)) {
    $existing_features[] = $row;
}

mysqli_stmt_close($stmt);


/* Update product */

if (isset($_POST['update_product'])) {

    $display_order = (int) $_POST['display_order'];
    $name = trim($_POST['name']);
    $category = trim($_POST['category'] ?? '');
    if ($category === 'other' && !empty($_POST['custom_category'])) {
        $category = trim($_POST['custom_category']);
    }
    $short_description = trim($_POST['short_description']);
    $status = isset($_POST['status']) ? 1 : 0;

    $features = $_POST['features'] ?? [];

    if ($name == "") {

        $error = "Product name is required.";

    } elseif ($category == "") {

        $error = "Product category is required.";

    } else {

        $image_path = $product['image'];

        /* New image */

        if (
            isset($_FILES['image']) &&
            $_FILES['image']['error'] != UPLOAD_ERR_NO_FILE
        ) {

            if ($_FILES['image']['error'] != UPLOAD_ERR_OK) {

                $error = "Image upload failed.";

            } elseif ($_FILES['image']['size'] > 5 * 1024 * 1024) {

                $error = "Image must be less than 5 MB.";

            } else {

                $tmp_name = $_FILES['image']['tmp_name'];

                $image_info = getimagesize($tmp_name);

                if ($image_info === false) {

                    $error = "Please upload a valid image.";

                } else {

                    $allowed_types = [
                        'image/jpeg' => 'jpg',
                        'image/png'  => 'png',
                        'image/webp' => 'webp'
                    ];

                    $mime_type = $image_info['mime'];

                    if (!isset($allowed_types[$mime_type])) {

                        $error = "Only JPG, PNG and WEBP images are allowed.";

                    } else {

                        $file_name = bin2hex(random_bytes(8))
                            . '.'
                            . $allowed_types[$mime_type];

                        $upload_directory = "../uploads/products/";

                        if (!is_dir($upload_directory)) {
                            mkdir($upload_directory, 0755, true);
                        }

                        $destination = $upload_directory . $file_name;

                        if (move_uploaded_file($tmp_name, $destination)) {

                            $image_path = "admin/uploads/products/" . $file_name;

                        } else {

                            $error = "Unable to save image.";
                        }
                    }
                }
            }
        }


        if ($error == "") {

            $sql = "UPDATE products
                    SET display_order = ?,
                        name = ?,
                        category = ?,
                        short_description = ?,
                        image = ?,
                        status = ?
                    WHERE id = ? AND is_deleted = 0";

            $stmt = mysqli_prepare($conn, $sql);

            mysqli_stmt_bind_param(
                $stmt,
                "issssii",
                $display_order,
                $name,
                $category,
                $short_description,
                $image_path,
                $status,
                $id
            );

            if (mysqli_stmt_execute($stmt)) {

                mysqli_stmt_close($stmt);

                /* Remove old feature records */

                $sql = "DELETE FROM product_features
                        WHERE product_id = ?";

                $stmt = mysqli_prepare($conn, $sql);

                mysqli_stmt_bind_param($stmt, "i", $id);

                mysqli_stmt_execute($stmt);

                mysqli_stmt_close($stmt);


                /* Insert updated features */

                foreach ($features as $index => $feature) {

                    $feature = trim($feature);

                    if ($feature != "") {

                        $feature_order = $index + 1;

                        $sql = "INSERT INTO product_features
                                (product_id, feature, display_order)
                                VALUES (?, ?, ?)";

                        $stmt = mysqli_prepare($conn, $sql);

                        mysqli_stmt_bind_param(
                            $stmt,
                            "isi",
                            $id,
                            $feature,
                            $feature_order
                        );

                        mysqli_stmt_execute($stmt);

                        mysqli_stmt_close($stmt);
                    }
                }

                header("Location: index.php");
                exit;

            } else {

                mysqli_stmt_close($stmt);

                $error = "Unable to update product.";
            }
        }
    }
}


require_once "../includes/header.php";

?>

<style>
    .product-form-container {
        max-width: 860px;
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

    .product-form-alert {
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

    .product-form-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 32px 28px;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
    }

    .form-grid-row {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 20px;
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

    textarea.form-control {
        height: auto;
        padding: 12px 14px;
        min-height: 85px;
        line-height: 1.5;
        resize: vertical;
    }

    .form-hint {
        font-size: 12px;
        color: #6b7280;
        margin-top: 5px;
    }

    .image-preview-box {
        background-color: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 16px;
    }

    .current-image-wrapper {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 16px;
        padding-bottom: 16px;
        border-bottom: 1px solid #e5e7eb;
    }

    .current-image-thumb {
        width: 100px;
        height: 75px;
        object-fit: cover;
        border-radius: 6px;
        border: 1px solid #d1d5db;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        background-color: #ffffff;
    }

    .current-image-meta {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .image-meta-tag {
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

    .image-meta-path {
        font-size: 13px;
        color: #4b5563;
        font-family: monospace;
    }

    .no-image-placeholder {
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

    .features-section-box {
        background-color: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 24px;
    }

    .features-section-title {
        font-size: 15px;
        font-weight: 600;
        color: #111827;
        margin: 0 0 4px 0;
    }

    .features-section-desc {
        font-size: 13px;
        color: #6b7280;
        margin: 0 0 16px 0;
    }

    .feature-row {
        display: flex;
        gap: 10px;
        margin-bottom: 12px;
        align-items: center;
    }

    .feature-row .form-control {
        flex: 1;
        background-color: #ffffff;
    }

    .btn-remove-feature {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        height: 44px;
        padding: 0 14px;
        font-size: 13px;
        font-weight: 500;
        color: #ef4444;
        background-color: #fee2e2;
        border: 1px solid #fecaca;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.15s ease, color 0.15s ease;
        flex-shrink: 0;
    }

    .btn-remove-feature:hover {
        background-color: #fca5a5;
        color: #991b1b;
    }

    .btn-add-feature {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        height: 38px;
        padding: 0 16px;
        font-size: 13px;
        font-weight: 600;
        color: #2563eb;
        background-color: #eff6ff;
        border: 1px dashed #bfdbfe;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.15s ease, border-color 0.15s ease;
    }

    .btn-add-feature:hover {
        background-color: #dbeafe;
        border-color: #93c5fd;
    }

    .form-actions-bar {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-top: 30px;
        padding-top: 22px;
        border-top: 1px solid #e5e7eb;
    }

    .btn-submit-product {
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

    .btn-submit-product:hover {
        background-color: #1d4ed8;
    }

    .btn-submit-product:active {
        background-color: #1e40af;
        transform: scale(0.99);
    }

    .btn-cancel-product {
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

    .btn-cancel-product:hover {
        background-color: #e5e7eb;
        color: #111827;
    }

    @media (max-width: 680px) {
        .form-grid-row {
            grid-template-columns: 1fr;
        }

        .product-form-card {
            padding: 22px 18px;
        }

        .feature-row {
            flex-direction: column;
            align-items: stretch;
        }

        .btn-remove-feature {
            justify-content: center;
        }

        .current-image-wrapper {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>

<div class="product-form-container">

    <div class="form-header-bar">
        <div>
            <h1>Edit Product</h1>
            <p>Update product specifications, images and display settings.</p>
        </div>
        <a href="index.php" class="btn-back-link">
            &larr; Back to Products
        </a>
    </div>

    <?php if ($error != "") { ?>
        <div class="product-form-alert" role="alert">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="8" x2="12" y2="12"></line>
                <line x1="12" y1="16" x2="12.01" y2="16"></line>
            </svg>
            <span><?php echo htmlspecialchars($error); ?></span>
        </div>
    <?php } ?>

    <div class="product-form-card">

        <form method="POST" enctype="multipart/form-data">

            <?php 
                $currentCat = $product['category'] ?? '';
                $standardCats = ['door', 'wall', 'ceiling', 'wetunit', 'cabin'];
                $isCustom = !empty($currentCat) && !in_array($currentCat, $standardCats);
            ?>
            <div class="form-grid-row">
                <div class="form-group">
                    <label class="form-label" for="product-name">
                        Product Name <span class="required-mark">*</span>
                    </label>
                    <input
                        type="text"
                        id="product-name"
                        name="name"
                        class="form-control"
                        value="<?php echo htmlspecialchars($product['name']); ?>"
                        placeholder="e.g. Fire Resistant Doors"
                        required
                    >
                </div>

                <div class="form-group">
                    <label class="form-label" for="product-order">
                        Display Order <span class="required-mark">*</span>
                    </label>
                    <input
                        type="number"
                        id="product-order"
                        name="display_order"
                        class="form-control"
                        value="<?php echo (int) $product['display_order']; ?>"
                        min="1"
                        required
                    >
                </div>
            </div>

            <div class="form-grid-row">
                <div class="form-group">
                    <label class="form-label" for="product-category">
                        Category (360° Inspector Model) <span class="required-mark">*</span>
                    </label>
                    <select
                        id="product-category"
                        name="category"
                        class="form-control"
                        required
                        onchange="toggleCustomCategory(this.value)"
                    >
                        <option value="">-- Select Category / 360 Model --</option>
                        <option value="door" <?php echo ($currentCat === 'door') ? 'selected' : ''; ?>>Fire Resistant Doors (door)</option>
                        <option value="wall" <?php echo ($currentCat === 'wall') ? 'selected' : ''; ?>>Wall Panels (wall)</option>
                        <option value="ceiling" <?php echo ($currentCat === 'ceiling') ? 'selected' : ''; ?>>Ceiling Panels (ceiling)</option>
                        <option value="wetunit" <?php echo ($currentCat === 'wetunit') ? 'selected' : ''; ?>>Marine Wet Units (wetunit)</option>
                        <option value="cabin" <?php echo ($currentCat === 'cabin') ? 'selected' : ''; ?>>Modular Cabins (cabin)</option>
                        <option value="other" <?php echo $isCustom ? 'selected' : ''; ?>>Other / Custom Category...</option>
                    </select>
                    <div class="form-hint">Used for 360° interactive inspection model &amp; technical inspector.</div>

                    <div id="custom-category-wrap" style="display: <?php echo $isCustom ? 'block' : 'none'; ?>; margin-top: 10px;">
                        <label class="form-label" for="custom-category" style="font-size: 12px; color: #4b5563;">Custom Category Name / Slug</label>
                        <input
                            type="text"
                            id="custom-category"
                            name="custom_category"
                            class="form-control"
                            value="<?php echo $isCustom ? htmlspecialchars($currentCat) : ''; ?>"
                            placeholder="Enter custom category (e.g. furniture, windows)"
                        >
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="product-desc">Short Description / Subtitle</label>
                    <textarea
                        id="product-desc"
                        name="short_description"
                        class="form-control"
                        rows="3"
                        placeholder="Brief technical summary or class badge (e.g. ABS Approved, Pre Modular)..."
                    ><?php echo htmlspecialchars($product['short_description'] ?? ''); ?></textarea>
                    <div class="form-hint">Displayed as a tag badge on the public product card.</div>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Product Image</label>
                <div class="image-preview-box">
                    <?php if (!empty($product['image'])) { ?>
                        <div class="current-image-wrapper">
                            <img
                                src="../../<?php echo htmlspecialchars($product['image']); ?>"
                                class="current-image-thumb"
                                alt="<?php echo htmlspecialchars($product['name']); ?>"
                            >
                            <div class="current-image-meta">
                                <span class="image-meta-tag">Current Image</span>
                                <span class="image-meta-path"><?php echo htmlspecialchars(basename($product['image'])); ?></span>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="no-image-placeholder">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                <polyline points="21 15 16 10 5 21"></polyline>
                            </svg>
                            <span>No image currently attached to this product</span>
                        </div>
                    <?php } ?>

                    <div class="replace-image-wrapper">
                        <label class="form-label" for="product-image" style="font-size: 12px; color: #6b7280; margin-bottom: 6px;">
                            <?php echo !empty($product['image']) ? 'Upload New Image to Replace' : 'Upload Product Image'; ?>
                        </label>
                        <input
                            type="file"
                            id="product-image"
                            name="image"
                            class="form-file-input"
                            accept=".jpg,.jpeg,.png,.webp"
                        >
                        <div class="form-hint">Accepted formats: JPG, PNG, WEBP (Max: 5 MB). Leave empty to keep the current image.</div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="status-checkbox-label" for="product-status">
                    <input
                        type="checkbox"
                        id="product-status"
                        name="status"
                        value="1"
                        <?php echo $product['status'] == 1 ? 'checked' : ''; ?>
                    >
                    <span>Active (Visible on public website)</span>
                </label>
            </div>

            <!-- Product Features Section -->
            <div class="features-section-box">
                <h3 class="features-section-title">Product Features &amp; Specifications</h3>
                <p class="features-section-desc">Add key technical specifications displayed as checkmarked bullets on the card.</p>

                <div class="features-list" id="features">
                    <?php foreach ($existing_features as $feature) { ?>
                        <div class="feature-row">
                            <input
                                type="text"
                                name="features[]"
                                class="form-control"
                                value="<?php echo htmlspecialchars($feature['feature']); ?>"
                                placeholder="Enter product feature"
                            >
                            <button
                                type="button"
                                class="btn-remove-feature"
                                onclick="this.parentElement.remove()"
                                title="Remove this feature"
                            >
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                </svg>
                                <span>Remove</span>
                            </button>
                        </div>
                    <?php } ?>

                    <?php if (count($existing_features) == 0) { ?>
                        <div class="feature-row">
                            <input
                                type="text"
                                name="features[]"
                                class="form-control"
                                placeholder="Enter product feature"
                            >
                            <button
                                type="button"
                                class="btn-remove-feature"
                                onclick="this.parentElement.remove()"
                                title="Remove this feature"
                            >
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                </svg>
                                <span>Remove</span>
                            </button>
                        </div>
                    <?php } ?>
                </div>

                <button type="button" class="btn-add-feature" onclick="addFeature()">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    <span>Add Another Feature</span>
                </button>
            </div>

            <div class="form-actions-bar">
                <button type="submit" name="update_product" class="btn-submit-product">
                    Update Product
                </button>
                <a href="index.php" class="btn-cancel-product">
                    Cancel
                </a>
            </div>

        </form>

    </div>

</div>

<?php
include "../includes/footer.php";
?>
<script>

function toggleCustomCategory(val) {
    const wrap = document.getElementById('custom-category-wrap');
    if (wrap) {
        wrap.style.display = (val === 'other') ? 'block' : 'none';
        const input = document.getElementById('custom-category');
        if (input) {
            input.required = (val === 'other');
            if (val === 'other') input.focus();
        }
    }
}

function addFeature() {
    const container = document.getElementById("features");
    const div = document.createElement("div");
    div.className = "feature-row";
    div.innerHTML = `
        <input type="text" name="features[]" class="form-control" placeholder="Enter product feature">
        <button type="button" class="btn-remove-feature" onclick="this.parentElement.remove()" title="Remove this feature">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
            <span>Remove</span>
        </button>
    `;
    container.appendChild(div);
}

</script>

