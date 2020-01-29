<?php
 header("Access-Control-Allow-Origin: *");
 header("Access-Control-Allow-Methods: GET,PUT,POST,DELETE");
 header("Access-Control-Allow-Headers: Content-Type, Authorization");
 
require_once("php7_mysql_shim.php");

require '../../vendor/autoload.php';
$app = new \Slim\App;

$app->get('/hello', function(){
	return 'Hello World!';
});

$app->post('/registrarAtendimento', 'registrarAtendimento');
$app->post('/gravarRegInquilino', 'gravarRegInquilino');
$app->post('/gravarDadosApolice', 'gravarDadosApolice');


function registrarAtendimento($request, $response){
	$param = json_decode($request->getBody());
	$codigoUsuario = trim(json_encode($param->codigoUsuario, JSON_UNESCAPED_UNICODE), '"');
	$codigoCadastro = trim(json_encode($param->codigoCadastro, JSON_UNESCAPED_UNICODE), '"');
	$dataAceite = date("Y-m-d H:i:s");
	
	$conexao = mysql_connect("mysql.segurosja.com.br", "segurosja", "m1181s2081_") or die ("problema na conexao");
	mysql_set_charset('utf8',$conexao);

	$rows = array();

 	$sql = "UPDATE fianca set usuario_analise = '$codigoUsuario', data_aceite_analise = '$dataAceite' WHERE codigo=$codigoCadastro";
	
	mysql_db_query("segurosja", $sql) or die (mysql_error());
}

function gravarDadosApolice($request, $response){
	$param = json_decode($request->getBody());
	$numApolice = trim(json_encode($param->numApolice, JSON_UNESCAPED_UNICODE), '"');
	$codigoCadastro = trim(json_encode($param->codigoCadastro, JSON_UNESCAPED_UNICODE), '"');
	$codSeguradora = trim(json_encode($param->codSeguradora, JSON_UNESCAPED_UNICODE), '"');
	
	$conexao = mysql_connect("mysql.segurosja.com.br", "segurosja", "m1181s2081_") or die ("problema na conexao");
	mysql_set_charset('utf8',$conexao);

	$rows = array();

 	$sql = "UPDATE fianca set apolice = '$numApolice', seguradora = '$codSeguradora' WHERE codigo=$codigoCadastro";
	
	mysql_db_query("segurosja", $sql) or die (mysql_error());
}

function gravarRegInquilino($request, $response){
	$param = json_decode($request->getBody());
	$data_servidor = trim(json_encode($param->data, JSON_UNESCAPED_UNICODE), '"');
	$hora_servidor = trim(json_encode($param->hora, JSON_UNESCAPED_UNICODE), '"');
	$CGC_imob = trim(json_encode($param->cgcImob->cpf, JSON_UNESCAPED_UNICODE), '"');
	$inquilino = trim(json_encode($param->inquilino, JSON_UNESCAPED_UNICODE), '"');
	$tipo_inquilino = trim(json_encode($param->tipoInquilino, JSON_UNESCAPED_UNICODE), '"');
	$cpfCnpj = trim(json_encode($param->cpfInquilino, JSON_UNESCAPED_UNICODE), '"');
	$codCorretor = trim(json_encode($param->codCorretor, JSON_UNESCAPED_UNICODE), '"');
	
	$conexao = mysql_connect("mysql.segurosja.com.br", "segurosja", "m1181s2081_") or die ("problema na conexao");
	mysql_set_charset('utf8',$conexao);

	$rows = array();

 	$sql = "INSERT INTO fianca(data_transm, hora_transm, seguradora, solicitante, CGC_imob, inquilino, tipo_inquilino, CPF_inquilino, corretor) VALUES ('$data_servidor', '$hora_servidor', 'ALL', 'Seguros Já', '$CGC_imob', '$inquilino', '$tipo_inquilino', '$cpfCnpj', '$codCorretor')";
	
	mysql_db_query("segurosja", $sql) or die (mysql_error());
}


$app->run();

?>
