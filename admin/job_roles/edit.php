<?php

require_once "../includes/auth.php";
require_once "../includes/db.php";


if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {

    header("Location: listing.php");
    exit;
}


$id = (int) $_GET['id'];

$error = "";


/* Get job role */

$sql = "SELECT *
        FROM job_roles
        WHERE id = ? AND is_deleted = 0
        LIMIT 1";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "i", $id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$role = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);


if (!$role) {

    header("Location: listing.php");
    exit;
}


/* Update job role */

if (isset($_POST['update_role'])) {

    $title = trim($_POST['title']);
    $department = trim($_POST['department']);
    $location = trim($_POST['location']);
    $employment_type = trim($_POST['employment_type']);
    $short_description = trim($_POST['short_description']);
    $overview = trim($_POST['overview']);
    $responsibilities = trim($_POST['responsibilities']);
    $qualifications = trim($_POST['qualifications']);
    $status = isset($_POST['status']) ? 1 : 0;


    if (
        $title == "" ||
        $department == "" ||
        $location == "" ||
        $employment_type == ""
    ) {

        $error = "Title, department, location and employment type are required.";

    } else {

        $sql = "UPDATE job_roles
                SET title = ?,
                    department = ?,
                    location = ?,
                    employment_type = ?,
                    short_description = ?,
                    overview = ?,
                    responsibilities = ?,
                    qualifications = ?,
                    status = ?
                WHERE id = ? AND is_deleted = 0";

        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param(
            $stmt,
            "ssssssssii",
            $title,
            $department,
            $location,
            $employment_type,
            $short_description,
            $overview,
            $responsibilities,
            $qualifications,
            $status,
            $id
        );


        if (mysqli_stmt_execute($stmt)) {

            mysqli_stmt_close($stmt);

            header("Location: listing.php");
            exit;

        } else {

            mysqli_stmt_close($stmt);

            $error = "Unable to update job role.";
        }
    }
}


require_once "../includes/header.php";

?>

<h1>Edit Job Role</h1>


<?php if ($error != "") { ?>

    <p>
        <?php echo htmlspecialchars($error); ?>
    </p>

<?php } ?>


<form method="POST">

    <label>Job Title</label><br>

    <input
        type="text"
        name="title"
        value="<?php echo htmlspecialchars($role['title']); ?>"
        required
    >

    <br><br>


    <label>Department</label><br>

    <input
        type="text"
        name="department"
        value="<?php echo htmlspecialchars($role['department']); ?>"
        required
    >

    <br><br>


    <label>Location</label><br>

    <input
        type="text"
        name="location"
        value="<?php echo htmlspecialchars($role['location']); ?>"
        required
    >

    <br><br>


    <label>Employment Type</label><br>

    <input
        type="text"
        name="employment_type"
        value="<?php echo htmlspecialchars($role['employment_type']); ?>"
        required
    >

    <br><br>


    <label>Short Description</label><br>

    <textarea
        name="short_description"
        rows="3"
    ><?php echo htmlspecialchars($role['short_description'] ?? ''); ?></textarea>

    <br><br>


    <label>Overview</label><br>

    <textarea
        name="overview"
        rows="6"
    ><?php echo htmlspecialchars($role['overview'] ?? ''); ?></textarea>

    <br><br>


    <label>Responsibilities</label><br>

    <textarea
        name="responsibilities"
        rows="10"
    ><?php echo htmlspecialchars($role['responsibilities'] ?? ''); ?></textarea>

    <br><br>


    <label>Qualifications</label><br>

    <textarea
        name="qualifications"
        rows="10"
    ><?php echo htmlspecialchars($role['qualifications'] ?? ''); ?></textarea>

    <br><br>


    <label>

        <input
            type="checkbox"
            name="status"
            value="1"
            <?php echo $role['status'] == 1 ? 'checked' : ''; ?>
        >

        Active

    </label>

    <br><br>


    <button type="submit" name="update_role">
        Update Job Role
    </button>

    <a href="listing.php">
        Cancel
    </a>

</form>


</main>
</div>
</div>

</body>
</html>