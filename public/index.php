<?php 
$images = array('images/images1.jpeg', 'images/images2.jpeg', 'images/images3.jpeg');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plant Biodiversity Project</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
    <?php include 'header.php'; ?>

    <main>
        <section class="intro">
            <div class="content">
                <h1>Herbarium for Plant Biodiversity</h1>
                <p>Over the centuries, botanists, taxonomists, naturalists, and physicians have meticulously collected herbarium specimens to study and document global plant biodiversity...</p>
                <div class="auth-buttons">
                    <a href="login.php" class="sign-in-btn">Sign In</a>
                    <a href="registration.php" class="register-btn">Register</a>
                </div>
            </div>

            <div class="slideshow-container">
                <?php foreach ($images as $image): ?>
                    <img src="<?php echo $image; ?>" alt="Herbarium Specimen">
                <?php endforeach; ?>
                
                <div class="dots-container">
                    <?php for ($i = 0; $i < count($images); $i++): ?>
                        <span class="dot" onclick="currentSlide(<?php echo $i + 1; ?>)"></span>
                    <?php endfor; ?>
                </div>
            </div>
        </section>
    </main>

    <script>
        let slideIndex = 0;
        const slides = document.querySelectorAll('.slideshow-container img');
        const dots = document.querySelectorAll('.dot');

        function showSlides() {
            slides.forEach((slide) => slide.classList.remove('active'));
            dots.forEach((dot) => dot.classList.remove('active'));

            slideIndex++;
            if (slideIndex > slides.length) {
                slideIndex = 1;
            }

            slides[slideIndex - 1].classList.add('active');
            dots[slideIndex - 1].classList.add('active');

            setTimeout(showSlides, 3000);
        }

        function currentSlide(n) {
            slideIndex = n;
            showSlides();
        }


        showSlides();
    </script>
</body>
</html>
