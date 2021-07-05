<?php
 header("Access-Control-Allow-Origin: *");
 header("Access-Control-Allow-Methods: GET,PUT,POST,DELETE");
 header("Access-Control-Allow-Headers: Content-Type, Authorization");
 
require_once("php7_mysql_shim.php");

$registro = $_REQUEST['codigo'];
$conexao = mysql_connect("localhost", "segurosja", "m1181s2081_") or die ("problema na conex�o");
$sql = "select * from fianca where codigo='$registro'";
$consulta = mysql_db_query("segurosja", $sql);
while($campo = mysql_fetch_assoc($consulta)){
    $inquilino=$campo['inquilino'];
    $cod_cor=$campo['corretor'];
}

$inquilino = str_replace(' ', '_', $inquilino);
function remover_caracter($inquilino) {
    $inquilino = preg_replace("/[����������]/", "A", $inquilino);
    $inquilino = preg_replace("/[������]/", "E", $inquilino);
    $inquilino = preg_replace("/[����]/", "I", $inquilino);
    $inquilino = preg_replace("/[����������]/", "O", $inquilino);
    $inquilino = preg_replace("/[������]/", "U", $inquilino);
    $inquilino = preg_replace("/��/", "C", $inquilino);
    $inquilino = preg_replace("/[][><}{)(:;,!?*%~^`@]/", "", $inquilino);
    $inquilino = strtoupper($inquilino);
    return $inquilino;
}
$inquilino = remover_caracter($inquilino);

if ( !empty( $_FILES ) ) {
    $tempPath = $_FILES[ 'file' ][ 'tmp_name' ];
    $path = "./uploads/" . "$registro" . '_' . "$inquilino";
    if(!file_exists ( $path )){
        mkdir($path, 0777);
    }
    $arquivo_nome = str_replace(' ', '_', $_FILES['file']['name']);
    $arquivo_nome = preg_replace('/[`^~\'"]/', null, iconv('UTF-8', 'ASCII//TRANSLIT', $arquivo_nome));
    $uploadPath = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . "$registro" . '_' . "$inquilino" . DIRECTORY_SEPARATOR . $arquivo_nome;
    move_uploaded_file( $tempPath, $uploadPath );
    copy('./uploads/index.php', './uploads/' . $registro . '_' . $inquilino . '/index.php');
    copy('./uploads/.user.ini', './uploads/' . $registro . '_' . $inquilino . '/.user.ini');
    $answer = array( 'answer' => 'Transfer�ncia Conclu�da' );
    $json = json_encode( $answer );
    echo $json;
} else {
    echo 'Sem arquivo.';
}
/*
$mensagem = "<html><body><div align='center'><b>** An�lise de Cadastro para Fian�a Locat�cia n�: ". $registro . " **</b><BR>" . $inquilino . "<BR><BR><BR><BR>Foi feito upload de um ou mais arquivos para an�lise desse cadastro. Clique no link a seguir para abrir a pasta de arquivos desse cliente: <a href='http://www.segurosja.com.br/gerenciador/fianca/app/php/uploads/" . $registro . '_' . $inquilino . "'>Arquivo(s) anexado(s)</a><BR>(Novos arquivos ainda podem ser enviados)</body></html>";

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

if($cod_cor == "0"){$mail->AddAddress('cadastro@maximizaseguros.com.br');$mail->AddCC('aluguel@mx10.com.br');$mail->AddCC('aluguel2@maximizaseguros.com.br');$mail->AddCC('cadastro@mx10.com.br');}
else if($cod_cor == "10"){$mail->AddAddress("cadastro.df@maximizaseguros.com.br");$mail->AddCC("aluguel.df@maximizaseguros.com.br");}
else if($cod_cor == "8"){$mail->AddAddress("mt@maximizaseguros.com.br");$mail->AddCC("mt@mx10.com.br");}
else if($cod_cor == "6"){$mail->AddAddress('cadastro@maximizaseguros.com.br');$mail->AddCC('aluguel@mx10.com.br');$mail->AddCC('aluguel2@maximizaseguros.com.br');$mail->AddCC('cadastro@mx10.com.br');}
else if($cod_cor == "5"){$mail->AddAddress('ccavalcante@riolupo.com.br');$mail->AddBCC('clemente@mx10.com.br');$mail->AddBCC('leandro@maximizaseguros.com.br');}
else if($cod_cor == "11"){$mail->AddAddress('ba@maximizaseguros.com.br');$mail->AddBCC('eduardo@maximizaseguros.com.br');$mail->AddBCC('silmara@maximizaseguros.com.br');}
else{$mail->AddBCC("clemente@maximizaseguros.com.br");}
$mail->AddBCC("leandro@mx10.com.br");

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

echo $retorno_mail;
*/
mysql_close($conexao);

?>
