<?php
 header("Access-Control-Allow-Origin: *");
 
require_once("php7_mysql_shim.php");

require '../../vendor/autoload.php';
$app = new \Slim\App;

$app->get('/hello', function(){
	return 'Hello World!';
});

$app->post('/consultarCpfCnpj', 'consultarCpfCnpj');
$app->get('/listar', 'listar');

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
	$cnpjCpf = trim(json_encode($param->cpfCnpj, JSON_UNESCAPED_UNICODE), '"');
	
	$conexao = mysql_connect("mysql.segurosja.com.br", "segurosja", "m1181s2081_") or die ("problema na conexão");
	mysql_set_charset('utf8',$conexao);

	$rows = array();

 	$sql = "SELECT *, (SELECT fantasia FROM imobs WHERE imobs.cpf=fianca.CGC_imob) as fantasia, 
			(SELECT razao FROM imobs WHERE imobs.cpf=fianca.CGC_imob) as razao, 
			(SELECT razao FROM corretores WHERE corretores.codigo=fianca.corretor) as corretora
			FROM fianca order by codigo";
	
	$consulta = mysql_db_query("segurosja", $sql) or die (mysql_error());

	while($campo = mysql_fetch_assoc($consulta)){
      $rows[] = $campo;
    }

	echo json_encode($rows);
}

$app->run();

?>
