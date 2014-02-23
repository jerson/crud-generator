<?php


namespace CrudGenerator\Bundle;


use CrudGenerator\Parser\Java;
use CrudGenerator\Parser\Php;
use CrudGenerator\Table\Table;
use Gaufrette\Filesystem;

class Base implements BundleInterface{

    /**
     * @var Table[]
     */
    protected  $tables;

    /**
     * @var array
     */
    protected $options;

    /**
     * @var Filesystem
     */
    protected $fileSystem;

    /**
     * @var \Twig_Environment
     */
    protected $twig;

    /**
     * @inheritdoc
     */
    public function __construct(Filesystem $fileSystem, \Twig_Environment $twig, array $options)
    {
        $this->fileSystem = $fileSystem;
        $this->twig = $twig;
        $this->options = $options;

        //$this->twig->addGlobal('fileSystem',$this->fileSystem);
        $this->twig->addGlobal('options',$this->options);
        $this->twig->addGlobal('java',new Java());
        $this->twig->addGlobal('php',new Php());

        $this->configure();
    }

    /**
     * @inheritdoc
     */
    public function configure(){

        $calledClass = get_called_class();

        $calledClass = str_replace('\\','/',$calledClass);
        $parts = explode('/Bundle/',$calledClass);

        $extraClass = (isset($parts[1]) ? $parts[1] : '');
        $parts = explode('/',$extraClass);

        unset($parts[count($parts)-1]);
        $baseDir= __DIR__.'/'.join('/',$parts);

        $loader = new \Twig_Loader_Filesystem(sprintf('%s/Template',$baseDir));
        $this->twig->setLoader($loader);

    }

    /**
     * @inheritdoc
     */
    public function setTables(array $tables)
    {
        $this->tables = $tables;
        $this->twig->addGlobal('tables',$this->tables);
    }

    /**
     * @inheritdoc
     */
    public function generate()
    {
        throw new \Exception('falta implementar método generate');

    }
} 