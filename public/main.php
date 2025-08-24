<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";  // replace with your database password if any

try {
    // Connect to MySQL
    $conn = new PDO("mysql:host=$servername", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create database if it doesn't exist
    $conn->exec("CREATE DATABASE IF NOT EXISTS PlantBiodiversity");
    $conn->exec("USE PlantBiodiversity");

    // Create user_table
    $createUserTable = "CREATE TABLE IF NOT EXISTS user_table (
        email VARCHAR(50) NOT NULL PRIMARY KEY,
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
        type VARCHAR(5) NOT NULL,
        FOREIGN KEY (email) REFERENCES user_table(email) ON DELETE CASCADE ON UPDATE CASCADE
    )";
    $conn->exec($createAccountTable);

    // Create plant_table
    $createPlantTable = "CREATE TABLE IF NOT EXISTS plant_table (
        id INT(4) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        Scientific_Name VARCHAR(50) NOT NULL,
        Common_Name VARCHAR(50) NOT NULL,
        family VARCHAR(100) NOT NULL,
        genus VARCHAR(100) NOT NULL,
        species VARCHAR(100) NOT NULL,
        plants_image JSON NOT NULL,
        description VARCHAR(100) NULL,
        status ENUM('pending', 'approved', 'rejected') NOT NULL DEFAULT 'pending'
    )";
    $conn->exec($createPlantTable);

    // Insert dummy data into user_table
    $insertUserTable = "INSERT IGNORE INTO user_table (email, first_name, last_name, dob, gender, contact_number, hometown, profile_image, resume_path) VALUES
        ('admin@swin.edu.my', 'Admin', 'User', '1970-01-01', 'Male', '123456789', 'Hometown1', NULL, ''),
        ('user1@example.com', 'User1', 'Lastname1', '1990-02-02', 'Female', '234567890', 'Hometown2', NULL, ''),
        ('user2@example.com', 'User2', 'Lastname2', '1985-03-03', 'Male', '345678901', 'Hometown3', NULL, ''),
        ('user3@example.com', 'User3', 'Lastname3', '2000-04-04', 'Female', '456789012', 'Hometown4', NULL, '')";
    $conn->exec($insertUserTable);

    // Insert dummy data into account_table
    $insertAccountTable = "INSERT IGNORE INTO account_table (email, password, type) VALUES
        ('admin@swin.edu.my', '" . password_hash("admin", PASSWORD_DEFAULT) . "', 'admin'),
        ('user1@example.com', '" . password_hash("user1pass", PASSWORD_DEFAULT) . "', 'user'),
        ('user2@example.com', '" . password_hash("user2pass", PASSWORD_DEFAULT) . "', 'user'),
        ('user3@example.com', '" . password_hash("user3pass", PASSWORD_DEFAULT) . "', 'user')";
    $conn->exec($insertAccountTable);

    // Insert dummy data into plant_table
    $insertPlantTable = "INSERT INTO plant_table (Scientific_Name, Common_Name, plants_image, family, genus, species, description, status)
VALUES
    (
        'Vatica umbonata',
        'Vatica',
        '[\"images/Vatica.jpg\", \"images/vatica-umbonota.jpg\", \"images/vatica-umbonota-herbarium.jpg\"]',
        'Dipterocarpaceae',
        'Vatica',
        'V. umbonata',
        'descriptions/rosa_description.pdf',
        'pending'
    ),
    (
        'Dipterocarpus alatus',
        'Dipterocarpus',
        '[\"images/Dipterocarpaceae.jpg\", \"images/dipterocarpacea-leaves.jpg\", \"images/dipterocarpaceae-herbarium.jpg\"]',
        'Dipterocarpaceae',
        'Dipterocarpus',
        'D. alatus',
        'descriptions/oak_description.pdf',
        'pending'
    ),
    (
        'Dacryodes costata',
        'Dacryodes',
        '[\"images/dacryodes-costata.jpeg\", \"images/dacryodes-costata-leaves.jpeg\", \"images/dacryodes-costata-herbarium.jpg\"]',
        'Burseraceae',
        'Dacryodes',
        'D. costata',
        'descriptions/maple_description.pdf',
        'pending'
    ),
    (
        'Dipterocarpus alatus',
        'Dipterocarpus',
        '[\"images/dipterocarpus-alatus.jpg\", \"images/dipterocarpus-alatus-leaves.jpg\", \"images/dipterocarpus-alatus-herbarium.jpg\"]',
        'Dipterocarpaceae',
        'Dipterocarpus',
        'D. alatus',
        'descriptions/magnolia_description.pdf',
        'pending'
    ),
    (
        'Canarium',
        'Canarium',
        '[\"images/Canarium.jpg\", \"images/canarium-leaves.jpeg\", \"images/canarium-herbarium.jpeg\"]',
        'Burseraceae',
        'Canarium',
        'C. sp.',
        'descriptions/lavender_description.pdf',
        'pending'
    ),
    (
        'Actinodaphne glomerata',
        'Actinodaphne',
        '[\"images/actinodaphne.JPG\", \"images/actinodaphne glomerata.jpg\", \"images/Actinodaphne-herbarium.jpg\"]',
        'Lauraceae',
        'Actinodaphne',
        'A. glomerata',
        'descriptions/lavender_description.pdf',
        'pending'
    );
";
    $conn->exec($insertPlantTable);

    echo "Database and tables created successfully, and data inserted.";
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;
?>
