<?php


namespace CrudGenerator\Parser;


use CrudGenerator\Table\Field;

class Php implements ParserInterface{

    /**
     * @inheritdoc
     */
    public function getType(Field $field)
    {
       return $field->getType()->getName();
    }
}