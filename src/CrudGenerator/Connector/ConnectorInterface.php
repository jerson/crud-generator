<?php

namespace CrudGenerator\Connector;


use CrudGenerator\Table\Table;

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
     * @return array
     */
    public function getIndexes($name);

    /**
     * @param $name
     * @return array
     */
    public function getReferences($name);

}