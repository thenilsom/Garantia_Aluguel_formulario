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
	$sexo = json_encode($cadastro->pretendente->sexo);
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

	/*DADOS RESIDENCIAIS*/
	$tempoResidencia = json_encode($cadastro->residencia->tempoResidencia);
	$tipoResidencia = json_encode($cadastro->residencia->tipo);
	$emNomeDe = json_encode($cadastro->residencia->emNome);
	$arcaAluguel = json_encode($cadastro->residencia->arcaAluguel);
	$valorAluguelAtual = json_encode($cadastro->residencia->aluguel);
	$valorAgua = json_encode($cadastro->residencia->agua);
	$valorGas = json_encode($cadastro->residencia->gas);
	$valorLuz = json_encode($cadastro->residencia->luz);
	$outrosImoveisAlugados = json_encode($cadastro->residencia->outrosImoveisAlugados);
	$cepAnterior = json_encode($cadastro->residencia->anterior->cep);
	$estadoAnterior = json_encode($cadastro->residencia->anterior->estado);
	$cidadeAnterior = json_encode($cadastro->residencia->anterior->cidade);
	$enderecoAnterior = json_encode($cadastro->residencia->anterior->endereco);
	$bairroAnterior = json_encode($cadastro->residencia->anterior->bairro);
	$numeroAnterior = json_encode($cadastro->residencia->anterior->numero);

	/*DADOS PROFISSIONAIS*/
	$profEmpresa = json_encode($cadastro->profissional->empresa);
	$profTelefone = json_encode($cadastro->profissional->telefone);
	$profRamal = json_encode($cadastro->profissional->ramal);
	$profProfissao = json_encode($cadastro->profissional->profissao);
	$profNaturezaRenda = json_encode($cadastro->profissional->naturezaRenda);
	$profDataAdmissao = json_encode($cadastro->profissional->dataAdmissao);
	$profSalario = json_encode($cadastro->profissional->salario);
	$profOutrosRendimentos = json_encode($cadastro->profissional->outrosRendimentos);
	$profTotalRendimentos = json_encode($cadastro->profissional->totalRendimentos);
	$profCep = json_encode($cadastro->profissional->cep);
	$profEstado = json_encode($cadastro->profissional->estado);
	$profCidade = json_encode($cadastro->profissional->cidade);
	$profEndereco = json_encode($cadastro->profissional->endereco);
	$profBairro = json_encode($cadastro->profissional->bairro);
	$profNumero = json_encode($cadastro->profissional->numero);
	$profComplemento = json_encode($cadastro->profissional->complemento);
	$profEmpresaAnterior = json_encode($cadastro->profissional->empresaAnterior);
	$profEnderecoComercial = json_encode($cadastro->profissional->enderecoComercial);
	$profPossuiRefBancaria = json_encode($cadastro->profissional->possuiRefBancaria);
	$profBanco = json_encode($cadastro->profissional->banco);
	$profAgencia = json_encode($cadastro->profissional->agencia);
	$profContaCorrente = json_encode($cadastro->profissional->contaCorrente);
	$profGerente = json_encode($cadastro->profissional->gerente);
	$profTelefoneGerente = json_encode($cadastro->profissional->telefoneGerente);

	/*DADOS IMÓVEL PRETENDIDO*/
	$imovelFinalidade = json_encode($cadastro->imovel->finalidade);
	$imovelTipo = json_encode($cadastro->imovel->tipo);
	$imovelMotivoLocacao = json_encode($cadastro->imovel->motivoLocacao);
	$imovelCep = json_encode($cadastro->imovel->cep);
	$imovelEstado = json_encode($cadastro->imovel->estado);
	$imovelCidade = json_encode($cadastro->imovel->cidade);
	$imovelEndereco = json_encode($cadastro->imovel->endereco);
	$imovelBairro = json_encode($cadastro->imovel->bairro);
	$imovelNumero = json_encode($cadastro->imovel->numero);
	$imovelComplemento = json_encode($cadastro->imovel->complemento);
	$imovelValorAluguel = json_encode($cadastro->imovel->aluguel);
	$imovelValorIptu = json_encode($cadastro->imovel->iptu);
	$imovelCondominio = json_encode($cadastro->imovel->condominio);
	$imovelAgua = json_encode($cadastro->imovel->agua);
	$imovelLuz = json_encode($cadastro->imovel->luz);
	$imovelGas = json_encode($cadastro->imovel->gas);

	/*DADOS PESSOAIS*/
	$pessoalNome = json_encode($cadastro->pessoal->nome);
	$pessoalTelefone = json_encode($cadastro->pessoal->telefone);
	$pessoalCelular = json_encode($cadastro->pessoal->celular);
	$pessoalGrauParentesco = json_encode($cadastro->pessoal->grauParentesco);
	$pessoalNumOcupantes = json_encode($cadastro->pessoal->numOcupantes);
	$pessoalOcup1Nome = json_encode($cadastro->pessoal->ocupante1->nome);
	$pessoalOcup1Cpf = json_encode($cadastro->pessoal->ocupante1->cpf);
	$pessoalOcup1Telefone = json_encode($cadastro->pessoal->ocupante1->telefone);
	$pessoalOcup1Sexo = json_encode($cadastro->pessoal->ocupante1->sexo);
	$pessoalOcup1NumDoc = json_encode($cadastro->pessoal->ocupante1->numDoc);
	$pessoalOcup1OrgaoExpedidor = json_encode($cadastro->pessoal->ocupante1->orgaoExpedidor);
	$pessoalOcup1DataEmissao = json_encode($cadastro->pessoal->ocupante1->dataEmissao);
	$pessoalOcup2Nome = json_encode($cadastro->pessoal->ocupante2->nome);
	$pessoalOcup2Cpf = json_encode($cadastro->pessoal->ocupante2->cpf);
	$pessoalOcup2Telefone = json_encode($cadastro->pessoal->ocupante2->telefone);
	$pessoalOcup2Sexo = json_encode($cadastro->pessoal->ocupante2->sexo);
	$pessoalOcup2NumDoc = json_encode($cadastro->pessoal->ocupante2->numDoc);
	$pessoalOcup2OrgaoExpedidor = json_encode($cadastro->pessoal->ocupante2->orgaoExpedidor);
	$pessoalOcup2DataEmissao = json_encode($cadastro->pessoal->ocupante2->dataEmissao);
	$pessoalOcup3Nome = json_encode($cadastro->pessoal->ocupante3->nome);
	$pessoalOcup3Cpf = json_encode($cadastro->pessoal->ocupante3->cpf);
	$pessoalOcup3Telefone = json_encode($cadastro->pessoal->ocupante3->telefone);
	$pessoalOcup3Sexo = json_encode($cadastro->pessoal->ocupante3->sexo);
	$pessoalOcup3NumDoc = json_encode($cadastro->pessoal->ocupante3->numDoc);
	$pessoalOcup3OrgaoExpedidor = json_encode($cadastro->pessoal->ocupante2->orgaoExpedidor);
	$pessoalOcup3DataEmissao = json_encode($cadastro->pessoal->ocupante3->dataEmissao);
	
	
	

	
}

//return requisicaoSucesso('dados salvo com sucesso'); ex: retorno sucesso
//return erroInternoServidor('erro ao salvar dados'); ex: retorno erro servidor
//return erroNegocio('cpf invalido'); ex: retorno erro de negocio

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