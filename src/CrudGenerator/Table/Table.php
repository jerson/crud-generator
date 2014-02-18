<?php
namespace CrudGenerator\Table;


class Table
{

    const PRIMARY_KEY = 1;
    const FOREIGN_KEY = 2;
    const NO_KEY = 3;


    /**
     * @var int
     */
    private $field;

    /**
     * @var TableType
     */
    private $type;

    /**
     * @var bool
     */
    private $allowNull;

    /**
     * @var int
     */
    private $key;

    /**
     * @var string
     */
    private $default;

    /**
     * @var bool
     */
    private $autoIncrement;

    /**
     * @var array
     */
    private $references;

    /**
     * @var array
     */
    private $indexes;

    /**
     * @param boolean $allowNull
     */
    public function setAllowNull($allowNull)
    {
        $this->allowNull = $allowNull;
    }

    /**
     * @return boolean
     */
    public function getAllowNull()
    {
        return $this->allowNull;
    }

    /**
     * @param boolean $autoIncrement
     */
    public function setAutoIncrement($autoIncrement)
    {
        $this->autoIncrement = $autoIncrement;
    }

    /**
     * @return boolean
     */
    public function getAutoIncrement()
    {
        return $this->autoIncrement;
    }

    /**
     * @param string $default
     */
    public function setDefault($default)
    {
        $this->default = $default;
    }

    /**
     * @return string
     */
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * @param int $field
     */
    public function setField($field)
    {
        $this->field = $field;
    }

    /**
     * @return int
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @param int $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * @return int
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param \CrudGenerator\Table\TableType $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return \CrudGenerator\Table\TableType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param array $indexes
     */
    public function setIndexes($indexes)
    {
        $this->indexes = $indexes;
    }

    /**
     * @return array
     */
    public function getIndexes()
    {
        return $this->indexes;
    }

    /**
     * @param array $references
     */
    public function setReferences($references)
    {
        $this->references = $references;
    }

    /**
     * @return array
     */
    public function getReferences()
    {
        return $this->references;
    }




} 