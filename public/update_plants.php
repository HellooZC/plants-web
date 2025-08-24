<?php
require_once 'db_connection.php';

if (isset($_POST['id']) && isset($_POST['updatedData'])) {
    $id = $_POST['id'];
    $updatedData = json_decode($_POST['updatedData'], true); // Decode JSON

    // SQL query
    $sql = "UPDATE plant_table SET 
            Scientific_Name = ?, 
            Common_Name = ?, 
            family = ?, 
            genus = ?, 
            species = ? 
            WHERE id = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssssi", 
            $updatedData['Scientific_Name'], 
            $updatedData['Common_Name'], 
            $updatedData['family'], 
            $updatedData['genus'], 
            $updatedData['species'],  
            $id);

        if ($stmt->execute()) {
            echo 'plants updated successfully';
        } else {
            echo 'Error updating plants: ' . $stmt->error;
        }

        $stmt->close();
    } else {
        echo 'Database query failed: ' . $conn->error;
    }
} else {
    echo 'Invalid request';
}

$conn->close();
?>
