<?php

namespace Generator\Crud\Plugins;


use Generator\Crud\Table\Table;

interface Base {

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

} 