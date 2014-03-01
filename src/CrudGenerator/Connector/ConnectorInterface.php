<?php

namespace CrudGenerator\Connector;


use CrudGenerator\Table\Index;
use CrudGenerator\Table\Reference;
use CrudGenerator\Table\Table;

interface ConnectorInterface
{

    public function __construct(\PDO $pdo);

    /**
     * @return Table[]
     */
    public function getTables();

    /**
     * @param $name
     * @return Table
     */
    public function getTable($name);

    /**
     * @param $name
     * @return Index[]
     */
    public function getIndexes($name);

    /**
     * @param $name
     * @return Reference[]
     */
    public function getReferences($name);
}
