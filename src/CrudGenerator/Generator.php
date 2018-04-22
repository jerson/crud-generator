<?php

namespace CrudGenerator;


use CrudGenerator\Bundle\BundleInterface;
use CrudGenerator\Bundle\Controller;
use CrudGenerator\Bundle\Model;
use CrudGenerator\Bundle\View;
use CrudGenerator\Connector\ConnectorInterface;
use CrudGenerator\Connector\MySQL;
use CrudGenerator\Table\Table;
use CrudGenerator\Twig\Extension;
use Gaufrette\Adapter\Local;
use Gaufrette\Filesystem;
use Stringy\Stringy;
use Twig_Environment;
use Twig_Loader_Filesystem;

class Generator
{

    /**
     * @var ConnectorInterface
     */
    private $connector;

    /**
     * @var array
     */
    private $config;

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
     * @throws \Exception
     */
    public function __construct(array $config)
    {

        $this->configureConnector($config['database']);
        $this->tables = $this->connector->getTables();

        @mkdir($config['output']['dir'], 0777, true);
        $adapter = new Local($config['output']['dir']);
        $this->fileSystem = new Filesystem($adapter);

        $loader = new Twig_Loader_Filesystem(__DIR__);
        $this->twig = new Twig_Environment($loader, ['autoescape' => false]);
        $extension = new Extension();
        $this->twig->addExtension($extension);

        $this->config = $config;

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


                $dsn = sprintf(
                    'mysql:host=%s%s;dbname=%s',
                    !empty($database['host']) ? $database['host'] : 'localhost',
                    !empty($database['port']) ? ':' . $database['port'] : '',
                    $database['name']
                );

                $pdo = new \PDO($dsn, $database['user'], $database['password']);

                $this->connector = new MySQL($pdo);
                break;

            default:

                throw new \Exception(sprintf('Driver no Soportado %s', $driver));
                break;

        }

    }

    /**
     * @return Table[]
     */
    public function getTables()
    {
        return $this->tables;
    }

    /**
     * @param Table[] $tables
     */
    public function setTables($tables)
    {
        $this->tables = $tables;
    }

    /**
     * @param $type
     * @param $layout
     * @throws \Exception
     */
    public function generate($type, $layout)
    {

        $layout = $this->parseLayout($layout);
        $class = sprintf('\\CrudGenerator\\Bundle\\%s\\%s\\%s', $type, $layout, $type);

        if (!class_exists($class)) {
            throw new \Exception(sprintf('El %s Layout "%s" no existe', $type, $layout));
        }

        /** @var BundleInterface $model */
        $model = new $class($this->fileSystem, $this->twig, $this->config);
        $model->setTables($this->tables);
        $model->generate();


    }

    /**
     * @param $string
     * @return string
     */
    private function parseLayout($string)
    {
        return Stringy::create($string)->upperCamelize()->__toString();
    }


}
