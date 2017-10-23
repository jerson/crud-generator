<?php

namespace CrudGenerator\Table\Type;


class Type implements TypeInterface
{

    const INTEGER = 1;
    const BIGINT = 100;
    const TINYINT = 2;
    const VARCHAR = 3;
    const ENUM = 4;
    const TEXT = 5;
    const DOUBLE = 6;
    const FLOAT = 7;
    const REAL = 8;
    const BOOL = 9;
    const CHAR = 10;
    const DATE = 11;
    const DATETIME = 12;
    const TIME = 13;
    const TIMESTAMP = 14;
    const BLOB = 15;
    const UNKNOWN = 16;

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
    public function getLength()
    {
        return $this->length;
    }

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @inheritdoc
     */
    public function setName($type)
    {
        $this->name = $type;
    }

    /**
     * @return Option[]
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param Option[] $options
     */
    public function setOptions($options)
    {
        $this->options = $options;
    }
}
