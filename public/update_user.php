<?php
require_once 'db_connection.php';

if (isset($_POST['email']) && isset($_POST['updatedData'])) {
    $email = $_POST['email'];
    $updatedData = $_POST['updatedData'];

    $sql = "UPDATE user_table SET 
            first_name = ?, 
            last_name = ?, 
            dob = ?, 
            gender = ?, 
            contact_number = ?, 
            hometown = ? 
            WHERE email = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssssss", 
            $updatedData['first_name'], 
            $updatedData['last_name'], 
            $updatedData['dob'], 
            $updatedData['gender'], 
            $updatedData['contact_number'], 
            $updatedData['hometown'], 
            $email);

        if ($stmt->execute()) {
            echo 'User updated successfully';
        } else {
            echo 'Error updating user';
        }

        $stmt->close();
    } else {
        echo 'Database query failed';
    }
} else {
    echo 'Invalid request';
}

$conn->close();
?>
