<?php
include 'db_connection.php'; // Include database connection
include 'session_check.php'; // Include session check for authentication

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect data from the form
    $scientific_name = $conn->real_escape_string($_POST['scientific_name']);
    $common_name = $conn->real_escape_string($_POST['common_name']);
    $family = $conn->real_escape_string($_POST['family']);
    $genus = $conn->real_escape_string($_POST['genus']);
    $species = $conn->real_escape_string($_POST['species']);

    // Handle multiple image uploads
    $image_paths = [];
    if (!empty($_FILES['plants_image']['name'][0])) {
        foreach ($_FILES['plants_image']['tmp_name'] as $key => $tmp_name) {
            $file_name = basename($_FILES['plants_image']['name'][$key]);
            $target_path = "images/" . uniqid() . "_" . $file_name; // Save with unique names
            if (move_uploaded_file($tmp_name, $target_path)) {
                $image_paths[] = $target_path;
            }
        }
    }

    // Convert the image paths array to JSON
    $plants_image = json_encode($image_paths);

    // Handle PDF upload
    $description_path = null;
    if (!empty($_FILES['description']['tmp_name'])) {
        $pdf_name = basename($_FILES['description']['name']);
        $target_path = "plants_description/" . uniqid() . "_" . $pdf_name; // Save with unique names
        if (move_uploaded_file($_FILES['description']['tmp_name'], $target_path)) {
            $description_path = $target_path;
        }
    }

    // Prepare the SQL query
    $sql = "INSERT INTO plant_table (Scientific_Name, Common_Name, Family, Genus, Species, plants_image, description, status)
            VALUES ('$scientific_name', '$common_name', '$family', '$genus', '$species', '$plants_image', '$description_path', 'pending')";

    if ($conn->query($sql) === TRUE) {
        echo "New plant added successfully! It is now pending approval.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plant Submission Result</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .message {
            padding: 20px;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
        .success {
            color: #28a745;
        }
        .error {
            color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="message">
        <p class="<?php echo ($conn->error) ? 'error' : 'success'; ?>">
            <?php echo ($conn->error) ? "An error occurred. Please try again." : "Your plant has been submitted successfully."; ?>
        </p>
        <a href="plant_contribution_page.php">Go back to Contributions Page</a>
    </div>
</body>
</html>

<?php
$conn->close();
?>
