<?php

$current_script = str_replace('\\', '/', $_SERVER['PHP_SELF'] ?? '');

$active_section = '';
if (strpos($current_script, '/admin/products/') !== false) {
    $active_section = 'products';
} elseif (strpos($current_script, '/admin/blogs/') !== false) {
    $active_section = 'blogs';
} elseif (strpos($current_script, '/admin/clients/') !== false) {
    $active_section = 'clients';
} elseif (strpos($current_script, '/admin/job_roles/') !== false) {
    $active_section = 'job_roles';
} elseif (strpos($current_script, '/admin/enquiries/') !== false) {
    $active_section = 'enquiries';
} elseif (strpos($current_script, '/admin/applications/') !== false) {
    $active_section = 'applications';
} elseif (basename($current_script) === 'dashboard.php') {
    $active_section = 'dashboard';
} elseif (basename($current_script) === 'profile.php') {
    $active_section = 'profile';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Panel</title>

    <link rel="stylesheet" href="/sungmi/admin/assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/3.0.3/css/dataTables.dataTables.min.css">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    
</head>

<body>

<div class="admin-layout">

    <aside class="sidebar">

        <div class="logo">
            <img src="/sungmi/assets/sungmi_logo.png" alt="Sungmi India" width="50px" height="50px" >
        </div>

        <nav>

            <a href="/sungmi/admin/dashboard.php"
               class="<?php echo $active_section === 'dashboard' ? 'active' : ''; ?>">
                Dashboard
            </a>

            <a href="/sungmi/admin/products/index.php"
               class="<?php echo $active_section === 'products' ? 'active' : ''; ?>">
                Products
            </a>

            <a href="/sungmi/admin/blogs/listing.php" 
               class="<?php echo $active_section === 'blogs' ? 'active' : ''; ?>">
                Blogs
            </a>

           <a href="/sungmi/admin/clients/listing.php"
               class="<?php echo $active_section === 'clients' ? 'active' : ''; ?>">
                Clients
            </a>

            <a href="/sungmi/admin/job_roles/listing.php"
               class="<?php echo $active_section === 'job_roles' ? 'active' : ''; ?>">
                Job Roles
            </a>

            <a href="/sungmi/admin/enquiries/listing.php"
               class="<?php echo $active_section === 'enquiries' ? 'active' : ''; ?>">
                Enquiries
            </a>

            <a href="/sungmi/admin/applications/listing.php"
               class="<?php echo $active_section === 'applications' ? 'active' : ''; ?>">
                Applications
            </a>

        </nav>

        <div class="sidebar-bottom">

            <a href="/sungmi/admin/profile.php"
               class="<?php echo $active_section === 'profile' ? 'active' : ''; ?>">
                Profile
            </a>

            <a href="/sungmi/admin/logout.php">
                Logout
            </a>

        </div>

    </aside>


    <div class="main-area">

        <header class="topbar">

            <div>
                <h2>Admin Panel</h2>
            </div>

            <div class="admin-info">

                <span>
                    <?php echo htmlspecialchars($_SESSION['admin_name']); ?>
                </span>

                <a href="/sungmi/admin/profile.php">
                    Profile
                </a>

                <a href="/sungmi/admin/logout.php">
                    Logout
                </a>

            </div>

        </header>

        <main class="content">