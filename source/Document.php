<?php

require __DIR__ . "/../source/Upload.php";

class Document extends Upload
{
    /**
     * Tipos permitidos/MIMEs
     * @var array
     */
    protected static $allowTypes = [
        "application/pdf",
        "image/jpeg",
        "image/jpg",
        "image/png",
    ];

    /**
     * Extensoes permitidas
     * @var array
     */
    protected static $extensions = [
        "pdf",
        "jpeg",
        "jpg",
        "png"
    ];

    /**
     * Tipos permitidos de MIMEs/IMAGENS
     * @var array
     */
    protected static $allowTypesImages = [
        "image/jpeg",
        "image/jpg",
        "image/png",
    ];

    /**
     * Extensoes permitidas de IMAGENS
     * @var array
     */
    protected static $extensionsImages = [
        "jpeg",
        "jpg",
        "png"
    ];
    
    /** upload
     * @param  mixed $file - Arquivo
     * @param  string $path - Caminho do diretorio para salvar o arquivo
     * @param  int $sizeKbLimit - Tamanho limite do arquivo em kB
     * @return void
     */
    public function upload($file, $path, $sizeKbLimit)
    {
        if($file['error'] == 0)
        {
            //Transformando tamanho de kilobyte kB para byte B
            $sizeBResult = $sizeKbLimit * 1024;
            if($file['size'] > $sizeBResult)
            {
                //Transformando tamanho de kilobyte kB para megabyte MB
                $sizeMbResult = $sizeKbLimit / 1024;
                //Retorna false em caso de erro
                echo("Arquivo excede o tamanho permitido de {$sizeMbResult}MB");
                return false;
            }

            //Pegando nome original do arquivo
            $originalName = $file['name'];

            //Pegando extensao do arquivo
            $this->ext = mb_strtolower(pathinfo($file['name'])['extension']);

            //Pegando Caminho aonde sera salvo
            $this->path = $path;

            //Gerando nome do arquivo
            $this->generateName();

            //Compondo novo nome com a extensao do arquivo
            $this->name = "{$this->name}." . $this->ext;

            //Verifica se é arquivo com tipo/extensao de imagem
            if(in_array($file['type'], static::$allowTypesImages) || in_array($this->ext, static::$extensionsImages))
            {   
                //Realiza compressao e upload
                if(!$this->uploadCompressImage($file, $path, 60))
                {
                    //Retorna false em caso de erro
                    echo("Erro ao realizar upload do arquivo {$originalName}");
                    return false;
                }
                return $this->name;
            }
            else
            {
                //Verificando o Tipo/Extensao do arquivo
                if (!in_array($file['type'], static::$allowTypes) || !in_array($this->ext, static::$extensions)) {
                    //throw new \Exception("Not a valid file type or extension");
                    echo("Formato do arquivo {$originalName} é inválido");
                    return false;
                }

                //Movendo imagem para o diretorio de uploads
                if(move_uploaded_file($file['tmp_name'], $this->path . $this->name))
                {                
                    //Upload realizado com sucesso
                    return $this->name;
                }

                //Retorna false em caso de erro
                echo("Erro ao realizar upload do arquivo {$originalName}");
                return false; 
            }     
        }
        //Retorna false em caso de erro
        echo("Erro ao processar o arquivo");
        return false;          
    }

    /** uploadCompressImage
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

            //Pegando nome original do arquivo
            $originalName = $fileSource['name'];

            //Pegando extensao do arquivo
            $this->ext = mb_strtolower(pathinfo($fileSource['name'])['extension']);

            //Gerando nome do arquivo
            $this->generateName();

            //Compondo novo nome com a extensao do arquivo
            $this->name = "{$this->name}." . $this->ext;

            //Verificando o Tipo/Extensao do arquivo
            if (!in_array($fileSource['type'], static::$allowTypes) || !in_array($this->ext, static::$extensions)) {
                //throw new \Exception("Not a valid file type or extension");
                echo("Formato do arquivo {$originalName} é inválido");
                return false;
            }

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

            //Função para verificar se diretorio existe
            $this->directory($this->path);

            //Salvando imagem comprimida
            if(imagejpeg($image, $this->path . $this->name, $quality))
            {
                //Upload realizado com sucesso
                return $this->name;
            }

            //Retorna false em caso de erro
            echo("Erro ao realizar upload do arquivo");
            return false; 
        }        
        //Retorna false em caso de erro
        echo("Erro ao processar o arquivo");
        return false;  
    }
}