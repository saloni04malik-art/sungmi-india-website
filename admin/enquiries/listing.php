<?php

require_once "../includes/auth.php";
require_once "../includes/db.php";
require_once "../includes/header.php";

$sql = "SELECT 
            e.id,
            e.full_name,
            e.company_name,
            e.email,
            e.mobile,
            e.project_type,
            e.status,
            e.created_at,
            p.name AS product_name
        FROM project_enquiries e
        LEFT JOIN products p ON e.product_id = p.id
        WHERE e.is_deleted = 0
        ORDER BY e.created_at DESC";

$result = mysqli_query($conn, $sql);

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

<div class="page-header">
</div>

<div class="table-responsive">
    <table class="table table-striped table-bordered" id="enquiryTable">



        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Company</th>
                <th>Email</th>
                <th>Product</th>
                <th>Project Type</th>
                <th>Status</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>

        <?php if (mysqli_num_rows($result) > 0): ?>

            <?php while ($enquiry = mysqli_fetch_assoc($result)): ?>

                <tr>

                    <td><?php echo $enquiry['id']; ?></td>

                    <td>
                        <?php echo htmlspecialchars($enquiry['full_name']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($enquiry['company_name']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($enquiry['email']); ?>
                    </td>

                    <td>
                        <?php
                        echo $enquiry['product_name']
                            ? htmlspecialchars($enquiry['product_name'])
                            : 'N/A';
                        ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($enquiry['project_type']); ?>
                    </td>

                    <td>
                        <?php echo getStatus($enquiry['status']); ?>
                    </td>

                    <td>
                        <?php echo date('d M Y', strtotime($enquiry['created_at'])); ?>
                    </td>

                    <td>

                        <a class="btn btn-sm btn-primary" href="view.php?id=<?php echo $enquiry['id']; ?>">
                            View
                        </a>

                        <form
                            method="POST"
                            action="delete.php"
                            style="display:inline;"
                            onsubmit="return confirm('Are you sure you want to delete this enquiry?');"
                        >

                            <input
                                type="hidden"
                                name="id"
                                value="<?php echo $enquiry['id']; ?>"
                            >

                            <button type="submit" class="btn btn-sm btn-danger">
                                Delete
                            </button>

                        </form>

                    </td>

                </tr>

            <?php endwhile; ?>

        <?php else: ?>

            <tr>
                <td colspan="9" style="text-align:center;">
                    No enquiries found.
                </td>
            </tr>

        <?php endif; ?>

        </tbody>

    </table>

</div>

</main>
</div>
</body>
</html>
<?php
include "../includes/footer.php";
?>
<script>
    $(document).ready(function(){
        $('#enquiryTable').DataTable();
    });
</script>