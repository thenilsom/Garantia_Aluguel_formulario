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
	$inquilino = trim(json_encode($cadastro->pretendente->nome, JSON_UNESCAPED_UNICODE), '"');
	$CPF_inquilino = trim(json_encode($cadastro->pretendente->cpf, JSON_UNESCAPED_UNICODE), '"');
	$data_inquilino = trim(json_encode($cadastro->pretendente->dataNascimento, JSON_UNESCAPED_UNICODE), '"');
	$tipo_DOC_inquilino = trim(json_encode($cadastro->pretendente->tipoDoc, JSON_UNESCAPED_UNICODE), '"');
	$DOC_inquilino = trim(json_encode($cadastro->pretendente->numDoc, JSON_UNESCAPED_UNICODE), '"');
	$orgao_exp_inquilino = trim(json_encode($cadastro->pretendente->orgaoExpedidor, JSON_UNESCAPED_UNICODE), '"');
	$data_exp_inquilino = trim(json_encode($cadastro->pretendente->dataEmissao, JSON_UNESCAPED_UNICODE), '"');
	$data_validade_doc_inquilino = trim(json_encode($cadastro->pretendente->dataValidade, JSON_UNESCAPED_UNICODE), '"');
	$sexo_inquilino = trim(json_encode($cadastro->pretendente->sexo, JSON_UNESCAPED_UNICODE), '"');
	$est_civil_inquilino = trim(json_encode($cadastro->pretendente->estadoCivil, JSON_UNESCAPED_UNICODE), '"');
	$cpf_conjuge_inquilino = trim(json_encode($cadastro->pretendente->cpfConjuge, JSON_UNESCAPED_UNICODE), '"');
	$num_dependente_inquilino = trim(json_encode($cadastro->pretendente->numeroDependente, JSON_UNESCAPED_UNICODE), '"');
	$nome_mae_inquilino = trim(json_encode($cadastro->pretendente->nomeMae, JSON_UNESCAPED_UNICODE), '"');
	$nome_pai_inquilino = trim(json_encode($cadastro->pretendente->nomePai, JSON_UNESCAPED_UNICODE), '"');
	$nacionalidade_inquilino = trim(json_encode($cadastro->pretendente->nacionalidade, JSON_UNESCAPED_UNICODE), '"');
	//$pais_inquilino = trim(json_encode($cadastro->pretendente->paisOrigem, JSON_UNESCAPED_UNICODE), '"');
	$tempo_pais_inquilino = trim(json_encode($cadastro->pretendente->tempoPais, JSON_UNESCAPED_UNICODE), '"');
	//$resp_locacao_inquilino = trim(json_encode($cadastro->pretendente->responsavelLocacao, JSON_UNESCAPED_UNICODE), '"');
	$vai_residir_imov_inquilino = trim(json_encode($cadastro->pretendente->iraResidirImovel, JSON_UNESCAPED_UNICODE), '"');
	$fone_inquilino = trim(json_encode($cadastro->pretendente->telefone, JSON_UNESCAPED_UNICODE), '"');
	$cel_inquilino = trim(json_encode($cadastro->pretendente->celular, JSON_UNESCAPED_UNICODE), '"');
	$fone_com_inquilino = trim(json_encode($cadastro->pretendente->telefoneComercial, JSON_UNESCAPED_UNICODE), '"');
	$email_inquilino = trim(json_encode($cadastro->pretendente->email, JSON_UNESCAPED_UNICODE), '"');

	//DADOS DA IMOBILIARIA
	$fantasia_corretor = trim(json_encode($cadastro->imobiliaria->corretor, JSON_UNESCAPED_UNICODE), '"');
	$$CGC_imob = trim(json_encode($cadastro->imobiliaria->cnpj, JSON_UNESCAPED_UNICODE), '"');

	//DADOS RESIDENCIAIS ATUAIS//
	$tempo_resid_inquilino = trim(json_encode($cadastro->residencia->tempoResidencia, JSON_UNESCAPED_UNICODE), '"');
	$tipo_resid_inquilino = trim(json_encode($cadastro->residencia->tipo, JSON_UNESCAPED_UNICODE), '"');
	$nome_imobiliaria = trim(json_encode($cadastro->residencia->nomeImobiliaria, JSON_UNESCAPED_UNICODE), '"');
	$telefone_imobiliaria = trim(json_encode($cadastro->residencia->telefoneImobiliaria, JSON_UNESCAPED_UNICODE), '"');
	$resid_emnomede_inquilino = trim(json_encode($cadastro->residencia->emNome, JSON_UNESCAPED_UNICODE), '"');
	$arca_com_aluguel_inquilino = trim(json_encode($cadastro->residencia->arcaAluguel, JSON_UNESCAPED_UNICODE), '"');
	$cep_anterior_inquilino = trim(json_encode($cadastro->residencia->anterior->cep, JSON_UNESCAPED_UNICODE), '"');
	$uf_anterior_inquilino = trim(json_encode($cadastro->residencia->anterior->estado, JSON_UNESCAPED_UNICODE), '"');
	$cidade_anterior_inquilino = trim(json_encode($cadastro->residencia->anterior->cidade, JSON_UNESCAPED_UNICODE), '"');
	$endereco_anterior_inquilino = trim(json_encode($cadastro->residencia->anterior->endereco, JSON_UNESCAPED_UNICODE), '"');
	$bairro_anterior_inquilino = trim(json_encode($cadastro->residencia->anterior->bairro, JSON_UNESCAPED_UNICODE), '"');
	if(json_encode($cadastro->residencia->anterior->complemento) <> "null"){$complemento_anterior_inquilino = trim(json_encode($cadastro->residencia->anterior->complemento, JSON_UNESCAPED_UNICODE), '"');}else{$complemento_anterior_inquilino="";}
	$num_anterior_inquilino = trim(json_encode($cadastro->residencia->anterior->numero, JSON_UNESCAPED_UNICODE), '"');

	//DADOS PROFISSIONAIS//
	$empresa_trab_inquilino = trim(json_encode($cadastro->profissional->empresa, JSON_UNESCAPED_UNICODE), '"');
	$fone_com_2_inquilino = trim(json_encode($cadastro->profissional->telefone, JSON_UNESCAPED_UNICODE), '"');
	$ramal_com_inquilino = trim(json_encode($cadastro->profissional->ramal, JSON_UNESCAPED_UNICODE), '"');
	$profissao_inquilino = trim(json_encode($cadastro->profissional->profissao, JSON_UNESCAPED_UNICODE), '"');
	$natureza_renda_inquilino = trim(json_encode($cadastro->profissional->naturezaRenda, JSON_UNESCAPED_UNICODE), '"');
	$data_admissao_inquilino = trim(json_encode($cadastro->profissional->dataAdmissao, JSON_UNESCAPED_UNICODE), '"');
	$salario_inquilino = trim(json_encode($cadastro->profissional->salario, JSON_UNESCAPED_UNICODE), '"');
	$outros_rendim_inquilino = trim(json_encode($cadastro->profissional->outrosRendimentos, JSON_UNESCAPED_UNICODE), '"');
	$total_rendim_inquilino = trim(json_encode($cadastro->profissional->totalRendimentos, JSON_UNESCAPED_UNICODE), '"');
	$empresa_anterior_inquilino = trim(json_encode($cadastro->profissional->empresaAnterior, JSON_UNESCAPED_UNICODE), '"');
	$endereco_com_inquilino = trim(json_encode($cadastro->profissional->enderecoComercial, JSON_UNESCAPED_UNICODE), '"');
	$ref_bancaria_inquilino = trim(json_encode($cadastro->profissional->possuiRefBancaria, JSON_UNESCAPED_UNICODE), '"');
	$banco_inquilino = trim(json_encode($cadastro->profissional->banco, JSON_UNESCAPED_UNICODE), '"');
	$agencia_inquilino = trim(json_encode($cadastro->profissional->agencia, JSON_UNESCAPED_UNICODE), '"');
	$ccorrente_inquilino = trim(json_encode($cadastro->profissional->contaCorrente, JSON_UNESCAPED_UNICODE), '"');
	$gerente_inquilino = trim(json_encode($cadastro->profissional->gerente, JSON_UNESCAPED_UNICODE), '"');
	$fone_gerente_inquilino = trim(json_encode($cadastro->profissional->telefoneGerente, JSON_UNESCAPED_UNICODE), '"');

	//DADOS IM�VEL PRETENDIDO//
	$ocupacao = trim(json_encode($cadastro->imovel->finalidade, JSON_UNESCAPED_UNICODE), '"');
	$imovel_tipo = trim(json_encode($cadastro->imovel->tipo, JSON_UNESCAPED_UNICODE), '"');
	$motivo_locacao = trim(json_encode($cadastro->imovel->motivoLocacao, JSON_UNESCAPED_UNICODE), '"');
	$cep = trim(json_encode($cadastro->imovel->cep, JSON_UNESCAPED_UNICODE), '"');
	$uf = trim(json_encode($cadastro->imovel->estado, JSON_UNESCAPED_UNICODE), '"');
	$cidade = trim(json_encode($cadastro->imovel->cidade, JSON_UNESCAPED_UNICODE), '"');
	$endereco = trim(json_encode($cadastro->imovel->endereco, JSON_UNESCAPED_UNICODE), '"');
	$bairro = trim(json_encode($cadastro->imovel->bairro, JSON_UNESCAPED_UNICODE), '"');
	$numero = trim(json_encode($cadastro->imovel->numero, JSON_UNESCAPED_UNICODE), '"');
	$complemento = trim(json_encode($cadastro->imovel->complemento, JSON_UNESCAPED_UNICODE), '"');
	$aluguel = trim(json_encode($cadastro->imovel->aluguel, JSON_UNESCAPED_UNICODE), '"');
	$iptu = trim(json_encode($cadastro->imovel->iptu, JSON_UNESCAPED_UNICODE), '"');
	$condominio = trim(json_encode($cadastro->imovel->condominio, JSON_UNESCAPED_UNICODE), '"');
	$agua = trim(json_encode($cadastro->imovel->agua, JSON_UNESCAPED_UNICODE), '"');
	$energia = trim(json_encode($cadastro->imovel->luz, JSON_UNESCAPED_UNICODE), '"');
	$gas = trim(json_encode($cadastro->imovel->gas, JSON_UNESCAPED_UNICODE), '"');

	//DADOS PESSOAIS//
	$ref_pessoal_nome = trim(json_encode($cadastro->pessoal->nome, JSON_UNESCAPED_UNICODE), '"');
	$ref_pessoal_fone = trim(json_encode($cadastro->pessoal->telefone, JSON_UNESCAPED_UNICODE), '"');
	$ref_pessoal_cel = trim(json_encode($cadastro->pessoal->celular, JSON_UNESCAPED_UNICODE), '"');
	$ref_pessoal_grau_parent = trim(json_encode($cadastro->pessoal->grauParentesco, JSON_UNESCAPED_UNICODE), '"');
	$tem_renda_arcar_loc_inquilino = trim(json_encode($cadastro->pessoal->possuiRendaArcarLocacao, JSON_UNESCAPED_UNICODE), '"');
	$num_solidarios = trim(json_encode($cadastro->pessoal->numSolidarios, JSON_UNESCAPED_UNICODE), '"');
	$solidario1 = trim(json_encode($cadastro->pessoal->solidario1->nome, JSON_UNESCAPED_UNICODE), '"');
	$solidario1_cpf = trim(json_encode($cadastro->pessoal->solidario1->cpf, JSON_UNESCAPED_UNICODE), '"');
	$solidario1_fone = trim(json_encode($cadastro->pessoal->solidario1->telefone, JSON_UNESCAPED_UNICODE), '"');
	$solidario1_sexo = trim(json_encode($cadastro->pessoal->solidario1->sexo, JSON_UNESCAPED_UNICODE), '"');
	$solidario1_rg = trim(json_encode($cadastro->pessoal->solidario1->numDoc, JSON_UNESCAPED_UNICODE), '"');
	$solidario2_orgao_exp_rg = trim(json_encode($cadastro->pessoal->ocupante1->orgaoExpedidor, JSON_UNESCAPED_UNICODE), '"');
	$solidario2_data_exp_rg = trim(json_encode($cadastro->pessoal->ocupante1->dataEmissao, JSON_UNESCAPED_UNICODE), '"');
	$solidario2 = trim(json_encode($cadastro->pessoal->solidario2->nome, JSON_UNESCAPED_UNICODE), '"');
	$solidario2_cpf = trim(json_encode($cadastro->pessoal->solidario2->cpf, JSON_UNESCAPED_UNICODE), '"');
	$solidario2_fone = trim(json_encode($cadastro->pessoal->solidario2->telefone, JSON_UNESCAPED_UNICODE), '"');
	$solidario2_sexo = trim(json_encode($cadastro->pessoal->solidario2->sexo, JSON_UNESCAPED_UNICODE), '"');
	$solidario2_rg = trim(json_encode($cadastro->pessoal->solidario2->numDoc, JSON_UNESCAPED_UNICODE), '"');
	$solidario2_orgao_exp_rg = trim(json_encode($cadastro->pessoal->ocupante2->orgaoExpedidor, JSON_UNESCAPED_UNICODE), '"');
	$solidario2_data_exp_rg = trim(json_encode($cadastro->pessoal->ocupante2->dataEmissao, JSON_UNESCAPED_UNICODE), '"');
	$solidario3 = trim(json_encode($cadastro->pessoal->solidario3->nome, JSON_UNESCAPED_UNICODE), '"');
	$solidario3_cpf = trim(json_encode($cadastro->pessoal->solidario3->cpf, JSON_UNESCAPED_UNICODE), '"');
	$solidario3_fone = trim(json_encode($cadastro->pessoal->solidario3->telefone, JSON_UNESCAPED_UNICODE), '"');
	$solidario3_sexo = trim(json_encode($cadastro->pessoal->solidario3->sexo, JSON_UNESCAPED_UNICODE), '"');
	$solidario3_rg = trim(json_encode($cadastro->pessoal->solidario3->numDoc, JSON_UNESCAPED_UNICODE), '"');
	$solidario3_orgao_exp_rg = trim(json_encode($cadastro->pessoal->ocupante2->orgaoExpedidor, JSON_UNESCAPED_UNICODE), '"');
	$solidario3_data_exp_rg = trim(json_encode($cadastro->pessoal->ocupante3->dataEmissao, JSON_UNESCAPED_UNICODE), '"');

    $data_cob = date("Y-m-d");
    $hora_cob = date("H:i:s");
    $seguradora = "ALL";
    $usuario_upload = "HOTSITE";
    $tipo_inquilino = "F";
    $resp_inquilino = "";
    $CPF_resp_inquilino = "";
   	$cep_anterior_inquilino = str_replace(".","", $cep_anterior_inquilino);
   	$cep = str_replace(".","", $cep);

    $conexao = mysql_connect("mysql.segurosja.com.br", "segurosja", "m1181s2081_") or die ("problema na conex�o");

    $sql_imob = "select fantasia, razao, corretor, (select razao from corretores where corretores.codigo=imobs.corretor) AS NOME_COR from imobs where cpf='$CGC_imob'";
    $consulta_imob = mysql_db_query("segurosja", $sql_imob) or die ("problema no SQL imob");
    while($campo_imob = mysql_fetch_assoc($consulta_imob)){
            $razao_imob = $campo_imob['razao'];
            $fantasia_imob = $campo_imob['fantasia'];
            $cod_cor = $campo_imob['corretor'];
            $corretor = $campo_imob['NOME_COR'];
    }
    if($fantasia_imob <> ""){$IMOB = $fantasia_imob;}
    else{$IMOB = $razao_imob;}

    $sql = "insert into fianca values ('', '$data_cob', '$hora_cob', '$seguradora', '', '$usuario_upload', '', '$CGC_imob', '', '', '', '', '', '',
								   '', '', '', '', '', '', '', '', '', '', '',
								   '$inquilino', '$tipo_inquilino', '$CPF_inquilino', '$data_inquilino', '$sexo_inquilino', '$est_civil_inquilino', '$DOC_inquilino', '$orgao_exp_inquilino', '$data_exp_inquilino', '$data_validade_doc_inquilino', '$resp_inquilino', '$CPF_resp_inquilino', '$cpf_conjuge_inquilino', '$num_dependente_inquilino', '$nome_mae_inquilino', '$nome_pai_inquilino', '$nacionalidade_inquilino', '$pais_inquilino', '$tempo_pais_inquilino', '$resp_locacao_inquilino', '$vai_residir_imov_inquilino', '$tem_renda_arcar_loc_inquilino', '$fone_inquilino', '$cel_inquilino', '$email_inquilino',
								   '$tempo_resid_inquilino', '$tipo_resid_inquilino', '$nome_imobiliaria', '$telefone_imobiliaria', '$resid_emnomede_inquilino', '$arca_com_aluguel_inquilino', '$cep_anterior_inquilino', '$uf_anterior_inquilino', '$cidade_anterior_inquilino', '$endereco_anterior_inquilino', '$bairro_anterior_inquilino', '$complemento_anterior_inquilino', '$num_anterior_inquilino',
                                   '$empresa_trab_inquilino', '$fone_com_inquilino', '$ramal_com_inquilino', '$profissao_inquilino', '$natureza_renda_inquilino', '$data_admissao_inquilino', '$salario_inquilino', '$outros_rendim_inquilino', '$total_rendim_inquilino', '$empresa_anterior_inquilino', '$endereco_com_inquilino', '$ref_bancaria_inquilino', '$banco_inquilino', '$agencia_inquilino', '$ccorrente_inquilino', '$gerente_inquilino', '$fone_gerente_inquilino', '$ref_pessoal_nome', '$ref_pessoal_fone', '$ref_pessoal_cel', '$ref_pessoal_grau_parent',
                                   '$num_solidarios', '$solidario1', '$solidario1_cpf', '$solidario1_fone', '$solidario1_sexo', '$solidario1_rg', '$solidario2', '$solidario2_cpf', '$solidario2_fone', '$solidario2_sexo', '$solidario2_rg', '$solidario3', '$solidario3_cpf', '$solidario3_fone', '$solidario3_sexo', '$solidario3_rg',
								   '$cep', '$endereco', '$numero', '', '', '$complemento', '$bairro', '$cidade', '$uf', '$aluguel',
								   '$ocupacao', '$imovel_tipo', '$motivo_locacao', '$inicio', '', '', '', '', '', '', '', '', '', '$condominio', '$gas', '$iptu', '$energia', '$agua', '$pintura_int', '$pintura_ext', '$danos', '$multa', '',
							       '', '', '', '', '$cod_cor', '')";

    mysql_db_query("segurosja", $sql) or die (mysql_error());
    $sql_last_insert = "SELECT LAST_INSERT_ID()";
    $consulta_last_insert = mysql_db_query("segurosja", $sql_last_insert) or die (mysql_error());
    $aux=0;
    while($aux < mysql_num_rows($consulta_last_insert)){
          $campo_last_insert = mysql_fetch_array($consulta_last_insert);
          $registro = $campo_last_insert[0];
          $aux++;
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

    $mensagem = "<html><body><div align='center'><b>** An�lise de Cadastro para Fian�a Locat�cia n�: ". $registro . " **</b><BR>" . $inquilino . "<BR><BR>";
    $mensagem .= "
        <HR></div><div align='left'>
        <b>Imobili�ria:</b> ".$IMOB." - <b>Corretor:</b> ".$corretor."<BR>
        </div><div align='center'><HR></div><div align='left'>
        <b>Pretendente:</b> ".$inquilino." - <b>Tipo Pessoa:</b> ".$tipo_inquilino." - <b>CPF/CNPJ:</b> ".$CPF_inquilino."<BR>
        <b>Data de Nascimento:</b> ".$data_inquilino." - <b>Sexo:</b> ".$sexo_inquilino." - <b>Estado Civil:</b> ".$est_civil_inquilino."<BR>
        <b>RG/Documento:</b> ".$tipo_DOC_inquilino." - <b>�rg�o Expedidor:</b> ".$orgao_exp_inquilino." - <b>Data de Expedi��o do Documento:</b> ".$data_exp_inquilino." - <b>Validade:</b> ".$data_validade_doc_inquilino."<BR>
        <b>Respons�vel pela PJ:</b> ".$resp_inquilino." - <b>CPF:</b> ".$CPF_resp_inquilino."<BR>
        <b>Telefone:</b> ".$fone_inquilino." - <b>Celular:</b> ".$cel_inquilino." - <b>E-mail:</b> ".$email_inquilino."<BR>
        </div><div align='center'><HR></div><div align='left'>
        <b>CPF C�njuge:</b> ".$cpf_conjuge_inquilino." - <b>N�mero de Dependentes:</b> ".$num_dependente_inquilino."<BR>
        <b>Nome da M�e:</b> ".$nome_mae_inquilino." - <b>Nome do Pai:</b> ".$nome_pai_inquilino."<BR>
        <b>Nacionalidade Pretendente:</b> ".$nacionalidade_inquilino." - <b>Pa�s:</b> ".$pais_inquilino." - <b>Tempo no Pa�s:</b> ".$tempo_pais_inquilino."<BR>
        </div><div align='center'><HR></div><div align='left'>
        <b>Respons�vel pela Loca��o:</b> ".$resp_locacao_inquilino." - <b>Inquilino vai residir no im�vel?</b> ".$vai_residir_imov_inquilino." - <b>Tem renda para arcar com a loca��o?</b> ".$tem_renda_arcar_loc_inquilino."<BR>
        <b>Tempo de resid�ncia atual:</b> ".$tempo_resid_inquilino." - <b>Tipo de Resid�ncia:</b> ".$tipo_resid_inquilino." -
        <b>Imobili�ria/Propriet�rio Atual:</b> ".$imob_prop_atual." - <b>Telefone:</b> ".$fone_imob_prop_atual." - <b>Resid�ncia em Nome de quem?</b> ".$resid_emnomede_inquilino."<BR>
        <b>Arca com aluguel?</b> ".$arca_com_aluguel_inquilino."<b>CEP Atual:</b> ".$cep_anterior_inquilino." - <b>UF:</b> ".$uf_anterior_inquilino." - <b>Cidade:</b> ".$cidade_anterior_inquilino."<BR>
        <b>Endere�o Atual:</b> ".$endereco_anterior_inquilino." - <b>N�mero:</b> ".$num_anterior_inquilino." - <b>Complemento:</b> ".$complemento_anterior_inquilino." - <b>Bairro:</b> ".$bairro_anterior_inquilino."<BR>
        </div><div align='center'><HR></div><div align='left'>
        <b>Empresa que Trabalha:</b> ".$empresa_trab_inquilino." - <b>Telefone:</b> ".$fone_com_inquilino." - <b>Ramal:</b> ".$ramal_com_inquilino." - <b>Data de Admiss�o:</b> ".$data_admissao_inquilino." - <b>Endere�o Comercial:</b> ".$endereco_com_inquilino."<BR>
        <b>Profiss�o:</b> ".$profissao_inquilino." - <b>Natureza da Renda:</b> ".$natureza_renda_inquilino." - <b>Sal�rio:</b> ".$salario_inquilino."<BR>
        <b>Ourtos Rendimentos:</b> ".$outros_rendim_inquilino." - <b>Total de Outros Rendimentos:</b> ".$total_rendim_inquilino."<BR>
        <b>Empresa que trabalhou Anteriormente:</b> ".$empresa_anterior_inquilino."<BR>
        </div><div align='center'><HR></div><div align='left'>
        <b>Refer�ncia Banc�ria:</b> ".$ref_bancaria_inquilino." - <b>Banco:</b> ".$banco_inquilino." - <b>Ag�ncia:</b> ".$agencia_inquilino." - <b>Conta Corrente:</b> ".$ccorrente_inquilino."<BR>
        <b>Gerente da Conta:</b> ".$gerente_inquilino." - <b>Telefone:</b> ".$fone_gerente_inquilino."<BR>
        <b>Refer�ncia Pessoal:</b> ".$ref_pessoal_nome." - <b>Telefone:</b> ".$ref_pessoal_fone." - <b>Celular:</b> ".$ref_pessoal_cel." - <b>Grau de Parentesco/Relacionamento:</b> ".$ref_pessoal_grau_parent."<BR>
        </div><div align='center'><HR></div><div align='left'>
        <b>N�mero de Locat�rios Solid�rios:</b> ".$num_solidarios."<BR>
        <b>Nome do Solid�rio 1:</b> ".$solidario1." - <b>CPF/CNPJ:</b> ".$solidario1_cpf." - <b>Sexo:</b> ".$solidario1_sexo." - <b>RG:</b> ".$solidario1_rg." - <b>�rg�o Expedidor:</b> ".$solidario1_orgao_exp_rg." - <b>Data de Expedi��o:</b> ".$solidario1_data_exp_rg." - <b>Telefone:</b> ".$solidario1_fone."<BR>
        <b>Nome do Solid�rio 2:</b> ".$solidario2." - <b>CPF/CNPJ:</b> ".$solidario2_cpf." - <b>Sexo:</b> ".$solidario2_sexo." - <b>RG:</b> ".$solidario2_rg." - <b>�rg�o Expedidor:</b> ".$solidario2_orgao_exp_rg." - <b>Data de Expedi��o:</b> ".$solidario2_data_exp_rg." - <b>Telefone:</b> ".$solidario2_fone."<BR>
        <b>Nome do Solid�rio 3:</b> ".$solidario3." - <b>CPF/CNPJ:</b> ".$solidario3_cpf." - <b>Sexo:</b> ".$solidario3_sexo." - <b>RG:</b> ".$solidario3_rg." - <b>�rg�o Expedidor:</b> ".$solidario3_orgao_exp_rg." - <b>Data de Expedi��o:</b> ".$solidario3_data_exp_rg." - <b>Telefone:</b> ".$solidario3_fone."<BR>
        </div><div align='center'><HR></div><div align='left'>
        <b>CEP do Im�vel Pretendido:</b> ".$cep." - <b>Endere�o:</b> ".$endereco." - <b>N�mero:</b> ".$numero." - <b>Quadra:</b> ".$quadra." - <b>Lote:</b> ".$lote." - <b>Complemento:</b> ".$complemento."<BR>
        <b>Bairro:</b> ".$bairro." - <b>Cidade:</b> ".$cidade." - <b>UF:</b> ".$uf."<BR>
        <b>Finalidade da Loca��o:</b> ".$ocupacao." - <b>Tipo do Im�vel:</b> ".$imovel_tipo." - <b>Motivo da Loca��o:</b> ".$motivo_locacao."<BR>
        </div><div align='center'><HR></div><div align='left'>
        <b>Aluguel:</b> ".$aluguel." - <b>Condom�nio:</b> ".$condominio." - <b>G�s:</b> ".$gas." - <b>IPTU:</b> ".$iptu." - <b>Energia:</b> ".$energia." - <b>�gua:</b> ".$agua."
        </div><div align='center'><HR></div>";
    $mensagem .= "<div align='center'><font size='2'>Data e hora de envio: ".$data_cob." - ".$hora_cob." - Seg: ".$seguradora." - Usu�rio: ".$usuario_upload."</font></div></body></html>";

    // Inclui o arquivo class.phpmailer.php localizado na pasta phpmailer
    require("../../../../adm/phpmailer/class.phpmailer.php");
    // Inicia a classe PHPMailer
    $mail = new PHPMailer();
    // Define os dados do servidor e tipo de conex�o
    $mail->IsSMTP(); // Define que a mensagem ser� SMTP
    $mail->Host = "smtp.segurosja.com.br"; // Endere�o do servidor SMTP (caso queira utilizar a autentica��o, utilize o host smtp.seudom�nio.com.br)
    $mail->SMTPAuth = true; // Usar autentica��o SMTP (obrigat�rio para smtp.seudom�nio.com.br)
    $mail->Username = 'cobertura=segurosja.com.br'; // Usu�rio do servidor SMTP (endere�o de email)
    $mail->Password = 'm1181s2081_'; // Senha do servidor SMTP (senha do email usado)
    // Define o remetente
    $mail->From = "cobertura@segurosja.com.br"; // Seu e-mail
    $mail->Sender = "cobertura@segurosja.com.br"; // Seu e-mail
    $mail->FromName = "Seguros J�! Cadastro"; // Seu nome
    $mail->AddReplyTo("cobertura@segurosja.com.br"); // Email para receber as respostas
    // Define os dados t�cnicos da Mensagem
    $mail->IsHTML(true); // Define que o e-mail ser� enviado como HTML
    $mail->CharSet = 'iso-8859-1'; // Charset da mensagem (opcional)

    if($cod_cor == "0"){$mail->AddAddress('aluguel@mx10.com.br');$mail->AddAddress('aluguel2@maximizaseguros.com.br');$mail->AddAddress('cadastro@maximizaseguros.com.br');}
    if($cod_cor == "10"){$mail->AddAddress("cadastro.df@maximizaseguros.com.br");$mail->AddAddress("aluguel.df@maximizaseguros.com.br");}
    if($cod_cor == "8"){$mail->AddAddress("mt@maximizaseguros.com.br");$mail->AddAddress("mt@mx10.com.br");}
    if($cod_cor == "6"){$mail->AddAddress('aluguel@mx10.com.br');$mail->AddAddress('aluguel2@maximizaseguros.com.br');$mail->AddAddress('cadastro@maximizaseguros.com.br');}
    if($cod_cor == "5"){$mail->AddBCC('clemente@mx10.com.br');$mail->AddBCC('leandro@maximizaseguros.com.br');$mail->AddAddress('ccavalcante@riolupo.com.br');}
    if($cod_cor == "11"){$mail->AddAddress('ba@maximizaseguros.com.br');$mail->AddBCC('eduardo@maximizaseguros.com.br');$mail->AddBCC('silmara@maximizaseguros.com.br');}

    $mail->AddBCC("leandro@maximizaseguros.com.br");

    $mail->Body = $mensagem;//apagar
    $mail->Subject = "An�lise de Fian�a " . $registro . " - " . $inquilino; //apagar
    $enviado = $mail->Send();//apagar

    // Limpa os destinat�rios e os anexos
    $mail->ClearAllRecipients();
    $mail->ClearAttachments();
    // Exibe uma mensagem de resultado
    if($enviado){$retorno_mail = "E-mail(s) enviado(s) com sucesso!";}
    else{
        $retorno_mail = "N�o foi poss�vel enviar o(s) e-mail(s).";
        $retorno_mail .= " Informa��es do erro: " . $mail->ErrorInfo;
    }

    mysql_close($conexao);

    //echo $retorno_mail;
    return $registro;
}

$app->run();

?>
