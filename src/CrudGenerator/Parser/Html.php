<?php


namespace CrudGenerator\Parser;


use CrudGenerator\Table\Field;
use CrudGenerator\Table\SpecialType;
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

    /**
     * @inheritdoc
     */
    public function getSpecialType(Field $field)
    {
        switch ($field->getSpecialType()->getName()) {
            case SpecialType::DOCUMENT:
                $type = 'textarea';
                break;
            case SpecialType::URL:
                $type = 'url';
                break;
            case SpecialType::MONTH:
                $type = 'month';
                break;
            case SpecialType::WEEK:
                $type = 'week';
                break;
            case SpecialType::RANGE:
                $type = 'range';
                break;
            case SpecialType::PHONE:
                $type = 'tel';
                break;
            case SpecialType::CELLPHONE:
                $type = 'tel';
                break;
            case SpecialType::EMAIL:
                $type = 'email';
                break;
            case SpecialType::PASSWORD:
                $type = 'password';
                break;
            default:
                $type = '';
                break;

        }
        return $type;
    }
}