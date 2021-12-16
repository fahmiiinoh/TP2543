<?php
session_start();
if (!isset($_SESSION['loggedin']))
header("LOCATION: login.php");
header("Content-Type: application/json;Charset=UTF-8");
require 'database.php';

$Json = array();
if (isset($_GET['search'])) {
	$field = ['fld_product_name', 'fld_product_brand', 'fld_product_type'];
	$search = htmlspecialchars($_GET['search']);
	$data = explode(" ", $search);

	$name = (isset($data[0]) ? $data[0] : '');
	$brand = (isset($data[1]) ? $data[1] : '');
	$type = (isset($data[2]) ? $data[2] : '');

	try {

		$queries = array();
		foreach($data as $dat){
			$queries[] = "SELECT * FROM `tbl_products_a178796_pt2` WHERE {$field[0]} LIKE '%{$dat}%' OR {$field[1]} LIKE '%{$dat}%' OR {$field[2]} LIKE '%{$dat}%'";
		}
		$sql = implode(' UNION ',$queries);
		$stmt = $db->prepare($sql);

		$stmt->execute();
		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$Json = array('status' => 200, 'data' => $res);
	} catch (PDOException $e) {
		$Json = array('status' => 400, 'data' => $e->getMessage());
	}

}

if (isset($Json))
	echo json_encode($Json);
