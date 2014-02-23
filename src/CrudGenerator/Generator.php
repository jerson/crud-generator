<?php

namespace CrudGenerator;


use CrudGenerator\Bundle\ModelInterface;
use CrudGenerator\Connector\ConnectorInterface;
use CrudGenerator\Connector\MySQL;
use CrudGenerator\Table\Table;
use CrudGenerator\Bundle\Model;
use CrudGenerator\Bundle\Controller;
use CrudGenerator\Bundle\Database;
use CrudGenerator\Bundle\View;
use CrudGenerator\Twig\Extension;
use Gaufrette\Adapter\Local;
use Gaufrette\Filesystem;
use Stringy\Stringy;

class Generator
{

    /**
     * @var ConnectorInterface
     */
    private $connector;

    /**
     * @var ModelInterface
     */
    private $model;

    /**
     * @var Table[]
     */
    private $tables;

    /**
     * @var Filesystem
     */
    private $fileSystem;

    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {

        $this->configureConnector($config['database']);
        $this->tables = $this->connector->getTables();

        @mkdir($config['output']['dir'], 0777, true);
        $adapter = new Local($config['output']['dir']);
        $this->fileSystem = new Filesystem($adapter);

        $this->twig = new \Twig_Environment(null, array('autoescape' => false));
        $extension = new Extension();
        $this->twig->addExtension($extension);

    }

    /**
     * @param array $database
     * @throws \Exception
     */
    private function configureConnector(array $database)
    {


        $driver = strtolower($database['driver']);
        switch ($driver) {
            case 'mysql':

                $dsn = sprintf('%s:host=%s:%s;dbname=%s', $database['driver'], $database['host'], $database['port'], $database['name']);
                $pdo = new \PDO($dsn, $database['user'], $database['password']);

                $this->connector = new MySQL($pdo);
                break;

            default:

                throw new \Exception(sprintf('Driver no Soportado %s', $driver));
                break;

        }

    }

    /**
     * @param $string
     * @return string
     */
    private function parseLayout($string)
    {
        $layout = Stringy::create($string)->upperCamelize();
        return $layout;
    }

    /**
     * @param $layout
     * @param array $options
     */
    public function generateModel($layout, array $options)
    {
        $this->generate('Model', $layout, $options);
    }

    /**
     * @param $layout
     * @param array $options
     */
    public function generateDatabase($layout, array $options)
    {
        $this->generate('Database', $layout, $options);
    }

    /**
     * @param $layout
     * @param array $options
     */
    public function generateView($layout, array $options)
    {
        $this->generate('View', $layout, $options);
    }

    /**
     * @param $layout
     * @param array $options
     */
    public function generateController($layout, array $options)
    {
        $this->generate('Controller', $layout, $options);
    }

    /**
     * @param $type
     * @param $layout
     * @param array $options
     * @throws \Exception
     */
    public  function generate($type, $layout, array $options)
    {

        $layout = $this->parseLayout($layout);
        $class = sprintf('\\CrudGenerator\\Bundle\\%s\\%s\\%s', $type, $layout, $type);

        if (!class_exists($class)) {
            throw new \Exception(sprintf('El %s Layout "%s" no existe', $type, $layout));
        }

        $model = new $class($this->fileSystem, $this->twig, $options);

        $model->setTables($this->tables);
        $model->generate();


    }

} 