
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

<header>
  <nav>
    <div class="logo">Plant Biodiversity</div>

    <!-- Home Button -->
    <button type="button" title="Home" onclick="window.location.href='main_menu.php'">
      <span>Home</span>
      <span class="material-symbols-outlined" aria-hidden="true">home</span>
      <svg viewBox="0 0 300 300" aria-hidden="true">
        <g>
          <text fill="currentColor">
            <textPath xlink:href="#circlePath">Home</textPath>
          </text>
          <text fill="currentColor">
            <textPath xlink:href="#circlePath" startOffset="50%">Home</textPath>
          </text>
        </g>
      </svg>
    </button>

    <!-- Classify Button -->
    <button type="button" title="Classify" onclick="window.location.href='classify.php'">
      <span>Classify</span>
      <span class="material-symbols-outlined" aria-hidden="true">category</span>
      <svg viewBox="0 0 300 300" aria-hidden="true">
        <g>
          <text fill="currentColor">
            <textPath xlink:href="#circlePath">Classify</textPath>
          </text>
          <text fill="currentColor">
            <textPath xlink:href="#circlePath" startOffset="50%">Classify</textPath>
          </text>
        </g>
      </svg>
    </button>

    <!-- Tutorial Button -->
    <button type="button" title="Tutorial" onclick="window.location.href='tutorial.php'">
      <span>Tutorial</span>
      <span class="material-symbols-outlined" aria-hidden="true">school</span>
      <svg viewBox="0 0 300 300" aria-hidden="true">
        <g>
          <text fill="currentColor">
            <textPath xlink:href="#circlePath">Tutorial</textPath>
          </text>
          <text fill="currentColor">
            <textPath xlink:href="#circlePath" startOffset="50%">Tutorial</textPath>
          </text>
        </g>
      </svg>
    </button>

    <!-- Contribute Button -->
    <button type="button" title="Contribute" onclick="window.location.href='contribute.php'">
      <span>Contribute</span>
      <span class="material-symbols-outlined" aria-hidden="true">volunteer_activism</span>
      <svg viewBox="0 0 300 300" aria-hidden="true">
        <g>
          <text fill="currentColor">
            <textPath xlink:href="#circlePath">Contribute</textPath>
          </text>
          <text fill="currentColor">
            <textPath xlink:href="#circlePath" startOffset="50%">Contribute</textPath>
          </text>
        </g>
      </svg>
    </button>

    <!-- Profile Button -->
    <button type="button" title="Profile" onclick="window.location.href='profile.php'">
      <span>Profile</span>
      <span class="material-symbols-outlined" aria-hidden="true">account_circle</span>
      <svg viewBox="0 0 300 300" aria-hidden="true">
        <g>
          <text fill="currentColor">
            <textPath xlink:href="#circlePath">Profile</textPath>
          </text>
          <text fill="currentColor">
            <textPath xlink:href="#circlePath" startOffset="50%">Profile</textPath>
          </text>
        </g>
      </svg>
    </button>
    <!-- Log Out Button -->
    <button onclick="window.location.href='logout.php'" class="main-menu-btn">Log Out</button>

  </nav>

  <!-- SVG template with dynamic text -->
  <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 300 300" width="0" height="0">
    <defs>
      <path id="circlePath" d="M 150, 150 m -50, 0 a 50,50 0 0,1 100,0 a 50,50 0 0,1 -100,0" />
    </defs>
  </svg>
</header>
