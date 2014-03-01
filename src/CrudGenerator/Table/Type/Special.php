<?php
namespace CrudGenerator\Table\Type;


class Special implements TypeInterface
{


    const EMAIL = 100;
    const PASSWORD = 101;
    const CELLPHONE = 102;
    const PHONE = 103;
    const WEEK = 104;
    const URL = 105;
    const MONTH = 106;
    const RANGE = 107;
    const HTML = 108;
    const MARKDOWN = 109;
    const OPTIONS = 110;
    const FILE = 111;
    const IMAGE = 112;
    const UNKNOWN = 113;

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
