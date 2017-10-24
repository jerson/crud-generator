<?php


namespace CrudGenerator\Parser;


use CrudGenerator\Table\Field;
use CrudGenerator\Table\Table;
use CrudGenerator\Table\Type\Type;
use Stringy\Stringy;

class Golang implements ParserInterface
{


    /**
     * @inheritdoc
     */
    public function getType(Field $field)
    {

        if ($field->isForeign()) {
            $reference = $field->getReference();
            $tableReference = $reference->getTable();
            return Stringy::create($tableReference)->upperCamelize();
        }

        return $this->getRealType($field);
    }

    /**
     * @param Field $field
     * @return string
     */
    public function getRealType(Field $field)
    {

        switch ($field->getType()->getName()) {
            case Type::INTEGER:
            case Type::BIGINT:
                $type = 'int';
                break;
            case Type::CHAR:
            case Type::VARCHAR:
                $type = 'string';
                break;
            case Type::ENUM:
                $type = 'string';
                break;
            case Type::DOUBLE:
            case Type::FLOAT:
            case Type::REAL:
                $type = 'float64';
                break;
            case Type::TEXT:
                $type = 'string';
                break;
            case Type::TINYINT:
            case Type::BOOL:
                $type = 'bool';
                break;
            case Type::DATE:
            case Type::DATETIME:
            case Type::TIME:
                $type = 'time.Time';
                break;
            case Type::TIMESTAMP:
                $type = 'int64';
                break;
            default:
                $type = 'string';
                break;

        }

        return $type;
    }

    /**
     * @param $string
     * @return string
     */
    public function getPrimaryName($string)
    {
        if (strlen($string) < 4) {
            return strtoupper($string);
        }
        return str_replace(['_id', '_url'], ['_ID', '_URL'], $string);
    }

    /**
     * @inheritdoc
     */
    public function getSpecialType(Field $field)
    {
        return;
    }

    /**
     * @param Field $field
     * @return string
     */
    public function getParseType(Field $field)
    {

        switch ($field->getType()->getName()) {
            case Type::INTEGER:
            case Type::TINYINT:
                $type = 'int';
                break;
            case Type::CHAR:
                $type = '';
                break;
            case Type::VARCHAR:
                $type = '';
                break;
            case Type::ENUM:
                $type = '';
                break;
            case Type::DOUBLE:
                $type = 'float64';
                break;
            case Type::FLOAT:
                $type = 'float64';
                break;
            case Type::REAL:
                $type = 'float64';
                break;
            case Type::TEXT:
                $type = '';
                break;
            case Type::BOOL:
                $type = 'bool';
                break;
            case Type::DATE:
                $type = 'time.Time';
                break;
            case Type::DATETIME:
                $type = 'time.Time';
                break;
            case Type::TIME:
                $type = 'time.Time';
                break;
            case Type::TIMESTAMP:
                $type = 'time.Time';
                break;
            default:
                $type = '';
                break;

        }

        return $type;
    }
}
