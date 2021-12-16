<?php

include_once 'database.php';
session_start();
if (!isset($_SESSION['loggedin']))
    header("LOCATION: login.php");

function uploadPhoto($file, $id)
{
    $target_dir = "products/";
    $target_file = $target_dir . basename($file["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $allowedExt = ['png', 'gif'];

    $newfilename = "{$id}.{$imageFileType}";


    if ($file['error'] == 4)
        return 4;

    // Check if image file is a actual image or fake image
    if (!getimagesize($file['tmp_name']))
        return 0;

    // Check file size
    if ($file["size"] > 10000000)
        return 1;

    // Allow certain file formats
    if (!in_array($imageFileType, $allowedExt))
        return 2;

    if (!move_uploaded_file($file["tmp_name"], $target_dir . $newfilename))
        return 3;

    return array('status' => 200, 'name' => $newfilename, 'ext' => $imageFileType);
}

//Create
if (isset($_POST['create'])) {
    if (isset($_SESSION['user']) && $_SESSION['user']['fld_staff_role'] == 'Admin') {
        $uploadStatus = uploadPhoto($_FILES['fileToUpload'], $_POST['pid']);

        if (isset($uploadStatus['status'])) {
            try {
                $stmt = $db->prepare("INSERT INTO tbl_products_a178796_pt2(fld_product_id, fld_product_name, fld_product_price, fld_product_brand, fld_product_type,
        fld_product_warranty, fld_product_quantity, fld_product_image) VALUES (:pid, :name, :price, :brand, :type, :warranty, :quantity, :image)");

                $stmt->bindParam(':pid', $pid, PDO::PARAM_STR);
                $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                $stmt->bindParam(':price', $price, PDO::PARAM_INT);
                $stmt->bindParam(':brand', $brand, PDO::PARAM_STR);
                $stmt->bindParam(':type', $type, PDO::PARAM_STR);
                $stmt->bindParam(':warranty', $warranty, PDO::PARAM_STR);
                $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
                $stmt->bindParam(':image', $uploadStatus['name']);

                $pid = $_POST['pid'];
                $name = $_POST['name'];
                $price = $_POST['price'];
                $brand =  $_POST['brand'];
                $type = $_POST['type'];
                $warranty = $_POST['warranty'];
                $quantity = $_POST['quantity'];

                $stmt->execute();


            } catch (PDOException $e) {
                $_SESSION['error'] = "Error while creating: " . $e->getMessage();
            }
        } else {
            if ($uploadStatus == 0)
                $_SESSION['error'] = "Please make sure the file uploaded is an image.";
            elseif ($uploadStatus == 1)
                $_SESSION['error'] = "Sorry, only file with below 10MB are allowed.";
            elseif ($uploadStatus == 2)
                $_SESSION['error'] = "Sorry, only PNG & GIF files are allowed.";
            elseif ($uploadStatus == 3)
                $_SESSION['error'] = "Sorry, there was an error uploading your file.";
            elseif ($uploadStatus == 4)
                $_SESSION['error'] = 'Please upload an image.';
            else
                $_SESSION['error'] = "An unknown error has been occurred.";
        }
    } else {
        $_SESSION['error'] = "Sorry, but you don't have permission to create a new product.";
    }

    header("LOCATION: products.php");
    exit();
}

//Update
if (isset($_POST['update'])) {
    if (isset($_SESSION['user']) && $_SESSION['user']['fld_staff_role'] == 'Admin') {
        try {
            $stmt = $db->prepare("UPDATE tbl_products_a178796_pt2 SET fld_product_id = :pid,
        fld_product_name = :name, fld_product_price = :price, fld_product_brand = :brand,
        fld_product_type = :type, fld_product_quantity = :quantity, fld_product_warranty = :warranty 
          WHERE fld_product_id = :pid LIMIT 1");

            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':price', $price, PDO::PARAM_INT);
            $stmt->bindParam(':brand', $brand, PDO::PARAM_STR);
            $stmt->bindParam(':type', $type, PDO::PARAM_STR);
            $stmt->bindParam(':warranty', $warranty, PDO::PARAM_STR);
            $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
            $stmt->bindParam(':pid', $pid, PDO::PARAM_STR);

            $name = $_POST['name'];
            $price = $_POST['price'];
            $brand =  $_POST['brand'];
            $type = $_POST['type'];
            $warranty = $_POST['warranty'];
            $quantity = $_POST['quantity'];
            $pid = $_POST['pid'];

            $stmt->execute();

            // Image Upload
            $flag = uploadPhoto($_FILES['fileToUpload'], $pid);
            if (isset($flag['status'])) {
                $stmt = $db->prepare("UPDATE tbl_products_a178796_pt2 SET fld_product_image = :image WHERE fld_product_id = :pid LIMIT 1");

                $stmt->bindParam(':image', $flag['name']);
                $stmt->bindParam(':pid', $pid);
                $stmt->execute();

            } elseif ($flag != 4) {
                if ($flag == 0)
                    $_SESSION['error'] = "Please make sure the file uploaded is an image.";
                elseif ($flag == 1)
                    $_SESSION['error'] = "Sorry, only file with below 10MB are allowed.";
                elseif ($flag == 2)
                    $_SESSION['error'] = "Sorry, only PNG & GIF files are allowed.";
                elseif ($flag == 3)
                    $_SESSION['error'] = "Sorry, there was an error uploading your file.";
                else
                    $_SESSION['error'] = "An unknown error has been occurred.";
            }
        } catch (PDOException $e) {
            $_SESSION['error'] = "Error while updating: " . $e->getMessage();
        } catch (Exception $e) {
            $_SESSION['error'] = "Error while updating: " . $e->getMessage();
        }
    } else {
        $_SESSION['error'] = "Sorry, but you don't have permission to update this product.";
        header("LOCATION: products.php");
        exit();
    }

    if (isset($_SESSION['error']))
        header("LOCATION: products.php");
    else
        header("Location: products.php");

    exit();
}



//Delete
if (isset($_GET['delete'])) {
    if (isset($_SESSION['user']) && $_SESSION['user']['fld_staff_role'] == 'Admin') {
        try {
            $pid = $_GET['delete'];

            // Select Product Image Name
            $query = $db->query("SELECT fld_product_image FROM tbl_products_a178796_pt2 WHERE fld_product_id = {$pid} LIMIT 1")->fetch(PDO::FETCH_ASSOC);

            // Check if selected product id exists .
            if (isset($query['fld_product_image'])) {
                // Delete Query
                $stmt = $db->prepare("DELETE FROM tbl_products_a178796_pt2 WHERE fld_product_id = :pid");
                $stmt->bindParam(':pid', $pid);

                $stmt->execute();

                // Delete Image
                unlink("products/{$query['fld_product_image']}");
            }

        } catch (PDOException $e) {
            $_SESSION['error'] = "Error while deleting: " . $e->getMessage();
        }
    } else {
        $_SESSION['error'] = "Sorry, but you don't have permission to delete this product.";
    }

    header("LOCATION: products.php");
    exit();
}

//Edit
if (isset($_GET['edit'])) {
 
  try {
 
      $stmt = $db->prepare("SELECT * FROM tbl_products_a178796_pt2 WHERE fld_product_id = :pid");
     
      $stmt->bindParam(':pid', $pid, PDO::PARAM_STR);
       
    $pid = $_GET['edit'];
     
    $stmt->execute();
 
    $editrow = $stmt->fetch(PDO::FETCH_ASSOC);
    }
 
  catch(PDOException $e)
  {
      echo "Error: " . $e->getMessage();
  }
    
}

