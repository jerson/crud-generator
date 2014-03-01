<?php


namespace CrudGenerator\Parser;


use CrudGenerator\Table\Field;

class Php implements ParserInterface
{

    /**
     * @inheritdoc
     */
    public function getType(Field $field)
    {
        return $field->getType()->getName();
    }

    /**
     * @inheritdoc
     */
    public function getSpecialType(Field $field)
    {
        return;
    }
}
