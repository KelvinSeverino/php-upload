<?php 

require __DIR__ . "/../source/File.php";


/**
 * UPLOAD FILE
 */
//Instanciando Classe Upload de Imagem
$uploadFile = (new File());

//Atribuindo valores do input na variavel $file
$file = $_FILES["file"];

//Atribundo o caminho aonde sera salvo os input de files
$path = __DIR__ . "/../storage/";

//Upload de Imagem
//$uploadFile->upload($file, $path);
var_dump($uploadFile->upload($file, $path, 2048));