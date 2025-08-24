<?php
include('session_check.php'); // Ensure the user is logged in
include('db_connection.php'); // Database connection file

// Fetch user data to populate the form (for displaying current info in the form)
$userData = [];
$query = "SELECT * FROM user_table WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $_SESSION['email']);
$stmt->execute();
$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
    $userData = $row;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Fetch data from form
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $contact_number = $_POST['contact_number'];
    $hometown = $_POST['hometown'];
    $email = $_POST['email'];

    // Handle profile image upload
    $profileImage = $userData['profile_image'] ?? 'profile_images/boys.jpg'; // Default profile image

    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        $maxSize = 5 * 1024 * 1024; // 5MB

        $fileType = $_FILES['profile_image']['type'];
        $fileSize = $_FILES['profile_image']['size'];
        $fileTmp = $_FILES['profile_image']['tmp_name'];
        $fileName = $_FILES['profile_image']['name'];
        
        // Check file type and size for profile image
        if (in_array($fileType, $allowedTypes) && $fileSize <= $maxSize) {
            $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
            $fileNewName = uniqid() . '.' . $fileExtension;
            $profileImage = 'profile_images/' . $fileNewName;
            move_uploaded_file($fileTmp, $profileImage);
        } else {
            $error = "Invalid profile image type or file is too large!";
        }
    }

    // Handle resume upload
    $resumePath = $userData['resume_path'] ?? ''; // Keep existing resume path if no new file is uploaded
    if (isset($_FILES['resume']) && $_FILES['resume']['error'] == 0) {
        $uploadDir = 'resume/';
        $allowedExtension = 'pdf';
        $maxFileSize = 7 * 1024 * 1024; // 7MB

        $resumeFileType = strtolower(pathinfo($_FILES['resume']['name'], PATHINFO_EXTENSION));
        $resumeFileSize = $_FILES['resume']['size'];
        $resumeTmp = $_FILES['resume']['tmp_name'];

        // Check file type and size for resume
        if ($resumeFileType === $allowedExtension && $resumeFileSize <= $maxFileSize) {
            $resumeFileName = uniqid() . '.' . $resumeFileType;
            $resumePath = $uploadDir . $resumeFileName;

            // Create resume directory if it doesn't exist
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            move_uploaded_file($resumeTmp, $resumePath);
        } else {
            $error = "Invalid resume file type or file size exceeds 7MB!";
        }
    }

    // Update database with the new values
    $query = "UPDATE user_table SET first_name = ?, last_name = ?, dob = ?, gender = ?, contact_number = ?, hometown = ?, profile_image = ?, resume_path = ? WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssssss", $first_name, $last_name, $dob, $gender, $contact_number, $hometown, $profileImage, $resumePath, $email);
    $stmt->execute();

    header("Location: profile.php"); // Redirect after update
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <style>
        .update-profile-container {
            width: 100%;
            min-height: 460px;
            margin: auto;
            box-shadow: 0px 8px 60px -10px rgba(13, 28, 39, 0.6);
            background: #fff;
            border-radius: 12px;
            max-width: 700px;
            position: relative;
            margin-top:100px;
            margin-bottom: 100px;
        }
        .profile-img {
            width: 150px;
            height: 150px;
            margin-left: auto;
            margin-right: auto;
            transform: translateY(-50%);
            border-radius: 50%;
            overflow: hidden;
            position: relative;
            z-index: 4;
            box-shadow: 0px 5px 50px 0px #8AE28A, 0px 0px 0px 7px rgba(107, 74, 255, 0.5);  
        }
        .profile-card__img img {
            display: block;
            width: 30%;
            height: 30%;
            object-fit: cover;
            border-radius: 50%;
        }
        .profile-card__cnt {
            margin-top: -35px;
            text-align: center;
            padding: 0 20px;
            padding-bottom: 40px;
            transition: all 0.3s;
        }
        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }
        .form-group label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .profile-card__button {
            background: none;
            border: none;
            font-family: "Quicksand", sans-serif;
            font-weight: 700;
            font-size: 19px;
            margin: 15px 35px;
            padding: 15px 40px;
            min-width: 201px;
            border-radius: 50px;
            min-height: 55px;
            color: #fff;
            cursor: pointer;
            backface-visibility: hidden;
            transition: all 0.3s;
        }
        .profile-card__button:first-child {
        margin-left: 0;
        }
        .profile-card__button:last-child {
        margin-right: 0;
        }
        .profile-card__button.button--blue {
        background: linear-gradient(45deg, #1da1f2, #0e71c8);
        box-shadow: 0px 4px 30px rgba(19, 127, 212, 0.4);
        }
        .profile-card__button.button--blue:hover {
        box-shadow: 0px 7px 30px rgba(19, 127, 212, 0.75);
        }
        .profile-card__button.button--orange {
        background: linear-gradient(45deg, #d5135a, #f05924);
        box-shadow: 0px 4px 30px rgba(223, 45, 70, 0.35);
        }
        .profile-card__button.button--orange:hover {
        box-shadow: 0px 7px 30px rgba(223, 45, 70, 0.75);
        }
        .profile-card__button.button--gray {
        box-shadow: none;
        background: #dcdcdc;
        color: #142029;
        }
    </style>
</head>
<body>
<?php include 'header.php'; ?>
<div class="update-profile-container">
    <div class="profile-card__img">
        <img src="<?php echo $userData['profile_image'] ?? 'profile_images/boys.jpg'; ?>" alt="Profile Image" class="profile-img">
    </div>
    <form class="profile-card__cnt" action="update_profile.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($userData['first_name'] ?? ''); ?>" required>
        </div>

        <div class="form-group">
            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($userData['last_name'] ?? ''); ?>" required>
        </div>

        <div class="form-group">
            <label for="dob">Date of Birth:</label>
            <input type="date" id="dob" name="dob" value="<?php echo $userData['dob'] ?? ''; ?>" required>
        </div>

        <div class="form-group">
            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="Male" <?php echo ($userData['gender'] ?? '') === 'Male' ? 'selected' : ''; ?>>Male</option>
                <option value="Female" <?php echo ($userData['gender'] ?? '') === 'Female' ? 'selected' : ''; ?>>Female</option>
            </select>
        </div>

        <div class="form-group">
            <label for="contact_number">Contact Number:</label>
            <input type="text" id="contact_number" name="contact_number" value="<?php echo htmlspecialchars($userData['contact_number'] ?? ''); ?>" required>
        </div>

        <div class="form-group">
            <label for="hometown">Hometown:</label>
            <input type="text" id="hometown" name="hometown" value="<?php echo htmlspecialchars($userData['hometown'] ?? ''); ?>" required>
        </div>

        <div class="form-group">
            <label for="profile_image">Profile Image (JPG, PNG, JPEG, max 5MB):</label>
            <input type="file" id="profile_image" name="profile_image" accept="image/jpeg, image/png, image/jpg">
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($userData['email'] ?? ''); ?>" readonly required>
        </div>
        <div class="form-group" action="upload_resume.php" method="post" enctype="multipart/form-data">
            <label for="resume">Upload your resume (PDF only, max 7MB):</label>
            <input type="file" name="resume" id="resume" required>
        </div>
        <div class="profile-card-ctr">
            <button type="submit" class="profile-card__button button--blue">Update</button>
            <button type="button" onclick="window.location.href='index.php'" class="profile-card__button button--orange">Cancel</button>
        </div>
        

    </form>
</div>
</body>
</html>