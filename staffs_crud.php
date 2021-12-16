<?php
 
include_once 'database.php';
 session_start();
if (!isset($_SESSION['loggedin']))
  header("LOCATION: login.php");
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 
//Create
if (isset($_POST['create'])) {
  if (isset($_SESSION['user']) && $_SESSION['user']['fld_staff_role'] == 'Admin') {
 
  try {
 
    $stmt = $conn->prepare("INSERT INTO tbl_staffs_a178796_pt2(fld_staff_id, fld_staff_name, fld_staff_phone, fld_staff_role, fld_staff_email, fld_staff_password) VALUES(:sid, :name, :phone, :role, :email, :pass)");
   
    $stmt->bindParam(':sid', $sid, PDO::PARAM_STR);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
    $stmt->bindParam(':role', $role, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
       
    $sid = $_POST['sid'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $role = $_POST['role'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];
         
    $stmt->execute();
    }
 
  catch(PDOException $e)
  {
      echo "Error: " . $e->getMessage();
  }
} else {
    $_SESSION['error'] = "Sorry, but you don't have permission to create a new staff.";
  }

}
 
//Update
if (isset($_POST['update'])) {
  if (isset($_SESSION['user']) && $_SESSION['user']['fld_staff_role'] == 'Admin') {
   
  try {
 
    $stmt = $conn->prepare("UPDATE tbl_staffs_a178796_pt2 SET
      fld_staff_id = :sid, fld_staff_name = :name,
      fld_staff_phone = :phone, fld_staff_role = :role, fld_staff_email = :email, fld_staff_password = :pass
      WHERE fld_staff_id = :oldsid");
   
    $stmt->bindParam(':sid', $sid, PDO::PARAM_STR);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
    $stmt->bindParam(':role', $role, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
    $stmt->bindParam(':oldsid', $oldsid, PDO::PARAM_STR);
       
    $sid = $_POST['sid'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $role = $_POST['role'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $oldsid = $_POST['oldsid'];
         
    $stmt->execute();
 
    header("Location: staffs.php");
    }
 
  catch(PDOException $e)
  {
      echo "Error: " . $e->getMessage();
  }
}
else {
    $_SESSION['error'] = "Sorry, but you don't have permission to create a new staff.";
  }

}
 
//Delete
if (isset($_GET['delete'])) {
  if (isset($_SESSION['user']) && $_SESSION['user']['fld_staff_role'] == 'Admin') {
 
  try {
 
    $stmt = $conn->prepare("DELETE FROM tbl_staffs_a178796_pt2 where fld_staff_id = :sid");
   
    $stmt->bindParam(':sid', $sid, PDO::PARAM_STR);
       
    $sid = $_GET['delete'];
     
    $stmt->execute();
 
    header("Location: staffs.php");
    }
 
  catch(PDOException $e)
  {
      echo "Error: " . $e->getMessage();
  }
}
else {
    $_SESSION['error'] =  "Sorry, but you don't have permission to delete a new staff.";
  }

}
 
//Edit
if (isset($_GET['edit'])) {
  if (isset($_SESSION['user']) && $_SESSION['user']['fld_staff_role'] == 'Admin') {
   
  try {
 
    $stmt = $conn->prepare("SELECT * FROM tbl_staffs_a178796_pt2 where fld_staff_id = :sid");
   
    $stmt->bindParam(':sid', $sid, PDO::PARAM_STR);
       
    $sid = $_GET['edit'];
     
    $stmt->execute();
 
    $editrow = $stmt->fetch(PDO::FETCH_ASSOC);
    }
 
  catch(PDOException $e)
  {
      echo "Error: " . $e->getMessage();
  }
}
else {
    $_SESSION['error'] = "Sorry, but you don't have permission to edit a new staff.";
  }

}
 
  $conn = null;
 
?>