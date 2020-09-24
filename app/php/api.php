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

$app->post('/salvarFormulario', 'salvar');

function salvar($request, $response){
	$cadastro = json_decode($request->getBody());
    //echo json_encode($cadastro->pretendente->cpf);

	$codigoCadastro = obterValorVariavel($cadastro->codigo);
	$statusCadastro = obterValorVariavel($cadastro->status);

	//DADOS DO PRETENDENTE
	$inquilino = obterValorVariavel($cadastro->pretendente->nome);
	$CPF_inquilino = obterValorVariavel($cadastro->pretendente->cpf);
	$tipo_inquilino = obterValorVariavel($cadastro->pretendente->tipoInquilino);
	$data_inquilino = obterValorVariavel($cadastro->pretendente->dataNascimento);
	$tipo_DOC_inquilino = obterValorVariavel($cadastro->pretendente->tipoDoc);
	$DOC_inquilino = obterValorVariavel($cadastro->pretendente->numDoc);
	$orgao_exp_inquilino = obterValorVariavel($cadastro->pretendente->orgaoExpedidor);
	$data_exp_inquilino = obterValorVariavel($cadastro->pretendente->dataEmissao);
	$data_validade_doc_inquilino = obterValorVariavel($cadastro->pretendente->dataValidade); 
	$sexo_inquilino = obterValorVariavel($cadastro->pretendente->sexo);
	$est_civil_inquilino = obterValorVariavel($cadastro->pretendente->estadoCivil);
	$cpf_conjuge_inquilino = obterValorVariavel($cadastro->pretendente->cpfConjuge);
	$nome_conjuge_inquilino = obterValorVariavel($cadastro->pretendente->nomeConjuge);
	$data_conjuge_inquilno = obterValorVariavel($cadastro->pretendente->dataNascimentoConjuge);
	$vai_residir_conjuge_inquilno = obterValorVariavel($cadastro->pretendente->iraResidirImovelConjuge);
	$vai_compor_renda_conjuge_inquilno = obterValorVariavel($cadastro->pretendente->iraComporRendaConjuge);
	$vai_compor_renda_pretendente = obterValorVariavel($cadastro->pretendente->iraComporRendaPretendente);
	$renda_conjuge_inquilno = obterValorVariavel($cadastro->pretendente->rendaConjuge);
	$num_dependente_inquilino = obterValorVariavel($cadastro->pretendente->numeroDependente);
	$nome_mae_inquilino = obterValorVariavel($cadastro->pretendente->nomeMae);
	$nome_pai_inquilino = obterValorVariavel($cadastro->pretendente->nomePai);
	$nacionalidade_inquilino = obterValorVariavel($cadastro->pretendente->nacionalidade);
	//$pais_inquilino = utf8_decode(trim(json_encode($cadastro->pretendente->paisOrigem, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES), '"'));
	$tempo_pais_inquilino = obterValorVariavel($cadastro->pretendente->tempoPais);
	//$resp_locacao_inquilino = utf8_decode(trim(json_encode($cadastro->pretendente->responsavelLocacao, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES), '"'));
	$vai_residir_imov_inquilino = obterValorVariavel($cadastro->pretendente->iraResidirImovel); 
	$fone_inquilino = obterValorVariavel($cadastro->pretendente->telefone);
	$ddd_inquilino = obterValorVariavel($cadastro->pretendente->dddTelefone);
	$cel_inquilino = obterValorVariavel($cadastro->pretendente->celular);
	$ddd_cel_inquilino = obterValorVariavel($cadastro->pretendente->dddCelular);
	$fone_com_inquilino = obterValorVariavel($cadastro->pretendente->telefoneComercial);
	$ddd_com_inquilino = obterValorVariavel($cadastro->pretendente->dddTelefoneComercial);
	$email_inquilino = obterValorVariavel($cadastro->pretendente->email);

	//DADOS DA IMOBILIARIA
	$fantasia_corretor = obterValorVariavel($cadastro->imobiliaria->corretor);
	$CGC_imob = obterValorVariavel($cadastro->imobiliaria->cnpj);

	//DADOS RESIDENCIAIS ATUAIS//
	$tempo_resid_inquilino = obterValorVariavel($cadastro->residencia->tempoResidencia);
	$tipo_resid_inquilino = obterValorVariavel($cadastro->residencia->tipo);
	$nome_imobiliaria = obterValorVariavel($cadastro->residencia->nomeImobiliaria);
	$telefone_imobiliaria = obterValorVariavel($cadastro->residencia->telefoneImobiliaria);
	$ddd_telefone_imobiliaria = obterValorVariavel($cadastro->residencia->dddTelefoneImobiliaria);
	$resid_emnomede_inquilino = obterValorVariavel($cadastro->residencia->emNome);
	$arca_com_aluguel_inquilino = obterValorVariavel($cadastro->residencia->arcaAluguel);
	$cep_anterior_inquilino = obterValorVariavel($cadastro->residencia->anterior->cep);
	$uf_anterior_inquilino = obterValorVariavel($cadastro->residencia->anterior->estado);
	$cidade_anterior_inquilino = obterValorVariavel($cadastro->residencia->anterior->cidade);
	$endereco_anterior_inquilino = obterValorVariavel($cadastro->residencia->anterior->endereco);
	$bairro_anterior_inquilino = obterValorVariavel($cadastro->residencia->anterior->bairro);
	if(json_encode($cadastro->residencia->anterior->complemento) <> "null"){$complemento_anterior_inquilino = utf8_decode(trim(json_encode($cadastro->residencia->anterior->complemento, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES), '"'));}else{$complemento_anterior_inquilino="";}
	$num_anterior_inquilino = obterValorVariavel($cadastro->residencia->anterior->numero);

	//DADOS PROFISSIONAIS//
	$empresa_trab_inquilino = obterValorVariavel($cadastro->profissional->empresa);
	$fone_com_2_inquilino = obterValorVariavel($cadastro->profissional->telefone);
	$ramal_com_inquilino = obterValorVariavel($cadastro->profissional->ramal);
	$profissao_inquilino = obterValorVariavel($cadastro->profissional->profissao);
	//$profissao_inquilino = utf8_decode(trim(json_encode($cadastro->profissional->profissao->ocupacao, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES), '"'));
	
	//$profissao_inquilino = utf8_decode(trim(json_encode($cadastro->profissional->profissao->codigo_cbo, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES), '"'));
	
	$natureza_renda_inquilino = obterValorVariavel($cadastro->profissional->naturezaRenda);
	$data_admissao_inquilino = obterValorVariavel($cadastro->profissional->dataAdmissao);
	$salario_inquilino = obterValorVariavel($cadastro->profissional->salario);
	$outros_rendim_inquilino = obterValorVariavel($cadastro->profissional->outrosRendimentos);
	$total_rendim_inquilino = obterValorVariavel($cadastro->profissional->totalRendimentos);
	$empresa_anterior_inquilino = obterValorVariavel($cadastro->profissional->empresaAnterior);
	$endereco_com_inquilino = obterValorVariavel($cadastro->profissional->enderecoComercial);
	$ref_bancaria_inquilino = obterValorVariavel($cadastro->profissional->possuiRefBancaria);
	$banco_inquilino = obterValorVariavel($cadastro->profissional->banco);
	$agencia_inquilino = obterValorVariavel($cadastro->profissional->agencia);
	$ccorrente_inquilino = obterValorVariavel($cadastro->profissional->contaCorrente);
	$gerente_inquilino = obterValorVariavel($cadastro->profissional->gerente);
	$fone_gerente_inquilino = obterValorVariavel($cadastro->profissional->telefoneGerente);
	$ddd_gerente_inquilino = obterValorVariavel($cadastro->profissional->dddTelefoneGerente);

	//DADOS IMÓVEL PRETENDIDO//
	$ocupacao = obterValorVariavel($cadastro->imovel->finalidade);
	$imovel_tipo = obterValorVariavel($cadastro->imovel->tipo);
	$imovel_tipo_descricao = obterValorVariavel($cadastro->imovel->imovelTipoDescricao);
	$motivo_locacao = obterValorVariavel($cadastro->imovel->motivoLocacao);
	$cep = obterValorVariavel($cadastro->imovel->cep);
	$uf = obterValorVariavel($cadastro->imovel->estado);
	$cidade = obterValorVariavel($cadastro->imovel->cidade);
	$endereco = obterValorVariavel($cadastro->imovel->endereco);
	$bairro = obterValorVariavel($cadastro->imovel->bairro);
	$numero = obterValorVariavel($cadastro->imovel->numero);
	$complemento = obterValorVariavel($cadastro->imovel->complemento);
	$aluguel = obterValorVariavel($cadastro->imovel->aluguel);
	$iptu = obterValorVariavel($cadastro->imovel->iptu);
	$condominio = obterValorVariavel($cadastro->imovel->condominio);
	$agua = obterValorVariavel($cadastro->imovel->agua);
	$energia = obterValorVariavel($cadastro->imovel->luz);
	$gas = obterValorVariavel($cadastro->imovel->gas);
	
	//DADOS IMÓVEL PARA CADASTRO NÃO RESIDENCIAL//
	$empresa_constituida = obterValorVariavel($cadastro->imovel->locacaoEmpresaConstituida);
	$cnpj_empresa_constituida = obterValorVariavel($cadastro->imovel->cnpjEmpresaConstituida);
	$ramo_atividade_empresa = obterValorVariavel($cadastro->imovel->ramoAtividadeEmpresa);
	$franquia_empresa = obterValorVariavel($cadastro->imovel->trataDeFranquia);
	$franqueadora_empresa = obterValorVariavel($cadastro->imovel->nomeFranqueadora);
	$produtos_servicos_empresa = obterValorVariavel($cadastro->imovel->produtosFabRevPrest);
	$experiencia_ramo_empresa = obterValorVariavel($cadastro->imovel->experienciaNoRamo);
	$faturam_estim_empresa = obterValorVariavel($cadastro->imovel->faturamentoMensalEstimado);
	$ret_cap_invest_empresa = obterValorVariavel($cadastro->imovel->prazoRetCapitalInvest);

	//DADOS PESSOAIS//
	$ref_pessoal_nome = obterValorVariavel($cadastro->pessoal->nome);
	$ref_pessoal_fone = obterValorVariavel($cadastro->pessoal->telefone);
	$ref_pessoal_cel = obterValorVariavel($cadastro->pessoal->celular);
	$ref_pessoal_grau_parent = obterValorVariavel($cadastro->pessoal->grauParentesco);
	$tem_renda_arcar_loc_inquilino = obterValorVariavel($cadastro->pessoal->possuiRendaArcarLocacao);
	$num_solidarios = obterValorVariavel($cadastro->pessoal->numSolidarios);
	$solidario1 = obterValorVariavel($cadastro->pessoal->solidario1->nome);
	$solidario1_cpf = obterValorVariavel($cadastro->pessoal->solidario1->cpf);
	$solidario1_fone = obterValorVariavel($cadastro->pessoal->solidario1->telefone);
	$solidario1_ddd = obterValorVariavel($cadastro->pessoal->solidario1->dddTelefone);
	$solidario1_sexo = obterValorVariavel($cadastro->pessoal->solidario1->sexo);
	$solidario1_rg = obterValorVariavel($cadastro->pessoal->solidario1->numDoc);
	$solidario1_renda = obterValorVariavel($cadastro->pessoal->solidario1->rendaMensalBruta);
	$solidario1_orgao_rg = obterValorVariavel($cadastro->pessoal->solidario1->orgaoExpedidor);
	$solidario1_data_emissao_rg = obterValorVariavel($cadastro->pessoal->solidario1->dataEmissao);
	$solidario1_data_valid_doc = obterValorVariavel($cadastro->pessoal->solidario1->dataValidade);
	$solidario1_estado_civil = obterValorVariavel($cadastro->pessoal->solidario1->estadoCivil);
	$solidario1_data_nascimento = obterValorVariavel($cadastro->pessoal->solidario1->dataNascimento);
	$solidario1_grau_parentesco = obterValorVariavel($cadastro->pessoal->solidario1->grauParentesco);
	$solidario1_cep = obterValorVariavel($cadastro->pessoal->solidario1->cep);
	$solidario1_ira_residir = obterValorVariavel($cadastro->pessoal->solidario1->iraResidirImovel);
	$solidario1_natureza_renda = obterValorVariavel($cadastro->pessoal->solidario1->naturezaRenda);
	$solidario1_empresa_trabalho = obterValorVariavel($cadastro->pessoal->solidario1->localTrabalhoTel);
	$solidario1_data_admissao = obterValorVariavel($cadastro->pessoal->solidario1->dataAdmissao);
	$solidario1_conjuge_cpf = obterValorVariavel($cadastro->pessoal->solidario1->cpfConjuge);

	$solidario2 = obterValorVariavel($cadastro->pessoal->solidario2->nome);
	$solidario2_cpf = obterValorVariavel($cadastro->pessoal->solidario2->cpf);
	$solidario2_fone = obterValorVariavel($cadastro->pessoal->solidario2->telefone);
	$solidario2_ddd = obterValorVariavel($cadastro->pessoal->solidario2->dddTelefone);
	$solidario2_sexo = obterValorVariavel($cadastro->pessoal->solidario2->sexo);
	$solidario2_rg = obterValorVariavel($cadastro->pessoal->solidario2->numDoc);
	$solidario2_renda = obterValorVariavel($cadastro->pessoal->solidario2->rendaMensalBruta);
	$solidario2_orgao_rg = obterValorVariavel($cadastro->pessoal->solidario2->orgaoExpedidor);
	$solidario2_data_emissao_rg = obterValorVariavel($cadastro->pessoal->solidario2->dataEmissao);
	$solidario2_data_valid_doc = obterValorVariavel($cadastro->pessoal->solidario2->dataValidade);
	$solidario2_estado_civil = obterValorVariavel($cadastro->pessoal->solidario2->estadoCivil);
	$solidario2_data_nascimento = obterValorVariavel($cadastro->pessoal->solidario2->dataNascimento);
	$solidario2_grau_parentesco = obterValorVariavel($cadastro->pessoal->solidario2->grauParentesco);
	$solidario2_cep = obterValorVariavel($cadastro->pessoal->solidario2->cep);
	$solidario2_ira_residir = obterValorVariavel($cadastro->pessoal->solidario2->iraResidirImovel);
	$solidario2_natureza_renda = obterValorVariavel($cadastro->pessoal->solidario2->naturezaRenda);
	$solidario2_empresa_trabalho = obterValorVariavel($cadastro->pessoal->solidario2->localTrabalhoTel);
	$solidario2_data_admissao = obterValorVariavel($cadastro->pessoal->solidario2->dataAdmissao);
	$solidario2_conjuge_cpf = obterValorVariavel($cadastro->pessoal->solidario2->cpfConjuge);

	$solidario3 = obterValorVariavel($cadastro->pessoal->solidario3->nome);
	$solidario3_cpf = obterValorVariavel($cadastro->pessoal->solidario3->cpf);
	$solidario3_fone = obterValorVariavel($cadastro->pessoal->solidario3->telefone);
	$solidario3_ddd = obterValorVariavel($cadastro->pessoal->solidario3->dddTelefone);
	$solidario3_sexo = obterValorVariavel($cadastro->pessoal->solidario3->sexo);
	$solidario3_rg = obterValorVariavel($cadastro->pessoal->solidario3->numDoc);
	$solidario3_renda = obterValorVariavel($cadastro->pessoal->solidario3->rendaMensalBruta);
	$solidario3_orgao_rg = obterValorVariavel($cadastro->pessoal->solidario3->orgaoExpedidor);
	$solidario3_data_emissao_rg = obterValorVariavel($cadastro->pessoal->solidario3->dataEmissao);
	$solidario3_data_valid_doc = obterValorVariavel($cadastro->pessoal->solidario3->dataValidade);
	$solidario3_estado_civil = obterValorVariavel($cadastro->pessoal->solidario3->estadoCivil);
	$solidario3_data_nascimento = obterValorVariavel($cadastro->pessoal->solidario3->dataNascimento);
	$solidario3_grau_parentesco = obterValorVariavel($cadastro->pessoal->solidario3->grauParentesco);
	$solidario3_cep = obterValorVariavel($cadastro->pessoal->solidario3->cep);
	$solidario3_ira_residir = obterValorVariavel($cadastro->pessoal->solidario3->iraResidirImovel);
	$solidario3_natureza_renda = obterValorVariavel($cadastro->pessoal->solidario3->naturezaRenda);
	$solidario3_empresa_trabalho = obterValorVariavel($cadastro->pessoal->solidario3->localTrabalhoTel);
	$solidario3_data_admissao = obterValorVariavel($cadastro->pessoal->solidario3->dataAdmissao);
	$solidario3_conjuge_cpf = obterValorVariavel($cadastro->pessoal->solidario3->cpfConjuge);
	
	
	
	
	$solicitante = obterValorVariavel($cadastro->imovel->solicitante);
	
	if($solicitante != ""){
		
		$pdo = new PDO("mysql:host=localhost;dbname=segurosja;", "segurosja", "m1181s2081_", array());
		$sth = $pdo->prepare("select usuarios_imobs.email from usuarios_imobs where usuarios_imobs.codigo_chavinha = $solicitante and usuarios_imobs.cgc_imob = $CGC_imob");
		$sth->execute();
		$result = $sth->fetch(PDO::FETCH_ASSOC);
		$email_solicitante = $result['email'];
		$pdo = null;
		
	}else{
		$email_solicitante = "";
	}
	
	
    $data_cob = date("Y-m-d");
    $hora_cob = date("H:i:s");
    $seguradora = "ALL";
    //$usuario_upload = "HOTSITE";
	
	$usuario_upload = "HOTSITE";
    if($email_solicitante != ""){
		$usuario_upload = $email_solicitante;
	}
	
    //$tipo_inquilino = "F"; *esta sendo capturado nos dados do pretendente
    $resp_inquilino = "";
    $CPF_resp_inquilino = "";
   	$cep_anterior_inquilino = str_replace(".","", $cep_anterior_inquilino);
   	$cep = str_replace(".","", $cep);

    $conexao = mysql_connect("mysql.segurosja.com.br", "segurosja", "m1181s2081_") or die ("problema na conexão");

    $sql_imob = "select fantasia, razao, corretor, email, (select razao from corretores where corretores.codigo=imobs.corretor) AS NOME_COR, (select email from corretores where corretores.codigo=imobs.corretor) AS EMAIL_COR from imobs where cpf='$CGC_imob'";
    $consulta_imob = mysql_db_query("segurosja", $sql_imob) or die ("problema no SQL imob");
    while($campo_imob = mysql_fetch_assoc($consulta_imob)){
            $razao_imob = $campo_imob['razao'];
            $fantasia_imob = $campo_imob['fantasia'];
            $email_imob = $campo_imob['email'];
            $cod_cor = $campo_imob['corretor'];
            $corretor = $campo_imob['NOME_COR'];
            $email_cor = $campo_imob['EMAIL_COR'];
    }
    if($fantasia_imob <> ""){$IMOB = $fantasia_imob;}
    else{$IMOB = $razao_imob;}

    //se não veio codigo cadastro é inclusão senão é alteração
    if($codigoCadastro == "" || $codigoCadastro == null || $codigoCadastro == "null"){

        $sql = "insert into fianca (data_transm, 
        							hora_transm, 
        							seguradora, 
        							solicitante, 
        							CGC_imob,
                                    inquilino, 
                                    tipo_inquilino, 
                                    CPF_inquilino, 
                                    data_inquilino, 
                                    sexo_inquilino, 
                                    est_civil_inquilino, 
                                    tipo_doc_inquilino, 
                                    rg_inquilino, 
                                    orgao_exp_inquilino, 
                                    data_exp_inquilino, 
                                    data_validade_doc_inquilino, 
                                    resp_inquilino, 
                                    CPF_resp_inquilino,
                                    nome_conjuge_inquilino, 
                                    cpf_conjuge_inquilino, 
                                    data_conjuge_inquilno, 
                                    vai_residir_conjuge_inquilno, 
                                    vai_compor_renda_conjuge_inquilno,
                                    inquilino_vai_compor_renda, 
                                    renda_conjuge_inquilno,
                                    num_dependente_inquilino, 
                                    nome_mae_inquilino, 
                                    nome_pai_inquilino, 
                                    nacionalidade_inquilino, 
                                    pais_inquilino, 
                                    tempo_pais_inquilino, 
                                    resp_locacao_inquilino, 
                                    vai_residir_imov_inquilino, 
                                    tem_renda_arcar_loc_inquilino, 
                                    fone_inquilino,
                                    ddd_inquilino, 
                                    cel_inquilino, 
                                    ddd_cel_inquilino,
                                    email_inquilino,
                                    tempo_resid_inquilino, 
                                    tipo_resid_inquilino, 
                                    imob_prop_atual, 
                                    fone_imob_prop_atual,
                                    ddd_imob_prop_atual, 
                                    resid_emnomede_inquilino, 
                                    arca_com_aluguel_inquilino, 
                                    cep_anterior_inquilino, 
                                    uf_anterior_inquilino, 
                                    cidade_anterior_inquilino, 
                                    endereco_anterior_inquilino, 
                                    bairro_anterior_inquilino, 
                                    complemento_anterior_inquilino, 
                                    num_anterior_inquilino,
                                    empresa_trab_inquilino, 
                                    fone_com_inquilino, 
                                    ddd_com_inquilino,
                                    ramal_com_inquilino, 
                                    profissao_inquilino, 
                                    natureza_renda_inquilino, 
                                    data_admissao_inquilino, 
                                    salario_inquilino, 
                                    outros_rendim_inquilino, 
                                    total_rendim_inquilino, 
                                    empresa_anterior_inquilino, 
                                    endereco_com_inquilino,
                                    ref_bancaria_inquilino, 
                                    banco_inquilino, 
                                    agencia_inquilino, 
                                    ccorrente_inquilino, 
                                    gerente_inquilino, 
                                    fone_gerente_inquilino, 
                                    ddd_gerente_inquilino,
                                    ref_pessoal_nome, 
                                    ref_pessoal_fone, 
                                    ref_pessoal_cel, 
                                    ref_pessoal_grau_parent,
                                    empresa_constituida, 
                                    cnpj_empresa_constituida, 
                                    ramo_atividade_empresa, 
                                    franquia_empresa, 
                                    franqueadora_empresa, 
                                    produtos_servicos_empresa, 
                                    experiencia_ramo_empresa, 
                                    faturam_estim_empresa, 
                                    ret_cap_invest_empresa,
                                    num_solidarios, 
                                    solidario1, 
                                    solidario1_cpf, 
                                    solidario1_fone,
                                    solidario1_ddd, 
                                    solidario1_sexo, 
                                    solidario1_rg, 
                                    solidario1_orgao_rg,
                                    solidario1_data_emissao_rg,
                                    solidario1_data_valid_doc, 
                                    solidario1_estado_civil, 
                                    solidario1_data_nascimento, 
                                    solidario1_grau_parentesco, 
                                    solidario1_cep, 
                                    solidario1_ira_residir, 
                                    solidario1_natureza_renda, 
                                    solidario1_renda,
                                    solidario1_empresa_trabalho, 
                                    solidario1_data_admissao, 
                                    solidario1_conjuge_cpf, 
                                    solidario2, 
                                    solidario2_cpf, 
                                    solidario2_fone,
                                    solidario2_ddd, 
                                    solidario2_sexo, 
                                    solidario2_rg, 
                                    solidario2_orgao_rg,
                                    solidario2_data_emissao_rg,
                                    solidario2_data_valid_doc, 
                                    solidario2_estado_civil, 
                                    solidario2_data_nascimento, 
                                    solidario2_grau_parentesco, 
                                    solidario2_cep, 
                                    solidario2_ira_residir, 
                                    solidario2_natureza_renda, 
                                    solidario2_renda,
                                    solidario2_empresa_trabalho, 
                                    solidario2_data_admissao, 
                                    solidario2_conjuge_cpf, 
                                    solidario3, 
                                    solidario3_cpf, 
                                    solidario3_fone, 
                                    solidario3_ddd,
                                    solidario3_sexo, 
                                    solidario3_rg,
                                    solidario3_orgao_rg, 
                                    solidario3_data_emissao_rg,
                                    solidario3_data_valid_doc, 
                                    solidario3_estado_civil, 
                                    solidario3_data_nascimento, 
                                    solidario3_grau_parentesco, 
                                    solidario3_cep, 
                                    solidario3_ira_residir, 
                                    solidario3_natureza_renda, 
                                    solidario3_renda,
                                    solidario3_empresa_trabalho, 
                                    solidario3_data_admissao, 
                                    solidario3_conjuge_cpf, 
                                    status,
                                    cep, 
                                    endereco, 
                                    numero, 
                                    complemento, 
                                    bairro, 
                                    cidade, 
                                    uf, 
                                    aluguel, 
                                    ocupacao, 
                                    imovel_tipo, 
                                    imovel_tipo_descricao, 
                                    motivo_locacao, 
                                    inicio, 
                                    condominio, 
                                    gas, 
                                    iptu, 
                                    energia, 
                                    agua, 
                                    pintura_int, 
                                    pintura_ext, 
                                    danos, 
                                    multa, 
                                    corretor)
                            values ('$data_cob', 
                            		'$hora_cob', 
                            		'$seguradora', 
                            		'$usuario_upload', 
                            		'$CGC_imob',
								   	'$inquilino', 
								   	'$tipo_inquilino', 
								   	'$CPF_inquilino', 
								   	'$data_inquilino', 
								   	'$sexo_inquilino', 
								   	'$est_civil_inquilino', 
								   	'$tipo_DOC_inquilino', 
								   	'$DOC_inquilino', 
								   	'$orgao_exp_inquilino', 
								   	'$data_exp_inquilino', 
								   	'$data_validade_doc_inquilino', '$resp_inquilino', '$CPF_resp_inquilino',
                                   	'$nome_conjuge_inquilino', 
                                   	'$cpf_conjuge_inquilino', 
                                   	'$data_conjuge_inquilno', 
                                   	'$vai_residir_conjuge_inquilno', 
                                   	'$vai_compor_renda_conjuge_inquilno', 
                                   	'$vai_compor_renda_pretendente',
                                   	'$renda_conjuge_inquilno',
                                   	'$num_dependente_inquilino', 
                                   	'$nome_mae_inquilino', 
                                   	'$nome_pai_inquilino', 
                                   	'$nacionalidade_inquilino', 
                                   	'$pais_inquilino', 
                                   	'$tempo_pais_inquilino', 
                                   	'$resp_locacao_inquilino', 
                                   	'$vai_residir_imov_inquilino', 
                                   	'$tem_renda_arcar_loc_inquilino', 
                                   	'$fone_inquilino', 
                                   	'$ddd_inquilino',
                                   	'$cel_inquilino', 
                                   	'$ddd_cel_inquilino',
                                   	'$email_inquilino',
								   	'$tempo_resid_inquilino', 
								   	'$tipo_resid_inquilino', 
								   	'$nome_imobiliaria', 
								   	'$telefone_imobiliaria', 
								   	'$ddd_telefone_imobiliaria',
								   	'$resid_emnomede_inquilino', 
								   	'$arca_com_aluguel_inquilino', 
								   	'$cep_anterior_inquilino', 
								   	'$uf_anterior_inquilino', 
								   	'$cidade_anterior_inquilino', 
								   	'$endereco_anterior_inquilino', 
								   	'$bairro_anterior_inquilino', 
								   	'$complemento_anterior_inquilino', 
								   	'$num_anterior_inquilino',
                                   	'$empresa_trab_inquilino', 
                                   	'$fone_com_inquilino', 
                                   	'$ddd_com_inquilino',
                                   	'$ramal_com_inquilino', 
                                   	'$profissao_inquilino', 
                                   	'$natureza_renda_inquilino', 
                                   	'$data_admissao_inquilino', 
                                   	'$salario_inquilino', 
                                   	'$outros_rendim_inquilino', 
                                   	'$total_rendim_inquilino', 
                                   	'$empresa_anterior_inquilino', 
                                   	'$endereco_com_inquilino',
                                   	'$ref_bancaria_inquilino', 
                                   	'$banco_inquilino', 
                                   	'$agencia_inquilino', 
                                   	'$ccorrente_inquilino', 
                                   	'$gerente_inquilino', 
                                   	'$fone_gerente_inquilino', 
                                   	'$ddd_gerente_inquilino',
                                   	'$ref_pessoal_nome', 
                                   	'$ref_pessoal_fone', 
                                   	'$ref_pessoal_cel', 
                                   	'$ref_pessoal_grau_parent',
                                   	'$empresa_constituida', 
                                   	'$cnpj_empresa_constituida', 
                                   	'$ramo_atividade_empresa',	
                                   	'$franquia_empresa', 
                                   	'$franqueadora_empresa', 
                                   	'$produtos_servicos_empresa', 
                                   	'$experiencia_ramo_empresa', 
                                   	'$faturam_estim_empresa', 
                                   	'$ret_cap_invest_empresa',
                                   	'$num_solidarios', 
                                   	'$solidario1', 
                                   	'$solidario1_cpf', 
                                   	'$solidario1_fone',
                                   	'$solidario1_ddd', 
                                   	'$solidario1_sexo', 
                                   	'$solidario1_rg',
                                   	'$solidario1_orgao_rg', 
                                   	'$solidario1_data_emissao_rg',
                                   	'$solidario1_data_valid_doc', 
                                   	'$solidario1_estado_civil', 
                                   	'$solidario1_data_nascimento', 
                                   	'$solidario1_grau_parentesco', 
                                   	'$solidario1_cep', 
                                   	'$solidario1_ira_residir', 
                                   	'$solidario1_natureza_renda', 
                                   	'$solidario1_renda',
                                   	'$solidario1_empresa_trabalho', 
                                   	'$solidario1_data_admissao', 
                                   	'$solidario1_conjuge_cpf', 
                                   	'$solidario2', 
                                   	'$solidario2_cpf', 
                                   	'$solidario2_fone',
                                   	'$solidario2_ddd', 
                                   	'$solidario2_sexo', 
                                   	'$solidario2_rg', 
                                   	'$solidario2_orgao_rg',
                                   	'$solidario2_data_emissao_rg',
                                   	'$solidario2_data_valid_doc', 
                                   	'$solidario2_estado_civil', 
                                   	'$solidario2_data_nascimento', 
                                   	'$solidario2_grau_parentesco', 
                                   	'$solidario2_cep', 
                                   	'$solidario2_ira_residir', 
                                   	'$solidario2_natureza_renda', 
                                   	'$solidario2_renda',
                                   	'$solidario2_empresa_trabalho', 
                                   	'$solidario2_data_admissao', 
                                   	'$solidario2_conjuge_cpf',
                                   	'$solidario3', 
                                   	'$solidario3_cpf', 
                                   	'$solidario3_fone',
                                   	'$solidario3_ddd', 
                                   	'$solidario3_sexo', 
                                   	'$solidario3_rg',
                                   	'$solidario3_orgao_rg', 
                                   	'$solidario3_data_emissao_rg',
                                   	'$solidario3_data_valid_doc', 
                                   	'$solidario3_estado_civil', 
                                   	'$solidario3_data_nascimento', 
                                   	'$solidario3_grau_parentesco', 
                                   	'$solidario3_cep', 
                                   	'$solidario3_ira_residir', 
                                   	'$solidario3_natureza_renda', 
                                   	'$solidario3_renda',
                                   	'$solidario3_empresa_trabalho', 
                                   	'$solidario3_data_admissao', 
                                   	'$solidario3_conjuge_cpf',
                                   	'$statusCadastro',
								   	'$cep', 
								   	'$endereco', 
								   	'$numero', 
								   	'$complemento', 
								   	'$bairro', 
								   	'$cidade', 
								   	'$uf', 
								   	'$aluguel',
								   	'$ocupacao', 
								   	'$imovel_tipo', 
								   	'$imovel_tipo_descricao', 
								   	'$motivo_locacao', 
								   	'$inicio', 
								   	'$condominio', 
								   	'$gas', 
								   	'$iptu', 
								   	'$energia', 
								   	'$agua', 
								   	'$pintura_int', 
								   	'$pintura_ext', 
								   	'$danos', 
								   	'$multa',
							       	'$cod_cor')";
							       
        $sql = str_replace("null", "", $sql);

    }else{
    	$sql = "UPDATE fianca set 
		inquilino='$inquilino',
		tipo_inquilino='$tipo_inquilino',
		CPF_inquilino='$CPF_inquilino',
		data_inquilino='$data_inquilino',
		tipo_doc_inquilino = '$tipo_DOC_inquilino',
		sexo_inquilino='$sexo_inquilino',
		est_civil_inquilino='$est_civil_inquilino',
		rg_inquilino='$DOC_inquilino',
		orgao_exp_inquilino='$orgao_exp_inquilino',
		data_exp_inquilino='$data_exp_inquilino',
		data_validade_doc_inquilino='$data_validade_doc_inquilino',
		resp_inquilino='$resp_inquilino',
		CPF_resp_inquilino='$CPF_resp_inquilino',
		nome_conjuge_inquilino='$nome_conjuge_inquilino',
		cpf_conjuge_inquilino='$cpf_conjuge_inquilino',
		nome_conjuge_inquilino='$nome_conjuge_inquilino',
        cpf_conjuge_inquilino='$cpf_conjuge_inquilino',
        data_conjuge_inquilno='$data_conjuge_inquilno',
        vai_residir_conjuge_inquilno='$vai_residir_conjuge_inquilno',
        vai_compor_renda_conjuge_inquilno='$vai_compor_renda_conjuge_inquilno',
        inquilino_vai_compor_renda='$vai_compor_renda_pretendente',
        renda_conjuge_inquilno='$renda_conjuge_inquilno',
		num_dependente_inquilino='$num_dependente_inquilino',
		nome_mae_inquilino='$nome_mae_inquilino',
		nome_pai_inquilino='$nome_pai_inquilino',
		nacionalidade_inquilino='$nacionalidade_inquilino',
		pais_inquilino='$pais_inquilino',
		tempo_pais_inquilino='$tempo_pais_inquilino',
		resp_locacao_inquilino='$resp_locacao_inquilino',
		vai_residir_imov_inquilino='$vai_residir_imov_inquilino',
		tem_renda_arcar_loc_inquilino='$tem_renda_arcar_loc_inquilino',
		fone_inquilino='$fone_inquilino',
		ddd_inquilino= '$ddd_inquilino',
		cel_inquilino='$cel_inquilino',
		ddd_cel_inquilino= '$ddd_cel_inquilino',
		email_inquilino='$email_inquilino',
		tempo_resid_inquilino='$tempo_resid_inquilino',
		tipo_resid_inquilino='$tipo_resid_inquilino',
		imob_prop_atual='$nome_imobiliaria',
		fone_imob_prop_atual='$telefone_imobiliaria',
		ddd_imob_prop_atual = '$ddd_telefone_imobiliaria',
		resid_emnomede_inquilino='$resid_emnomede_inquilino',
		arca_com_aluguel_inquilino='$arca_com_aluguel_inquilino',
		cep_anterior_inquilino='$cep_anterior_inquilino',
		uf_anterior_inquilino='$uf_anterior_inquilino',
		cidade_anterior_inquilino='$cidade_anterior_inquilino',
		endereco_anterior_inquilino='$endereco_anterior_inquilino',
		bairro_anterior_inquilino='$bairro_anterior_inquilino',
		complemento_anterior_inquilino='$complemento_anterior_inquilino',
		num_anterior_inquilino='$num_anterior_inquilino',
		empresa_trab_inquilino='$empresa_trab_inquilino',
		fone_com_inquilino='$fone_com_inquilino',
		ddd_com_inquilino= '$ddd_com_inquilino',
		ramal_com_inquilino='$ramal_com_inquilino',
		profissao_inquilino='$profissao_inquilino',
		natureza_renda_inquilino='$natureza_renda_inquilino',
		data_admissao_inquilino='$data_admissao_inquilino',
		salario_inquilino='$salario_inquilino',
		outros_rendim_inquilino='$outros_rendim_inquilino',
		total_rendim_inquilino='$total_rendim_inquilino',
		empresa_anterior_inquilino='$empresa_anterior_inquilino',
		endereco_com_inquilino='$endereco_com_inquilino',
		ref_bancaria_inquilino='$ref_bancaria_inquilino',
		banco_inquilino='$banco_inquilino',
		agencia_inquilino='$agencia_inquilino',
		ccorrente_inquilino='$ccorrente_inquilino',
		gerente_inquilino='$gerente_inquilino',
		fone_gerente_inquilino='$fone_gerente_inquilino',
		ddd_gerente_inquilino = '$ddd_gerente_inquilino',
		ref_pessoal_nome='$ref_pessoal_nome',
		ref_pessoal_fone='$ref_pessoal_fone',
		ref_pessoal_cel='$ref_pessoal_cel',
		ref_pessoal_grau_parent='$ref_pessoal_grau_parent',
		empresa_constituida='$empresa_constituida',
		cnpj_empresa_constituida='$cnpj_empresa_constituida',
		ramo_atividade_empresa='$ramo_atividade_empresa',
		franquia_empresa='$franquia_empresa',
		franqueadora_empresa='$franqueadora_empresa',
		produtos_servicos_empresa='$produtos_servicos_empresa',
		experiencia_ramo_empresa='$experiencia_ramo_empresa',
		faturam_estim_empresa='$faturam_estim_empresa',
		ret_cap_invest_empresa='$ret_cap_invest_empresa',
		num_solidarios='$num_solidarios',
		solidario1='$solidario1',
		solidario1_cpf='$solidario1_cpf',
		solidario1_fone='$solidario1_fone',
		solidario1_ddd= '$solidario1_ddd',
		solidario1_sexo='$solidario1_sexo',
		solidario1_rg='$solidario1_rg',
		solidario1_orgao_rg = '$solidario1_orgao_rg',
		solidario1_data_emissao_rg = '$solidario1_data_emissao_rg',
		solidario1_data_valid_doc = '$solidario1_data_valid_doc',
		solidario1_estado_civil = '$solidario1_estado_civil',
		solidario1_data_nascimento = '$solidario1_data_nascimento',
		solidario1_grau_parentesco = '$solidario1_grau_parentesco',
		solidario1_cep = '$solidario1_cep',
		solidario1_ira_residir = '$solidario1_ira_residir',
		solidario1_natureza_renda = '$solidario1_natureza_renda',
		solidario1_renda = '$solidario1_renda',
		solidario1_empresa_trabalho = '$solidario1_empresa_trabalho',
		solidario1_data_admissao = '$solidario1_data_admissao',
		solidario1_conjuge_cpf = '$solidario1_conjuge_cpf',
		solidario2='$solidario2',
		solidario2_cpf='$solidario2_cpf',
		solidario2_fone='$solidario2_fone',
		solidario2_ddd= '$solidario2_ddd',
		solidario2_sexo='$solidario2_sexo',
		solidario2_rg='$solidario2_rg',
		solidario2_orgao_rg = '$solidario2_orgao_rg',
		solidario2_data_emissao_rg = '$solidario2_data_emissao_rg',
		solidario2_data_valid_doc = '$solidario2_data_valid_doc',
		solidario2_estado_civil = '$solidario2_estado_civil',
		solidario2_data_nascimento = '$solidario2_data_nascimento',
		solidario2_grau_parentesco = '$solidario2_grau_parentesco',
		solidario2_cep = '$solidario2_cep',
		solidario2_ira_residir = '$solidario2_ira_residir',
		solidario2_natureza_renda = '$solidario2_natureza_renda',
		solidario2_renda = '$solidario2_renda',
		solidario2_empresa_trabalho = '$solidario2_empresa_trabalho',
		solidario2_data_admissao = '$solidario2_data_admissao',
		solidario2_conjuge_cpf = '$solidario2_conjuge_cpf',
		solidario3='$solidario3',
		solidario3_cpf='$solidario3_cpf', 
		solidario3_fone='$solidario3_fone',
		solidario3_ddd= '$solidario3_ddd',
		solidario3_sexo='$solidario3_sexo',
		solidario3_rg='$solidario3_rg',
		solidario3_orgao_rg = '$solidario3_orgao_rg',
		solidario3_data_emissao_rg = '$solidario3_data_emissao_rg',
		solidario3_data_valid_doc = '$solidario3_data_valid_doc',
		solidario3_estado_civil = '$solidario3_estado_civil',
		solidario3_data_nascimento = '$solidario3_data_nascimento',
		solidario3_grau_parentesco = '$solidario3_grau_parentesco',
		solidario3_cep = '$solidario3_cep',
		solidario3_ira_residir = '$solidario3_ira_residir',
		solidario3_natureza_renda = '$solidario3_natureza_renda',
		solidario3_renda = '$solidario3_renda',
		solidario3_empresa_trabalho = '$solidario3_empresa_trabalho',
		solidario3_data_admissao = '$solidario3_data_admissao',
		solidario3_conjuge_cpf = '$solidario3_conjuge_cpf',
		status = '$statusCadastro',
		cep='$cep',
		endereco='$endereco',
		numero='$numero',
		quadra='$quadra',
		lote='$lote',
		complemento='$complemento',
		bairro='$bairro',
		cidade='$cidade',
		uf='$uf',
		aluguel='$aluguel',
		ocupacao='$ocupacao',
		imovel_tipo='$imovel_tipo',
		imovel_tipo_descricao = '$imovel_tipo_descricao',
		motivo_locacao='$motivo_locacao',
		condominio='$condominio',
		gas='$gas',
		iptu='$iptu',
		energia='$energia',
		agua='$agua'
		WHERE codigo=$codigoCadastro";
    }

   
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

    $mensagem = "<html><body><div align='center'><b>** Análise de Cadastro para Fiança Locatícia nº: ". $registro . " **</b><BR>" . $inquilino . "<BR><BR>";
    $mensagem .= "
        <HR></div><div align='left'>
        <b>Imobiliária:</b> ".$IMOB." - <b>Corretor:</b> ".$corretor."<BR>
        </div><div align='center'><HR></div><div align='left'>
        <b>Pretendente:</b> ".$inquilino." - <b>Tipo Pessoa:</b> ".$tipo_inquilino." - <b>CPF/CNPJ:</b> ".$CPF_inquilino."<BR>
        <b>Data de Nascimento:</b> ".$data_inquilino." - <b>Sexo:</b> ".$sexo_inquilino." - <b>Estado Civil:</b> ".$est_civil_inquilino."<BR>
        <b>RG/Documento:</b> ".$tipo_DOC_inquilino." - <b>Órgão Expedidor:</b> ".$orgao_exp_inquilino." - <b>Data de Expedição do Documento:</b> ".$data_exp_inquilino." - <b>Validade:</b> ".$data_validade_doc_inquilino."<BR>
        <b>Responsável pela PJ:</b> ".$resp_inquilino." - <b>CPF:</b> ".$CPF_resp_inquilino."<BR>
        <b>Telefone:</b> ".$ddd_inquilino." ".$fone_inquilino." - <b>Celular:</b> ".$ddd_cel_inquilino." ".$cel_inquilino." - <b>E-mail:</b> ".$email_inquilino."<BR>
        </div><div align='center'><HR></div><div align='left'>
		<b>Nome do Cônjuge:</b> ".$nome_conjuge_inquilino." - <b>Data de Nascimento do Cônjuge:</b> ".$data_conjuge_inquilno."<BR>
        <b>CPF Cônjuge:</b> ".$cpf_conjuge_inquilino." - <b>Número de Dependentes:</b> ".$num_dependente_inquilino."<BR>
        <b>Nome da Mãe:</b> ".$nome_mae_inquilino." - <b>Nome do Pai:</b> ".$nome_pai_inquilino."<BR>
        <b>Nacionalidade Pretendente:</b> ".$nacionalidade_inquilino." - <b>País:</b> ".$pais_inquilino." - <b>Tempo no País:</b> ".$tempo_pais_inquilino."<BR>
        </div><div align='center'><HR></div><div align='left'>
        <b>Responsável pela Locação:</b> ".$resp_locacao_inquilino." - <b>Inquilino vai residir no imóvel?</b> ".$vai_residir_imov_inquilino." - <b>Tem renda para arcar com a locação?</b> ".$tem_renda_arcar_loc_inquilino."<BR>
        <b>Tempo de residência atual:</b> ".$tempo_resid_inquilino." - <b>Tipo de Residência:</b> ".$tipo_resid_inquilino." -
        <b>Imobiliária/Proprietário Atual:</b> ".$imob_prop_atual." - <b>Telefone:</b> ".$ddd_telefone_imobiliaria." ".$telefone_imobiliaria." - <b>Residência em Nome de quem?</b> ".$resid_emnomede_inquilino."<BR>
        <b>Arca com aluguel?</b> ".$arca_com_aluguel_inquilino."<b>CEP Atual:</b> ".$cep_anterior_inquilino." - <b>UF:</b> ".$uf_anterior_inquilino." - <b>Cidade:</b> ".$cidade_anterior_inquilino."<BR>
        <b>Endereço Atual:</b> ".$endereco_anterior_inquilino." - <b>Número:</b> ".$num_anterior_inquilino." - <b>Complemento:</b> ".$complemento_anterior_inquilino." - <b>Bairro:</b> ".$bairro_anterior_inquilino."<BR>
        </div><div align='center'><HR></div><div align='left'>
        <b>Empresa que Trabalha:</b> ".$empresa_trab_inquilino." - <b>Telefone:</b> ".$ddd_com_inquilino." ".$fone_com_inquilino." - <b>Ramal:</b> ".$ramal_com_inquilino." - <b>Data de Admissão:</b> ".$data_admissao_inquilino." - <b>Endereço Comercial:</b> ".$endereco_com_inquilino."<BR>
        <b>Profissão:</b> ".$profissao_inquilino." - <b>Natureza da Renda:</b> ".$natureza_renda_inquilino." - <b>Salário:</b> ".$salario_inquilino."<BR>
        <b>Ourtos Rendimentos:</b> ".$outros_rendim_inquilino." - <b>Total de Outros Rendimentos:</b> ".$total_rendim_inquilino."<BR>
        <b>Empresa que trabalhou Anteriormente:</b> ".$empresa_anterior_inquilino."<BR>
        </div><div align='center'><HR></div><div align='left'>
        <b>Referência Bancária:</b> ".$ref_bancaria_inquilino." - <b>Banco:</b> ".$banco_inquilino." - <b>Agência:</b> ".$agencia_inquilino." - <b>Conta Corrente:</b> ".$ccorrente_inquilino."<BR>
        <b>Gerente da Conta:</b> ".$gerente_inquilino." - <b>Telefone:</b> ".$ddd_gerente_inquilino." ".$fone_gerente_inquilino."<BR>
        <b>Referência Pessoal:</b> ".$ref_pessoal_nome." - <b>Telefone:</b> ".$ref_pessoal_fone." - <b>Celular:</b> ".$ref_pessoal_cel." - <b>Grau de Parentesco/Relacionamento:</b> ".$ref_pessoal_grau_parent."<BR>
        </div><div align='center'><HR></div><div align='left'>
        <b>Número de Locatários Solidários:</b> ".$num_solidarios."<BR>
        <b>Nome do Solidário 1:</b> ".$solidario1." - <b>CPF/CNPJ:</b> ".$solidario1_cpf." - <b>Sexo:</b> ".$solidario1_sexo." - <b>RG:</b> ".$solidario1_rg." - <b>Órgão Expedidor:</b> ".$solidario1_orgao_rg." - <b>Data de Expedição:</b> ".$solidario1_data_emissao_rg." - <b>Validade Doc:</b> ".$solidario1_data_valid_doc." - <b>Estado Civíl:</b> ".$solidario1_estado_civil." - <b>Data Nascimento:</b> ".$solidario1_data_nascimento." - <b>Grau Parentesco:</b> ".$solidario1_grau_parentesco." - <b>Cep:</b> ".$solidario1_cep." - <b>Irá Residir:</b> ".$solidario1_ira_residir." - <b>Natureza Renda:</b> ".$solidario1_natureza_renda." - <b>Empresa Local trabalho:</b> ".$solidario1_empresa_trabalho." - <b>Data Admissão:</b> ".$solidario1_data_admissao." - <b>CPF Conjuge:</b> ".$solidario1_conjuge_cpf." - <b>Telefone:</b> ".$solidario1_ddd." ".$solidario1_fone."<BR>
        <b>Nome do Solidário 2:</b> ".$solidario2." - <b>CPF/CNPJ:</b> ".$solidario2_cpf." - <b>Sexo:</b> ".$solidario2_sexo." - <b>RG:</b> ".$solidario2_rg." - <b>Órgão Expedidor:</b> ".$solidario2_orgao_rg." - <b>Data de Expedição:</b> ".$solidario2_data_emissao_rg." - <b>Validade Doc:</b> ".$solidario2_data_valid_doc." - <b>Estado Civíl:</b> ".$solidario2_estado_civil." - <b>Data Nascimento:</b> ".$solidario2_data_nascimento." - <b>Grau Parentesco:</b> ".$solidario2_grau_parentesco." - <b>Cep:</b> ".$solidario2_cep." - <b>Irá Residir:</b> ".$solidario2_ira_residir." - <b>Natureza Renda:</b> ".$solidario2_natureza_renda." - <b>Empresa Local trabalho:</b> ".$solidario2_empresa_trabalho." - <b>Data Admissão:</b> ".$solidario2_data_admissao." - <b>CPF Conjuge:</b> ".$solidario2_conjuge_cpf." - <b>Telefone:</b> ".$solidario2_ddd." ".$solidario2_fone."<BR>
        <b>Nome do Solidário 3:</b> ".$solidario3." - <b>CPF/CNPJ:</b> ".$solidario3_cpf." - <b>Sexo:</b> ".$solidario3_sexo." - <b>RG:</b> ".$solidario3_rg." - <b>Órgão Expedidor:</b> ".$solidario3_orgao_rg." - <b>Data de Expedição:</b> ".$solidario3_data_emissao_rg." - <b>Validade Doc:</b> ".$solidario3_data_valid_doc." - <b>Estado Civíl:</b> ".$solidario3_estado_civil." - <b>Data Nascimento:</b> ".$solidario3_data_nascimento." - <b>Grau Parentesco:</b> ".$solidario3_grau_parentesco." - <b>Cep:</b> ".$solidario3_cep." - <b>Irá Residir:</b> ".$solidario3_ira_residir." - <b>Natureza Renda:</b> ".$solidario3_natureza_renda." - <b>Empresa Local trabalho:</b> ".$solidario3_empresa_trabalho." - <b>Data Admissão:</b> ".$solidario3_data_admissao." - <b>CPF Conjuge:</b> ".$solidario3_conjuge_cpf." - <b>Telefone:</b> ".$solidario3_ddd." ".$solidario3_fone."<BR>
        </div><div align='center'><HR></div><div align='left'>
        <b>CEP do Imóvel Pretendido:</b> ".$cep." - <b>Endereço:</b> ".$endereco." - <b>Número:</b> ".$numero." - <b>Quadra:</b> ".$quadra." - <b>Lote:</b> ".$lote." - <b>Complemento:</b> ".$complemento."<BR>
        <b>Bairro:</b> ".$bairro." - <b>Cidade:</b> ".$cidade." - <b>UF:</b> ".$uf."<BR>
        <b>Finalidade da Locação:</b> ".$ocupacao." - <b>Tipo do Imóvel:</b> ".$imovel_tipo." - <b>Motivo da Locação:</b> ".$motivo_locacao."<BR>
        </div><div align='center'><HR></div><div align='left'>
        <b>Aluguel:</b> ".$aluguel." - <b>Condomínio:</b> ".$condominio." - <b>Gás:</b> ".$gas." - <b>IPTU:</b> ".$iptu." - <b>Energia:</b> ".$energia." - <b>Água:</b> ".$agua."
        </div><div align='center'><HR></div>";
    $mensagem .= "<div align='center'><font size='2'>Data e hora de envio: ".$data_cob." - ".$hora_cob." - Seg: ".$seguradora." - Usuário: ".$usuario_upload."</font></div></body></html>";
/*
    // Inclui o arquivo class.phpmailer.php localizado na pasta phpmailer
    require("../../../../adm/phpmailer/class.phpmailer.php");
    // Inicia a classe PHPMailer
    $mail = new PHPMailer();
    // Define os dados do servidor e tipo de conexão
    $mail->IsSMTP(); // Define que a mensagem será SMTP
    $mail->Host = "smtp.segurosja.com.br"; // Endereço do servidor SMTP (caso queira utilizar a autenticação, utilize o host smtp.seudomínio.com.br)
    $mail->SMTPAuth = true; // Usar autenticação SMTP (obrigatório para smtp.seudomínio.com.br)
    $mail->Username = 'cobertura=segurosja.com.br'; // Usuário do servidor SMTP (endereço de email)
    $mail->Password = 'm1181s2081_'; // Senha do servidor SMTP (senha do email usado)
    // Define o remetente
    $mail->From = "cobertura@segurosja.com.br"; // Seu e-mail
    $mail->Sender = "cobertura@segurosja.com.br"; // Seu e-mail
    $mail->FromName = "Seguros Já! Cadastro"; // Seu nome
    $mail->AddReplyTo("$email_cor"); // Email para receber as respostas
    // Define os dados técnicos da Mensagem
    $mail->IsHTML(true); // Define que o e-mail será enviado como HTML
    $mail->CharSet = 'UTF-8'; // Charset da mensagem (opcional)

    if($cod_cor == "0"){$mail->AddAddress('cadastro@maximizaseguros.com.br');$mail->AddCC('aluguel@mx10.com.br');$mail->AddCC('aluguel2@maximizaseguros.com.br');$mail->AddCC('cadastro@mx10.com.br');}
    else if($cod_cor == "10"){$mail->AddAddress("cadastro.df@maximizaseguros.com.br");$mail->AddCC("aluguel.df@maximizaseguros.com.br");}
    else if($cod_cor == "8"){$mail->AddAddress("mt@maximizaseguros.com.br");$mail->AddCC("mt@mx10.com.br");}
    else if($cod_cor == "6"){$mail->AddAddress('cadastro@maximizaseguros.com.br');$mail->AddCC('aluguel@mx10.com.br');$mail->AddCC('aluguel2@maximizaseguros.com.br');$mail->AddCC('cadastro@mx10.com.br');}
    else if($cod_cor == "5"){$mail->AddAddress('ccavalcante@riolupo.com.br');$mail->AddBCC('clemente@mx10.com.br');$mail->AddBCC('leandro@maximizaseguros.com.br');}
    else if($cod_cor == "11"){$mail->AddAddress('ba@maximizaseguros.com.br');$mail->AddBCC('eduardo@maximizaseguros.com.br');$mail->AddBCC('silmara@maximizaseguros.com.br');}
    else{$mail->AddBCC("clemente@maximizaseguros.com.br");}
    $mail->AddCC("$email_imob");
    $mail->AddBCC("leandro@mx10.com.br");

    $mail->Body = $mensagem;//apagar
    $mail->Subject = "Análise de Fiança " . $registro . " - " . $inquilino; //apagar
    $enviado = $mail->Send();//apagar

    // Limpa os destinatários e os anexos
    $mail->ClearAllRecipients();
    $mail->ClearAttachments();
    // Exibe uma mensagem de resultado
    if($enviado){$retorno_mail = "E-mail(s) enviado(s) com sucesso!";}
    else{
        $retorno_mail = "Não foi possível enviar o(s) e-mail(s).";
        $retorno_mail .= " Informações do erro: " . $mail->ErrorInfo;
    }
*/
    mysql_close($conexao);

    //echo $retorno_mail;
    return $registro;
}

function obterValorVariavel($variavel){
	$valor = utf8_decode(trim(json_encode($variavel, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES), '"'));
	if($valor == "null"){
		return "";
	}else{
		return $valor;
	}
}

$app->run();

?>
