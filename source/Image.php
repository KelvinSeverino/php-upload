<?php

require __DIR__ . "/../source/Upload.php";

class Image extends Upload
{
    /**
     * Tipos permitidos/MIMEs
     * @var array
     */
    protected static $allowTypes = [
        "image/jpeg",
        "image/jpg",
        "image/png",
    ];

    /**
     * Extensoes permitidas
     * @var array
     */
    protected static $extensions = [
        "jpeg",
        "jpg",
        "png"
    ];
    
    /**
     * upload
     *
     * @param  mixed $file - Imagem
     * @param  mixed $path - Caminho do diretorio para salvar a imagem
     * @return void
     */
    public function upload($file, $path)
    {
        if($file['error'] != 1)
        {
            //Pegando Caminho aonde sera salvo
            $this->path = $path;

            //Pegando extensao do arquivo
            $this->ext = mb_strtolower(pathinfo($file['name'])['extension']);

            //Gerando nome do arquivo
            $this->generateName();

            //Compondo novo nome com a extensao do arquivo
            $this->name = "{$this->name}." . $this->ext;

            //Verificando o Tipo/Extensao do arquivo
            if (!in_array($file['type'], static::$allowTypes) || !in_array($this->ext, static::$extensions)) {
                throw new \Exception("Not a valid file type or extension");
                return false;
            }

            //Movendo imagem para o diretorio de uploads
            if(move_uploaded_file($file['tmp_name'], $this->path . $this->name))
            {                
                //Upload realizado com sucesso
                return true;
            }

            //Retorna false em caso de erro
            return false; 
        }
        //Retorna false em caso de erro
        return false;        
    }
    
    /**
     * uploadCompressImage
     *
     * @param  mixed $fileSource - Um resource de imagem, retornado por funções de criação de imagens
     * @param  mixed $path - O caminho para salvar o arquivo.
     * @param  int $quality - vai de 0 (pior qualidade, menor arquivo) a 100 (melhor qualidade, maior arquivo)
     * @return void
     */
    function uploadCompressImage($fileSource, $path, $quality) 
    {
        //Pegando o temp_name do arquivo de origem
        $fileTemp = $fileSource['tmp_name'];

        //Verifica se o temp_name tem valor
        if($fileSource['error'] != 1 || !empty($fileTemp))
        {
            //Pegando Caminho aonde sera salvo
            $this->path = $path;

            //Pegando extensao do arquivo
            $this->ext = mb_strtolower(pathinfo($fileSource['name'])['extension']);

            //Gerando nome do arquivo
            $this->generateName();

            //Compondo novo nome com a extensao do arquivo
            $this->name = "{$this->name}." . $this->ext;

            //Obtem o tamanho de uma imagem
            $fileInfo = getimagesize($fileTemp);

            if ($fileInfo['mime'] == 'image/jpeg')
            {
                $image = imagecreatefromjpeg($fileTemp);
            } 
            elseif ($fileInfo['mime'] == 'image/png') 
            {
                $image = imagecreatefrompng($fileTemp);
            }
            elseif ($fileInfo['mime'] == 'image/gif') 
            {
                $image = imagecreatefromgif($fileTemp);
            } 

            //Salvando imagem comprimida
            if(imagejpeg($image, $this->path . $this->name, $quality))
            {
                //Upload realizado com sucesso
                return true;
            }

            //Retorna false em caso de erro
            return false;
        }        
        //Retorna false em caso de erro
        return false;
    }
}