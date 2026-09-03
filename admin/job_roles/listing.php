<?php

require_once "../includes/auth.php";
require_once "../includes/db.php";
require_once "../includes/header.php";

$sql = "SELECT id, title, department, location, employment_type, short_description, status
        FROM job_roles
        WHERE is_deleted = 0
        ORDER BY id ASC";

$result = mysqli_query($conn, $sql);

?>

<div class="page-header">


    <a href="add.php" class="btn btn-sm btn-success">Add Job Role</a>

</div>

<br>    

<div class="table-responsive">
    <table class="table table-striped table-bordered" id="job_rolesTable">

    <thead>

        <tr>
            <th>Title</th>
            <th>Department</th>
            <th>Location</th>
            <th>Employment Type</th>
            <th>Short Description</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>

    </thead>

    <tbody>

    <?php if (mysqli_num_rows($result) > 0) { ?>

        <?php while ($role = mysqli_fetch_assoc($result)) { ?>

            <tr>

                <td>
                    <?php echo htmlspecialchars($role['title']); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($role['department']); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($role['location']); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($role['employment_type']); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($role['short_description']); ?>
                </td>

                <td>

                    <?php if ($role['status'] == 1) { ?>

                        Active

                    <?php } else { ?>

                        Inactive

                    <?php } ?>

                </td>

                <td style="white-space: nowrap;">

                    <a class="btn btn-sm btn-primary" href="edit.php?id=<?php echo $role['id']; ?>">
                        Edit
                    </a>

                    <form
                        method="POST"
                        action="delete.php"
                        style="display:inline;"
                        onsubmit="return confirm('Are you sure you want to delete this job role?');"
                    >

                        <input
                            type="hidden"
                            name="id"
                            value="<?php echo $role['id']; ?>"
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

            <td colspan="7">
                No job roles found.
            </td>

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
$(document).ready(function () {
    $('#job_rolesTable').DataTable();
});
</script>
