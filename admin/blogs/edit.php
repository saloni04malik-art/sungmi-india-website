<?php

require_once "../includes/auth.php";
require_once "../includes/db.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: listing.php");
    exit;
}

$id = (int) $_GET['id'];

$error = "";


/* Get blog */

$sql = "SELECT *
        FROM blogs
        WHERE id = ? AND is_deleted = 0
        LIMIT 1";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "i", $id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$blog = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);


if (!$blog) {
    header("Location: listing.php");
    exit;
}


/* Update blog */

if (isset($_POST['update_blog'])) {

    $category = trim($_POST['category']);
    $title = trim($_POST['title']);
    $published_date = $_POST['published_date'];
    $excerpt = trim($_POST['excerpt']);
    $content = $_POST['content'];
    $read_time = (int) $_POST['read_time'];
    $status = isset($_POST['status']) ? 1 : 0;

    if ($category == "" || $title == "" || $published_date == "") {

        $error = "Category, title and date are required.";

    } elseif (trim(strip_tags($content)) == "") {

        $error = "Blog content is required.";

    } else {

        $image_path = $blog['image'];

        /* Replace image */

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

                    $upload_directory = "../uploads/blogs/";

                    if (!is_dir($upload_directory)) {
                        mkdir($upload_directory, 0755, true);
                    }

                    $destination = $upload_directory . $file_name;

                    if (move_uploaded_file($tmp_name, $destination)) {

                        /*
                         * Delete old image only if it belongs
                         * to admin/uploads/blogs.
                         */

                        if (
                            !empty($blog['image']) &&
                            strpos($blog['image'], 'admin/uploads/blogs/') === 0
                        ) {

                            $old_file = "../../" . $blog['image'];

                            if (file_exists($old_file)) {
                                unlink($old_file);
                            }
                        }

                        $image_path = "admin/uploads/blogs/" . $file_name;

                    } else {

                        $error = "Unable to save image.";
                    }
                }
            }
        }


        if ($error == "") {

            $sql = "UPDATE blogs
                    SET category = ?,
                        title = ?,
                        published_date = ?,
                        image = ?,
                        excerpt = ?,
                        content = ?,
                        read_time = ?,
                        status = ?
                    WHERE id = ? AND is_deleted = 0";

            $stmt = mysqli_prepare($conn, $sql);

            mysqli_stmt_bind_param(
                $stmt,
                "ssssssiii",
                $category,
                $title,
                $published_date,
                $image_path,
                $excerpt,
                $content,
                $read_time,
                $status,
                $id
            );

            if (mysqli_stmt_execute($stmt)) {

                mysqli_stmt_close($stmt);

                header("Location: listing.php");
                exit;

            } else {

                mysqli_stmt_close($stmt);

                $error = "Unable to update blog.";
            }
        }
    }
}

require_once "../includes/header.php";

?>

<link
    href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css"
    rel="stylesheet"
>

<style>
    .blog-form-container {
        max-width: 900px;
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

    .blog-form-alert {
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

    .blog-form-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 32px 28px;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
    }

    .form-grid-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
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

    /* Quill Editor Modern Styling */
    .ql-toolbar.ql-snow {
        border: 1px solid #d1d5db !important;
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
        background-color: #f9fafb;
        padding: 10px 12px !important;
    }

    .ql-container.ql-snow {
        border: 1px solid #d1d5db !important;
        border-top: none !important;
        border-bottom-left-radius: 8px;
        border-bottom-right-radius: 8px;
        font-family: inherit !important;
        font-size: 15px !important;
        min-height: 280px;
        background-color: #ffffff;
    }

    .ql-editor {
        min-height: 260px;
        padding: 14px 16px !important;
        font-size: 15px;
        line-height: 1.6;
        color: #111827;
    }

    .ql-container.ql-snow:focus-within {
        border-color: #2563eb !important;
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

    .btn-submit-blog {
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

    .btn-submit-blog:hover {
        background-color: #1d4ed8;
    }

    .btn-submit-blog:active {
        background-color: #1e40af;
        transform: scale(0.99);
    }

    .btn-cancel-blog {
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

    .btn-cancel-blog:hover {
        background-color: #e5e7eb;
        color: #111827;
    }

    @media (max-width: 680px) {
        .form-grid-row {
            grid-template-columns: 1fr;
        }

        .blog-form-card {
            padding: 22px 18px;
        }

        .current-image-wrapper {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>

<div class="blog-form-container">

    <div class="form-header-bar">
        <div>
            <h1>Edit Blog</h1>
            <p>Update article content, category metadata, and featured image.</p>
        </div>
        <a href="listing.php" class="btn-back-link">
            &larr; Back to Blogs
        </a>
    </div>

    <?php if ($error != "") { ?>
        <div class="blog-form-alert" role="alert">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="8" x2="12" y2="12"></line>
                <line x1="12" y1="16" x2="12.01" y2="16"></line>
            </svg>
            <span><?php echo htmlspecialchars($error); ?></span>
        </div>
    <?php } ?>

    <div class="blog-form-card">

        <form method="POST" enctype="multipart/form-data">

            <div class="form-group">
                <label class="form-label" for="blog-title">
                    Blog Title <span class="required-mark">*</span>
                </label>
                <input
                    type="text"
                    id="blog-title"
                    name="title"
                    class="form-control"
                    value="<?php echo htmlspecialchars($blog['title']); ?>"
                    placeholder="e.g. Modern Innovations in Marine Accommodation Systems"
                    required
                >
            </div>

            <div class="form-grid-row">
                <div class="form-group">
                    <label class="form-label" for="blog-category">
                        Category <span class="required-mark">*</span>
                    </label>
                    <input
                        type="text"
                        id="blog-category"
                        name="category"
                        class="form-control"
                        value="<?php echo htmlspecialchars($blog['category']); ?>"
                        placeholder="e.g. Engineering, Marine Interiors"
                        required
                    >
                </div>

                <div class="form-group">
                    <label class="form-label" for="blog-date">
                        Published Date <span class="required-mark">*</span>
                    </label>
                    <input
                        type="date"
                        id="blog-date"
                        name="published_date"
                        class="form-control"
                        value="<?php echo htmlspecialchars($blog['published_date']); ?>"
                        required
                    >
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Featured Image</label>
                <div class="image-preview-box">
                    <?php if (!empty($blog['image'])) { ?>
                        <div class="current-image-wrapper">
                            <img
                                src="../../<?php echo htmlspecialchars($blog['image']); ?>"
                                class="current-image-thumb"
                                alt="<?php echo htmlspecialchars($blog['title']); ?>"
                            >
                            <div class="current-image-meta">
                                <span class="image-meta-tag">Current Image</span>
                                <span class="image-meta-path"><?php echo htmlspecialchars(basename($blog['image'])); ?></span>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="no-image-placeholder">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                <polyline points="21 15 16 10 5 21"></polyline>
                            </svg>
                            <span>No image currently attached to this blog post</span>
                        </div>
                    <?php } ?>

                    <div class="replace-image-wrapper">
                        <label class="form-label" for="blog-image" style="font-size: 12px; color: #6b7280; margin-bottom: 6px;">
                            <?php echo !empty($blog['image']) ? 'Upload New Image to Replace' : 'Upload Featured Image'; ?>
                        </label>
                        <input
                            type="file"
                            id="blog-image"
                            name="image"
                            class="form-file-input"
                            accept=".jpg,.jpeg,.png,.webp"
                        >
                        <div class="form-hint">Accepted formats: JPG, PNG, WEBP (Max: 5 MB). Leave empty to keep the current image.</div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="blog-read-time">Read Time (minutes)</label>
                <input
                    type="number"
                    id="blog-read-time"
                    name="read_time"
                    class="form-control"
                    min="0"
                    value="<?php echo (int) $blog['read_time']; ?>"
                >
                <div class="form-hint">Estimated reading duration shown on article cards.</div>
            </div>

            <div class="form-group">
                <label class="form-label" for="blog-excerpt">Excerpt / Short Description</label>
                <textarea
                    id="blog-excerpt"
                    name="excerpt"
                    class="form-control"
                    rows="3"
                    placeholder="Brief 1-2 sentence preview summary of the post..."
                ><?php echo htmlspecialchars($blog['excerpt'] ?? ''); ?></textarea>
                <div class="form-hint">Summary shown on public blog preview cards.</div>
            </div>

            <div class="form-group">
                <label class="form-label">
                    Blog Content <span class="required-mark">*</span>
                </label>
                <div id="editor" style="height: 300px;"></div>
                <input
                    type="hidden"
                    name="content"
                    id="content"
                >
            </div>

            <div class="form-group">
                <label class="status-checkbox-label" for="blog-status">
                    <input
                        type="checkbox"
                        id="blog-status"
                        name="status"
                        value="1"
                        <?php echo $blog['status'] == 1 ? 'checked' : ''; ?>
                    >
                    <span>Active (Published on public website)</span>
                </label>
            </div>

            <div class="form-actions-bar">
                <button type="submit" name="update_blog" class="btn-submit-blog">
                    Update Blog
                </button>
                <a href="listing.php" class="btn-cancel-blog">
                    Cancel
                </a>
            </div>

        </form>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>

<script>

const quill = new Quill('#editor', {
    theme: 'snow',
    modules: {
        toolbar: [
            ['bold', 'italic', 'underline'],
            [{ 'header': [1, 2, 3, false] }],
            [{ 'list': 'ordered' }, { 'list': 'bullet' }],
            ['link'],
            ['clean']
        ]
    }
});

const existingContent = <?php echo json_encode($blog['content']); ?>;
quill.root.innerHTML = existingContent;

document.querySelector('form').addEventListener('submit', function () {
    document.getElementById('content').value = quill.root.innerHTML;
});

</script>

</main>
</div>
</div>

</body>
</html>