<?php

namespace CrudGenerator\Table\Type;


class Type implements TypeInterface
{

    CONST INTEGER = 1;
    CONST TINYINT = 2;
    CONST VARCHAR = 3;
    CONST ENUM = 4;
    CONST TEXT = 5;
    CONST DOUBLE = 6;
    CONST FLOAT = 7;
    CONST REAL = 8;
    CONST BOOL = 9;
    CONST CHAR = 10;
    CONST DATE = 11;
    CONST DATETIME = 12;
    CONST TIME = 13;
    CONST TIMESTAMP = 14;
    CONST BLOB = 15;
    CONST UNKNOWN = 16;

    /**
     * @var int
     */
    private $name;

    /**
     * @var int
     */
    private $length;

    /**
     * @var Option[]
     */
    private $options;

    /**
     * @inheritdoc
     */
    public function setLength($length)
    {
        $this->length = $length;
    }

    /**
     * @inheritdoc
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @inheritdoc
     */
    public function setName($type)
    {
        $this->name = $type;
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param Option[] $options
     */
    public function setOptions($options)
    {
        $this->options = $options;
    }

    /**
     * @return Option[]
     */
    public function getOptions()
    {
        return $this->options;
    }



}