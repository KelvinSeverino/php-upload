<?php

abstract class Upload
{
    /** @var string */
    protected $path;

    /** @var resource */
    protected $file;

    /** @var string */
    protected $name;

    /** @var string */
    protected $ext;

    /** @var array */
    protected static $allowTypes = [];

    /** @var array */
    protected static $extensions = [];

    public function __construct()
    {       
    }

    /** Retorna array com os Tipos Permitidos
     * @return array
     */
    public static function isAllowed(): array
    {
        return static::$allowTypes;
    }

    /** Retorna array com as Extensoes Permitidas
     * @return array
     */
    public static function isExtension(): array
    {
        return static::$extensions;
    }

    /** Gera um nome com base em hash aleatoriamente
     * @return string
     */
    protected function generateName(): string
    {
        //Gerando hash como nome
        $this->name = md5(uniqid(rand(), true));

        return $this->name;
    }

        
    /** directory
     * @param  string $pathDir
     * @param  int $mode
     * @return void
     */
    public function directory(string $pathDir, int $mode = 0755): void
    {
        if (!file_exists($pathDir) || !is_dir($pathDir)) {
            mkdir($pathDir, $mode, true);
        }
    }

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

            //Função para verificar se diretorio existe
            $this->directory($this->path);

            //Movendo imagem para o diretorio de uploads
            if(move_uploaded_file( $file['tmp_name'], $this->path . $this->name ))
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