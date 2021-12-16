<?php
 
session_start();
 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
  $target_dir = "products/";
  $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
 
  // Check if image file is a actual image or fake image
  if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
      $uploadOk = 1;
    } else {
      echo "File is not an image.";
      $uploadOk = 0;
    }
  }
 
  // Check if file already exists
  if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
  }
 
  // Check file size
  if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
  }
 
  // Allow certain file formats
  if($imageFileType != "png" && $imageFileType != "gif" ) {
    echo "Sorry, only PNG & GIF files are allowed.";
    $uploadOk = 0;
  }
 
  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
  // if everything is ok, try to upload file
  } else {
      if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
       
  include "database.php";
 
  try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       
    $stmt = $conn->prepare("UPDATE tbl_products_a178796_pt2 SET fld_product_image = :picture WHERE id = :id");
 
    $stmt->bindParam(':id', $_SESSION['new_id'], PDO::PARAM_STR);
    $stmt->bindParam(':picture', $target_file, PDO::PARAM_STR);

    $stmt->execute();
     
    header("Location:products.php");
    }
      catch(PDOException $e)
      {
          echo "Error: " . $e->getMessage();
      }
    } else {
      echo "Sorry, there was an error uploading your file.";
    }
  }
}
?>