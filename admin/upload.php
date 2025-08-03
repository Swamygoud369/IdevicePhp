<?php
// Define the target directory for uploads
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["image"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Debugging: Check if the target directory exists
if (!file_exists($target_dir)) {
    echo "Error: Uploads directory does not exist.";
    $uploadOk = 0;
} else {
    echo "Uploads directory exists.<br>";
}

// Check if image file is an actual image or fake image
$check = getimagesize($_FILES["image"]["tmp_name"]);
if ($check === false) {
    echo "File is not an image.";
    $uploadOk = 0;
}

// Check file size (5MB limit)
if ($_FILES["image"]["size"] > 5000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

// Allow certain file formats
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// If everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        echo "The file " . htmlspecialchars(basename($_FILES["image"]["name"])) . " has been uploaded.";

        // Establish a database connection
       
$servername = "localhost"; // Replace with your database host
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "swamy"; 


$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
        // Escape user inputs for security
        $about_text = $conn->real_escape_string($_POST['about_text']);
        $image_url = $conn->real_escape_string($target_file);

        // Attempt to insert the data into the database
        $sql = "INSERT INTO about_us (about_text, image_url) VALUES ('$about_text', '$image_url')";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Close the connection
        $conn->close();
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}


// // Define the target directory for uploads
// $target_dir = "uploads/";
// $target_file = $target_dir . basename($_FILES["image"]["name"]);
// $uploadOk = 1;
// $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// // Debugging: Check if the target directory exists
// if (!file_exists($target_dir)) {
//     echo "Error: Uploads directory does not exist.";
//     $uploadOk = 0;
// } else {
//     echo "Uploads directory exists.<br>";
// }

// // Check if image file is an actual image or fake image
// $check = getimagesize($_FILES["image"]["tmp_name"]);
// if ($check === false) {
//     echo "File is not an image.";
//     $uploadOk = 0;
// }

// // Check file size (5MB limit)
// if ($_FILES["image"]["size"] > 5000000) {
//     echo "Sorry, your file is too large.";
//     $uploadOk = 0;
// }

// // Allow certain file formats
// if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
//     echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
//     $uploadOk = 0;
// }

// // Check if $uploadOk is set to 0 by an error
// if ($uploadOk == 0) {
//     echo "Sorry, your file was not uploaded.";
// // If everything is ok, try to upload file
// } else {
//     if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
//         echo "The file " . htmlspecialchars(basename($_FILES["image"]["name"])) . " has been uploaded.";
        
       
//         // Escape user inputs for security
//         $about_text = $conn->real_escape_string($_POST['about_text']);
//         $image_url = $conn->real_escape_string($target_file);

//         // Attempt to insert the data into the database
//         $sql = "INSERT INTO about_us (about_text, image_url) VALUES ('$about_text', '$image_url')";

//         if ($conn->query($sql) === TRUE) {
//             echo "New record created successfully";
//         } else {
//             echo "Error: " . $sql . "<br>" . $conn->error;
//         }

//         // Close the connection
//         $conn->close();
//     } else {
//         echo "Sorry, there was an error uploading your file.";
//     }
// }
?>
