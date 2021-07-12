<?php
 header("Access-Control-Allow-Origin: *");
 header("Access-Control-Allow-Methods: GET,PUT,POST,DELETE");
 header("Access-Control-Allow-Headers: Content-Type, Authorization");
 
//require_once("php7_mysql_shim.php");

require '../../vendor/autoload.php';
$app = new \Slim\App;

$app->get('/hello', function(){
	return 'Hello World!';
});

$app->post('/registrarAtendimento', 'registrarAtendimento');
$app->post('/gravarRegInquilino', 'gravarRegInquilino');
$app->post('/gravarDadosApolice', 'gravarDadosApolice');
$app->post('/removerDadosApolice', 'removerDadosApolice');
$app->post('/alterarDadosAnalise', 'alterarDadosAnalise');
$app->post('/vincularAnaliseAOutraImob', 'vincularAnaliseAOutraImob');
$app->post('/registrarDesistencia', 'registrarDesistencia');


function registrarAtendimento($request, $response){
	$param = json_decode($request->getBody());
	$codigoUsuario = trim(json_encode($param->codigoUsuario, JSON_UNESCAPED_UNICODE), '"');
	$codigoCadastro = trim(json_encode($param->codigoCadastro, JSON_UNESCAPED_UNICODE), '"');
	$dataAceite = date("Y-m-d H:i:s");
	
	$conexao = mysql_connect("localhost", "segurosja", "m1181s2081_") or die ("problema na conexao");
	mysql_set_charset('utf8',$conexao);

	$rows = array();

 	$sql = "UPDATE fianca set usuario_analise = '$codigoUsuario', data_aceite_analise = '$dataAceite' WHERE codigo=$codigoCadastro";
	
	mysql_db_query("segurosja", $sql) or die (mysql_error());
}

function registrarDesistencia($request, $response){
	$param = json_decode($request->getBody());
	$dataDesistencia = trim(json_encode($param->dataDesistencia, JSON_UNESCAPED_UNICODE), '"');
	$codigoCadastro = trim(json_encode($param->codigoCadastro, JSON_UNESCAPED_UNICODE), '"');
		
	$conexao = mysql_connect("localhost", "segurosja", "m1181s2081_") or die ("problema na conexao");
	mysql_set_charset('utf8',$conexao);

	$rows = array();

 	$sql = "UPDATE fianca set desistencia = '$dataDesistencia' WHERE codigo=$codigoCadastro";
	
	mysql_db_query("segurosja", $sql) or die (mysql_error());
}

function gravarDadosApolice($request, $response){
	$param = json_decode($request->getBody());
	$numApolice = trim(json_encode($param->numApolice, JSON_UNESCAPED_UNICODE), '"');
	$codigoCadastro = trim(json_encode($param->codigoCadastro, JSON_UNESCAPED_UNICODE), '"');
	$codSeguradora = trim(json_encode($param->codSeguradora, JSON_UNESCAPED_UNICODE), '"');
	$data_contratacao = trim(json_encode($param->data_contratacao, JSON_UNESCAPED_UNICODE), '"');
	$inicio_vigencia_apl = trim(json_encode($param->inicio_vigencia_apl, JSON_UNESCAPED_UNICODE), '"');
	$fim_vigencia_apl = trim(json_encode($param->fim_vigencia_apl, JSON_UNESCAPED_UNICODE), '"');
	
	$conexao = mysql_connect("localhost", "segurosja", "m1181s2081_") or die ("problema na conexao");
	mysql_set_charset('utf8',$conexao);

	$rows = array();

 	$sql = "UPDATE fianca set 
 	apolice = '$numApolice', 
 	seguradora = '$codSeguradora',
 	inicio_vigencia_apl = '$inicio_vigencia_apl',
 	fim_vigencia_apl = '$fim_vigencia_apl', 
 	data_contratacao = '$data_contratacao' WHERE codigo=$codigoCadastro";
	
	mysql_db_query("segurosja", $sql) or die (mysql_error());
}

function removerDadosApolice($request, $response){
	$param = json_decode($request->getBody());
	$codigoCadastro = trim(json_encode($param->codigoCadastro, JSON_UNESCAPED_UNICODE), '"');
	$conexao = mysql_connect("localhost", "segurosja", "m1181s2081_") or die ("problema na conexao");
	mysql_set_charset('utf8',$conexao);

	$rows = array();

 	$sql = "UPDATE fianca set 
 	apolice = null, 
 	seguradora = 'ALL', 
 	data_contratacao = '',
 	inicio_vigencia_apl = '',
 	fim_vigencia_apl = '' WHERE codigo=$codigoCadastro";
	
	mysql_db_query("segurosja", $sql) or die (mysql_error());
}

function alterarDadosAnalise($request, $response){
	$param = json_decode($request->getBody());
	$tipo = trim(json_encode($param->tipoSeg, JSON_UNESCAPED_UNICODE), '"');
	$codigoCadastro = trim(json_encode($param->codigoCadastro, JSON_UNESCAPED_UNICODE), '"');
	$processo = trim(json_encode($param->analise, JSON_UNESCAPED_UNICODE), '"');
	$situacao = trim(json_encode($param->situacao, JSON_UNESCAPED_UNICODE), '"');
	$dataAprovacao = trim(json_encode($param->dataAprovacao, JSON_UNESCAPED_UNICODE), '"');
	
	$conexao = mysql_connect("localhost", "segurosja", "m1181s2081_") or die ("problema na conexao");
	mysql_set_charset('utf8',$conexao);

	$rows = array();

 	$sqlLiberty = "UPDATE fianca set processo_liberty = '$processo', situacao_analise_liberty = '$situacao', data_aprovacao_liberty = '$dataAprovacao'
 			WHERE codigo=$codigoCadastro";

 	$sqlPorto = "UPDATE fianca set processo_porto = '$processo', situacao_analise_porto = '$situacao', data_aprovacao_porto = '$dataAprovacao'
 			WHERE codigo=$codigoCadastro";

 	$sqlToo = "UPDATE fianca set processo_too = '$processo', situacao_analise_too = '$situacao', data_aprovacao_too = '$dataAprovacao'
 			WHERE codigo=$codigoCadastro";

 	if($tipo == "liberty"){
 		$sql = $sqlLiberty;
 	}else if($tipo == "porto"){
 		$sql = $sqlPorto;
 	}else if($tipo == "too"){
 		$sql = $sqlToo;
 	}
	
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
	$status = trim(json_encode($param->status, JSON_UNESCAPED_UNICODE), '"');
	$cep = trim(json_encode($param->cep, JSON_UNESCAPED_UNICODE), '"');
	$endereco = trim(json_encode($param->endereco, JSON_UNESCAPED_UNICODE), '"');
	$numero = trim(json_encode($param->numero, JSON_UNESCAPED_UNICODE), '"');
	$quadra = trim(json_encode($param->quadra, JSON_UNESCAPED_UNICODE), '"');
	$lote = trim(json_encode($param->lote, JSON_UNESCAPED_UNICODE), '"');
	$complemento = trim(json_encode($param->complemento, JSON_UNESCAPED_UNICODE), '"');
	$bairro = trim(json_encode($param->bairro, JSON_UNESCAPED_UNICODE), '"');
	$cidade = trim(json_encode($param->cidade, JSON_UNESCAPED_UNICODE), '"');
	$uf = trim(json_encode($param->uf, JSON_UNESCAPED_UNICODE), '"');
		
	$conexao = mysql_connect("localhost", "segurosja", "m1181s2081_") or die ("problema na conexao");
	mysql_set_charset('utf8',$conexao);

	$rows = array();

 	$sql = "INSERT INTO fianca
 	(data_transm, 
 	hora_transm, 
 	seguradora, 
 	solicitante, 
 	CGC_imob, 
 	inquilino, 
 	tipo_inquilino, 
 	CPF_inquilino, 
 	corretor, 
 	status,
 	cep,
 	endereco,
 	numero,
 	quadra,
 	lote,
 	complemento,
 	bairro,
 	cidade,
 	uf) VALUES 
 	('$data_servidor', 
 	'$hora_servidor', 
 	'ALL', 
 	'Seguros Já', 
 	'$CGC_imob', 
 	'$inquilino', 
 	'$tipo_inquilino', 
 	'$cpfCnpj', 
 	'$codCorretor',
 	'$status',
 	'$cep',
 	'$endereco',
 	'$numero',
 	'$quadra',
 	'$lote',
 	'$complemento',
 	'$bairro',
 	'$cidade',
 	'$uf')";
	
	mysql_db_query("segurosja", $sql) or die (mysql_error());
}

function vincularAnaliseAOutraImob($request, $response){
	$param = json_decode($request->getBody());
	$codReg = trim(json_encode($param->codReg, JSON_UNESCAPED_UNICODE), '"');
	$CGC_imob = trim(json_encode($param->CGC_imob, JSON_UNESCAPED_UNICODE), '"');

	$conexao = mysql_connect("localhost", "segurosja", "m1181s2081_") or die ("problema na conexao");
	mysql_set_charset('utf8',$conexao);

	$sql = "UPDATE fianca set CGC_imob = '$CGC_imob' WHERE codigo = $codReg";
	mysql_db_query("segurosja", $sql) or die (mysql_error());
}


$app->run();

?>
