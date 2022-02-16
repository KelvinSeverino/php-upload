<?php

require __DIR__ . "/../source/Document.php";


/**
 * UPLOAD DOCUMENT
 */
//Instanciando Classe Upload de Imagem
$uploadDocument = (new Document());

//Atribuindo valores do input na variavel $file
$fileDocument = $_FILES["document"];

//Atribundo o caminho aonde sera salvo os input de files
$path = __DIR__ . "/../storage/";

//Upload de Imagem
//$uploadDocument->upload($fileDocument, $path);
var_dump($uploadDocument->upload($fileDocument, $path));