<?php
 $imagePreview = $_POST['imagePreview'];
 $descriptionData= $_POST['descriptionData'];
 $priority = $_POST['priority'];
 $assignedTo = $_POST['assignedTo'];
 $conn=new mysqli("localhost","root","root","snag ");
 if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}else{
    $stmt = $conn-> prepare("INSERT INTO issues (imagePreview, descriptionData, priority, assignedTo) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $imagePreview, $descriptionData, $priority, $assignedTo);
    $stmt->execute();
    echo "success";
    $stmt->close();
    $conn->close();
}


?>