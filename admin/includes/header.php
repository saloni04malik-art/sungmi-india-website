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

$base_url = (strpos($_SERVER['REQUEST_URI'] ?? '', '/sungmi') !== false) ? '/sungmi' : '';

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Panel</title>

    <link rel="stylesheet" href="<?php echo $base_url; ?>/admin/assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/3.0.3/css/dataTables.dataTables.min.css">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    
</head>

<body>

<div class="admin-layout">

    <aside class="sidebar">

        <div class="logo">
            <img src="<?php echo $base_url; ?>/assets/sungmi_logo.png" alt="Sungmi India" width="50px" height="50px" >
        </div>

        <nav>

            <a href="<?php echo $base_url; ?>/admin/dashboard.php"
               class="<?php echo $active_section === 'dashboard' ? 'active' : ''; ?>">
                Dashboard
            </a>

            <a href="<?php echo $base_url; ?>/admin/products/index.php"
               class="<?php echo $active_section === 'products' ? 'active' : ''; ?>">
                Products
            </a>

            <a href="<?php echo $base_url; ?>/admin/blogs/listing.php" 
               class="<?php echo $active_section === 'blogs' ? 'active' : ''; ?>">
                Blogs
            </a>

           <a href="<?php echo $base_url; ?>/admin/clients/listing.php"
               class="<?php echo $active_section === 'clients' ? 'active' : ''; ?>">
                Clients
            </a>

            <a href="<?php echo $base_url; ?>/admin/job_roles/listing.php"
               class="<?php echo $active_section === 'job_roles' ? 'active' : ''; ?>">
                Job Roles
            </a>

            <a href="<?php echo $base_url; ?>/admin/enquiries/listing.php"
               class="<?php echo $active_section === 'enquiries' ? 'active' : ''; ?>">
                Enquiries
            </a>

            <a href="<?php echo $base_url; ?>/admin/applications/listing.php"
               class="<?php echo $active_section === 'applications' ? 'active' : ''; ?>">
                Applications
            </a>

        </nav>

        
    </aside>


    <div class="main-area">

        <header class="topbar">

            <div>
                <h2>Admin Panel</h2>
            </div>

                       <div class="admin-info">

                <!-- Profile Link with Icon and Admin Name -->
                <a href="<?php echo $base_url; ?>/admin/profile.php" class="admin-profile-link" title="Profile">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    <span><?php echo htmlspecialchars($_SESSION['admin_name']); ?></span>
                </a>

                <!-- Logout Icon Button -->
                <a href="<?php echo $base_url; ?>/admin/logout.php" class="admin-logout-btn" title="Logout">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                        <polyline points="16 17 21 12 16 7"></polyline>
                        <line x1="21" y1="12" x2="9" y2="12"></line>
                    </svg>
                </a>

            </div>

        </header>

        <main class="content">