<?php
session_start();
if (!isset($_SESSION['loggedin']))
  header("LOCATION: login.php");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>Refrigerator Store Ordering System : Customers</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">

      <style type="text/css">
      html {
        width:100%;
        height:100%;
        background:url(logos.png) center center no-repeat;
        min-height:100%;
        background-color:#9FD7FC;">
      }
    </style>
</head>
<body>

<?php include_once 'nav_bar.php'; ?>


  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
</body>
</html>