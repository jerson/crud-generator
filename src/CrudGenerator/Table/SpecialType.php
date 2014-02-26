<?php
namespace CrudGenerator\Table;


class SpecialType implements TypeInterface {


    CONST EMAIL = 100;
    CONST PASSWORD = 200;
    CONST CELLPHONE = 300;
    CONST PHONE = 400;
    CONST DOCUMENT = 500;
    CONST UNKNOWN = 999;

    /**
     * @var int
     */
    private $name;

    /**
     * @var int
     */
    private $length;

    /**
     * @var array
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
     * @inheritdoc
     */
    public function setOptions($options)
    {
        $this->options = $options;
    }

    /**
     * @inheritdoc
     */
    public function getOptions()
    {
        return $this->options;
    }
}