<?php
include 'db_connection.php';
include 'session_check.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
            $file_type = mime_content_type($tmp_name);

            // Validate file type (only images)
            if (in_array($file_type, ['image/jpeg', 'image/png', 'image/gif'])) {
                $target_path = "images/" . uniqid() . "_" . $file_name;

                if (move_uploaded_file($tmp_name, $target_path)) {
                    $image_paths[] = $target_path;
                }
            }
        }
    }
    $plants_image = json_encode($image_paths);


    // Handle PDF upload
    $description_path = null;
    if (!empty($_FILES['description']['tmp_name'])) {
        $pdf_name = basename($_FILES['description']['name']);
        $target_path = "plants_description/" . uniqid() . "_" . $pdf_name;
        if (move_uploaded_file($_FILES['description']['tmp_name'], $target_path)) {
            $description_path = $target_path;
        }
    }

    // Insert into database
    $sql = "INSERT INTO plant_table (Scientific_Name, Common_Name, Family, Genus, Species, plants_image, description, status)
            VALUES ('$scientific_name', '$common_name', '$family', '$genus', '$species', '$plants_image', '$description_path', 'pending')";

    if ($conn->query($sql) === TRUE) {
        $message = "Plant submitted successfully! Awaiting approval.";
        $status = "success";
    } else {
        $message = "Error: " . $conn->error;
        $status = "error";
    }

    echo "<script>
        window.onload = function() {
            Swal.fire({
                icon: '$status',
                title: 'Submission Status',
                text: '$message',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = 'contribute.php';
            });
        };
    </script>";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Plant Contributions</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css'>
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Style for the floating button */
        .floating-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 50%;
            padding: 15px 20px;
            font-size: 20px;
            cursor: pointer;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

                /* Modal styles with animation */
        .modal {
            display: none; /* Hidden by default */
            position: fixed;
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: hidden; /* Prevent scrolling in the modal */
            background-color: rgba(0, 0, 0, 0.4);
            animation: fadeIn 0.3s; /* Fade-in animation */
        }

        /* Animation for modal appearance */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); 
            width: 50%;
            max-width: 600px; 
            animation: slideIn 0.4s ease-out; 
        }
        @keyframes slideIn {
            from {
                transform: translateY(-30%);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Prevent scrolling on the main page when modal is open */
        body.modal-open {
            overflow: hidden;
        }


        /* Close Button */
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        /* Form Styling Inside Modal */
        .modal-content form {
            display: flex;
            flex-direction: column;
        }

        .modal-content label {
            font-weight: bold;
            margin-top: 10px;
            color: #333;
        }

        .modal-content input[type="text"],
        .modal-content input[type="file"],
        .modal-content button[type="submit"] {
            padding: 10px;
            margin-top: 5px;
            border-radius: 5px; 
            border: 1px solid #ddd;
            width: 100%;
        }

        .modal-content input[type="file"] {
            padding: 8px; 
        }

        .modal-content button[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            margin-top: 15px;
        }

        .modal-content button[type="submit"]:hover {
            background-color: #45a049;
        }
        /* Add Plant Button Styles */
        #addPlant {
            background-color: #28a745; 
            color: white; 
            padding: 12px 20px; 
            font-size: 16px;
            font-weight: bold; 
            border: none; 
            border-radius: 8px; 
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: all 0.3s ease; 
        }

        /* Hover Effect */
        #addPlant:hover {
            background-color: #218838; 
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15); 
            transform: scale(1.05);
        }

        /* Focus Effect */
        #addPlant:focus {
            outline: none; 
            box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.5);
        }


    </style>
</head>
<body>
<?php include 'header.php'; ?>

<section class="intro-menu">
    <div class="intro-content">
        <h1>Contribution Page</h1>
        <p>This portal allows users to explore plant classifications, learn how to preserve plant specimens, and contribute to biodiversity data. Use the options below to navigate through the platform and engage in the world of plants.</p>
    </div>
    <div class="intro-image">
        <img src="images/images2.jpeg" alt="Plants Image">
    </div>
</section>
<main class="page-content">
    <?php
    // Query the database to fetch only approved plants
    $sql = "SELECT id, Scientific_Name, Common_Name, plants_image FROM plant_table WHERE status = 'approved'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $images = json_decode($row["plants_image"], true);
            $backgroundImage = !empty($images) ? $images[0] : 'default.jpg'; 

            echo '
            <div class="card" style="background-image: url(' . $backgroundImage . ');">
                <div class="card-content">
                    <h2 class="title">' . $row["Scientific_Name"] . '</h2>
                    <p class="copy">Common Name: ' . $row["Common_Name"] . '</p>
                    <a href="plant_detail.php?id=' . $row["id"] . '" class="btn">View Details</a>
                </div>
            </div>';
        }
    } else {
        echo "<p>No approved plant data found.</p>";
    }

    $conn->close();
    ?>
</main>


<!-- Floating Button to Open Modal -->
<button class="floating-btn" id="addPlantBtn"><i class="fa fa-plus"></i></button>
<!-- Modal for Adding Plant Details -->
<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Add New Plant</h2>
        <form action="contribute.php" method="POST" enctype="multipart/form-data">
            <label for="scientific_name">Scientific Name:</label>
            <input type="text" id="scientific_name" name="scientific_name" required><br>

            <label for="common_name">Common Name:</label>
            <input type="text" id="common_name" name="common_name" required><br>

            <label for="family">Family:</label>
            <input type="text" id="family" name="family" required><br>

            <label for="genus">Genus:</label>
            <input type="text" id="genus" name="genus" required><br>

            <label for="species">Species:</label>
            <input type="text" id="species" name="species" required><br>

            <label for="plants_image">Upload Images:</label>
            <div id="imageUploadContainer">
                <input type="file" name="plants_image[]" id="plants_image" accept="image/*"><br>
            </div>
            <button type="button" id="addMoreImagesBtn">Add More Images</button><br>

            <label for="description">Description (PDF file):</label>
            <input type="file" name="description" id="description" accept="application/pdf"><br>

            <button id="addPlant">Add Plant</button>
        </form>

    </div>
</div>

<script>
    var imageContainer = document.getElementById('imageUploadContainer');
    var addMoreImagesBtn = document.getElementById('addMoreImagesBtn');

    // Event listener to dynamically add more image input fields
    addMoreImagesBtn.addEventListener('click', function () {
        var newImageInput = document.createElement('input');
        newImageInput.type = 'file';
        newImageInput.name = 'plants_image[]';
        newImageInput.accept = 'image/*';
        newImageInput.style.marginTop = '5px'; 
        imageContainer.appendChild(newImageInput);
    });

    var modal = document.getElementById("myModal");
    var btn = document.getElementById("addPlantBtn");

    var span = document.getElementsByClassName("close")[0];


    btn.onclick = function() {
        modal.style.display = "block";
        document.body.classList.add("modal-open");
    };

    span.onclick = function() {
        modal.style.display = "none";
        document.body.classList.remove("modal-open"); 
    };

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
            document.body.classList.remove("modal-open");
        }
    };
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>
</html>
