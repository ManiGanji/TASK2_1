<?php
    // Database connection
    $conn = new mysqli("localhost", "root", "admin123", "snag_tracker");
    if ($conn){
        echo "connected";
    
    }else{
        die("connection failed".$conn->connect_error);
    }

    // Check if form was submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $descriptionData = $_POST['descriptionData'];
        $priority = $_POST['priority'];
        $assignedTo = $_POST['assignedTo'];

        // Handle image upload
        if (isset($_FILES['imagePreview']) && $_FILES['imagePreview']['error'] == 0) {
            $imageName = $_FILES['imagePreview']['name'];
            $imageTmpName = $_FILES['imagePreview']['tmp_name'];
            $imageSize = $_FILES['imagePreview']['size'];
            $imageError = $_FILES['imagePreview']['error'];
            $imageType = $_FILES['imagePreview']['type'];

            // Allow only certain file types (e.g., jpg, jpeg, png)
            $allowed = array('jpg', 'jpeg', 'png');
            $imageExt = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));

            if (in_array($imageExt, $allowed)) {
                // Create unique file name to avoid conflicts
                $newImageName =  "uplaod." . $imageExt;
                $imageDestination = 'uploads/' . $newImageName;

                // Move the uploaded file to the destination
                if (move_uploaded_file($imageTmpName, $imageDestination)) {
                    // Insert data into the database
                    $result = $conn->query("INSERT INTO snags (image_path, description, priority, assigned_to) VALUES 
                    ('".$newImageName."', '".$descriptionData."', '".$priority."', '".$assignedTo."')");
                    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
                    if(!$result) {
                        echo 'Error in Execution: '.$conn->error." | File: ".$file." | Line: ".$line;
                        exit;
                    }
                } else {
                    echo "Failed to upload the image.";
                }
            } else {
                echo "File type not allowed. Only JPG, JPEG, and PNG files are accepted.";
            }
        } else {
            echo "Please upload a valid image.";
        }

        $conn->close();
    }

    echo '<script type="text/javascript">
        window.location.href = "index.php";
    </script>';
?>