<?php
session_start();
require_once 'database.php';
    if (isset($_SESSION['loggedin']))
        header("LOCATION: index.php");

    if (isset($_POST['userid'], $_POST['password'])) {
    $UserID = htmlspecialchars($_POST['userid']);
    $Pass = $_POST['password'];

    if (empty($UserID) || empty($Pass)) {
        $_SESSION['error'] = 'Please fill in the blanks.';
    } else {
        $stmt = $db->prepare("SELECT * FROM tbl_staffs_a178796_pt2 WHERE (fld_staff_id = :id OR fld_staff_email = :id) LIMIT 1");
        $stmt->bindParam(':id', $UserID);

        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (isset($user['fld_staff_id'])) {
            if ($user['fld_staff_password'] == $Pass) {
                unset($user['fld_staff_password']);
                $_SESSION['loggedin'] = true;
                $_SESSION['user'] = $user;

                header("LOCATION: index.php");
                exit();
            } else {
                $_SESSION['error'] = 'Username or password invalid. Please try again.';
            }
        } else {
            $_SESSION['error'] = 'Account does not exist.';
        }
    }

    header("LOCATION: " . $_SERVER['REQUEST_URI']);
    exit();
}
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Refrigerator Store Login</title>
    <link rel="shortcut icon" type="image/x-icon" href="logoo.png"/>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="login/login.css" rel="stylesheet">


</head>
<body>
    <body style="background-color:powderblue;">
  
    <div class="container">
        <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST">
        <div class="row">
            <div class="col-lg-3 col-md-2"></div>
            <div class="col-lg-6 col-md-8 login-box">
                <div class="col-sm-offset-2 col-sm-4">
                    <i class="fa fa-key" aria-hidden="true"></i>
                    <img src="logos.png" width= "320px" height= "300px">
                </div>
                <div class="col-lg-12 login-title" style="text-align: center;">
                    
                </div>

                <div class="col-lg-12 login-form">
                    <div class="col-lg-12 login-form">
                        <form action="index.php" method ="post" class="form-horizontal">
                            <div class="form-group">
                                <label class="form-control-label">EMAIL/ID</label>
                                <input type="text" name="userid" placeholder="example@gmail.com" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">PASSWORD</label>
                                <input type="password" name="password" placeholder="*****"class="form-control" i>
                                 <?php
                if (isset($_SESSION['error'])) {
                    echo "<p id='error' class='text-danger text-center'>{$_SESSION['error']}</p>";
                    unset($_SESSION['error']);
                }
                ?>
                            </div>

                            <div class="col-sm-offset-3 col-sm-4">
                                <div class="col-lg-6 login-btm login-text">
                                </div>
                                <div class="col-lg-6 login-btm login-button" style="text-align: left ">
                                    <input type="submit" class="btn btn-outline-primary" value="Login"><br>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-3 col-md-2"></div>
            </div>
        </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>