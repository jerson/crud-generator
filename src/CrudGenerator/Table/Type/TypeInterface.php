<?php

namespace CrudGenerator\Table\Type;

interface TypeInterface
{
    /**
     * @param Option[] $options
     */
    public function setOptions($options);

    /**
     * @return Option[]
     */
    public function getOptions();

    /**
     * @return int
     */
    public function getName();

    /**
     * @return int
     */
    public function getLength();

    /**
     * @param int $length
     */
    public function setLength($length);

    /**
     * @param int $type
     */
    public function setName($type);
}