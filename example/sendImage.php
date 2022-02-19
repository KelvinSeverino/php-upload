<?php 

require __DIR__ . "/../source/Image.php";


/**
 * UPLOAD IMAGE
 */
//Instanciando Classe Upload de Imagem
$uploadImage = (new Image());

//Atribuindo valores do input na variavel $file
$fileImage = $_FILES["image"];

//Atribundo o caminho aonde sera salvo os input de files
$path = __DIR__ . "/../storage/";

//Upload de Imagem
//$uploadImage->upload($fileImage, $path);
var_dump($uploadImage->upload($fileImage, $path, 1024));


/**
 * UPLOAD IMAGE COMPRESS
 */
//Instanciando Classe Upload de Imagem
//$uploadImage = (new Image());

//Atribuindo valores do input na variavel $file
//$fileImageCompress = $_FILES["image"];

//Localizacao do diretorio de uploads
//$path = __DIR__ . "/../storage/";

//Upload de Imagem com Compressão
//$uploadImage->uploadCompressImage( $fileImageCompress, $path, 60 );
//var_dump($uploadImage->uploadCompressImage( $fileImageCompress, $path, 60 ));