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

    /**
     * upload
     *
     * @param  mixed $file - Arquivo
     * @param  mixed $path - Caminho do diretorio para salvar o arquivo
     * @return void
     */
    public function upload($file, $path)
    {
        //Pegando Caminho aonde sera salvo
        $this->path = $path;

        //Pegando extensao do arquivo
        $this->ext = mb_strtolower(pathinfo($file['name'])['extension']);

        //Gerando nome do arquivo
        $this->generateName();

        //Compondo novo nome com a extensao do arquivo
        $this->name = "{$this->name}." . $this->ext;

        //Movendo imagem para o diretorio de uploads
        move_uploaded_file( $file['tmp_name'], $this->path . $this->name );
    }
}