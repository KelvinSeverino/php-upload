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
    
    /**
     * upload
     *
     * @param  mixed $file - Arquivo
     * @param  mixed $path - Caminho do diretorio para salvar o arquivo
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
}