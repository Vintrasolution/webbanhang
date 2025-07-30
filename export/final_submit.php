<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['final_submit'])) {
    // Retrieve temporary file path and original file name
    $tempFilePath = $_POST['temp_image'];
    $fileName = $_POST['image_name'];
    
    // Define the directory where you want to permanently save the image
    $uploadDir = 'images/'; // Ensure this directory has write permissions

    // Create the directory if it doesn't exist
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    
    // Define the full path to save the image
    $permanentFilePath = $uploadDir . $fileName;

    // Move the file from temporary location to the permanent directory
    if (move_uploaded_file($tempFilePath, $permanentFilePath)) {
        echo "Image successfully uploaded! Saved at: " . $permanentFilePath;
    } else {
        echo "Error: Unable to save the file.";
    }
}
?>
