<?php
namespace CrudGenerator\Table;


use CrudGenerator\Table\Type\Special;
use CrudGenerator\Table\Type\Type;

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
     * @var Special
     */
    private $specialType;

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
     * @var string
     */
    private $comment;

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

        return count($this->references) > 0;

    }

    /**
     * @return bool
     */
    public function isUnique()
    {

        return $this->key == Key::UNIQUE;

    }

    /**
     * @return bool
     */
    public function isAutoIncrement()
    {

        return $this->autoIncrement;

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
        return isset($this->references[0]) ? $this->references[0] : null;
    }

    /**
     * @param Special $specialType
     */
    public function setSpecialType($specialType)
    {
        $this->specialType = $specialType;
    }

    /**
     * @return Special
     */
    public function getSpecialType()
    {
        return $this->specialType;
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
     * @param string $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }



} 