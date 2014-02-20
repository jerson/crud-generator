<?php

namespace CrudGenerator\Connector;


use CrudGenerator\Table\Field;
use CrudGenerator\Table\Reference;
use CrudGenerator\Table\Index;

interface ConnectorInterface {

    public function __construct(\PDO $pdo);

    /**
     * @return Array
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