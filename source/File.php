<?php

require __DIR__ . "/../source/Upload.php";

class File extends Upload
{
    /**
     * Tipos permitidos/MIMEs
     * @var array
     */
    protected static $allowTypes = [
        "application/pdf",
        "text/csv",
        "application/vnd.ms-excel",        
        "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
        "application/zip",
        'application/x-rar-compressed',
    ];

    /**
     * Extensoes permitidas
     * @var array
     */
    protected static $extensions = [
        "pdf",
        "csv",
        "xls",
        "xlsx",
        "zip",
        "rar"
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
                //throw new \Exception("Not a valid file type or extension");
                echo("Formato do arquivo {$originalName} é inválido");
                return false;
            }

            //Função para verificar se diretorio existe
            $this->directory($this->path);

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
        //Retorna false em caso de erro
        echo("Erro ao processar o arquivo");
        return false;         
    }
}