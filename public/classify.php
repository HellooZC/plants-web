
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plant Classification</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
<?php include 'header.php'; ?>
    
    <main>
        <section class="intro">
            <div class="intro-content">
                <h1>Plant Classification</h1>
                <p>Plant classification is the science of grouping plants into categories based on their physical and genetic characteristics. The classification system follows a hierarchical structure from broad groups to more specific ones: Family, Genus, and Species.</p>
            </div>
            <div class="classify-image">
                <img src="images/classify-diagram.png" alt="Plant Classification Diagram">
            </div>
        </section>

        <!-- Filter Buttons Section -->
        <section class="filter-buttons">
            <button class="filter-btn" onclick="filterCards('all')">View All</button>
            <button class="filter-btn" onclick="filterCards('family')">Family</button>
            <button class="filter-btn" onclick="filterCards('genus')">Genus</button>
            <button class="filter-btn" onclick="filterCards('species')">Species</button>
        </section>

        <!-- Plant Family, Genus, and Species Cards Section -->
        <section class="plant-classification-cards">
            <h2>Explore Plant Classification</h2>
            <div class="classify-cards-container">
                <!-- Family Card -->
                <div class="classify-card" data-category="family" onclick="toggleExpand(this)">
                    <img src="images/Dipterocarpaceae.jpg" alt="Plant Family" class="classify-card-image">
                    <div class="classify-card-content">
                        <h3>Family: Dipterocarpaceae</h3>
                        <p>Dipterocarpaceae is a family of tropical lowland rainforest trees.</p>
                    </div>
                    <div class="extra-images">
                        <h4>Herbarium Images</h4>
                        <img src="images/Dipterocarpaceae-herbarium.jpg" alt="Herbarium 1" class="extra-image">
                        <img src="images/Dipterocarpaceae-herbarium.jpg" alt="Herbarium 2" class="extra-image">
                    </div>
                </div>

                <!-- Genus Card -->
                <div class="classify-card" data-category="genus" onclick="toggleExpand(this)">
                    <img src="images/Vatica.jpg" alt="Vatica" class="classify-card-image">
                    <div class="classify-card-content">
                        <h3>Genus: Vatica</h3>
                        <p>The genus Vatica consists of trees commonly found in tropical Asia.</p>
                    </div>
                    <div class="extra-images">
                        <h4>Herbarium Images</h4>
                        <img src="images/vatica-herbarium.jpg" alt="Herbarium 1" class="extra-image">
                        <img src="images/vatica-herbarium.jpg" alt="Herbarium 2" class="extra-image">
                    </div>
                </div>

                <!-- Species Card -->
                <div class="classify-card" data-category="species" onclick="toggleExpand(this)">
                    <img src="images/vatica-umbonota.jpg" alt="Vatica umbonata" class="classify-card-image">
                    <div class="classify-card-content">
                        <h3>Species: Vatica umbonata</h3>
                        <p>Vatica umbonata is a tree species found in Southeast Asia.</p>
                    </div>
                    <div class="extra-images">
                        <h4>Herbarium Images</h4>
                        <img src="images/vatica-umbonota-herbarium.jpg" alt="Herbarium 1" class="extra-image">
                        <img src="images/vatica-umbonota-herbarium.jpg" alt="Herbarium 2" class="extra-image">
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script>
        function filterCards(category) {
            const cards = document.querySelectorAll('.classify-card');
            cards.forEach(card => {
                if (category === 'all') {
                    card.style.display = 'block';
                } else if (card.getAttribute('data-category') === category) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }
        function toggleExpand(card) {
        const isExpanded = card.classList.contains('expanded');
        if (isExpanded) {
            card.classList.remove('expanded');
        } else {
            document.querySelectorAll('.classify-card.expanded').forEach(function (expandedCard) {
                expandedCard.classList.remove('expanded');
            });
            card.classList.add('expanded');

            
        }
}

    </script>

</body>
</html>
