<?php
require '../../vendor/autoload.php';
$app = new \Slim\App;
$app->get('/hello', function(){
	return 'Hello World!';
});

$app->post('/salvarFormulario', 'salvar');

function salvar($request, $response){
	$cadastro = json_decode($request->getBody());
	//echo json_encode($cadastro->pretendente->cpf);

	/*DADOS DO PRETENDENTE*/
	$nome = json_encode($cadastro->pretendente->nome);
	$cpf = json_encode($cadastro->pretendente->cpf);
	$dataNascimento = json_encode($cadastro->pretendente->dataNascimento);
	$numDoc = json_encode($cadastro->pretendente->numDoc);
	$orgaoExpedidor = json_encode($cadastro->pretendente->orgaoExpedidor);
	$dataEmissao = json_encode($cadastro->pretendente->dataEmissao);
	$dataValidade = json_encode($cadastro->pretendente->dataValidade);
	$estadoCivil = json_encode($cadastro->pretendente->estadoCivil);
	$cpfConjuge = json_encode($cadastro->pretendente->cpfConjuge);
	$numeroDependente = json_encode($cadastro->pretendente->numeroDependente);
	$nomeMae = json_encode($cadastro->pretendente->nomeMae);
	$nomePai = json_encode($cadastro->pretendente->nomePai);
	$nacionalidade = json_encode($cadastro->pretendente->nacionalidade);
	$paisOrigem = json_encode($cadastro->pretendente->paisOrigem);
	$tempoPais = json_encode($cadastro->pretendente->tempoPais);
	$responsavelLocacao = json_encode($cadastro->pretendente->responsavelLocacao);
	$iraResidirImovel = json_encode($cadastro->pretendente->iraResidirImovel);
	$possuiRendaArcarLocacao = json_encode($cadastro->pretendente->possuiRendaArcarLocacao);
	$telefone = json_encode($cadastro->pretendente->telefone);
	$celular = json_encode($cadastro->pretendente->celular);
	$telefoneComercial = json_encode($cadastro->pretendente->telefoneComercial);
	$email = json_encode($cadastro->pretendente->email);

	return requisicaoSucesso('dados salvo com sucesso');

	return erroInternoServidor('erro ao salvar dados')

	return erroNegocio('cpf invalido')

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