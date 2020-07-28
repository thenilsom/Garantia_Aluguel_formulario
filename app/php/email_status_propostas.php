<?php
 header("Access-Control-Allow-Origin: *");
 header("Access-Control-Allow-Methods: GET,PUT,POST,DELETE");
 header("Access-Control-Allow-Headers: Content-Type, Authorization");

$codigos_corretora = array(
	'0'  => 'MAXIMIZA GO',  //SUSEP GO 
	'10' => 'MAXIMIZA DF',  //SUSEP DF
	'6'  => 'MAXIMIZA TO',  //SUSEP TO
	'11' => 'MAXIMIZA BA',  //SUSEP BA
	'8'  => 'MAXIMIZA MT'   //SUSEP MT
);

function checkmail($mail)
{
	if((strpos ($mail, '@') !== false) && (strpos ($mail, ".") !==false))
	{                   
		return true;
	}
	else
	{
		return false;
	}
}

function valida_email($email){
	if(substr($email, -16) != "naoenviar.com.br")
	   return true;
	else
	   return false;
}

$cor_liberty = '';
$cor_porto   = '';
$cor_too     = '';

$solidario1_conjuge_cpf = '';
$solidario2_conjuge_cpf = '';
$solidario3_conjuge_cpf = '';

$div_solidarios  = '';
$div_solidarios1 = '';
$div_solidarios2 = '';
$div_solidarios3 = '';

$codigo = '';
if((isset($_POST['codigo'])) && (!empty($_POST['codigo']))){
	
	$codigo = $_POST['codigo'];
	
	  $pdo = new PDO("mysql:host=localhost;dbname=segurosja;", "segurosja", "m1181s2081_", array());
	 
	  //$pdo = new PDO("mysql:host=localhost;dbname=segurosja;", "root", "", array());
	
	$sql = "SELECT 
				fianca.codigo,
				motivo_locacao,
				CPF_inquilino,
				inquilino,
				fone_inquilino,
				fone_com_inquilino,
				ramal_com_inquilino,
				cel_inquilino,
				email_inquilino,
				data_inquilino,
				tipo_doc_inquilino,
				rg_inquilino,
				num_dependente_inquilino,
				data_exp_inquilino,
				vai_residir_imov_inquilino,
				orgao_exp_inquilino,
				tempo_pais_inquilino,
				est_civil_inquilino,
				sexo_inquilino,
				nome_mae_inquilino,
				nome_pai_inquilino,
				nacionalidade_inquilino,
				vai_residir_imov_inquilino,
				vai_residir_conjuge_inquilno,
				vai_compor_renda_conjuge_inquilno,
				profissao_inquilino,
				salario_inquilino,
				ref_bancaria_inquilino,
				resid_emnomede_inquilino,
				empresa_anterior_inquilino,
				data_admissao_inquilino,
				cpf_conjuge_inquilino,
				aluguel,
				cep_anterior_inquilino,
				endereco_anterior_inquilino,
				num_anterior_inquilino,
				complemento_anterior_inquilino,
				bairro_anterior_inquilino,
				cidade_anterior_inquilino,
				uf_anterior_inquilino,
				tempo_resid_inquilino,
				empresa_trab_inquilino,
				fianca.ocupacao,
				tipo_resid_inquilino,
				natureza_renda_inquilino,
				aluguel,
				agua,
				energia,
				iptu,
				gas,
				imobs.razao as imobiliaria_razao,
				condominio,
				fianca.cep,
				tipo_inquilino,
				imovel_tipo,
				danos,
				multa,
				pintura_int,
				pintura_ext,
				nome_conjuge_inquilino,
				cpf_conjuge_inquilino,
				data_conjuge_inquilno,
				renda_conjuge_inquilno,
				fianca.uf,
				fianca.cidade,
				fianca.bairro,
				fianca.complemento,
				fianca.lote,
				fianca.quadra,
				fianca.numero,
				fianca.endereco,
				fianca.cep,
				outros_rendim_inquilino,
				total_rendim_inquilino,
				imob_prop_atual,
				fone_imob_prop_atual,
				carta_of_lib_fianca,
				fianca.corretor,
				num_solidarios,
				solidario1,
				solidario1_cpf,
				solidario1_renda,
				solidario1_fone,
				solidario1_sexo,
				solidario1_rg,
				solidario1_orgao_rg,
				solidario1_data_emissao_rg,
				solidario1_data_nascimento,
				solidario1_estado_civil,
				solidario1_cep,
				solidario1_natureza_renda,
				solidario1_empresa_trabalho,
				solidario1_data_admissao,
				solidario1_conjuge_cpf,
				solidario1_ira_residir,
				solidario1_grau_parentesco,
				solidario2,
				solidario2_cpf,
				solidario2_renda,
				solidario2_fone,
				solidario2_sexo,
				solidario2_rg,
				solidario2_orgao_rg,
				solidario2_data_emissao_rg,
				solidario2_data_nascimento,
				solidario2_estado_civil,
				solidario2_cep,
				solidario2_natureza_renda,
				solidario2_empresa_trabalho,
				solidario2_data_admissao,
				solidario2_conjuge_cpf,
				solidario2_ira_residir,
				solidario2_grau_parentesco,
				solidario3,
				solidario3_cpf,
				solidario3_renda,
				solidario3_fone,
				solidario3_sexo,
				solidario3_rg,
				solidario3_orgao_rg,
				solidario3_data_emissao_rg,
				solidario3_data_nascimento,
				solidario3_estado_civil,
				solidario3_cep,
				solidario3_natureza_renda,
				solidario3_empresa_trabalho,
				solidario3_data_admissao,
				solidario3_conjuge_cpf,
				solidario3_ira_residir,
				solidario3_grau_parentesco,
				situacao_analise_porto,
				situacao_analise_liberty,
				situacao_analise_too,
				corretores.email as email_corretor,
				corretores.razao as corretora_razao,
                resp_inquilino,
                CPF_resp_inquilino,
                resp_locacao_inquilino,
                data_validade_doc_inquilino,
                data_validade_doc_inquilino,
                tem_renda_arcar_loc_inquilino,
                ccorrente_inquilino,
                agencia_inquilino,
                banco_inquilino,
                data_transm,
                hora_transm,
                seguradora,
                solicitante,
				processo_porto,
                processo_liberty,
			    processo_too,
                imobs.email as email_imobs,
                imobs.email_alt1,
                imobs.email_alt2,
                imobs.email_alt3,
				imobs.fantasia
			FROM  
				fianca, imobs, corretores
			WHERE 
				imobs.cpf = fianca.CGC_imob
			AND fianca.corretor = corretores.codigo
			AND fianca.codigo = $codigo";
	
	$sth = $pdo->prepare($sql);
	$sth->execute();
	$dados_fianca = $sth->fetch(PDO::FETCH_ASSOC);
	
	
	
	if(!empty($dados_fianca)){
		
		$profissao_inquilino = $dados_fianca['profissao_inquilino'];
	
		if(!empty(trim($profissao_inquilino))){
			
			$sql = "SELECT ocupacao as profissao_inquilino_descricao FROM profissao_cbo WHERE codigo_cbo = $profissao_inquilino";
			$sth = $pdo->prepare($sql);
			$sth->execute();
			$dados_cbo = $sth->fetch(PDO::FETCH_ASSOC);
			
			$dados_fianca['profissao_inquilino_descricao'] = $dados_cbo['profissao_inquilino_descricao'];
			
		}else{
			$dados_fianca['profissao_inquilino_descricao'] = '';
		}
		
		$pdo = null;	

		if($dados_fianca['tipo_inquilino'] == 'F'){
			$dados_fianca['tipo_inquilino'] = 'Física';
		}elseif($dados_fianca['tipo_inquilino'] == 'J'){
			$dados_fianca['tipo_inquilino'] = 'Jurídica';
		}

		if($dados_fianca['vai_compor_renda_conjuge_inquilno'] == 'N'){
			$dados_fianca['vai_compor_renda_conjuge_inquilno'] = 'NÃO';
		}elseif($dados_fianca['vai_compor_renda_conjuge_inquilno'] == 'S'){
			$dados_fianca['vai_compor_renda_conjuge_inquilno'] = 'SIM';
		}

		if($dados_fianca['tem_renda_arcar_loc_inquilino'] == 'N'){
			$dados_fianca['tem_renda_arcar_loc_inquilino'] = 'NÃO';
		}elseif($dados_fianca['tem_renda_arcar_loc_inquilino'] == 'S'){
			$dados_fianca['tem_renda_arcar_loc_inquilino'] = 'SIM';
		}
		
		if($dados_fianca['situacao_analise_porto'] == "Aprovado - Finalizado"){
			$cor_porto = "green";
			$status_porto = "Aprovado";
		}elseif($dados_fianca['situacao_analise_porto'] == "Recusado pela Analise de Risco - Finalizado"){
			$cor_porto = "red";
			$status_porto = "Recusado";
		}else{
			$cor_porto   = "black";
			$status_porto = "Em Análise";
		}
		
		
		if($dados_fianca['situacao_analise_liberty'] == "Análise Cadastral Aprovada"){
			$cor_liberty = "green";
			$status_liberty = "Aprovado";
		}elseif($dados_fianca['situacao_analise_liberty'] == "Análise Cadastral Reprovada"){
			$cor_liberty = "red";
			$status_liberty = "Recusado";
		}elseif($dados_fianca['situacao_analise_liberty'] == "Carta Oferta Não Cadastrada"){
			$cor_liberty = "black";
			$status_liberty = "Carta Oferta Não Cadastrada";
		}elseif($dados_fianca['situacao_analise_liberty'] == "Em Análise Pela Companhia"){
			$cor_liberty = "black";
			$status_liberty = "Em Análise";
		}else{
			$cor_liberty = "black";
			$status_liberty = "";
		}
		
		
		if($dados_fianca['situacao_analise_too'] == "Análise cadastral aprovada"){
			$cor_too = "green";
			$status_too = "Aprovado";
		}elseif($dados_fianca['situacao_analise_too'] == "Análise cadastral reprovada"){
			$cor_too = "red";
			$status_too = "Recusado";
		}elseif($dados_fianca['situacao_analise_too'] == "Em Análise Pela Companhia"){
			$cor_too = "black";
			$status_too = "Em Análise";
		}elseif($dados_fianca['situacao_analise_too'] == "Pendente"){
			$cor_too = "black";
			$status_too = "Pendente";
		}else{
			$cor_too = "black";
			$status_too = "";
		}
		

		if($dados_fianca['sexo_inquilino'] == "F"){
			$dados_fianca['sexo_inquilino'] = "FEMININO";
		}elseif($dados_fianca['sexo_inquilino'] == "M"){
			$dados_fianca['sexo_inquilino'] = "MASCULINO";
		}else{
			$dados_fianca['sexo_inquilino'] = '';
		}
		
		if($dados_fianca['vai_residir_conjuge_inquilno'] == "S"){
			$dados_fianca['vai_residir_conjuge_inquilno'] = "SIM";
		}elseif($dados_fianca['vai_residir_conjuge_inquilno'] = "N"){
			$dados_fianca['vai_residir_conjuge_inquilno'] = "NÃO";
		}else{
			$dados_fianca['vai_residir_conjuge_inquilno'] = "";
		}
		
		if($dados_fianca['vai_residir_imov_inquilino'] == "S"){
			$dados_fianca['vai_residir_imov_inquilino'] = "SIM";
		}elseif($dados_fianca['vai_residir_imov_inquilino'] = "N"){
			$dados_fianca['vai_residir_imov_inquilino'] = "NÃO";
		}else{
			$dados_fianca['vai_residir_imov_inquilino'] = "";
		}
		
		if($dados_fianca['ocupacao'] == "R"){
			$dados_fianca['ocupacao'] = "RESIDENCIAL";
		}elseif($dados_fianca['ocupacao'] = "C"){
			$dados_fianca['ocupacao'] = "COMERCIAL";
		}else{
			$dados_fianca['ocupacao'] = "";
		}
		
		
		if(!empty($dados_fianca['nome_conjuge_inquilino'])){
			
				  $div_dados_conjuge = "<tr>
											<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;width:100px;'>
												Nome Conjuge:
											</td>
											<td>
												".$dados_fianca['nome_conjuge_inquilino']."
											</td>
											<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;width:100px;'>
												CPF Conjuge:
											</td>
											<td>
												".$dados_fianca['cpf_conjuge_inquilino']."
											</td>
											<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;width:100px;'>
												Dt. Nasc. Conjuge:
											</td>
											<td>
												".$dados_fianca['data_conjuge_inquilno']."
											</td>
											<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;width:100px;'>
												Irá Residir Conjuge:
											</td>
											<td>
												".$dados_fianca['vai_residir_conjuge_inquilno']."
											</td>
											<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;width:100px;'>
												Irá Compor Renda Conjuge:
											</td>
											<td>
												".$dados_fianca['vai_compor_renda_conjuge_inquilno']."
											</td>
										</tr>";
		}else{
			$div_dados_conjuge = '';
		}
		
		if($dados_fianca['num_solidarios'] != 0){
			
			$div_solidarios = '';
			
			$qtd_solidarios = 0;
			
			if(!empty($dados_fianca['solidario1'])){
				
				$qtd_solidarios++;
				
				if(($dados_fianca['solidario1_estado_civil'] == "CASADO") || ($dados_fianca['solidario1_estado_civil'] == "AMASIADO")){
					$solidario1_conjuge_cpf = "<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;'>
													CPF conjuge:
											   </td>
											   <td>".$dados_fianca['solidario1_conjuge_cpf']."</td>";
				}else{
					$solidario1_conjuge_cpf = "";
				}
				
					$div_solidarios1 = "<tr> 
											<td colspan='10' style = 'font-weight: bold;color:#000;background-color:#BBDFFB;padding:3px;'>Pretendente: ".$qtd_solidarios."</td>
										</tr>
										<tr>
											<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;width:100px;'>
												Nome:
											</td>
											<td colspan = '3'>
												".$dados_fianca['solidario1']."
											</td>
											<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;width:100px;'>
												CPF:
											</td>
											<td>
												".$dados_fianca['solidario1_cpf']."
											</td>
											<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;width:100px;'>
												Telefone:
											</td>
											<td>
												".$dados_fianca['solidario1_fone']."
											</td>
										</tr>
										<tr>
											<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;'>
												Sexo:
											</td>
											<td>
												".$dados_fianca['solidario1_sexo']."
											</td>
											<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;'>
												Numero do Documento (RG/RNE/Ordem/Conselho):
											</td>
											<td>
												".$dados_fianca['solidario1_rg']."
											</td>
											<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;'>
												Orgão Expedidor:
											</td>
											<td>
												".$dados_fianca['solidario1_orgao_rg']."
											</td>
											<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;'>
												Data Emissão:
											</td>
											<td>
												".$dados_fianca['solidario1_data_emissao_rg']."
											</td>
										</tr>
										<tr>
											<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;'>
												Estado Civil:
											</td>
											<td>
												".$dados_fianca['solidario1_estado_civil']."
											</td>
											<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;'>
												Data Nascimento:
											</td>
											<td>
												".$dados_fianca['solidario1_data_nascimento']."
											</td>
											<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;'>
												Grau de Parentesco:
											</td>
											<td>
												".$dados_fianca['solidario1_grau_parentesco']."
											</td>
											<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;'>
												CEP Residência:
											</td>
											<td>
												".$dados_fianca['solidario1_cep']."
											</td>
											<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;'>
												Irá Residir:
											</td>
											<td>
												".$dados_fianca['solidario1_ira_residir']."
											</td>
										</tr>
										<tr>
											<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;width:200px;'>
												Natureza da renda / Vínculo empregatício:
											</td>
											<td>
												".$dados_fianca['solidario1_natureza_renda']."
											</td>
											<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;'>
												Renda mensal bruta:
											</td>
											<td>
												".$dados_fianca['solidario1_renda']."
											</td>
											".$solidario1_conjuge_cpf."
										</tr>";
				
			}
			
			if(!empty($dados_fianca['solidario2'])){
				
				$qtd_solidarios++;
				
				if(($dados_fianca['solidario2_estado_civil'] == "CASADO") || ($dados_fianca['solidario2_estado_civil'] == "AMASIADO")){
					$solidario2_conjuge_cpf = "<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;'>
													CPF conjuge:
											   </td>
											   <td>".$dados_fianca['solidario2_conjuge_cpf']."</td>";
				}else{
					$solidario2_conjuge_cpf = "";
				}
				
					$div_solidarios2 = "<tr> 
											<td colspan='10' style = 'font-weight: bold;color:#000;background-color:#BBDFFB;padding:3px;'>Pretendente: ".$qtd_solidarios."</td>
										</tr>
										<tr>
											<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;width:100px;'>
												Nome:
											</td>
											<td colspan = '3'>
												".$dados_fianca['solidario2']."
											</td>
											<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;width:100px;'>
												CPF:
											</td>
											<td>
												".$dados_fianca['solidario2_cpf']."
											</td>
											<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;width:100px;'>
												Telefone:
											</td>
											<td>
												".$dados_fianca['solidario2_fone']."
											</td>
										</tr>
										<tr>
											<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;'>
												Sexo:
											</td>
											<td>
												".$dados_fianca['solidario2_sexo']."
											</td>
											<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;'>
												Numero do Documento (RG/RNE/Ordem/Conselho):
											</td>
											<td>
												".$dados_fianca['solidario2_rg']."
											</td>
											<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;'>
												Orgão Expedidor:
											</td>
											<td>
												".$dados_fianca['solidario2_orgao_rg']."
											</td>
											<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;'>
												Data Emissão:
											</td>
											<td>
												".$dados_fianca['solidario2_data_emissao_rg']."
											</td>
										</tr>
										<tr>
											<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;'>
												Estado Civil:
											</td>
											<td>
												".$dados_fianca['solidario2_estado_civil']."
											</td>
											<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;'>
												Data Nascimento:
											</td>
											<td>
												".$dados_fianca['solidario2_data_nascimento']."
											</td>
											<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;'>
												Grau de Parentesco:
											</td>
											<td>
												".$dados_fianca['solidario2_grau_parentesco']."
											</td>
											<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;'>
												CEP Residência:
											</td>
											<td>
												".$dados_fianca['solidario2_cep']."
											</td>
											<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;'>
												Irá Residir:
											</td>
											<td>
												".$dados_fianca['solidario2_ira_residir']."
											</td>
										</tr>
										<tr>
											<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;width:200px;'>
												Natureza da renda / Vínculo empregatício:
											</td>
											<td>
												".$dados_fianca['solidario2_natureza_renda']."
											</td>
											<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;'>
												Renda mensal bruta:
											</td>
											<td>
												".$dados_fianca['solidario2_renda']."
											</td>
											".$solidario2_conjuge_cpf."
										</tr>";
				
			}
			
			if(!empty($dados_fianca['solidario3'])){
				
				$qtd_solidarios++;
				
				if(($dados_fianca['solidario3_estado_civil'] == "CASADO") || ($dados_fianca['solidario3_estado_civil'] == "AMASIADO")){
					$solidario3_conjuge_cpf = "<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;'>
													CPF conjuge:
											   </td>
											   <td>".$dados_fianca['solidario3_conjuge_cpf']."</td>";
				}else{
					$solidario3_conjuge_cpf = "";
				}
				
					$div_solidarios3 = "<tr> 
											<td colspan='10' style = 'font-weight: bold;color:#000;background-color:#BBDFFB;padding:3px;'>Pretendente: ".$qtd_solidarios."</td>
										</tr>
										<tr>
											<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;width:100px;'>
												Nome:
											</td>
											<td colspan = '3'>
												".$dados_fianca['solidario3']."
											</td>
											<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;width:100px;'>
												CPF:
											</td>
											<td>
												".$dados_fianca['solidario3_cpf']."
											</td>
											<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;width:100px;'>
												Telefone:
											</td>
											<td>
												".$dados_fianca['solidario3_fone']."
											</td>
										</tr>
										<tr>
											<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;'>
												Sexo:
											</td>
											<td>
												".$dados_fianca['solidario3_sexo']."
											</td>
											<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;'>
												Numero do Documento (RG/RNE/Ordem/Conselho):
											</td>
											<td>
												".$dados_fianca['solidario3_rg']."
											</td>
											<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;'>
												Orgão Expedidor:
											</td>
											<td>
												".$dados_fianca['solidario3_orgao_rg']."
											</td>
											<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;'>
												Data Emissão:
											</td>
											<td>
												".$dados_fianca['solidario3_data_emissao_rg']."
											</td>
										</tr>
										<tr>
											<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;'>
												Estado Civil:
											</td>
											<td>
												".$dados_fianca['solidario3_estado_civil']."
											</td>
											<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;'>
												Data Nascimento:
											</td>
											<td>
												".$dados_fianca['solidario3_data_nascimento']."
											</td>
											<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;'>
												Grau de Parentesco:
											</td>
											<td>
												".$dados_fianca['solidario3_grau_parentesco']."
											</td>
											<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;'>
												CEP Residência:
											</td>
											<td>
												".$dados_fianca['solidario3_cep']."
											</td>
											<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;'>
												Irá Residir:
											</td>
											<td>
												".$dados_fianca['solidario3_ira_residir']."
											</td>
										</tr>
										<tr>
											<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;width:200px;'>
												Natureza da renda / Vínculo empregatício:
											</td>
											<td>
												".$dados_fianca['solidario3_natureza_renda']."
											</td>
											<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;'>
												Renda mensal bruta:
											</td>
											<td>
												".$dados_fianca['solidario3_renda']."
											</td>
											".$solidario3_conjuge_cpf."
										</tr>";
				
			}
					
			$div_solidarios = $div_solidarios1.$div_solidarios2.$div_solidarios3;
		}
		
		if(!empty($div_solidarios)){
				$composicao_renda = "<table style='width:100%;margin:auto;border:1px solid #aaa;font-size:7pt;'>
										 <tr>
											<td colspan='10' style = 'font-weight: bold;color:#000;background-color:#00BFFF;text-align:center;padding:3px;'>Composição da Renda</td>
										 </tr>
										 ".$div_solidarios."
									 </table>";	
		}else{
			$composicao_renda = '';
		}
		
		##################################################################### PDF ############################################################################
		
        //PDF LIBERTY
		if(!empty($dados_fianca['processo_liberty'])){
			$nome_arquivo = $dados_fianca['codigo'].'_LIB_'.$dados_fianca['processo_liberty'].'_'.$dados_fianca['inquilino'].'_1.pdf';
			$file_path_liberty = '../../../aplicacao_liberty_fianca/downloads/'.$nome_arquivo;
		}

		$processo_liberty = $dados_fianca['processo_liberty'];
		if(file_exists($file_path_liberty)){
			$processo_liberty = $processo_liberty.' (carta anexa)';
		}
		
		//PDF PORTO
		if(!empty($dados_fianca['processo_porto'])){
			$nome_arquivo = $dados_fianca['codigo'].'_POR_'.$dados_fianca['processo_porto'].'_'.$dados_fianca['inquilino'].'_1.pdf';
			$file_path_porto = '../../../aplicacao_porto/downloads/'.$nome_arquivo;
		}

		$processo_porto = $dados_fianca['processo_porto'];
		if(file_exists($file_path_porto)){
			$processo_porto = $processo_porto.' (carta anexa)';
		}
		
		##################################################################### FIM PDF ########################################################################
		
		$mensagem = "<!DOCTYPE html>
					</body>
						<table style='width:100%;margin:auto;border:1px solid #aaa;font-size:7pt;'>
							<tr>
								<td style='width:20%;'><img src='http://www.segurosja.com.br/gerenciador/capitalizacao/img/logo.png' style='margin:auto;display: block;' height='36' border='0' alt='' /></td>
								<td style='width:80%;text-align:center;'>
									<div style = 'font-weight:bold;color:#FA6E03;font-size:16pt;padding:3px;'>Pedido de Análise de Cadastro para Seguro Fiança</div>
									<div style = 'font-size:9pt;padding:3px;'>".$dados_fianca['inquilino']." - Nº ".$dados_fianca['codigo']."</div>
								</td>
							</tr>
						</table>
						<table style='width:100%;margin:auto;border:1px solid #aaa;font-size:7pt;'>
							<tr style = 'font-weight: bold;'>
								<td colspan='6' style = 'font-weight: bold;color:#000;background-color:#00BFFF;text-align:center;padding:3px;'>Dados Gerais</td>
							</tr>
							<tr style = 'border:1px solid #aaa;'>
								<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;width:100px;'>
									Imobiliária (razão):
								</td>
								<td>
								   ".$dados_fianca['imobiliaria_razao']."
								</td>
								<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;width:100px;'>
									Corretor:
								</td>
								<td colspan='2'>
									".$dados_fianca['corretora_razao']."
								</td>
							</tr>
							<tr style = 'border:1px solid #aaa;'>
								<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;'>
									Imobiliária (fantasia):
								</td>
								<td>
									".$dados_fianca['fantasia']."
								</td>
								<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;'>
									Usuário:
								</td>
								<td style = ''>
									".$dados_fianca['solicitante']."
								</td>
								<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;width:120px;'>
									Data e Hora do Envio:
								</td>
								<td style = ''>
									".$dados_fianca['data_transm'].' - '.$dados_fianca['hora_transm']."&nbsp;
								</td>
							</tr>
						</table>
						<table style='width:100%;margin:auto;border:1px solid #aaa;font-size:11pt;text-align:center;background-color:#eee;'>
							<tr><td colspan='4' style = 'font-weight: bold;color:#000;background-color:#00BFFF;text-align:center;padding:3px;font-size:7pt;'>Status de Aprovação do Cadastro</td></tr>
							<tr>
							    <td style='font-weight: bold;width:15%;border:1px solid #aaa;vertical-align:center;font-size:9pt;'>
									Seguradora
								</td>
								<td style='width:28.33%;border:1px solid #aaa;padding:5px;'>
									<img src='http://www.segurosja.com.br/gerenciador/fianca/app/img/liberty_logo.png' style='margin:auto;display: block;' height='70' border='0' alt='' />
								</td>
								<td style='width:28.33%;border:1px solid #aaa;padding:5px;'>
									<img src='http://www.segurosja.com.br/gerenciador/fianca/app/img/porto_logo.png' style='margin:auto;display: block;' height='70' border='0' alt='' />
								</td>
								<td style='width:28.33%;border:1px solid #aaa;padding:5px;'>
									<img src='http://www.segurosja.com.br/gerenciador/fianca/app/img/too_logo.png' style='margin:auto;display: block;' height='70' border='0' alt='' />
								</td>
							</tr>
							<tr>
							    <td style = 'font-weight: bold;padding:5px;border:1px solid #aaa;font-size:9pt;'><span style = 'color:black;'>Situação</span></td>
								<td style = 'padding:5px;border:1px solid #aaa;'><span style = 'color:".$cor_liberty.";font-weight: bold;'>".$status_liberty."</span></td>
								<td style = 'padding:5px;border:1px solid #aaa;'><span style = 'color:".$cor_porto.";font-weight: bold;'>".$status_porto."</span></td>
								<td style = 'padding:5px;border:1px solid #aaa;'><span style = 'color:".$cor_too.";font-weight: bold;'>".$status_too."</span></td>
							</tr>
							<tr>
							    <td style = 'font-weight: bold;padding-top:5px;border:1px solid #aaa;font-size:9pt;'><span style = 'color:black;'>Nº Processo</span></td>
								<td style = 'padding:5px;border:1px solid #aaa;font-size:7pt;'><span style = 'color:".$cor_liberty.";font-weight: bold;'>".$processo_liberty."</span></td>
								<td style = 'padding:5px;border:1px solid #aaa;font-size:7pt;'><span style = 'color:".$cor_porto.";font-weight: bold;'>".$processo_porto."</span></td>
								<td style = 'padding:5px;border:1px solid #aaa;font-size:7pt;'><span style = 'color:".$cor_too.";font-weight: bold;'>".$dados_fianca['processo_too']."</span></td>
							</tr>
						</table>
						<table style='width:100%;margin:auto;border:1px solid #aaa;font-size:7pt;'>
								<tr>
									<td colspan='10' style = 'font-weight: bold;color:#000;background-color:#00BFFF;text-align:center;padding:3px;'>Dados Pretendente</td>
								</tr>
								<tr>
									<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;width:100px;'>Nome</td>
									<td colspan = '3'>".$dados_fianca['inquilino']."</td>
									<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;width:120px;'>Tipo pessoa</td>
									<td>".$dados_fianca['tipo_inquilino']."</td>
									<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;width:120px;'>CPF/CNPJ</td>
									<td>".$dados_fianca['CPF_inquilino']."</td>
									<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;width:130px;'>Data de Nascimento</td>
									<td>".$dados_fianca['data_inquilino']."</td>
								</tr>
								<tr>
									<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;'>
										Tipo de Documento:
									</td>
									<td>
										".$dados_fianca['tipo_doc_inquilino']."
									</td>
									<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;width:120px;'>
										Numero do Documento:
									</td>
									<td>
										".$dados_fianca['rg_inquilino']."
									</td>
									<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;'>
										Orgão Expedidor:
									</td>
									<td>
										".$dados_fianca['orgao_exp_inquilino']."
									</td>
									<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;'>
										Data Expedição:
									</td>
									<td>
										".$dados_fianca['data_exp_inquilino']."
									</td>
									<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;'>
										Data Validade Doc.:
									</td>
									<td>
										".$dados_fianca['data_validade_doc_inquilino']."
									</td>
								</tr>
								<tr>
									<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;'>
										Sexo
									</td>
									<td>
										".$dados_fianca['sexo_inquilino']."
									</td>
									<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;'>
										Estado Civil
									</td>
									<td>
										".$dados_fianca['est_civil_inquilino']."
									</td>
									<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;'>
										N° Dependentes
									</td>
									<td>
										".$dados_fianca['num_dependente_inquilino']."
									</td>
								</tr>
								".$div_dados_conjuge."
								<tr>
									<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;'>
										Nome Mãe
									</td>
									<td colspan = '3'>
										".$dados_fianca['nome_mae_inquilino']."
									</td>
									<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;'>
										Nome Pai
									</td>
									<td colspan = '3'>
										".$dados_fianca['nome_pai_inquilino']."
									</td>
								</tr>
								<tr>
									<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;'>
										Nacionalidade:
									</td>
									<td>
										".$dados_fianca['nacionalidade_inquilino']."
									</td>
									<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;'>
										Tempo no País:
									</td>
									<td>
										".$dados_fianca['tempo_pais_inquilino']."
									</td>
									<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;'>
										Irá residir no imóvel:
									</td>
									<td>
										".$dados_fianca['vai_residir_imov_inquilino']."
									</td>
								</tr>
								<tr>
									<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;'>
										Telefone:
									</td>
									<td>
										".$dados_fianca['fone_inquilino']."
									</td>
									<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;'>
										Celular:
									</td>
									<td>
										".$dados_fianca['cel_inquilino']."
									</td>
									<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;'>
										Telefone Comercial:
									</td>
									<td>
										".$dados_fianca['fone_com_inquilino']."
									</td>
									<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;'>
										Email:
									</td>
									<td colspan = '3'>
										".$dados_fianca['email_inquilino']."
									</td>
								</tr>
								<tr>
									<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;'>
										Responsável pela PJ:
									</td>
									<td>
										".$dados_fianca['resp_inquilino']."
									</td>
									<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;'>
										CPF Responsável:
									</td>
									<td>
										".$dados_fianca['CPF_resp_inquilino']."
									</td>
									<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;'>
										Responsável Pela Locação:
									</td>
									<td>
										".$dados_fianca['resp_locacao_inquilino']."
									</td>
									<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;'>
										Tem renda arcar locação?:
									</td>
									<td>
										".$dados_fianca['tem_renda_arcar_loc_inquilino']."
									</td>
							   </tr>
						</table>
						
							<table style='width:100%;margin:auto;border:1px solid #aaa;font-size:7pt;'>
							<tr>
							   <td colspan='12' style = 'font-weight: bold;color:#000;background-color:#00BFFF;text-align:center;padding:3px;'>Coberturas</td>
							</tr>
							<tr>
								<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;width:80px;'>
								   Aluguel
								</td>
								<td>
								   ".$dados_fianca['aluguel']."
								</td>
								<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;width:80px;'>
									Iptu Mensal
								</td>
								<td>
									".$dados_fianca['iptu']."
								</td>
								<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;width:80px;'>
									Condomínio
								</td>
								<td>
									".$dados_fianca['condominio']."
								</td>
								<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;width:80px;'>
									Água
								</td>
								<td>
									".$dados_fianca['agua']."
								</td>
								<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;width:80px;'>
									Luz
								</td>
								<td>
									".$dados_fianca['energia']."
								</td>
								<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;width:80px;'>
									Gás Canalizado
								</td>
								<td>
									".$dados_fianca['gas']."
								</td>
							</tr>
						</table>
						
						 <table style='width:100%;margin:auto;border:1px solid #aaa;font-size:7pt;'>
						<tr style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;width:120px;'>
						   <td colspan='14' style = 'font-weight: bold;color:#000;background-color:#00BFFF;text-align:center;padding:3px;'>Imóvel Pretendido</td>
						</tr>
						<tr>
							<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;'>
								Finalidade Imóvel
							</td>
							<td>
								".$dados_fianca['ocupacao']."
							</td>
							<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;width:100px;'>
								Tipo de Imóvel
							</td>
							<td>
								".$dados_fianca['imovel_tipo']."
							</td>
							<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;width:100px;'>
								Motivo da Locação
							</td>
							<td colspan = '4'>
								".$dados_fianca['motivo_locacao']."
							</td>
						</tr>
						<tr>
								<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;'>
									CEP
								</td>
								<td>
									".$dados_fianca['cep']."
								</td>
								<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;'>
									Estado
								</td>
								<td>
									".$dados_fianca['uf']."
									
								</td>
								<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;'>
									Cidade
								</td>
								<td>
									".$dados_fianca['cidade']."
								</td>
								<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;width:50px;'>
									Endereço
								</td>
								<td>
									".$dados_fianca['endereco']."
								</td>
								<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;width:50px;'>
									Complemento
								</td>
								<td>
									".$dados_fianca['complemento']."
								</td>
								<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;width:50px;'>
									Bairro
								</td>
								<td>
									".$dados_fianca['bairro']."
								</td>
								<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;width:50px;'>
									Numero
								</td>
								<td>
									".$dados_fianca['numero']."
								</td>
							</tr>
					</table>

						<table style='width:100%;margin:auto;border:1px solid #aaa;font-size:7pt;'>
							<tr>
							   <td colspan='8' style = 'font-weight: bold;color:#000;background-color:#00BFFF;text-align:center;padding:3px;'>Dados Profissionais</td>
							</tr>
							<tr>
								<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;width:250px;'>
									Natureza da renda / Vínculo empregatício
								</td>
								<td>
									".$dados_fianca['natureza_renda_inquilino']."
								</td>
								<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;width:260px;'>
									Profissão
								</td>
								<td colspan = '4'>
									".$dados_fianca['profissao_inquilino_descricao']."
								</td>
							</tr>
							<tr>
								<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;width:200px;'>
									Salário Bruto
								</td>
								<td>
									".$dados_fianca['salario_inquilino']."
								</td>
								<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;width:100px;'>
									Descrição de outros rendimentos
								</td>
								<td style = 'width:20%;'>
									".$dados_fianca['outros_rendim_inquilino']."
								</td>
								<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;width:170px;'>
									Total Mensal de Outros Rendimentos
								</td>
								<td>
									".$dados_fianca['total_rendim_inquilino']."
								</td>
							</tr>
							<tr>
								<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;width:100px;'>
									Nome da Empresa/Instituição/Órgão em que trabalha
								</td>
								<td style = 'width:90px;'>
									".$dados_fianca['empresa_trab_inquilino']."
								</td>
								<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;width:100px;'>
									Empresa/Instituição Anterior (se atual menor que 1 ano)
								</td>
								<td>
									".$dados_fianca['empresa_anterior_inquilino']."
								</td>
								<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;'>
									Telefone
								</td>
								<td style = 'width:80px;'>
									".$dados_fianca['fone_com_inquilino']."
								</td>
								<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;width:40px;'>
									Ramal
								</td>
								<td>
									".$dados_fianca['ramal_com_inquilino']."
								</td>
							</tr>
						</table>
						<table style='width:100%;margin:auto;border:1px solid #aaa;font-size:7pt;'>
						   <tr>
							  <td colspan='8' style = 'font-weight: bold;color:#000;background-color:#00BFFF;text-align:center;padding:3px;'>Dados Bancários</td>
						   </tr>
						   <tr>
							 <td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;width:130px;'>
								Referências Bancárias
							 </td>
							 <td>
								".$dados_fianca['ref_bancaria_inquilino']."
							 </td>
							 <td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;width:100px;'>
								Banco
							</td>
							<td>
								".$dados_fianca['banco_inquilino']."
							</td>
							<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;width:100px;'>
								Agência
							</td>
							<td>
								".$dados_fianca['agencia_inquilino']."
							</td>
							<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;width:100px;'>
								Conta
							</td>
							<td>
								".$dados_fianca['ccorrente_inquilino']."
							</td>
						</tr>
					 </table>
					 
					 
					    <table style='width:100%;margin:auto;border:1px solid #aaa;font-size:7pt;'>
							<tr>
							   <td colspan='14' style = 'font-weight: bold;color:#000;background-color:#00BFFF;text-align:center;padding:3px;'>Residência Atual</td>
							</tr>
							<tr>
								<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;width:100px;'>
									Tempo de Residencia
								</td>
								<td colspan='3'>
									".$dados_fianca['tempo_resid_inquilino']."
								</td>
								<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;width:100px;'>
									Tipo Residência
								</td>
								<td colspan='3'>
									".$dados_fianca['tipo_resid_inquilino']."
								</td>
								<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;width:100px;'>
									Em nome de
								</td>
								<td colspan='4'>
									".$dados_fianca['resid_emnomede_inquilino']."
								</td>
							</tr>
							<tr>
								<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;width:100px;'>
									CEP
								</td>
								<td>
									".$dados_fianca['cep_anterior_inquilino']."
								</td>
								<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;width:60px;'>
									Estado
								</td>
								<td>
									".$dados_fianca['uf_anterior_inquilino']."
								</td>
								<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;width:60px;'>
									Cidade
								</td>
								<td>
									".$dados_fianca['cidade_anterior_inquilino']."
								</td>
								<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;width:100px;'>
									Endereço
								</td>
								<td>
									".$dados_fianca['endereco_anterior_inquilino']."
								</td>
								<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;width:70px;'>
									Complemento
								</td>
								<td>
									".$dados_fianca['complemento_anterior_inquilino']."
								</td>
								<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;width:60px;'>
									Bairro
								</td>
								<td>
									".$dados_fianca['bairro_anterior_inquilino']."
								</td>
								<td style = 'background-color:#ADD8E6;font-weight: bold;padding:3px;text-align:right;width:60px;'>
									Numero
								</td>
								<td>
									".$dados_fianca['num_anterior_inquilino']."
								</td>
							</tr>
						</table>
						".$composicao_renda."
					</body>
					</html>";
		
		//echo $mensagem;

		####################################################### ENVIO DE EMAIL #############################################################
		
		$email_imob      = $dados_fianca['email_imobs'];
		$email_alt1      = $dados_fianca['email_alt1'];
		$email_alt2      = $dados_fianca['email_alt2'];
		$email_alt3      = $dados_fianca['email_alt3'];
		$email_cor       = $dados_fianca['email_corretor'];
		$cod_cor         = $dados_fianca['corretor'];
		$email_atendente = $dados_fianca['solicitante'];
		
		
		
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
		
		############################################################# EMAILS ##########################################################
		if(valida_email($email_cor)){
			$mail->AddReplyTo("$email_cor"); // Email para receber as respostas
			// Define os dados técnicos da Mensagem
		}
		
		############################################### ANEXO DE PDF EMAIL ####################################################

		if(file_exists($file_path_liberty)){
			$mail->AddAttachment($file_path_liberty);
		}
		
		if(file_exists($file_path_porto)){
			$mail->AddAttachment($file_path_porto);
		}

		#######################################################################################################################
		
		$mail->IsHTML(true); // Define que o e-mail será enviado como HTML
		$mail->CharSet = 'iso-8859-1'; // Charset da mensagem (opcional)

        //se o campo for email será adicionado
        if(checkmail($email_atendente) && (valida_email($email_atendente))){
            $mail->AddAddress("$email_atendente");
		}

		if($cod_cor == "0" or $cod_cor == "6"){
			 $mail->AddCC("$email_cor");
			 $mail->AddCC('cadastro@maximizaseguros.com.br');
			 $mail->AddCC('aluguel@maximizaseguros.com.br');
			 $mail->AddCC('aluguel2@maximizaseguros.com.br');
			 $mail->AddCC('cadastro@mx10.com.br');
		}else if($cod_cor == "10"){
			 $mail->AddCC("$email_cor");
			 $mail->AddCC("cadastro.df@maximizaseguros.com.br");
			 $mail->AddCC("aluguel.df@maximizaseguros.com.br");
			 $mail->AddCC("aluguel2.df@maximizaseguros.com.br");
		}else if($cod_cor == "8"){
			 $mail->AddCC("$email_cor");
			 $mail->AddCC("mt@mx10.com.br");		
		}else if($cod_cor == "5"){
			 $mail->AddCC("$email_cor");
			 $mail->AddCC('ccavalcante@riolupo.com.br');
			 $mail->AddBCC('clemente@mx10.com.br');
			 $mail->AddBCC('leandro@maximizaseguros.com.br');
		}else if($cod_cor == "11"){
			 $mail->AddCC("$email_cor");
			 $mail->AddBCC('eduardo@maximizaseguros.com.br');
			 $mail->AddBCC('silmara@maximizaseguros.com.br');
		}else{
			 $mail->AddBCC("clemente@maximizaseguros.com.br");
		}
		
		if(valida_email($email_imob)){
			$mail->AddAddress("$email_imob");
		}
		
		if(!empty(trim($email_alt1)) && (valida_email($email_alt1))){
			$mail->AddAddress("$email_alt1");
		}
		
		if(!empty(trim($email_alt2)) && (valida_email($email_alt2))){
			$mail->AddAddress("$email_alt2");
		}
		
		if(!empty(trim($email_alt3)) && (valida_email($email_alt3))){
			$mail->AddAddress("$email_alt3");
		}
		
		$mail->AddBCC("leandro@mx10.com.br");
		
		############################################################# FIM EMAILS ##########################################################
		//email de teste
		//$mail->AddBCC("denysczr@gmail.com");
		$mail->AddBCC("ti01@maximizaseguros.com.br");

		$mail->Body = $mensagem;//apagar
		$mail->Subject = "Análise Seguro Fiança - " . $dados_fianca['codigo']; //apagar
		$enviado = $mail->Send();//apagar

		// Limpa os destinatários e os anexos
		$mail->ClearAllRecipients();
		$mail->ClearAttachments();
		// Exibe uma mensagem de resultado
		if($enviado){
			$retorno_mail = "E-mail(s) enviado(s) com sucesso!";
			
			 echo json_encode(array(
				'data' => true,
				'msg' => $retorno_mail
			 ));
			
		}else{
			$retorno_mail = "Não foi possível enviar o(s) e-mail(s).";
			$retorno_mail .= " Informações do erro: " . $mail->ErrorInfo;
			
			echo json_encode(array(
				'data' => false,
				'msg' => $retorno_mail
			));
		}

	}

}

?>