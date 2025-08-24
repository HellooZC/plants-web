<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Herbarium Tutorial</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.3.5/css/swiper.min.css'>
</head>
<body>
<?php include 'header.php'; ?>

    <main>
    <section class="intro-menu">
           <div class="intro-content">
                    <h1>How to Make Herbarium Specimens</h1>
                    <p>Herbarium specimens are critical for plant research and conservation. This tutorial will guide you through the process of making, preserving, and using the right tools for creating herbarium specimens.</p>
                </div>
                <div class="intro-image">
                    <img src="images/images1.jpeg" alt="Herbarium Specimen">
                </div>
            </div>
        </section>

      <h2>Step-by-Step Process to Make Herbarium Specimens</h2>
        <div class="blog-slider">
          <div class="blog-slider__wrp swiper-wrapper">
            
            <!-- Step 1: Collecting Plant Material -->
            <div class="blog-slider__item swiper-slide">
              <div class="blog-slider__img">
                <img src="images/collection.jpeg" alt="Collecting Plant Material">
              </div>
              <div class="blog-slider__content">
                <span class="blog-slider__code">Step 1</span>
                <div class="blog-slider__title">Collecting Plant Material</div>
                <div class="blog-slider__text">Collect healthy and representative specimens, including leaves, flowers, fruits, or seeds. Use sharp tools to avoid damage.</div>
              </div>
            </div>

            <!-- Step 2: Pressing the Specimen -->
            <div class="blog-slider__item swiper-slide">
              <div class="blog-slider__img">
                <img src="images/pressed_plants.jpg" alt="Pressing the Specimen">
              </div>
              <div class="blog-slider__content">
                <span class="blog-slider__code">Step 2</span>
                <div class="blog-slider__title">Pressing the Specimen</div>
                <div class="blog-slider__text">Place the specimen between newspaper sheets and press it using a plant press or heavy books. Keep the specimen flat and avoid overlapping parts.</div>
              </div>
            </div>

            <!-- Step 3: Drying -->
            <div class="blog-slider__item swiper-slide">
              <div class="blog-slider__img">
                <img src="images/drying.jpeg" alt="Drying">
              </div>
              <div class="blog-slider__content">
                <span class="blog-slider__code">Step 3</span>
                <div class="blog-slider__title">Drying</div>
                <div class="blog-slider__text">Allow the specimen to dry completely by changing the newspaper daily to remove moisture. The drying process can take up to a week.</div>
              </div>
            </div>

            <!-- Step 4: Mounting -->
            <div class="blog-slider__item swiper-slide">
              <div class="blog-slider__img">
                <img src="images/mounting.jpeg" alt="Mounting">
              </div>
              <div class="blog-slider__content">
                <span class="blog-slider__code">Step 4</span>
                <div class="blog-slider__title">Mounting</div>
                <div class="blog-slider__text">Once dried, mount the specimen on an herbarium sheet using glue or archival tape. Ensure it's securely fastened.</div>
              </div>
            </div>

            <!-- Step 5: Labeling -->
            <div class="blog-slider__item swiper-slide">
              <div class="blog-slider__img">
                <img src="images/label.jpeg" alt="Labeling">
              </div>
              <div class="blog-slider__content">
                <span class="blog-slider__code">Step 5</span>
                <div class="blog-slider__title">Labeling</div>
                <div class="blog-slider__text">Attach a label detailing the plant’s scientific name, collection date, location, and collector's name.</div>
              </div>
            </div>
            
          </div>
          <div class="blog-slider__pagination"></div>
        </div>

        <!-- partial -->
        <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.3.5/js/swiper.min.js'></script><script  src="./script.js"></script>


        <section class="tools">
          <h2>Tools Used to Create Herbarium Specimens</h2>
          <div class="container swiper">
            <div class = "center-container">
            <div class="card-wrapper">
              <!-- Card slides container -->
              <ul class="card-list swiper-wrapper">
                <li class="card-item swiper-slide">
                  <a href="#" class="card-link">
                    <img src="images/herbarium-press.jpg" alt="Plant Press" class="card-image">
                    <p class="badge badge-tool">Tool</p>
                    <h2 class="card-title">Plant Press</h2>
                    <p class="card-text">A device used to flatten and dry plant specimens between sheets of newspaper or blotting paper.</p>
                  </a>
                </li>
                <li class="card-item swiper-slide">
                  <a href="#" class="card-link">
                    <img src="images/newspaper.jpg" alt="Newspaper" class="card-image">
                    <p class="badge badge-tool">Tool</p>
                    <h2 class="card-title">Newspaper</h2>
                    <p class="card-text">Used to separate and absorb moisture from the plant specimens during pressing.</p>
                  </a>
                </li>
                <li class="card-item swiper-slide">
                  <a href="#" class="card-link">
                    <img src="images/secateurs.jpeg" alt="Secateurs" class="card-image">
                    <p class="badge badge-tool">Tool</p>
                    <h2 class="card-title">Secateurs</h2>
                    <p class="card-text">Sharp scissors or pruning shears for cutting plant samples.</p>
                  </a>
                </li>
                <li class="card-item swiper-slide">
                  <a href="#" class="card-link">
                    <img src="images/archival tape.jpg" alt="Archival Tape" class="card-image">
                    <p class="badge badge-tool">Tool</p>
                    <h2 class="card-title">Archival Tape</h2>
                    <p class="card-text">A special adhesive tape used for mounting dried specimens onto herbarium sheets.</p>
                  </a>
                </li>
                <li class="card-item swiper-slide">
                  <a href="#" class="card-link">
                    <img src="images/label_tools.jpeg" alt="Labels" class="card-image">
                    <p class="badge badge-tool">Tool</p>
                    <h2 class="card-title">Labels</h2>
                    <p class="card-text">Printed or handwritten information about the specimen, including its species name, date, location, and collector.</p>
                    
                  </a>
                </li>
              </ul>

              <!-- Pagination -->
              <div class="swiper-pagination"></div>

              <!-- Navigation Buttons -->
              <div class="swiper-slide-button swiper-button-prev"></div>
              <div class="swiper-slide-button swiper-button-next"></div>
            </div>
</div>
          </div>
      </section>
      <h2>Preservation</h2>
      <section class="preservation">
      
        <div class="video-background">
            <div class="video-foreground">
                <iframe src="https://www.youtube.com/embed/2kEbCaTe8XM?autoplay=1&mute=1&controls=1" 
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; fullscreen" 
                        allowfullscreen>
                </iframe>
            </div>
        </div>

        <div id="vidtop-content">
            <div class="vid-info">
                <p>Proper preservation ensures herbarium specimens last for decades or even centuries. Here are some preservation tips:</p>
                <ul>
                    <li>Store herbarium sheets in a cool, dry environment to prevent mold or decay.</li>
                    <li>Keep specimens away from direct sunlight to prevent fading.</li>
                    <li>Use insect repellents, such as mothballs or natural oils, to avoid insect damage.</li>
                    <li>Ensure proper ventilation and humidity control in the storage area.</li>
                    <li>Handle herbarium sheets with care, preferably using gloves, to avoid contamination.</li>
                </ul>
            </div>
        </div>
    </section>

    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
    var swiper = new Swiper('.blog-slider', {
        spaceBetween: 30,
        effect: 'fade',
        loop: true,
        mousewheel: {
          invert: false,
        },
        pagination: {
          el: '.blog-slider__pagination',
          clickable: true,
        }
      });
    </script>

    <script>
      new Swiper('.card-wrapper', {
        loop: true,
        spaceBetween: 30,

        // Pagination bullets
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
            dynamicBullets: true
        },

        // Navigation arrows
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },

        // Responsive breakpoints
        breakpoints: {
            0: {
                slidesPerView: 1
            },
            768: {
                slidesPerView: 2
            },
            1024: {
                slidesPerView: 3
            }
        }
    });
    </script>
</body>
</html>

<style>

.blog-slider {
  width: 95%;
  position: relative;
  max-width: 800px;
  margin: auto;
  background: #fff;
  box-shadow: 0px 14px 80px rgba(34, 35, 58, 0.2);
  padding: 25px;
  border-radius: 25px;
  height: 400px;
  transition: all 0.3s;
  margin-top:50px;
}
@media screen and (max-width: 992px) {
  .blog-slider {
    max-width: 680px;
    height: 400px;
  }
}
@media screen and (max-width: 768px) {
  .blog-slider {
    min-height: 500px;
    height: auto;
    margin: 180px auto;
  }
}
@media screen and (max-height: 500px) and (min-width: 992px) {
  .blog-slider {
    height: 350px;
  }
}
.blog-slider__item {
  display: flex;
  align-items: center;
}
@media screen and (max-width: 768px) {
  .blog-slider__item {
    flex-direction: column;
  }
}
.blog-slider__item.swiper-slide-active .blog-slider__img img {
  opacity: 1;
  transition-delay: 0.3s;
}
.blog-slider__item.swiper-slide-active .blog-slider__content > * {
  opacity: 1;
  transform: none;
}
.blog-slider__item.swiper-slide-active .blog-slider__content > *:nth-child(1) {
  transition-delay: 0.3s;
}
.blog-slider__item.swiper-slide-active .blog-slider__content > *:nth-child(2) {
  transition-delay: 0.4s;
}
.blog-slider__item.swiper-slide-active .blog-slider__content > *:nth-child(3) {
  transition-delay: 0.5s;
}
.blog-slider__item.swiper-slide-active .blog-slider__content > *:nth-child(4) {
  transition-delay: 0.6s;
}
.blog-slider__item.swiper-slide-active .blog-slider__content > *:nth-child(5) {
  transition-delay: 0.7s;
}
.blog-slider__item.swiper-slide-active .blog-slider__content > *:nth-child(6) {
  transition-delay: 0.8s;
}
.blog-slider__item.swiper-slide-active .blog-slider__content > *:nth-child(7) {
  transition-delay: 0.9s;
}
.blog-slider__item.swiper-slide-active .blog-slider__content > *:nth-child(8) {
  transition-delay: 1s;
}
.blog-slider__item.swiper-slide-active .blog-slider__content > *:nth-child(9) {
  transition-delay: 1.1s;
}
.blog-slider__item.swiper-slide-active .blog-slider__content > *:nth-child(10) {
  transition-delay: 1.2s;
}
.blog-slider__item.swiper-slide-active .blog-slider__content > *:nth-child(11) {
  transition-delay: 1.3s;
}
.blog-slider__item.swiper-slide-active .blog-slider__content > *:nth-child(12) {
  transition-delay: 1.4s;
}
.blog-slider__item.swiper-slide-active .blog-slider__content > *:nth-child(13) {
  transition-delay: 1.5s;
}
.blog-slider__item.swiper-slide-active .blog-slider__content > *:nth-child(14) {
  transition-delay: 1.6s;
}
.blog-slider__item.swiper-slide-active .blog-slider__content > *:nth-child(15) {
  transition-delay: 1.7s;
}
.blog-slider__img {
  width: 300px;
  flex-shrink: 0;
  height: 300px;
  background-image: linear-gradient(147deg, #3b8b3b 0%, #287c37 74%); 
  box-shadow: 4px 13px 30px 1px rgba(34, 139, 34, 0.2); 
  border-radius: 20px;
  transform: translateX(-80px);
  overflow: hidden;
}
.blog-slider__img:after {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;

  border-radius: 20px;
}
.blog-slider__img img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;

  border-radius: 20px;
  transition: all 0.3s;
}
@media screen and (max-width: 768px) {
  .blog-slider__img {
    transform: translateY(-50%);
    width: 90%;
  }
}
@media screen and (max-width: 576px) {
  .blog-slider__img {
    width: 95%;
  }
}
@media screen and (max-height: 500px) and (min-width: 992px) {
  .blog-slider__img {
    height: 270px;
  }
}
.blog-slider__content {
  padding-right: 25px;
}

@media screen and (max-width: 768px) {
  .blog-slider__content {
    margin-top: -80px;
    text-align: center;
    padding: 0 30px;
  }
}

@media screen and (max-width: 576px) {
  .blog-slider__content {
    padding: 0;
  }
}

.blog-slider__content > * {
  opacity: 0;
  transform: translateY(25px);
  transition: all 0.4s;
}

.blog-slider__code {
  color: #7b7992;
  margin-bottom: 15px;
  display: block;
  font-weight: 500;
}

.blog-slider__title {
  font-size: 24px;
  font-weight: 700;
  color: #0d0925;
  margin-bottom: 20px;
}

.blog-slider__text {
  color: #4e4a67;
  margin-bottom: 30px;
  line-height: 1.5em;
}

.blog-slider__button {
  display: inline-flex;
  background-image: linear-gradient(147deg, #fe8a39 0%, #fd3838 74%);
  padding: 15px 35px;
  border-radius: 50px;
  color: #fff;
  box-shadow: 0px 14px 80px rgba(252, 56, 56, 0.4);
  text-decoration: none;
  font-weight: 500;
  justify-content: center;
  text-align: center;
  letter-spacing: 1px;
}

@media screen and (max-width: 576px) {
  .blog-slider__button {
    width: 100%;
  }
}

.blog-slider .swiper-container-horizontal > .swiper-pagination-bullets,
.blog-slider .swiper-pagination-custom,
.blog-slider .swiper-pagination-fraction {
  bottom: 10px;
  left: 0;
  width: 100%;
}

.blog-slider__pagination {
  position: absolute;
  z-index: 21;
  right: 20px;
  width: 11px !important;
  text-align: center;
  left: auto !important;
  top: 50%;
  transform: translateY(-100%);
}

@media screen and (max-width: 768px) {
  .blog-slider__pagination {
    transform: translateX(-50%);
    left: 50% !important;
    top: 205px;
    width: 100% !important;
    display: flex;
    justify-content: center;
    align-items: center;
  }
}

.blog-slider__pagination.swiper-pagination-bullets .swiper-pagination-bullet {
  margin: 8px 0;
}

@media screen and (max-width: 768px) {
  .blog-slider__pagination.swiper-pagination-bullets .swiper-pagination-bullet {
    margin: 0 5px;
  }
}

.blog-slider__pagination .swiper-pagination-bullet {
  width: 11px;
  height: 11px;
  display: block;
  border-radius: 10px;
  background: #3b8b3b;
  opacity: 0.2;
  transition: all 0.3s;
}

.blog-slider__pagination .swiper-pagination-bullet-active {
  opacity: 1;
  background: #3b8b3b;
  height: 30px;
  box-shadow: 0px 0px 20px rgba(34, 139, 34, 0.3);
}

@media screen and (max-width: 768px) {
  .blog-slider__pagination .swiper-pagination-bullet-active {
    height: 11px;
    width: 30px;
  }
}

.preservation {
  position: relative;
  height: 400px;
  width: 70%;
  padding: 0;
  margin: 50px auto;
  overflow: hidden;
  border-radius: 15px;
  display: flex;
  justify-content: center;
  align-items: center;
}

.video-background {
  background: #000;
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  z-index: -1;
}

.video-foreground,
.video-background iframe {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  pointer-events: none;
}

#vidtop-content {
  position: absolute;
  top: 0;
  right: 0;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: flex-end;
  z-index: 1;
}

.vid-info {
  width: 33%;
  background: rgba(0, 0, 0, 0.3);
  color: #fff;
  padding: 1rem;
  font-family: Avenir, Helvetica, sans-serif;
}

.vid-info h1 {
  font-size: 2rem;
  font-weight: 700;
  margin-top: 0;
  line-height: 1.2;
}

.vid-info a {
  display: block;
  color: #fff;
  text-decoration: none;
  background: rgba(0, 0, 0, 0.5);
  transition: background 0.6s;
  border-bottom: none;
  margin: 1rem auto;
  text-align: center;
}

.youtube-button {
  display: inline-block;
  margin-top: 1rem;
  padding: 0.5rem 1rem;
  background: rgba(0, 0, 0, 0.7);
  color: #fff;
  text-decoration: none;
  border-radius: 5px;
  transition: background 0.3s;
}

.youtube-button:hover {
  background: rgba(0, 0, 0, 0.9);
}

.full-article-link {
  color: #fff;
  text-decoration: underline;
}

@media (max-width: 768px) {
  .preservation {
    flex-direction: column;
  }

  .video-background {
    flex-basis: 100%;
    height: 50vh;
  }

  #vidtop-content {
    width: 100%;
    padding: 1rem;
  }

  .vid-info {
    width: 100%;
  }
}


@media (min-aspect-ratio: 16/9) {
  .video-foreground {
    height: 300%;
    top: -100%;
  }
}

@media (max-aspect-ratio: 16/9) {
  .video-foreground {
    width: 300%;
    left: -100%;
  }
}

</style>
