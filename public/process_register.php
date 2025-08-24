<?php
// Database connection
include 'db_connection.php';

// Function to validate email format
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Function to validate password strength
function isValidPassword($password) {
    return preg_match('/^(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/', $password);
}

// Function to check if email already exists in the database
function emailExists($email, $conn) {
    $stmt = $conn->prepare("SELECT email FROM user_table WHERE email = ?");
    $stmt->bind_param('s', $email); // 's' stands for string type
    $stmt->execute();
    $stmt->store_result(); // This is needed to get row count properly
    return $stmt->num_rows > 0;
}

$errors = [];
$success = false;

// Ensure all fields are filled
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $hometown = $_POST['hometown'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Determine default profile image based on gender
    $profile_image = $gender === 'female' ? 'profile_images/girl.png' : 'profile_images/boys.jpg';

    // Validate fields
    if (!preg_match("/^[a-zA-Z ]*$/", $first_name) || !preg_match("/^[a-zA-Z ]*$/", $last_name)) {
        $errors[] = "First and Last names should contain only alphabets and spaces.";
    }

    if (!isValidEmail($email)) {
        $errors[] = "Invalid email format.";
    }

    if (!isValidPassword($password)) {
        $errors[] = "Password must contain at least 8 characters, including 1 number and 1 symbol.";
    }

    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    if (emailExists($email, $conn)) {
        $errors[] = "Email already exists.";
    }

    // If no errors, save to database
    if (empty($errors)) {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        try {
            // Disable autocommit to start a transaction
            $conn->autocommit(false);
        
            // Insert into user_table
            $stmt = $conn->prepare("INSERT INTO user_table (email, first_name, last_name, dob, gender, hometown, profile_image) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param('sssssss', $email, $first_name, $last_name, $dob, $gender, $hometown, $profile_image);
            $stmt->execute();
        
            // Insert into account_table
            $stmt = $conn->prepare("INSERT INTO account_table (email, password, type) VALUES (?, ?, 'user')");
            $stmt->bind_param('ss', $email, $hashed_password);
            $stmt->execute();
        
            // Commit transaction
            $conn->commit();
            $success = true;
        
            // Re-enable autocommit mode
            $conn->autocommit(true);
        } catch (Exception $e) {
            // Rollback transaction in case of error
            $conn->rollback();
            $conn->autocommit(true);
            $errors[] = "Failed to register: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Validation</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<?php include 'header.php' ?>
<?php if (!empty($errors)): ?>
<script>
    Swal.fire({
        icon: 'error',
        title: 'Registration Failed',
        html: '<?php echo implode("<br>", $errors); ?>',
        confirmButtonText: 'Ok'
    }).then(() => {
        window.location.href = 'registration.php';
    });
</script>
<?php elseif ($success): ?>
<script>
    Swal.fire({
        icon: 'success',
        title: 'Registration Successful',
        text: 'Your account has been created. Redirecting to login page...',
        timer: 3000,
        showConfirmButton: false
    }).then(() => {
        window.location.href = 'login.php';
    });
</script>
<?php endif; ?>
</body>
</html>
