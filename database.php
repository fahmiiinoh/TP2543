<?php

$servername = "lrgs.ftsm.ukm.my";
$username = "a178796";
$password = "hugeredturtle";
$dbname = "a178796";
 
$db = null;
try {
    $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>