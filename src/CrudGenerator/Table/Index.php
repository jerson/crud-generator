<?php

namespace CrudGenerator\Table;


class Index
{


    const BTREE = 1;
    const UNKNOWN = 2;

    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $columns;

    /**
     * @var string
     */
    private $collation;

    /**
     * @var int
     */
    private $cardinality;

    /**
     * @var int
     */
    private $type;

    /**
     * @var bool
     */
    private $unique;

    /**
     * @return int
     */
    public function getCardinality()
    {
        return $this->cardinality;
    }

    /**
     * @param int $cardinality
     */
    public function setCardinality($cardinality)
    {
        $this->cardinality = $cardinality;
    }

    /**
     * @return string
     */
    public function getCollation()
    {
        return $this->collation;
    }

    /**
     * @param string $collation
     */
    public function setCollation($collation)
    {
        $this->collation = $collation;
    }

    /**
     * @param $column
     */
    public function addColumn($column)
    {
        $this->columns[] = $column;
    }

    /**
     * @return array
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * @param array $columns
     */
    public function setColumns($columns)
    {
        $this->columns = $columns;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param int $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return boolean
     */
    public function getUnique()
    {
        return $this->unique;
    }

    /**
     * @param boolean $unique
     */
    public function setUnique($unique)
    {
        $this->unique = $unique;
    }
}
