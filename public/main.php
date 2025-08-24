<?php
// PostgreSQL connection (Render DATABASE_URL)
$url = getenv("DATABASE_URL");

if (!$url) {
    die("❌ DATABASE_URL environment variable is not set.");
}

$db = parse_url($url);

$host = $db['host'];
$port = $db['port'] ?? 5432;
$user = $db['user'];
$pass = $db['pass'];
$name = ltrim($db['path'], '/');

try {
    // Connect to PostgreSQL
    $conn = new PDO("pgsql:host=$host;port=$port;dbname=$name", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create user_table
    $createUserTable = "CREATE TABLE IF NOT EXISTS user_table (
        email VARCHAR(50) PRIMARY KEY,
        first_name VARCHAR(50) NOT NULL,
        last_name VARCHAR(50) NOT NULL,
        dob DATE NULL,
        gender VARCHAR(6) NOT NULL,
        contact_number VARCHAR(15) NULL,
        hometown VARCHAR(50) NOT NULL,
        profile_image VARCHAR(100) NULL,
        resume_path VARCHAR(100) NULL
    )";
    $conn->exec($createUserTable);

    // Create account_table
    $createAccountTable = "CREATE TABLE IF NOT EXISTS account_table (
        email VARCHAR(50) NOT NULL,
        password VARCHAR(255) NOT NULL,
        type VARCHAR(10) NOT NULL,
        FOREIGN KEY (email) REFERENCES user_table(email) ON DELETE CASCADE ON UPDATE CASCADE
    )";
    $conn->exec($createAccountTable);

    // Create plant_table
    $createPlantTable = "CREATE TABLE IF NOT EXISTS plant_table (
        id SERIAL PRIMARY KEY,
        Scientific_Name VARCHAR(50) NOT NULL,
        Common_Name VARCHAR(50) NOT NULL,
        family VARCHAR(100) NOT NULL,
        genus VARCHAR(100) NOT NULL,
        species VARCHAR(100) NOT NULL,
        plants_image JSON NOT NULL,
        description VARCHAR(100) NULL,
        status VARCHAR(10) NOT NULL DEFAULT 'pending'
    )";
    $conn->exec($createPlantTable);

    echo "✅ Database tables created successfully.";
} catch(PDOException $e) {
    echo "❌ Error: " . $e->getMessage();
}
?>
