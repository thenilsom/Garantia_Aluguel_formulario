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
    echo $json;
} else {
    echo 'Sem arquivo.';
}

mysql_close($conexao);

?>
