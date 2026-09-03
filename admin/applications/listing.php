<?php

require '../includes/auth.php';
require '../includes/db.php';

include '../includes/header.php';


$sql = "
    SELECT
        ja.id,
        ja.full_name,
        ja.email,
        ja.mobile,
        ja.area_of_interest,
        ja.status,
        ja.created_at,
        jr.title AS job_role
    FROM job_applications ja
    LEFT JOIN job_roles jr
        ON ja.job_role_id = jr.id
    WHERE ja.is_deleted = 0
    ORDER BY ja.created_at DESC
";

$result = mysqli_query($conn, $sql);


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

?>

<div class="page-header">
   
</div>


<div class="table-responsive">
    <table class="table table-striped table-bordered" id="applicationTable">

        <thead>
            <tr>
                <th>#</th>
                <th>Applicant</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Applied Role</th>
                <th>Area</th>
                <th>Status</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>

        <?php if ($result && mysqli_num_rows($result) > 0): ?>

            <?php $count = 1; ?>

            <?php while ($application = mysqli_fetch_assoc($result)): ?>

                <tr>

                    <td>
                        <?php echo $count++; ?>
                    </td>

                    <td>
                        <strong>
                            <?php
                            echo htmlspecialchars(
                                $application['full_name']
                            );
                            ?>
                        </strong>
                    </td>

                    <td>
                        <?php
                        echo htmlspecialchars(
                            $application['email']
                        );
                        ?>
                    </td>

                    <td>
                        <?php
                        echo htmlspecialchars(
                            $application['mobile']
                        );
                        ?>
                    </td>

                    <td>
                        <?php
                        echo htmlspecialchars(
                            $application['job_role']
                            ?: 'General Application'
                        );
                        ?>
                    </td>

                    <td>
                        <?php
                        echo htmlspecialchars(
                            $application['area_of_interest']
                        );
                        ?>
                    </td>

                    <td>

                        <form
                            method="POST"
                            action="status.php"
                        >

                            <input
                                type="hidden"
                                name="id"
                                value="<?php echo (int) $application['id']; ?>"
                            >

                            <select
                                name="status"
                                onchange="this.form.submit()"
                                class="status-select"
                            >

                                <option
                                    value="0"
                                    <?php echo $application['status'] == 0 ? 'selected' : ''; ?>
                                >
                                    New
                                </option>

                                <option
                                    value="1"
                                    <?php echo $application['status'] == 1 ? 'selected' : ''; ?>
                                >
                                    Reviewed
                                </option>

                                <option
                                    value="2"
                                    <?php echo $application['status'] == 2 ? 'selected' : ''; ?>
                                >
                                    Shortlisted
                                </option>

                                <option
                                    value="3"
                                    <?php echo $application['status'] == 3 ? 'selected' : ''; ?>
                                >
                                    Rejected
                                </option>

                                <option
                                    value="4"
                                    <?php echo $application['status'] == 4 ? 'selected' : ''; ?>
                                >
                                    Hired
                                </option>

                            </select>

                        </form>

                    </td>

                    <td>
                        <?php
                        echo date(
                            'd M Y',
                            strtotime($application['created_at'])
                        );
                        ?>
                    </td>

                    <td>

                        <a class="btn btn-sm btn-primary" href="view.php?id=<?php echo $application['id']; ?>">
                            Edit
                        </a>

                        <form
                            method="POST"
                            action="delete.php"
                            style="display:inline;"
                            onsubmit="return confirm('Are you sure you want to delete this application?');"
                        >

                            <input
                                type="hidden"
                                name="id"
                                value="<?php echo (int) $application['id']; ?>"
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

                <td
                    colspan="9"
                    style="text-align:center;"
                >
                    No job applications found.
                </td>

            </tr>

        <?php endif; ?>

        </tbody>

    </table>

</div>

<?php
include "../includes/footer.php";
?>
<script>
    $(document).ready(function(){
        $('#applicationTable').DataTable();
    });
</script>