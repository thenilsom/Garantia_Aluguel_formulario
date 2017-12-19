<?php
require '../../vendor/autoload.php';
$app = new \Slim\App;
$app->get('/hello', function(){
	return 'Hello World!';
});
$app->post('/salvarFormulario', 'testarPost');
function testarPost($request, $response){
	$cadastro = json_decode($request->getBody());
	echo json_encode($cadastro->pretendente->nome);
}

//retorna status 500-> erro interno do servidor
function erroInternoServidor($response, $erro){
return $response->withStatus(500)->withHeader('HTTP/1.1 500 Error', $erro);
}
//retorna status 400-> erro de validacao
function erroNegocio($response, $erro){
return $response->withStatus(400)->withHeader('HTTP/1.1 400 Error', $erro);
}
//retorna status 200-> Ok
function requisicaoSucesso($response, $msg){
return $response->withStatus(200)->withHeader('HTTP/1.1 200 Success', $msg);
}
$app->run();
?>