<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET,PUT,POST,DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
 
$search_term = '';

if(isset($_POST['searchTerm'])){
	$ocupacao = $_POST['searchTerm'];

	$pdo = new PDO("mysql:host=localhost;dbname=segurosja;", "segurosja", "m1181s2081_", array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
	//$pdo = new PDO("mysql:host=localhost;dbname=segurosja;", "root", "", array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
	$sth = $pdo->prepare("SELECT codigo_cbo as id, ocupacao as text FROM profissao_cbo WHERE ocupacao LIKE _utf8 '%$ocupacao%' COLLATE utf8_unicode_ci");
	$sth->execute();
	$result = $sth->fetchAll(PDO::FETCH_ASSOC);
	$pdo = null;
	echo json_encode($result);

} 
?>
