<?php
require_once("php7_mysql_shim.php");

require '../../vendor/autoload.php';
$app = new \Slim\App;
$app->get('/hello', function(){
	return 'Hello World!';
});

$app->post('/salvarFormulario', 'salvar');

function salvar($request, $response){
	$cadastro = json_decode($request->getBody());
    //echo json_encode($cadastro->pretendente->cpf);

	//DADOS DO PRETENDENTE
	$inquilino = json_encode($cadastro->pretendente->nome);
	$CPF_inquilino = json_encode($cadastro->pretendente->cpf);
	$data_inquilino = json_encode($cadastro->pretendente->dataNascimento);
	$rg_inquilino = json_encode($cadastro->pretendente->numDoc);
	$orgao_exp_inquilino = json_encode($cadastro->pretendente->orgaoExpedidor);
	$data_exp_inquilino = json_encode($cadastro->pretendente->dataEmissao);
	$data_validade_doc_inquilino = json_encode($cadastro->pretendente->dataValidade);
	$sexo_inquilino = json_encode($cadastro->pretendente->sexo);
	$est_civil_inquilino = json_encode($cadastro->pretendente->estadoCivil);
	$cpf_conjuge_inquilino = json_encode($cadastro->pretendente->cpfConjuge);
	$num_dependente_inquilino = json_encode($cadastro->pretendente->numeroDependente);
	$nome_mae_inquilino = json_encode($cadastro->pretendente->nomeMae);
	$nome_pai_inquilino = json_encode($cadastro->pretendente->nomePai);
	$nacionalidade_inquilino = json_encode($cadastro->pretendente->nacionalidade);
	$pais_inquilino = json_encode($cadastro->pretendente->paisOrigem);
	$tempo_pais_inquilino = json_encode($cadastro->pretendente->tempoPais);
	$resp_locacao_inquilino = json_encode($cadastro->pretendente->responsavelLocacao);
	$vai_residir_imov_inquilino = json_encode($cadastro->pretendente->iraResidirImovel);
	$tem_renda_arcar_loc_inquilino = json_encode($cadastro->pretendente->possuiRendaArcarLocacao);
	$fone_inquilino = json_encode($cadastro->pretendente->telefone);
	$cel_inquilino = json_encode($cadastro->pretendente->celular);
//	$fone_com_inquilino = json_encode($cadastro->pretendente->telefoneComercial);
	$email_inquilino = json_encode($cadastro->pretendente->email);

	//DADOS RESIDENCIAIS ATUAIS//
	$tempo_resid_inquilino = json_encode($cadastro->residencia->tempoResidencia);
	$tipo_resid_inquilino = json_encode($cadastro->residencia->tipo);
	$resid_emnomede_inquilino = json_encode($cadastro->residencia->emNome);
	$arca_com_aluguel_inquilino = json_encode($cadastro->residencia->arcaAluguel);
	$aluguel_atual_inquilino = json_encode($cadastro->residencia->aluguel);
//	$agua_atual_inquilino = json_encode($cadastro->residencia->agua);
//	$gas_atual_inquilino = json_encode($cadastro->residencia->gas);
//	$luz_atual_inquilino = json_encode($cadastro->residencia->luz);
	$outros_imov_alugados_inquilino = json_encode($cadastro->residencia->outrosImoveisAlugados);
	$cep_anterior_inquilino = json_encode($cadastro->residencia->anterior->cep);
	$uf_anterior_inquilino = json_encode($cadastro->residencia->anterior->estado);
	$cidade_anterior_inquilino = json_encode($cadastro->residencia->anterior->cidade);
	$endereco_anterior_inquilino = json_encode($cadastro->residencia->anterior->endereco);
	$bairro_anterior_inquilino = json_encode($cadastro->residencia->anterior->bairro);
	$num_anterior_inquilino = json_encode($cadastro->residencia->anterior->numero);

	//DADOS PROFISSIONAIS//
	$empresa_trab_inquilino = json_encode($cadastro->profissional->empresa);
	$fone_com_inquilino = json_encode($cadastro->profissional->telefone);
	$ramal_com_inquilino = json_encode($cadastro->profissional->ramal);
	$profissao_inquilino = json_encode($cadastro->profissional->profissao);
	$natureza_renda_inquilino = json_encode($cadastro->profissional->naturezaRenda);
	$data_admissao_inquilino = json_encode($cadastro->profissional->dataAdmissao);
	$salario_inquilino = json_encode($cadastro->profissional->salario);
	$outros_rendim_inquilino = json_encode($cadastro->profissional->outrosRendimentos);
	$total_rendim_inquilino = json_encode($cadastro->profissional->totalRendimentos);
//	$profCep = json_encode($cadastro->profissional->cep);
//	$profEstado = json_encode($cadastro->profissional->estado);
//	$profCidade = json_encode($cadastro->profissional->cidade);
//	$profEndereco = json_encode($cadastro->profissional->endereco);
//	$profBairro = json_encode($cadastro->profissional->bairro);
//	$profNumero = json_encode($cadastro->profissional->numero);
//	$profComplemento = json_encode($cadastro->profissional->complemento);
	$empresa_anterior_inquilino = json_encode($cadastro->profissional->empresaAnterior);
	$endereco_com_inquilino = json_encode($cadastro->profissional->enderecoComercial);
	$ref_bancaria_inquilino = json_encode($cadastro->profissional->possuiRefBancaria);
	$banco_inquilino = json_encode($cadastro->profissional->banco);
	$agencia_inquilino = json_encode($cadastro->profissional->agencia);
	$ccorrente_inquilino = json_encode($cadastro->profissional->contaCorrente);
	$gerente_inquilino = json_encode($cadastro->profissional->gerente);
	$fone_gerente_inquilino = json_encode($cadastro->profissional->telefoneGerente);

	//DADOS IMÓVEL PRETENDIDO//
	$ocupacao = json_encode($cadastro->imovel->finalidade);
	$imovel_tipo = json_encode($cadastro->imovel->tipo);
	$motivo_locacao = json_encode($cadastro->imovel->motivoLocacao);
	$cep = json_encode($cadastro->imovel->cep);
	$uf = json_encode($cadastro->imovel->estado);
	$cidade = json_encode($cadastro->imovel->cidade);
	$endereco = json_encode($cadastro->imovel->endereco);
	$bairro = json_encode($cadastro->imovel->bairro);
	$numero = json_encode($cadastro->imovel->numero);
	$complemento = json_encode($cadastro->imovel->complemento);
	$aluguel = json_encode($cadastro->imovel->aluguel);
	$iptu = json_encode($cadastro->imovel->iptu);
	$condominio = json_encode($cadastro->imovel->condominio);
	$agua = json_encode($cadastro->imovel->agua);
	$energia = json_encode($cadastro->imovel->luz);
	$gas = json_encode($cadastro->imovel->gas);

	//DADOS PESSOAIS//
	$ref_pessoal_nome = json_encode($cadastro->pessoal->nome);
	$ref_pessoal_fone = json_encode($cadastro->pessoal->telefone);
	$ref_pessoal_cel = json_encode($cadastro->pessoal->celular);
	$ref_pessoal_grau_parent = json_encode($cadastro->pessoal->grauParentesco);
	$num_solidarios = json_encode($cadastro->pessoal->numOcupantes);
	$solidario1 = json_encode($cadastro->pessoal->ocupante1->nome);
	$solidario1_cpf = json_encode($cadastro->pessoal->ocupante1->cpf);
	$solidario1_fone = json_encode($cadastro->pessoal->ocupante1->telefone);
	$solidario1_sexo = json_encode($cadastro->pessoal->ocupante1->sexo);
	$solidario1_rg = json_encode($cadastro->pessoal->ocupante1->numDoc);
//	$solidario2_orgao_exp_rg = json_encode($cadastro->pessoal->ocupante1->orgaoExpedidor);
//	$solidario2_data_exp_rg = json_encode($cadastro->pessoal->ocupante1->dataEmissao);
	$solidario2 = json_encode($cadastro->pessoal->ocupante2->nome);
	$solidario2_cpf = json_encode($cadastro->pessoal->ocupante2->cpf);
	$solidario2_fone = json_encode($cadastro->pessoal->ocupante2->telefone);
	$solidario2_sexo = json_encode($cadastro->pessoal->ocupante2->sexo);
	$solidario2_rg = json_encode($cadastro->pessoal->ocupante2->numDoc);
//	$solidario2_orgao_exp_rg = json_encode($cadastro->pessoal->ocupante2->orgaoExpedidor);
//	$solidario2_data_exp_rg = json_encode($cadastro->pessoal->ocupante2->dataEmissao);
	$solidario3 = json_encode($cadastro->pessoal->ocupante3->nome);
	$solidario3_cpf = json_encode($cadastro->pessoal->ocupante3->cpf);
	$solidario3_fone = json_encode($cadastro->pessoal->ocupante3->telefone);
	$solidario3_sexo = json_encode($cadastro->pessoal->ocupante3->sexo);
	$solidario3_rg = json_encode($cadastro->pessoal->ocupante3->numDoc);
//	$solidario3_orgao_exp_rg = json_encode($cadastro->pessoal->ocupante2->orgaoExpedidor);
//	$solidario3_data_exp_rg = json_encode($cadastro->pessoal->ocupante3->dataEmissao);

    $data_cob = date("Y-m-d");
    $hora_cob = date("H:i:s");
    $seguradora = "ALL";
    $usuario_upload = "HOTSITE";
    $tipo_inquilino = "F";
    $resp_inquilino = "";
    $CPF_resp_inquilino = "";

    $conexao = mysql_connect("mysql.segurosja.com.br", "segurosja", "m1181s2081_") or die ("problema na conexão");

    $sql = "insert into fianca values ('', '$data_cob', '$hora_cob', '$seguradora', '', '$usuario_upload', '', '', '', '', '', '', '', '',
								   '', '', '', '', '', '', '', '', '', '', '',
								   '$inquilino', '$tipo_inquilino', '$CPF_inquilino', '$data_inquilino', '$sexo_inquilino', '$est_civil_inquilino', '$rg_inquilino', '$orgao_exp_inquilino', '$data_exp_inquilino', '$data_validade_doc_inquilino', '$resp_inquilino', '$CPF_resp_inquilino', '$cpf_conjuge_inquilino', '$num_dependente_inquilino', '$nome_mae_inquilino', '$nome_pai_inquilino', '$nacionalidade_inquilino', '$pais_inquilino', '$tempo_pais_inquilino', '$resp_locacao_inquilino', '$vai_residir_imov_inquilino', '$tem_renda_arcar_loc_inquilino', '$fone_inquilino', '$cel_inquilino', '$email_inquilino',
								   '$tempo_resid_inquilino', '$tipo_resid_inquilino', '$resid_emnomede_inquilino', '$arca_com_aluguel_inquilino', '$aluguel_atual_inquilino', '$outros_imov_alugados_inquilino', '$cep_anterior_inquilino', '$uf_anterior_inquilino', '$cidade_anterior_inquilino', '$endereco_anterior_inquilino', '$bairro_anterior_inquilino', '$num_anterior_inquilino',
                                   '$empresa_trab_inquilino', '$fone_com_inquilino', '$ramal_com_inquilino', '$profissao_inquilino', '$natureza_renda_inquilino', '$data_admissao_inquilino', '$salario_inquilino', '$outros_rendim_inquilino', '$total_rendim_inquilino', '$empresa_anterior_inquilino', '$endereco_com_inquilino', '$ref_bancaria_inquilino', '$banco_inquilino', '$agencia_inquilino', '$ccorrente_inquilino', '$gerente_inquilino', '$fone_gerente_inquilino', '$ref_pessoal_nome', '$ref_pessoal_fone', '$ref_pessoal_cel', '$ref_pessoal_grau_parent',
                                   '$num_solidarios', '$solidario1', '$solidario1_cpf', '$solidario1_fone', '$solidario1_sexo', '$solidario1_rg', '$solidario2', '$solidario2_cpf', '$solidario2_fone', '$solidario2_sexo', '$solidario2_rg', '$solidario3', '$solidario3_cpf', '$solidario3_fone', '$solidario3_sexo', '$solidario3_rg',
								   '$cep', '$endereco', '$numero', '', '', '$complemento', '$bairro', '$cidade', '$uf', '$aluguel',
								   '$ocupacao', '$imovel_tipo', '$motivo_locacao', '$inicio', '', '', '', '', '', '', '', '', '', '$condominio', '$gas', '$iptu', '$energia', '$agua', '$pintura_int', '$pintura_ext', '$danos', '$multa', '',
							       '', '', '', '', '$corretor', '')";

    mysql_db_query("segurosja", $sql) or die (mysql_error());

    echo 'Cadastro enviado!9';
    return 'Cadastro enviado!';

}
/*
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
}      */
$app->run();

?>
