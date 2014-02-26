<?php

namespace CrudGenerator\Table;

interface TypeInterface
{
    /**
     * @param array $options
     */
    public function setOptions($options);

    /**
     * @return array
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