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

$app->post('/consultarCpfCnpj', 'consultarCpfCnpj');
$app->post('/listar', 'listar');
$app->post('/consultarPorCpfInquilino', 'consultarPorCpfInquilino');
$app->post('/registrarAtendimento', 'registrarAtendimento');
$app->post('/listarCGC_Imob', 'listarCGC_Imob');

function consultarCpfCnpj($request, $response){
	$param = json_decode($request->getBody());
	$cnpjCpf = trim(json_encode($param->cpfCnpj, JSON_UNESCAPED_UNICODE), '"');
	
	$conexao = mysql_connect("mysql.segurosja.com.br", "segurosja", "m1181s2081_") or die ("problema na conexão");
	mysql_set_charset('utf8',$conexao);
	
	$sql = "SELECT fantasia, razao, corretor FROM imobs where cpf='$cnpjCpf'";
	$consulta = mysql_db_query("segurosja", $sql) or die (mysql_error());
	while($campo = mysql_fetch_assoc($consulta)){
        $fantasia=$campo['fantasia'];
        $razao=$campo['razao'];
        $corretor=$campo['corretor'];
    }
    if($fantasia == ""){$fantasia = $razao;}
    return "fantasia=".$fantasia."&"."razao=".$razao."&"."corretor=".$corretor;
}


function listar($request, $response){
	$param = json_decode($request->getBody());
	$codigo = trim(json_encode($param->codigo, JSON_UNESCAPED_UNICODE), '"');
	
	$conexao = mysql_connect("mysql.segurosja.com.br", "segurosja", "m1181s2081_") or die ("problema na conexão");
	mysql_set_charset('utf8',$conexao);

	$rows = array();

 	$sqlTodos = "SELECT *, (SELECT fantasia FROM imobs WHERE imobs.cpf=fianca.CGC_imob) as fantasia, 
			(SELECT razao FROM imobs WHERE imobs.cpf=fianca.CGC_imob) as razao, 
			(SELECT razao FROM corretores WHERE corretores.codigo=fianca.corretor) as corretora,
			(SELECT nome FROM usuarios WHERE usuarios.codigo=fianca.usuario_analise) as usuario_atendente
			from fianca order by codigo desc";

	$sqlPorCodigo = "SELECT *, (SELECT fantasia FROM imobs WHERE imobs.cpf=fianca.CGC_imob) as fantasia, 
			(SELECT razao FROM imobs WHERE imobs.cpf=fianca.CGC_imob) as razao, 
			(SELECT razao FROM corretores WHERE corretores.codigo=fianca.corretor) as corretora,
			(SELECT nome FROM usuarios WHERE usuarios.codigo=fianca.usuario_analise) as usuario_atendente
			from fianca where corretor='$codigo' order by codigo desc";
	
	$consulta = mysql_db_query("segurosja", $codigo != "null" ? $sqlPorCodigo : $sqlTodos) or die (mysql_error());

	while($campo = mysql_fetch_assoc($consulta)){
      $rows[] = $campo;
    }

	echo json_encode($rows);
}

function consultarPorCpfInquilino($request, $response){
	$param = json_decode($request->getBody());
	$cpf = trim(json_encode($param->cpf, JSON_UNESCAPED_UNICODE), '"');
	
	$conexao = mysql_connect("mysql.segurosja.com.br", "segurosja", "m1181s2081_") or die ("problema na conexão");
	mysql_set_charset('utf8',$conexao);

	$rows = array();

 	$sql = "SELECT *, (SELECT fantasia FROM imobs WHERE imobs.cpf=fianca.CGC_imob) as fantasia, 
			(SELECT razao FROM imobs WHERE imobs.cpf=fianca.CGC_imob) as razao, 
			(SELECT razao FROM corretores WHERE corretores.codigo=fianca.corretor) as corretora
			from fianca WHERE codigo = (SELECT max(codigo) as CODIGO from fianca where CPF_inquilino = '$cpf')";
	
	$consulta = mysql_db_query("segurosja", $sql) or die (mysql_error());

	while($campo = mysql_fetch_assoc($consulta)){
      $rows[] = $campo;
    }

	echo json_encode($rows);
}

function registrarAtendimento($request, $response){
	$param = json_decode($request->getBody());
	$codigoUsuario = trim(json_encode($param->codigoUsuario, JSON_UNESCAPED_UNICODE), '"');
	$codigoCadastro = trim(json_encode($param->codigoCadastro, JSON_UNESCAPED_UNICODE), '"');
	$dataAceite = date("Y-m-d H:i:s");
	
	$conexao = mysql_connect("mysql.segurosja.com.br", "segurosja", "m1181s2081_") or die ("problema na conexão");
	mysql_set_charset('utf8',$conexao);

	$rows = array();

 	$sql = "UPDATE fianca set usuario_analise = '$codigoUsuario', data_aceite_analise = '$dataAceite' WHERE codigo=$codigoCadastro";
	
	mysql_db_query("segurosja", $sql) or die (mysql_error());
}

function listarCGC_Imob($request, $response){	
	$param = json_decode($request->getBody());
	$codigCorretor = trim(json_encode($param->codCorretor, JSON_UNESCAPED_UNICODE), '"');

	$conexao = mysql_connect("mysql.segurosja.com.br", "segurosja", "m1181s2081_") or die ("problema na conexão");
	mysql_set_charset('utf8',$conexao);

	$rows = array();

 	$sql = "SELECT cpf, fantasia FROM imobs WHERE corretor='$codigCorretor' and fantasia <> '' order BY fantasia";
	
	$consulta = mysql_db_query("segurosja", $sql) or die (mysql_error());

	while($campo = mysql_fetch_assoc($consulta)){
      $rows[] = $campo;
    }

	echo json_encode($rows);
}

$app->run();

?>
