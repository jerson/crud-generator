<?php
namespace Generator\Crud\Plugins;

use Generator\Crud\Table\Table;

class MySQL implements Base {

    /**
     * @var \PDO
     */
    private $pdo;

    public function __construct(\PDO $pdo)
    {
       $this->pdo = $pdo;
    }

    /**
     * @inheritdoc
     */
    public function getTables()
    {
        // TODO: Implement getTables() method.
    }

    /**
     * @inheritdoc
     */
    public function getTable($name)
    {
        // TODO: Implement getTable() method.
    }
}