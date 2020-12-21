<?php
 header("Access-Control-Allow-Origin: *");
 header("Access-Control-Allow-Methods: GET,PUT,POST,DELETE");
 header("Access-Control-Allow-Headers: Content-Type, Authorization");
 
require_once("php7_mysql_shim.php");

$registro = $_REQUEST['codigo'];

if ( !empty( $_FILES ) ) {
    $tempPath = $_FILES[ 'file' ][ 'tmp_name' ];
    //$path = "./uploads/" . "$registro" . '_' . "$inquilino";
    $path = "./apolices";
    if(!file_exists ( $path )){
        mkdir($path, 0777);
    }
    $arquivo_nome = str_replace(' ', '_', $_FILES['file']['name']);
    $arquivo_nome = preg_replace('/[`^~\'"]/', null, iconv('UTF-8', 'ASCII//TRANSLIT', $arquivo_nome));
    //$uploadPath = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . "$registro" . '_' . "$inquilino" . DIRECTORY_SEPARATOR . $arquivo_nome;
    $uploadPath = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'apolices' . DIRECTORY_SEPARATOR.$arquivo_nome;
    move_uploaded_file( $tempPath, $uploadPath);
    //copy('./uploads/index.php', './uploads/' . $registro . '_' . $inquilino . '/index.php');
    //copy('./uploads/.user.ini', './uploads/' . $registro . '_' . $inquilino . '/.user.ini');
    $answer = array( 'answer' => 'Transferência Concluída' );
    $json = json_encode( $answer );
    //echo $json;

    $mensagem = "<html><body><div align='center'><b>** Segue em anexo</body></html>";

// Inclui o arquivo class.phpmailer.php localizado na pasta phpmailer
require("../../adm/phpmailer/class.phpmailer.php");
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
$mail->AddReplyTo("cobertura@segurosja.com.br"); // Email para receber as respostas
// Define os dados técnicos da Mensagem
$mail->IsHTML(true); // Define que o e-mail será enviado como HTML
$mail->CharSet = 'iso-8859-1'; // Charset da mensagem (opcional)

$mail->AddBCC("denilson.anhanguera@gmail.com");

$mail->Body = $mensagem;//apagar
$mail->Subject = "Apólice"; //apagar
$mail->AddAttachment($tempPath, $arquivo_nome);// anexar arquivo
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

echo $retorno_mail;

} else {
    echo 'Sem arquivo.';
}


mysql_close($conexao);

?>
