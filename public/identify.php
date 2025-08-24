<?php
require 'fpdf/fpdf.php'; // Include the FPDF library
include 'session_check.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $file = $_FILES['file'];
    $uploadDir = 'upload/';
    $uploadedFilePath = $uploadDir . basename($file['name']);

    // Ensure the "upload" directory exists
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    // Move the uploaded file to the "upload" directory
    if (move_uploaded_file($file['tmp_name'], $uploadedFilePath)) {
        // Call Python script to compare images
        $command = escapeshellcmd("python compare_images.py " . escapeshellarg($uploadedFilePath));
        $output = shell_exec($command);

        // Parse Python output (JSON)
        $result = json_decode($output, true);
        $plantImages = json_decode($result['plants_image'], true);
        $imagePath = is_array($plantImages) && count($plantImages) > 0 ? $plantImages[0] : null;

        if ($result) {
            if ($result['success'] && $result['match']) {
                // Create a PDF with FPDF
                $pdf = new FPDF();
                $pdf->AddPage();
                $pdf->SetFont('Arial', 'B', 16);

                // Title
                $pdf->Cell(0, 10, 'Plant Identification Result', 0, 1, 'C');
                $pdf->Ln(10); // Line break

                // Add plant details
                $pdf->SetFont('Arial', '', 12);
                $pdf->Cell(0, 10, 'Scientific Name: ' . $result['Scientific_Name'], 0, 1);
                $pdf->Cell(0, 10, 'Common Name: ' . $result['Common_Name'], 0, 1);
                $pdf->Cell(0, 10, 'Family: ' . $result['family'], 0, 1);
                $pdf->Cell(0, 10, 'Genus: ' . $result['genus'], 0, 1);
                $pdf->Cell(0, 10, 'Species: ' . $result['species'], 0, 1);
                $pdf->Ln(10);

                // Add description
                $pdf->MultiCell(0, 10, 'Description: ' . $result['description']);
                $pdf->Ln(10);

                // Add image if available
                if ($imagePath && file_exists($imagePath)) {
                    $pdf->Image($imagePath, 10, $pdf->GetY(), 100); // Adjust the image size and position
                }

                // Save PDF file
                $pdfFilePath = $uploadDir . 'Plant_Details_' . time() . '.pdf';
                $pdf->Output('F', $pdfFilePath);

                // Return JSON response including the PDF download URL
                echo json_encode([
                    'status' => 'success',
                    'data' => [
                        'Scientific_Name' => $result['Scientific_Name'],
                        'Common_Name' => $result['Common_Name'],
                        'Family' => $result['family'],
                        'Genus' => $result['genus'],
                        'Species' => $result['species'],
                        'Description' => $result['description'],
                        'Image' => $imagePath,
                        'Pdf' => $pdfFilePath, // Include PDF file path
                    ]
                ]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Plant not identified.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to parse Python output.', 'raw_output' => $output]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to upload image.']);
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Plant Identification</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        /* Styles for the drag-and-drop area */
        .drag-area {
            border: 2px dashed #ddd;
            height: 300px;
            width: 70%;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            position: relative;
            border-radius: 10px;
            margin-left:15%;
            background-color: whitesmoke;
        }

        .drag-area img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            display: block;
            margin-top: 10px;
        }

        .drag-area .icon {
            font-size: 50px;
            color: #6c757d;
        }

        .drag-area header {
            font-size: 20px;
            color: #6c757d;
        }

        /* Style the browse button */
        #browse-btn {
            padding: 12px 20px;
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
            border: 2px solid #4CAF50;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            display: inline-block;
            transition: all 0.3s ease;
        }

        #browse-btn:hover {
            background-color: white;
            color: #4CAF50;
            border-color: #4CAF50;
        }

        #browse-btn:focus {
            outline: none;
            box-shadow: 0 0 5px rgba(76, 175, 80, 0.6);
        }

        #confirm-form {
            margin-top: 20px;
            text-align: center;
            display: none;
        }

        #confirm-btn {
            padding: 10px 20px;
            background-color: #4caf50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #result {
            margin-top: 20px;
        }

        #result img {
            max-width: 100%;
            height: auto;
        }

        .drag-area.image-attached {
            background-color: #f8f9fa;
            border-color: #4caf50;
            padding: 20px;
        }

        .drag-area.image-attached .icon {
            display: none;
        }

        .drag-area.image-attached header {
            font-size: 18px;
            color: #4caf50;
        }

        .drag-area.image-attached img {
            max-width: 100%;
            height: auto;
        }

            
        .result-container {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 600px;
            text-align: center;
            margin-top: 20px;
            box-sizing: border-box;
            margin-left: 32.5%;
        }

        /* Style for the plant information headers */
        .result-container h3 {
            font-size: 24px;
            color: #4CAF50;
            margin-bottom: 20px;
        }

        /* Style for the plant information paragraphs */
        .result-container p {
            font-size: 16px;
            color: #333;
            margin-bottom: 10px;
            text-align: left;  /* Align text to the left for better readability */
        }

        /* Style for the plant image */
        .result-container img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin-top: 20px;
        }

    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="drag-area" id="drag-area">
        <div class="icon"><i class="fas fa-cloud-upload-alt"></i></div>
        <header>Drag & Drop to Upload File</header>
        <span>OR</span>
        <button id="browse-btn">Browse File</button>
        <input type="file" name="file" id="file" hidden>
    </div>
    
    <form id="confirm-form">
        <button type="button" id="confirm-btn">Confirm & Identify</button>
    </form>
    <div id="result"></div>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        const dropArea = document.getElementById("drag-area");
        const browseBtn = document.getElementById("browse-btn");
        const fileInput = document.getElementById("file");
        const confirmForm = document.getElementById("confirm-form");
        const confirmBtn = document.getElementById("confirm-btn");
        const resultDiv = document.getElementById("result");
        let file; // Variable to hold the uploaded file

        // Prevent default drag behaviors
        ["dragenter", "dragover", "dragleave", "drop"].forEach(eventName => {
            dropArea.addEventListener(eventName, (event) => {
                event.preventDefault();
                event.stopPropagation();
            });
        });

        // Highlight drop area when file is dragged over it
        ["dragenter", "dragover"].forEach(eventName => {
            dropArea.addEventListener(eventName, () => {
                dropArea.classList.add("active");
            });
        });

        // Remove highlight when drag leaves the area
        ["dragleave", "drop"].forEach(eventName => {
            dropArea.addEventListener(eventName, () => {
                dropArea.classList.remove("active");
            });
        });

        // Handle dropped files
        dropArea.addEventListener("drop", (event) => {
            file = event.dataTransfer.files[0];
            if (file) {
                displayImagePreview(file);
                confirmForm.style.display = "block";
            }
        });

        // Open file dialog when the "Browse" button is clicked
        browseBtn.onclick = () => fileInput.click();

        // Handle file input change
        fileInput.addEventListener("change", (event) => {
            file = event.target.files[0];
            if (file) {
                displayImagePreview(file);
                confirmForm.style.display = "block";
            }
        });

        // Function to display image preview in the drop area
        function displayImagePreview(file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                dropArea.innerHTML = `<img src="${event.target.result}" alt="Image Preview" style="max-width:100%; height:auto;">`;
                dropArea.classList.add("image-attached");
            };
            reader.readAsDataURL(file);
        }

        confirmBtn.addEventListener("click", () => {
    if (!file) {
        Swal.fire({
            icon: "warning",
            title: "No File Selected",
            text: "Please upload a file first.",
        });
        return;
    }

    // Show SweetAlert loading animation
    Swal.fire({
        title: "Identifying Plant...",
        html: "Please wait while we process your image.",
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        },
    });

    resultDiv.innerHTML = "";

    // Prepare the file for upload
    const formData = new FormData();
    formData.append("file", file);

    // Send file to PHP via AJAX
    fetch("identify.php", {
        method: "POST",
        body: formData,
    })
        .then((response) => response.json())
        .then((data) => {
            Swal.close();
            if (data.status === "success") {
                // Display plant information
                resultDiv.innerHTML = `
                    <div class="result-container">
                        <h3>Plant Identified</h3>
                        <p><strong>Scientific Name:</strong> ${data.data.Scientific_Name}</p>
                        <p><strong>Common Name:</strong> ${data.data.Common_Name}</p>
                        <p><strong>Family:</strong> ${data.data.Family}</p>
                        <p><strong>Genus:</strong> ${data.data.Genus}</p>
                        <p><strong>Species:</strong> ${data.data.Species}</p>
                        <p><strong>Description:</strong> ${data.data.Description}</p>
                        <img src="${data.data.Image}" alt="Plant Image">
                        <a href="${data.data.Pdf}" download="Plant_Details.pdf" class="download-btn">Download PDF</a>
                    </div>
                `;
            } else {
                resultDiv.innerHTML = `<p>${data.message}</p>`;
            }
        })
        .catch((error) => {
            Swal.close();
            resultDiv.innerHTML = `<p>Something went wrong. Please try again.</p>`;
            console.error("Error:", error);
        });
});

    </script>
</body>
</html>
