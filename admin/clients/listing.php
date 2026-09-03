<?php

require_once "../includes/auth.php";
require_once "../includes/db.php";
require_once "../includes/header.php";

$sql = "SELECT id, name, logo, status
        FROM clients
        WHERE is_deleted = 0
        ORDER BY id ASC";

$result = mysqli_query($conn, $sql);

?>

<div class="page-header">


 <a href="add.php" class="btn btn-sm btn-success">Add Client</a>
</div>

<div class="table-responsive">
    <table class="table table-striped table-bordered" id="clientTable">
    <thead>

        <tr>
            <th>Logo</th>
            <th>Client Name</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>

    </thead>


    <tbody>

    <?php if (mysqli_num_rows($result) > 0) { ?>

        <?php while ($client = mysqli_fetch_assoc($result)) { ?>

            <tr>

                <td>

                    <?php if (!empty($client['logo'])) { ?>

                        <img
                            src="../../<?php echo htmlspecialchars($client['logo']); ?>"
                            width="120"
                            height="70"
                            style="object-fit: contain;"
                            alt="<?php echo htmlspecialchars($client['name']); ?>"
                        >

                    <?php } else { ?>

                        No Logo

                    <?php } ?>

                </td>


                <td>
                    <?php echo htmlspecialchars($client['name']); ?>
                </td>


                <td>

                    <?php if ($client['status'] == 1) { ?>

                        Active

                    <?php } else { ?>

                        Inactive

                    <?php } ?>

                </td>


                <td>

                    <a class="btn btn-sm btn-primary" href="edit.php?id=<?php echo $client['id']; ?>">
                        Edit
                    </a>

                    <form
                        method="POST"
                        action="delete.php"
                        style="display:inline;"
                        onsubmit="return confirm('Are you sure you want to delete this client?');"
                    >

                        <input
                            type="hidden"
                            name="id"
                            value="<?php echo $client['id']; ?>"
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

            <td colspan="4">
                No clients found.
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
    $(document).ready(function(){
        $('#clientTable').DataTable();
    });
</script>