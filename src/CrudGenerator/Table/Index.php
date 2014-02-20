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
     * @param int $cardinality
     */
    public function setCardinality($cardinality)
    {
        $this->cardinality = $cardinality;
    }

    /**
     * @return int
     */
    public function getCardinality()
    {
        return $this->cardinality;
    }

    /**
     * @param string $collation
     */
    public function setCollation($collation)
    {
        $this->collation = $collation;
    }

    /**
     * @return string
     */
    public function getCollation()
    {
        return $this->collation;
    }

    /**
     * @param array $columns
     */
    public function setColumns($columns)
    {
        $this->columns = $columns;
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
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param int $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param boolean $unique
     */
    public function setUnique($unique)
    {
        $this->unique = $unique;
    }

    /**
     * @return boolean
     */
    public function getUnique()
    {
        return $this->unique;
    }

} 