<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email']) || !isset($_SESSION['type'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About This Assignment</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <style>
        .container {
            margin-top: 50px;
        }
        h1 {
            color: #0d6efd;
        }
        .links a {
            text-decoration: none;
            color: #0d6efd;
        }
        .links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <?php include 'header.php' ?>
    <div class="container">
        <div class="text-center mb-4">
            <h1 class="text-primary">About This Assignment</h1>
            <p class="text-muted">Details and insights about the tasks completed for this assignment.</p>
        </div>

        <h5>Tasks Not Attempted or Not Completed:</h5>
        <ul>
            <li>N/A - All tasks were completed successfully.</li>
        </ul>

        <h5>Parts I Had Trouble With:</h5>
        <ul>
            <li>Identify the plants based on the uploaded photo.</li>
            <li>Implementing the file upload validation for profile images and plant description files.</li>
        </ul>

        <h5>What I Would Like to Do Better Next Time:</h5>
        <ul>
            <li>Optimize the code structure for better readability and maintainability.</li>
            <li>Implement more advanced error handling for database and file operations.</li>
            <li>Enhance the UI/UX design for better usability on mobile devices.</li>
        </ul>

        <h5>Extension Features/Extra Challenges Attempted:</h5>
        <ul>
            <li>Added an "Identify Plant" page that retrieves plant information based on user-uploaded images.</li>
            <li>Added Python's OpenCV library to compare uploaded images with those in the database to identify plants.</li>
        </ul>

        <h5>Video Presentation:</h5>
        <ul>
            <li><a href="https://youtu.be/pTvi1NEQyOQ" target="_blank">Watch the video presentation here</a>.</li>
        </ul>

        <h5>Links to Other Pages:</h5>
        <ul class="links">
            <li><a href="index.php">Home Page</a></li>
        </ul>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
