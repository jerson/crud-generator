<?php


namespace CrudGenerator\Parser;


use CrudGenerator\Table\Field;
use CrudGenerator\Table\Type;
use Stringy\Stringy;

class Html implements ParserInterface
{


    /**
     * @inheritdoc
     */
    public function getType(Field $field)
    {

        switch ($field->getType()->getName()) {
            case Type::INTEGER:
            case Type::TINYINT:
                $type = 'number';
                break;
            case Type::CHAR:
                $type = 'text';
                break;
            case Type::VARCHAR:
                $type = 'text';
                break;
            case Type::ENUM:
                $type = 'select';
                break;
            case Type::DOUBLE:
                $type = 'number';
                break;
            case Type::FLOAT:
                $type = 'number';
                break;
            case Type::REAL:
                $type = 'number';
                break;
            case Type::TEXT:
                $type = 'textarea';
                break;
            case Type::BOOL:
                $type = 'checkbox';
                break;
            case Type::DATE:
                $type = 'date';
                break;
            case Type::DATETIME:
                $type = 'datetime-local';
                break;
            case Type::TIME:
                $type = 'time';
                break;
            case Type::TIMESTAMP:
                $type = 'datetime-local';
                break;
            default:
                $type = 'text';
                break;

        }
        return $type;
    }

}