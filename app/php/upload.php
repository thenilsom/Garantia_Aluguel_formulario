<?php
require_once("php7_mysql_shim.php");

$registro = $_REQUEST ['codigo'];
$conexao = mysql_connect("mysql.segurosja.com.br", "segurosja", "m1181s2081_") or die ("problema na conexão");
$sql = "select * from fianca where codigo='$registro'";
$consulta = mysql_db_query("segurosja", $sql);
while($campo = mysql_fetch_assoc($consulta)){
    $nome=$campo['inquilino'];
}

if ( !empty( $_FILES ) ) {
    $tempPath = $_FILES[ 'file' ][ 'tmp_name' ];
    $path = "./uploads/" . "$registro" . '_' . "$nome";
    if(!file_exists ( $path )){
        mkdir($path, 0777);
    }
    $uploadPath = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . "$registro" . '_' . "$nome" . DIRECTORY_SEPARATOR . $_FILES[ 'file' ][ 'name' ];
    move_uploaded_file( $tempPath, $uploadPath );
    $answer = array( 'answer' => 'Transferência Concluída' );
    $json = json_encode( $answer );
    echo $json;
} else {
    echo 'Sem arquivo.';
}


// Inclui o arquivo class.phpmailer.php localizado na pasta phpmailer
require("../../../../adm/phpmailer/class.phpmailer.php");
// Inicia a classe PHPMailer
$mail = new PHPMailer();
// Define os dados do servidor e tipo de conexão
$mail->IsSMTP(); // Define que a mensagem será SMTP
$mail->Host = "smtp.segurosja.com.br"; // Endereço do servidor SMTP (caso queira utilizar a autenticação, utilize o host smtp.seudomínio.com.br)
$mail->SMTPAuth = true; // Usar autenticação SMTP (obrigatório para smtp.seudomínio.com.br)
$mail->Username = 'admin=segurosja.com.br'; // Usuário do servidor SMTP (endereço de email)
$mail->Password = 'm1181s2081_'; // Senha do servidor SMTP (senha do email usado)
// Define o remetente
$mail->From = "admin@segurosja.com.br"; // Seu e-mail
$mail->Sender = "admin@segurosja.com.br"; // Seu e-mail
$mail->FromName = "Seguros Já!"; // Seu nome
/*   $mail->AddReplyTo("$email_cor"); // Email para receber as respostas
// Define os dados técnicos da Mensagem
$mail->IsHTML(true); // Define que o e-mail será enviado como HTML
$mail->CharSet = 'iso-8859-1'; // Charset da mensagem (opcional)
// Insere um anexo
for ($i = 0; $i < count($anexos); $i++){
    $caminho = "./lotes_liberty/".$anexos[$i];
    echo $caminho."<BR>";
    $mail->AddAttachment("$caminho", $anexos[$i]);
}
// Define o email principal do corretor como destinatário e também emails de emissão da Liberty
$mail->AddAddress("$email_cor");
*/

$mail->AddAddress("leandro@mx10.com.br");//apagar
$mail->Body = $mensagem;//apagar
$mail->Subject  = "Análise de Fiança"; //apagar
$enviado = $mail->Send();//apagar

/*
//Estabelece o CC

if($email_cor == "cobertura@maximizaseguros.com.br"){$mail->AddCC('imobiliario@mx10.com.br');$mail->AddCC('imobiliario2@mx10.com.br');$mail->AddCC('imobiliario3@mx10.com.br');$mail->AddCC('financeiro@maximizaseguros.com.br');}
if($email_cor == "df@maximizaseguros.com.br"){$mail->AddCC('df2@maximizaseguros.com.br');$mail->AddCC('financeiro@maximizaseguros.com.br');}
if($email_cor == "mt@maximizaseguros.com.br"){$mail->AddCC('mt@mx10.com.br');$mail->AddCC('financeiro@maximizaseguros.com.br');}
if($email_cor == "to@maximizaseguros.com.br"){$mail->AddCC('imobiliario@mx10.com.br');$mail->AddCC('imobiliario2@mx10.com.br');$mail->AddCC('imobiliario3@mx10.com.br');$mail->AddCC('financeiro@maximizaseguros.com.br');}
if($email_cor == "riolupo@riolupo.com.br"){$mail->AddBCC('clemente@mx10.com.br');$mail->AddBCC('leandro@mx10.com.br');$mail->AddBCC('ccavalcante@riolupo.com.br');}
//Estabelece o BCC

$mail->AddBCC('cobertura@segurosja.com.br');

if($email_cor <> "cobertura@maximizaseguros.com.br"){$mail->AddBCC('cobertura@maximizaseguros.com.br');}

$mail->Body = $mensagem;// Estabelece o body da mensagem
$mail->Subject  = "Emissão Imobiliário LIBERTY - Lote(s): " . $lista_todos_lotes; // Assunto da mensagem
if($aux > 0){$enviado = $mail->Send();}// Envia o e-mail
*/
// Limpa os destinatários e os anexos
$mail->ClearAllRecipients();
$mail->ClearAttachments();
// Exibe uma mensagem de resultado
if($enviado){$retorno_mail = "E-mail(s) enviado(s) com sucesso!";}
else{
    $retorno_mail = "Não foi possível enviar o(s) e-mail(s).";
    $retorno_mail .= " Informações do erro: " . $mail->ErrorInfo;
}

mysql_close($conexao);

echo $retorno_mail;

?>
