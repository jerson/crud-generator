<?php


namespace CrudGenerator\Parser;


use CrudGenerator\Table\Field;
use CrudGenerator\Table\Type\Special;
use CrudGenerator\Table\Type\Type;

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
        if (!$field->getSpecialType()) {
            return '';
        }

        switch ($field->getSpecialType()->getName()) {
            case Special::HTML:
                $type = 'textarea';
                break;
            case Special::MARKDOWN:
                $type = 'textarea';
                break;
            case Special::URL:
                $type = 'url';
                break;
            case Special::MONTH:
                $type = 'month';
                break;
            case Special::FILE:
                $type = 'file';
                break;
            case Special::IMAGE:
                $type = 'file';
                break;
            case Special::OPTIONS:
                $type = 'text';
                break;
            case Special::WEEK:
                $type = 'week';
                break;
            case Special::RANGE:
                $type = 'range';
                break;
            case Special::PHONE:
                $type = 'tel';
                break;
            case Special::CELLPHONE:
                $type = 'tel';
                break;
            case Special::EMAIL:
                $type = 'email';
                break;
            case Special::PASSWORD:
                $type = 'password';
                break;
            default:
                $type = '';
                break;

        }
        return $type;
    }
}
