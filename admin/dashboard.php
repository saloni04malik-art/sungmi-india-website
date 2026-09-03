<?php

require_once "includes/auth.php";
require_once "includes/db.php";
require_once "includes/header.php";


/* Get counts */

function getCount($conn, $table)
{
    $sql = "SELECT COUNT(*) AS total
            FROM $table
            WHERE is_deleted = 0";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['total'];
    }

    return 0;
}


$products = getCount($conn, "products");
$blogs = getCount($conn, "blogs");
$clients = getCount($conn, "clients");
$job_roles = getCount($conn, "job_roles");
$enquiries = getCount($conn, "project_enquiries");
$applications = getCount($conn, "job_applications");

?>

<div class="dashboard-header">

    <h1>Dashboard</h1>

    <p>
        Welcome,
        <?php echo htmlspecialchars($_SESSION['admin_name']); ?>
    </p>

</div>


<div class="dashboard-cards">

    <div class="dashboard-card">
        <h3>Products</h3>
        <div class="count">
            <?php echo $products; ?>
        </div>
    </div>


    <div class="dashboard-card">
        <h3>Blogs</h3>
        <div class="count">
            <?php echo $blogs; ?>
        </div>
    </div>


    <div class="dashboard-card">
        <h3>Clients</h3>
        <div class="count">
            <?php echo $clients; ?>
        </div>
    </div>


    <div class="dashboard-card">
        <h3>Job Roles</h3>
        <div class="count">
            <?php echo $job_roles; ?>
        </div>
    </div>


    <div class="dashboard-card">
        <h3>Project Enquiries</h3>
        <div class="count">
            <?php echo $enquiries; ?>
        </div>
    </div>


    <div class="dashboard-card">
        <h3>Job Applications</h3>
        <div class="count">
            <?php echo $applications; ?>
        </div>
    </div>

</div>

<?php
include "includes/footer.php";
?>