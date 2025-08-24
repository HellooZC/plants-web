<?php
require_once 'db_connection.php'; // Include the mysqli connection

// Check if the request is a POST and has the 'id' parameter
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $email = $_POST['id']; // Get the email from the POST request

    // Delete from user_table using the email
    $deleteUserQuery = "DELETE FROM user_table WHERE email = '$email'";
    $deleteAccountQuery = "DELETE FROM account_table WHERE email = '$email'";

    // Perform the delete operation for user_table
    if ($conn->query($deleteUserQuery) === TRUE) {
        // If successful, delete from account_table
        if ($conn->query($deleteAccountQuery) === TRUE) {
            echo 'success'; // Send success message
        } else {
            echo 'error: Failed to delete from account_table'; // Send failure message
        }
    } else {
        echo 'error: Failed to delete from user_table'; // Send failure message
    }
}
?>
