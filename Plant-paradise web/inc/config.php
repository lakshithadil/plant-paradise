<?php
$dsn = 'mysql:dbname=plant_cart;host=localhost';
$user = 'root';
$password = '';

try
{
	$db = new PDO($dsn,$user,$password);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
	echo "PDO error".$e->getMessage();
	die();
}

define('PRODUCT_IMG_URL','assets/product-images/');

?>