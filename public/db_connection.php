<?php
// Get the Render PostgreSQL connection string from environment
$url = getenv("DATABASE_URL");

if (!$url) {
    die("DATABASE_URL environment variable is not set.");
}

// Parse the DATABASE_URL
$db = parse_url($url);

$host = $db['host'];
$port = $db['port'] ?? 5432;
$user = $db['user'];
$pass = $db['pass'];
$name = ltrim($db['path'], '/');

echo "Raw DATABASE_URL: [$url]<br>";
echo "Parsed dbname: [$name]<br>";

try {
    // Create a new PDO connection to PostgreSQL
    $conn = new PDO("pgsql:host=$host;port=$port;dbname=$name", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    // Optional: uncomment for debugging
    // echo "✅ Connected to PostgreSQL database.";
} catch (PDOException $e) {
    die("❌ Database connection failed: " . $e->getMessage());
}
?>
