<?php
namespace CrudGenerator\Table;


class Field
{


    /**
     * @var string
     */
    private $name;

    /**
     * @var Type
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
     * @var Reference[]
     */
    private $references;

    /**
     * @var Index[]
     */
    private $indexes;

    function __toString()
    {
       return $this->getName();
    }


    /**
     * @return bool
     */
    public function isPrimary()
    {

        return $this->key == Key::PRIMARY;

    }

    /**
     * @return bool
     */
    public function isForeign()
    {

        return $this->key == Key::FOREIGN;

    }

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
     * @param Type $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return Type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param Index[] $indexes
     */
    public function setIndexes($indexes)
    {
        $this->indexes = $indexes;
    }

    /**
     * @return Index[]
     */
    public function getIndexes()
    {
        return $this->indexes;
    }

    /**
     * @param Reference[] $references
     */
    public function setReferences($references)
    {
        $this->references = $references;
    }

    /**
     * @return Reference[]
     */
    public function getReferences()
    {
        return $this->references;
    }

    /**
     * @return Reference
     */
    public function getReference()
    {
        return isset($this->references[0]) ? $this->references[0] : array();
    }

} 