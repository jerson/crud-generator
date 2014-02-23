<?php


namespace CrudGenerator\Parser;


use CrudGenerator\Table\Field;
use CrudGenerator\Table\Type;
use Stringy\Stringy;

class Java implements ParserInterface{


    /**
     * @inheritdoc
     */
    public function getType(Field $field)
    {

        if($field->isForeign()){
            $references = $field->getReferences();
            $tableReference = $references[0]->getTable();

            return Stringy::create($tableReference)->upperCamelize();
        }

        switch ($field->getType()->getName()) {
            case Type::INTEGER:
                $type = 'int';
                break;
            case Type::CHAR:
                $type = 'char';
                break;
            case Type::VARCHAR:
                $type = 'String';
                break;
            case Type::ENUM:
                $type = 'String';
                break;
            case Type::DOUBLE:
                $type = 'double';
                break;
            case Type::FLOAT:
                $type = 'float';
                break;
            case Type::REAL:
                $type = 'float';
                break;
            case Type::TEXT:
                $type = 'String';
                break;
            case Type::BOOL:
                $type = 'boolean';
                break;
            case Type::DATE:
                $type = 'Date';
                break;
            case Type::DATE_TIME:
                $type = 'Date';
                break;
            case Type::TIME:
                $type = 'String';
                break;
            case Type::TIMESTAMP:
                $type = 'String';
                break;
            default:
                $type = 'String';
                break;

        }

        return $type;
    }
}