<?php
session_start();

// Check if the user is logged in and if they are an admin
if (
    !isset($_SESSION['loggedin']) || 
    $_SESSION['loggedin'] !== true || 
    $_SESSION['type'] !== 'admin' || 
    !isset($_SESSION['email'])
) {
    // Redirect to login page if any condition is not met
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin - Main Menu</title>
</head>
<body>
<?php include 'admin-header.php'; ?>
    <!-- Main Content -->
    <main class="container my-5">
        <section class="intro-menu text-center">
            <div class="intro-content">
                <h1>Welcome to the Admin Dashboard</h1>
                <p>As an admin, you can manage user data, plant data, and more. Please choose an option below to get started.</p>
            </div>
        </section>

        <!-- Admin Options -->
        <section class="menu-options">
            <h2 class="text-center">Admin Menu</h2>
            <div class="row">
                <div class="col-md-6">
                    <div class="menu-card text-center">
                        <h2>Manage Users</h2>
                        <p>View and manage user accounts and permissions.</p>
                        <a href="manage_users.php" class="btn btn-admin btn-block">Manage Users</a>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="menu-card text-center">
                        <h2>Manage Plant Data</h2>
                        <p>Manage plant classification data, add new plants, and update existing records.</p>
                        <a href="manage_plants.php" class="btn btn-admin btn-block">Manage Plant Data</a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="text-center mt-5">
        <p>&copy; 2024 Plant Biodiversity Portal. All rights reserved.</p>
    </footer>

    <!-- Include necessary JS files -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
