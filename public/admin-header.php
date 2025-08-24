<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/style-admin.css">
<header>
  <nav> <!-- Darker shade of blue -->
    <div class="logo" style="color: white;">Plant Biodiversity</div>

    <!-- Home Button -->
    <button type="button" title="Home" onclick="window.location.href='main_menu_admin.php'">
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

    <!-- Manage Users Button -->
    <button type="button" title="Manage Users" onclick="window.location.href='manage_users.php'">
      <span>Manage Users</span>
      <span class="material-symbols-outlined" aria-hidden="true">group</span>
      <svg viewBox="0 0 300 300" aria-hidden="true">
        <g>
          <text fill="currentColor">
            <textPath xlink:href="#circlePath">Manage Users</textPath>
          </text>
          <text fill="currentColor">
            <textPath xlink:href="#circlePath" startOffset="50%">Manage Users</textPath>
          </text>
        </g>
      </svg>
    </button>

    <!-- Manage Plants Button -->
    <button type="button" title="Manage Plants" onclick="window.location.href='manage_plants.php'">
      <span>Manage Plants</span>
      <span class="material-symbols-outlined" aria-hidden="true">nature</span>
      <svg viewBox="0 0 300 300" aria-hidden="true">
        <g>
          <text fill="currentColor">
            <textPath xlink:href="#circlePath">Manage Plants</textPath>
          </text>
          <text fill="currentColor">
            <textPath xlink:href="#circlePath" startOffset="50%">Manage Plants</textPath>
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

