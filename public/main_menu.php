<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Menu - Plant Biodiversity</title>
</head>
<body>
<?php include 'header.php'; ?>

    <main>
        <section class="intro-menu">
            <div class="intro-content">
                <h1>Welcome to Plant Biodiversity Portal</h1>
                <p>This portal allows users to explore plant classifications, learn how to preserve plant specimens, and contribute to biodiversity data. Use the options below to navigate through the platform and engage in the world of plants.</p>
            </div>
            <div class="intro-image">
                <img src="images/images2.jpeg" alt="Plants Image">
            </div>
        </section>

        <section class="menu-options">
            <h1>Main Menu</h1>
            <div class="menu-card-container">
                <div class="menu-card">
                    <h2>Plants Classification</h2>
                    <p>Learn about Plant family, Genus, and Species.</p>
                    <a href="classification.php" class="btn">Learn More</a>
                </div>

                <div class="menu-card">
                    <h2>Tutorial</h2>
                    <p>Learn how to transfer a fresh leaf into herbarium specimens and preserve them.</p>
                    <a href="tutorial.php" class="btn">Start Tutorial</a>
                </div>


                <div class="menu-card">
                    <h2>Identify</h2>
                    <p>Identify plant types based on uploaded photos</p>
                    <a href="identify.php" class="btn">Identify</a>
                </div>

                <div class="menu-card">
                    <h2>Contribution</h2>
                    <p>Contribute to the data set by uploading fresh leaf and herbarium photos.</p>
                    <a href="contribute.php" class="btn">Contribute</a>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
