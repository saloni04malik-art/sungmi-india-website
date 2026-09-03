<?php

require_once "../includes/auth.php";
require_once "../includes/db.php";

$sql = "SELECT id, category, title, published_date, image, excerpt, read_time, status
        FROM blogs
        WHERE is_deleted = 0
        ORDER BY published_date DESC, id DESC";

$result = mysqli_query($conn, $sql);
require_once "../includes/header.php";
?>

<div class="page-header">

<a href="add.php" class="btn btn-sm btn-success">Add Blog</a>

</div>
<div class="table-responsive">
    <table class="table table-striped table-bordered" id="blogTable">
    <thead>

        <tr>
            <th>Category</th>
            <th>Image</th>
            <th>Title</th>
            <th>Date</th>
            <th>Read Time</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>

    </thead>

    <tbody>

    <?php if (mysqli_num_rows($result) > 0) { ?>

        <?php while ($blog = mysqli_fetch_assoc($result)) { ?>

            <tr>

                <td>
                    <?php echo htmlspecialchars($blog['category']); ?>
                </td>

                <td>

                    <?php if (!empty($blog['image'])) { ?>

                        <img
                            src="../../<?php echo htmlspecialchars($blog['image']); ?>"
                            width="100"
                            alt=""
                        >

                    <?php } else { ?>

                        No Image

                    <?php } ?>

                </td>

                <td>
                    <?php echo htmlspecialchars($blog['title']); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($blog['published_date']); ?>
                </td>

                <td>
                    <?php echo $blog['read_time'] ? $blog['read_time'] . ' min' : '-'; ?>
                </td>

                <td>

                    <?php echo $blog['status'] == 1 ? 'Active' : 'Inactive'; ?>

                </td>

                <td style="white-space: nowrap;">

                    <a class="btn btn-sm btn-primary" href="edit.php?id=<?php echo $blog['id']; ?>">
                        Edit
                    </a>

                    <form
                        method="POST"
                        action="delete.php"
                        style="display:inline;"
                        onsubmit="return confirm('Are you sure you want to delete this blog?');"
                    >

                        <input
                            type="hidden"
                            name="id"
                            value="<?php echo $blog['id']; ?>"
                        >

                        <button type="submit" class="btn btn-sm btn-danger">
                            Delete
                        </button>

                    </form>

                </td>

            </tr>

        <?php } ?>

    <?php } else { ?>

        <tr>
            <td colspan="7">No blogs found.</td>
        </tr>

    <?php } ?>

    </tbody>

</table>

</main>
</div>
</div>

</body>
</html>

<?php
include "../includes/footer.php";
?>
<script>
    $(document).ready(function(){
        $('#blogTable').DataTable();
    });
</script>