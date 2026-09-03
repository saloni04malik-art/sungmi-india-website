<?php

require_once "../includes/auth.php";
require_once "../includes/db.php";

$error = "";

if (isset($_POST['add_role'])) {

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

        $sql = "INSERT INTO job_roles
                (
                    title,
                    department,
                    location,
                    employment_type,
                    short_description,
                    overview,
                    responsibilities,
                    qualifications,
                    status,
                    is_deleted
                )
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 0)";

        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param(
            $stmt,
            "ssssssssi",
            $title,
            $department,
            $location,
            $employment_type,
            $short_description,
            $overview,
            $responsibilities,
            $qualifications,
            $status
        );

        if (mysqli_stmt_execute($stmt)) {

            mysqli_stmt_close($stmt);

            header("Location: listing.php");
            exit;

        } else {

            mysqli_stmt_close($stmt);

            $error = "Unable to add job role.";
        }
    }
}

require_once "../includes/header.php";

?>

<h1>Add Job Role</h1>


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
        required
    >

    <br><br>


    <label>Department</label><br>

    <input
        type="text"
        name="department"
        required
    >

    <br><br>


    <label>Location</label><br>

    <input
        type="text"
        name="location"
        required
    >

    <br><br>


    <label>Employment Type</label><br>

    <input
        type="text"
        name="employment_type"
        placeholder="Full Time"
        required
    >

    <br><br>


    <label>Short Description</label><br>

    <textarea
        name="short_description"
        rows="3"
    ></textarea>

    <br><br>


    <label>Overview</label><br>

    <textarea
        name="overview"
        rows="6"
    ></textarea>

    <br><br>


    <label>Responsibilities</label><br>

    <textarea
        name="responsibilities"
        rows="10"
        placeholder="Enter each responsibility on a new line"
    ></textarea>

    <br><br>


    <label>Qualifications</label><br>

    <textarea
        name="qualifications"
        rows="10"
        placeholder="Enter each qualification on a new line"
    ></textarea>

    <br><br>


    <label>

        <input
            type="checkbox"
            name="status"
            value="1"
            checked
        >

        Active

    </label>

    <br><br>


    <button type="submit" name="add_role">
        Save Job Role
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