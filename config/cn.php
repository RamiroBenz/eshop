<?php 
@session_start();
@extract($_REQUEST);
$nombre_tienda= "Lola Morena";

$mysql_host = "localhost";
$db_name = "e_shop_lola";
$mysql_pass = "root";
$mysql_user = "root";
$url="http://localhost/eshopper/";

$pdo = new PDO('mysql:host='.$mysql_host.';dbname='.$db_name, $mysql_user, $mysql_pass) or die ("No se ha establecido la base de datos..");



 ?>