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

$app->get('/dataServidor', function(){
	$result = array( 'data' => date("Y-m-d"), 'hora' => date("H:i:s")); 
	echo json_encode($result);
});

$app->post('/consultarCpfCnpj', 'consultarCpfCnpj');
$app->post('/listar', 'listar');
$app->post('/consultarPorCpfInquilino', 'consultarPorCpfInquilino');
$app->post('/listarCGC_Imob', 'listarCGC_Imob');
$app->post('/fezUploadArquivos', 'fezUploadArquivos');
$app->post('/consultarFaixaCep', 'consultarFaixaCep');
$app->post('/consultarPorCodigoRegistro', 'consultarPorCodigoRegistro');
$app->post('/consultarPorCodigoUsuario', 'consultarPorCodigoUsuario');
$app->post('/listarOpCartas', 'listarOpCartas');
$app->get('/listarSeguradoras', 'listarSeguradoras');
$app->get('/listarFormasPgtoPorto', 'listarFormasPgtoPorto');


function fezUploadArquivos($request, $response){
	$param = json_decode($request->getBody());
	$pasta = trim(json_encode($param->pasta, JSON_UNESCAPED_UNICODE), '"');

	$dir = scandir('./uploads/'.$pasta.'/');
	$aux=0;
	$num_files=0;
	while($aux < count($dir)){
	    $arquivo = $dir[$aux];
	    $caminho_todo = './uploads/'.$pasta.'/'. $arquivo;
	    if(is_file($caminho_todo)){
	        if($arquivo != "index.php" and $arquivo != ".user.ini" and $arquivo != "logo.jpg"){$num_files++;}
	    }
	    $aux++;
}

	$result = array('qtd' => $num_files); 
	echo json_encode($result);
}

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
			(SELECT ocupacao FROM profissao_cbo WHERE profissao_cbo.codigo_cbo COLLATE latin1_general_ci = fianca.profissao_inquilino) as profissao_descricao,
			(SELECT razao FROM corretores WHERE corretores.codigo=fianca.corretor) as corretora,
			(SELECT nome FROM usuarios WHERE usuarios.codigo=fianca.usuario_analise) as usuario_atendente
			from fianca where status!= '0' order by data_transm desc, hora_transm desc";

	$sqlPorCodigo = "SELECT *, (SELECT fantasia FROM imobs WHERE imobs.cpf=fianca.CGC_imob) as fantasia, 
			(SELECT razao FROM imobs WHERE imobs.cpf=fianca.CGC_imob) as razao,
			(SELECT ocupacao FROM profissao_cbo WHERE profissao_cbo.codigo_cbo COLLATE latin1_general_ci = fianca.profissao_inquilino) as profissao_descricao, 
			(SELECT razao FROM corretores WHERE corretores.codigo=fianca.corretor) as corretora,
			(SELECT nome FROM usuarios WHERE usuarios.codigo=fianca.usuario_analise) as usuario_atendente
			from fianca where corretor='$codigo' and status!= '0' order by data_transm desc, hora_transm desc";
	
	$consulta = mysql_db_query("segurosja", $codigo != "null" ? $sqlPorCodigo : $sqlTodos) or die (mysql_error());

	while($campo = mysql_fetch_assoc($consulta)){
      $rows[] = $campo;
    }

	echo json_encode($rows);
}

function consultarPorCodigoRegistro($request, $response){
	$param = json_decode($request->getBody());
	$codigo = trim(json_encode($param->codigo, JSON_UNESCAPED_UNICODE), '"');
	
	$conexao = mysql_connect("mysql.segurosja.com.br", "segurosja", "m1181s2081_") or die ("problema na conexão");
	mysql_set_charset('utf8',$conexao);

	$rows = array();

	$sql = "SELECT *, (SELECT fantasia FROM imobs WHERE imobs.cpf=fianca.CGC_imob) as fantasia, 
			(SELECT razao FROM imobs WHERE imobs.cpf=fianca.CGC_imob) as razao, 
			(SELECT razao FROM corretores WHERE corretores.codigo=fianca.corretor) as corretora,
			(SELECT nome FROM usuarios WHERE usuarios.codigo=fianca.usuario_analise) as usuario_atendente
			from fianca where codigo='$codigo' order by data_transm desc, hora_transm desc";
	
	$consulta = mysql_db_query("segurosja", $sql) or die (mysql_error());

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
			(SELECT razao FROM corretores WHERE corretores.codigo=fianca.corretor) as corretora,
			(SELECT ocupacao FROM profissao_cbo WHERE profissao_cbo.codigo_cbo COLLATE latin1_general_ci = fianca.profissao_inquilino) as profissao_inquilino_descricao
			from fianca WHERE codigo = (SELECT max(codigo) as CODIGO from fianca where CPF_inquilino = '$cpf')";
	
	$consulta = mysql_db_query("segurosja", $sql) or die (mysql_error());

	while($campo = mysql_fetch_assoc($consulta)){
      $rows[] = $campo;
    }

	echo json_encode($rows);
}

function listarCGC_Imob($request, $response){	
	$param = json_decode($request->getBody());
	$codigCorretor = trim(json_encode($param->codCorretor, JSON_UNESCAPED_UNICODE), '"');

	$conexao = mysql_connect("mysql.segurosja.com.br", "segurosja", "m1181s2081_") or die ("problema na conexão");
	mysql_set_charset('utf8',$conexao);

	$rows = array();

 	$sql = "SELECT cpf, fantasia, razao FROM imobs WHERE corretor='$codigCorretor' and fantasia <> '' order BY fantasia";
	
	$consulta = mysql_db_query("segurosja", $sql) or die (mysql_error());

	while($campo = mysql_fetch_assoc($consulta)){
      $rows[] = $campo;
    }

	echo json_encode($rows);
}

function listarSeguradoras($request, $response){	
	$param = json_decode($request->getBody());
	
	$conexao = mysql_connect("mysql.segurosja.com.br", "segurosja", "m1181s2081_") or die ("problema na conexão");
	mysql_set_charset('utf8',$conexao);

	$rows = array();

 	$sql = "SELECT nome_abrev, sigla from seguradoras where fianca = '1' order by nome_abrev";
	
	$consulta = mysql_db_query("segurosja", $sql) or die (mysql_error());

	while($campo = mysql_fetch_assoc($consulta)){
      $rows[] = $campo;
    }

	echo json_encode($rows);
}

function listarFormasPgtoPorto($request, $response){	
	$param = json_decode($request->getBody());
	
	$conexao = mysql_connect("mysql.segurosja.com.br", "segurosja", "m1181s2081_") or die ("problema na conexão");
	mysql_set_charset('utf8',$conexao);

	$rows = array();

 	$sql = "SELECT *from formas_pagto_fianca_porto";
	
	$consulta = mysql_db_query("segurosja", $sql) or die (mysql_error());

	while($campo = mysql_fetch_assoc($consulta)){
      $rows[] = $campo;
    }

	echo json_encode($rows);
}

function consultarFaixaCep($request, $response){
	$param = json_decode($request->getBody());
	$cep = trim(json_encode($param->cep, JSON_UNESCAPED_UNICODE), '"');
	
	$conexao = mysql_connect("mysql.segurosja.com.br", "segurosja", "m1181s2081_") or die ("problema na conexão");
	mysql_set_charset('utf8',$conexao);

	$sql = "SELECT cidade, estado from cidades where '$cep' <= cep_final and '$cep' >= cep_inicial";
	
	$consulta = mysql_db_query("segurosja", $sql) or die (mysql_error());
	while($campo = mysql_fetch_assoc($consulta)){
        $cidade=$campo['cidade'];
        $estado=$campo['estado'];
    }

    $result = array('localidade' => $cidade, 'uf' => $estado); 
    echo json_encode($result);
}

function consultarPorCodigoUsuario($request, $response){
	$param = json_decode($request->getBody());
	$codigo = trim(json_encode($param->codigoUser, JSON_UNESCAPED_UNICODE), '"');
	$nivel = trim(json_encode($param->nivel, JSON_UNESCAPED_UNICODE), '"');

	$conexao = mysql_connect("mysql.segurosja.com.br", "segurosja", "m1181s2081_") or die ("problema na conexão");
	mysql_set_charset('utf8',$conexao);

	if($nivel == '1'){
		$sql = "SELECT nome from usuarios where codigo='$codigo'";
	}else if($nivel == '2'){
		$sql = "SELECT usuario from imobs where codigo='$codigo'";
	}else if($nivel == '3'){
		$sql = "SELECT usuario from usuarios_imobs where codigo='$codigo'";
	}
	
	
	$consulta = mysql_db_query("segurosja", $sql) or die (mysql_error());
	while($campo = mysql_fetch_assoc($consulta)){
		if($nivel == '1'){
			$nome=$campo['nome'];
		}else{
			$nome=$campo['usuario'];
		}
        
    }

    $result = array('nome' => $nome); 
    echo json_encode($result);
}

function listarOpCartas($request, $response){
	$param = json_decode($request->getBody());
	$codigo = trim(json_encode($param->codigo, JSON_UNESCAPED_UNICODE), '"');
	
	$conexao = mysql_connect("mysql.segurosja.com.br", "segurosja", "m1181s2081_") or die ("problema na conexão");
	mysql_set_charset('utf8',$conexao);
	$sql = "SELECT carta_of_lib_fianca, carta_of_lib_fianca_variavel, carta_of_lib_fianca_tombamento from imobs where codigo='$codigo'";	
	$consulta = mysql_db_query("segurosja", $sql) or die (mysql_error());

	while($campo = mysql_fetch_assoc($consulta)){
      $rows[] = $campo;
    }

	echo json_encode($rows);
}

$app->run();

?>
