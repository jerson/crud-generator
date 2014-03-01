<?php


namespace CrudGenerator\Parser;


use CrudGenerator\Table\Field;

interface ParserInterface
{

    /**
     * @param Field $field
     * @return string
     */
    public function getType(Field $field);

    /**
     * @param Field $field
     * @return string
     */
    public function getSpecialType(Field $field);
}
