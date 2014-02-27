<?php
namespace CrudGenerator\Table\Type;


class Special implements TypeInterface {


    CONST EMAIL = 100;
    CONST PASSWORD = 101;
    CONST CELLPHONE = 102;
    CONST PHONE = 103;
    CONST WEEK = 104;
    CONST URL = 105;
    CONST MONTH = 106;
    CONST RANGE = 107;
    CONST HTML = 108;
    CONST MARKDOWN = 109;
    CONST OPTIONS = 110;
    CONST FILE = 111;
    CONST IMAGE = 112;
    CONST UNKNOWN = 113;

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