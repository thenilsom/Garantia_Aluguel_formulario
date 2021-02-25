<?php
 header("Access-Control-Allow-Origin: *");
 header("Access-Control-Allow-Methods: GET,PUT,POST,DELETE");
 header("Access-Control-Allow-Headers: Content-Type, Authorization");
 
require_once("php7_mysql_shim.php");

function valida_email($email){
    if(substr($email, -16) != "naoenviar.com.br")
       return true;
    else
       return false;
}

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


    //*************************PARTE DO ENVIO DE EMAIL DA APOLICE *************************//
    $pdo = new PDO("mysql:host=localhost;dbname=segurosja;", "segurosja", "m1181s2081_", array());
     
      //$pdo = new PDO("mysql:host=localhost;dbname=segurosja;", "root", "", array());
    
    $sql = "SELECT *,(SELECT email_fianca FROM corretores WHERE corretores.codigo=fianca.corretor) as email_corretor1,
            (SELECT email_fianca2 FROM corretores WHERE corretores.codigo=fianca.corretor) as email_corretor2,
            (SELECT email_fianca3 FROM corretores WHERE corretores.codigo=fianca.corretor) as email_corretor3
            from fianca where codigo='$registro'";
    
    $sth = $pdo->prepare($sql);
    $sth->execute();
    $dados_fianca = $sth->fetch(PDO::FETCH_ASSOC);

$email_imob      = $dados_fianca['email_imobs'];
$email_alt1      = $dados_fianca['email_alt1'];
$email_alt2      = $dados_fianca['email_alt2'];
$email_alt3      = $dados_fianca['email_alt3'];
$email_cor1      = $dados_fianca['email_corretor1'];
$email_cor2      = $dados_fianca['email_corretor2'];
$email_cor3      = $dados_fianca['email_corretor3'];
$cod_cor         = $dados_fianca['corretor'];

$mensagem = "<html><body><div align='center'><b>Segue em anexo a Apólice</b></body></html>";

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
$mail->FromName = "Seguros Ja! Apolice"; // Seu nome
$mail->AddReplyTo("cobertura@segurosja.com.br"); // Email para receber as respostas
// Define os dados técnicos da Mensagem
$mail->IsHTML(true); // Define que o e-mail será enviado como HTML
$mail->CharSet = 'iso-8859-1'; // Charset da mensagem (opcional)

//$mail->AddBCC("denilson.anhanguera@gmail.com");

if(valida_email($email_imob)){$mail->AddAddress("$email_imob");}
if($email_cor1 <> ""){$mail->AddAddress("$email_cor1");}
if($email_cor2 <> ""){$mail->AddCC("$email_cor2");}
if($email_cor3 <> ""){$mail->AddCC("$email_cor3");}

if(!empty(trim($email_alt1)) && (valida_email($email_alt1))){
    $mail->AddAddress("$email_alt1");
}
        
if(!empty(trim($email_alt2)) && (valida_email($email_alt2))){
    $mail->AddAddress("$email_alt2");
}
        
if(!empty(trim($email_alt3)) && (valida_email($email_alt3))){
    $mail->AddAddress("$email_alt3");
}

//$mail->Body = $mensagem;//apagar
$mail->MsgHTML($mensagem);
$mail->Subject = "Apólice"; //apagar
$mail->AddAttachment($uploadPath);// anexar arquivo
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
