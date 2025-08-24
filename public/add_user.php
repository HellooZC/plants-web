<?php
// Include database connection
require_once 'db_connection.php';

// Get the form data
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$email = $_POST['email'];
$dob = $_POST['dob'];
$gender = $_POST['gender'];
$contactNumber = $_POST['contactNumber'];
$hometown = $_POST['hometown'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the password
$accountType = $_POST['accountType'];

// Begin a transaction
$conn->begin_transaction();

try {
    // Insert the new user into the user_table
    $userSql = "INSERT INTO user_table (first_name, last_name, email, dob, gender, contact_number, hometown) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
    $userStmt = $conn->prepare($userSql);
    $userStmt->bind_param('sssssss', $firstName, $lastName, $email, $dob, $gender, $contactNumber, $hometown);
    $userStmt->execute();

    // Insert the account details into the account_table
    $accountSql = "INSERT INTO account_table (email, password, type) 
                   VALUES (?, ?, ?)";
    $accountStmt = $conn->prepare($accountSql);
    $accountStmt->bind_param('sss', $email, $password, $accountType);
    $accountStmt->execute();

    // Commit the transaction
    $conn->commit();

    echo 'User added successfully';
} catch (Exception $e) {
    // Roll back the transaction in case of an error
    $conn->rollback();
    echo 'Error adding user: ' . $e->getMessage();
}

// Close the statements and connection
$userStmt->close();
$accountStmt->close();
$conn->close();
?>
