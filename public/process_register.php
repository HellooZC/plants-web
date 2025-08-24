<?php
// Database connection (PDO)
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
    $stmt = $conn->prepare("SELECT 1 FROM user_table WHERE email = :email LIMIT 1");
    $stmt->execute([':email' => $email]);
    return $stmt->fetchColumn() !== false;
}

$errors = [];
$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name  = $_POST['last_name'];
    $dob        = $_POST['dob'];
    $gender     = $_POST['gender'];
    $email      = $_POST['email'];
    $hometown   = $_POST['hometown'];
    $password   = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Default profile image
    $profile_image = $gender === 'female' ? 'profile_images/girl.png' : 'profile_images/boys.jpg';

    // Validation
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

    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        try {
            // Start transaction
            $conn->beginTransaction();

            // Insert into user_table
            $stmt = $conn->prepare("
                INSERT INTO user_table (email, first_name, last_name, dob, gender, hometown, profile_image) 
                VALUES (:email, :first_name, :last_name, :dob, :gender, :hometown, :profile_image)
            ");
            $stmt->execute([
                ':email' => $email,
                ':first_name' => $first_name,
                ':last_name' => $last_name,
                ':dob' => $dob,
                ':gender' => $gender,
                ':hometown' => $hometown,
                ':profile_image' => $profile_image
            ]);

            // Insert into account_table
            $stmt = $conn->prepare("
                INSERT INTO account_table (email, password, type) 
                VALUES (:email, :password, 'user')
            ");
            $stmt->execute([
                ':email' => $email,
                ':password' => $hashed_password
            ]);

            // Commit transaction
            $conn->commit();
            $success = true;
        } catch (Exception $e) {
            $conn->rollBack();
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
