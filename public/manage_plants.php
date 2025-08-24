<?php
session_start();
include 'db_connection.php'; // Include your database connection file

// Check if the user is logged in and if they are an admin
if (
    !isset($_SESSION['loggedin']) || 
    $_SESSION['loggedin'] !== true || 
    $_SESSION['type'] !== 'admin' || 
    !isset($_SESSION['email'])
) {
    // Redirect to login page if any condition is not met
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle Approve/Reject/Delete actions
    if (isset($_POST['plant_id'])) {
        $plantId = $_POST['plant_id'];

        if (isset($_POST['approve'])) {
            $query = "UPDATE plant_table SET status = 'approved' WHERE id = ?";
        } elseif (isset($_POST['reject'])) {
            $query = "UPDATE plant_table SET status = 'rejected' WHERE id = ?";
        } elseif (isset($_POST['delete'])) {
            $query = "DELETE FROM plant_table WHERE id = ?";
        }

        if (isset($query)) {
            $stmt = $conn->prepare($query);
            $stmt->bind_param('i', $plantId);
            $stmt->execute();
        }
    }

    // Handle Add Plant Form submission
    if (isset($_POST['scientific_name']) && isset($_POST['common_name'])) {
        $scientificName = $_POST['scientific_name'];
        $commonName = $_POST['common_name'];
        $family = $_POST['family'];
        $genus = $_POST['genus'];
        $species = $_POST['species'];

        // Handle file uploads
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

        // Insert into the database
        $query = "INSERT INTO plant_table (Scientific_Name, Common_Name, family, genus, species, plants_image, description, status) VALUES (?, ?, ?, ?, ?, ?, ?, 'pending')";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('sssssss', $scientificName, $commonName,$family, $genus, $species, $plants_image, $description_path);
        if ($stmt->execute()) {
            // Redirect to the same page to prevent resubmission
            header("Location: " . $_SERVER['PHP_SELF']);
            exit(); // Always call exit after a header redirect
        } else {
            // Handle error (if any)
        }
    }
}


$query = "SELECT * FROM plant_table";
$result = $conn->query($query);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Plants</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css'>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    
</head>
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
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); /* Soft shadow */
            width: 50%;
            max-width: 600px; /* Prevents the modal from becoming too wide */
            animation: slideIn 0.4s ease-out; /* Slide-in animation */
        }

        /* Animation for sliding the modal from the top */
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
            border-radius: 5px; /* Rounded input fields */
            border: 1px solid #ddd;
            width: 100%;
        }

        .modal-content input[type="file"] {
            padding: 8px; /* Smaller padding for file inputs */
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
            background-color: #28a745; /* Green color */
            color: white; /* Text color */
            padding: 12px 20px; /* Add padding for better spacing */
            font-size: 16px; /* Slightly larger font */
            font-weight: bold; /* Bold text */
            border: none; /* Remove border */
            border-radius: 8px; /* Rounded corners */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Add subtle shadow */
            cursor: pointer; /* Pointer cursor */
            transition: all 0.3s ease; /* Smooth hover transition */
        }

        /* Hover Effect */
        #addPlant:hover {
            background-color: #218838; /* Darker green on hover */
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15); /* Increase shadow */
            transform: scale(1.05); /* Slightly enlarge the button */
        }

        /* Focus Effect */
        #addPlant:focus {
            outline: none; /* Remove default focus outline */
            box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.5); /* Green focus ring */
        }
        .btn-margin-top {
            margin-top: 10px;
        }


    </style>
<body>
<?php include 'admin-header.php'; ?>
<div class="container mt-5">
    <h1 class="text-center mb-4">Manage Plants</h1>
    <div class="table-responsive">
        <!-- Add bg-white for white background -->
        <table class="table table-striped table-bordered bg-white">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Scientific Name</th>
                    <th>Common Name</th>
                    <th>Family</th>
                    <th>Genus</th>
                    <th>Species</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td class='editable' data-column="id"><?= htmlspecialchars($row['id']) ?></td>
                        <td class='editable' data-column='Scientific_Name'><?= htmlspecialchars($row['Scientific_Name']) ?></td>
                        <td class='editable' data-column="Common_Name"><?= htmlspecialchars($row['Common_Name']) ?></td>
                        <td class='editable' data-column="family"><?= htmlspecialchars($row['family']) ?></td>
                        <td class='editable' data-column="genus"><?= htmlspecialchars($row['genus']) ?></td>
                        <td class='editable' data-column="species"><?= htmlspecialchars($row['species']) ?></td>
                        <td>
                            <span class="badge 
                                <?php 
                                    echo $row['status'] === 'approved' ? 'badge-success' : 
                                    ($row['status'] === 'rejected' ? 'badge-danger' : 'badge-warning');
                                ?>">
                                <?= htmlspecialchars($row['status']) ?>
                            </span>
                        </td>
                        <td>
                            <form method="POST" style="display:inline-block;">
                                <input type="hidden" name="plant_id" value="<?= $row['id'] ?>">
                                <?php if ($row['status'] === 'pending' || $row['status'] === 'rejected') : ?>
                                    <button style = 'margin-bottom:10px; width:80px;' type="submit" name="approve" class="btn btn-sm btn-success">Approve</button>
                                <?php else : ?>
                                    <button style = 'margin-bottom:10px; width:80px;' type="submit" name="approve" class="btn btn-sm btn-success" disabled>Approve</button>
                                <?php endif; ?>

                                <?php if ($row['status'] === 'pending' || $row['status'] === 'approved') : ?>
                                    <button style = 'margin-bottom:10px; width:80px;' type="submit" name="reject" class="btn btn-sm btn-danger">Reject</button>
                                <?php else : ?>
                                    <button style = 'margin-bottom:10px; width:80px;'type="submit" name="reject" class="btn btn-sm btn-danger" disabled>Reject</button>
                                <?php endif; ?>

                                <button style = 'margin-bottom:10px; width:80px;' type="submit" name="delete" class="btn btn-sm btn-warning">Delete</button>
                                
                                <button style = 'margin-bottom:10px; width:80px;' class="saveBtn btn btn-sm btn-primary" data-id="<?= $row['id'] ?>">Save</button>
                            </form>
                            
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    
</div>

<button class="floating-btn" id="addPlantBtn"><i class="fa fa-plus"></i></button>
<!-- Modal for Adding Plant Details -->
<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Add New Plant</h2>
        <form action="manage_plants.php" method="POST" enctype="multipart/form-data">
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

            <label for="plants_image" style="color: black;">Upload Images:</label>
                <div id="imageUploadContainer">
                    <input type="file" name="plants_image[]" id="plants_image" accept="image/*" style="color: black;"><br>
                </div>
            <button type="button" id="addMoreImagesBtn">Add More Images</button><br>

            <label for="description">Description (PDF file):</label>
            <input type="file" name="description" id="description" accept="application/pdf" style="color: black;"><br>

            <button id="addPlant">Add Plant</button>
        </form>

    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- JavaScript for Modal -->
<script>
    var imageContainer = document.getElementById('imageUploadContainer');

    // Get the button to add more image inputs
    var addMoreImagesBtn = document.getElementById('addMoreImagesBtn');

    // Event listener to dynamically add more image input fields
    addMoreImagesBtn.addEventListener('click', function () {
        var newImageInput = document.createElement('input');
        newImageInput.type = 'file';
        newImageInput.name = 'plants_image[]';
        newImageInput.accept = 'image/*';
        newImageInput.style.marginTop = '5px'; // Optional styling
        newImageInput.style.color = 'black';
        imageContainer.appendChild(newImageInput);
    });
    var modal = document.getElementById("myModal");

    // Get the button that opens the modal
    var btn = document.getElementById("addPlantBtn");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal and disable page scroll
    btn.onclick = function() {
        modal.style.display = "block";
        document.body.classList.add("modal-open"); // Add class to disable scrolling
    };

    // When the user clicks on <span> (x), close the modal and enable page scroll
    span.onclick = function() {
        modal.style.display = "none";
        document.body.classList.remove("modal-open"); // Remove class to enable scrolling
    };

    // When the user clicks anywhere outside of the modal, close it and enable page scroll
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
            document.body.classList.remove("modal-open");
        }
    };
    jQuery.noConflict();
    jQuery(document).ready(function($) {
    // Enable inline editing on table cells
    $('.editable').on('click', function() {
        var $cell = $(this);
        if ($cell.attr('contenteditable') === 'true') return; // If already editable, do nothing

        // Make the clicked cell editable
        $cell.attr('contenteditable', 'true');
        $cell.focus();
    });

    // Handle the save functionality
    $('.saveBtn').on('click', function() {
        var row = $(this).closest('tr');
        var id = row.find('.editable[data-column="id"]').text();  // Get the email to identify the user
        var updatedData = {};

        // Get the edited data from each cell
        row.find('.editable').each(function() {
            var column = $(this).data('column');
            var value = $(this).text().trim();  // Trim any whitespace
            updatedData[column] = value;
            $(this).attr('contenteditable', 'false');  // Disable further editing on this cell
        });

        // Send the updated data to the server
        $.ajax({
            url: 'update_plants.php', // Create this PHP script to handle the update
            type: 'POST',
            data: {
                id: id,
                updatedData: JSON.stringify(updatedData)
            },
            success: function(response) {
                alert(response); // Show server response
                location.reload(); // Reload the page to reflect changes
            },
            error: function() {
                alert('Error updating data.');
            }
        });
    });
});
</script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
<!-- Bootstrap JS and dependencies -->

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html> 