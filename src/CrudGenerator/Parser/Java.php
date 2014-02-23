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
                $type = 'int';
                break;
            case Type::CHAR:
                $type = 'String';
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
                $type = 'Date';
                break;
            case Type::TIMESTAMP:
                $type = 'Date';
                break;
            default:
                $type = 'String';
                break;

        }

        return $type;
    }


    /**
     * @param Field $field
     * @return string
     */
    public function getParseType(Field $field)
    {

        switch ($field->getType()->getName()) {
            case Type::INTEGER:
                $type = 'Integer';
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
                $type = 'Double';
                break;
            case Type::FLOAT:
                $type = 'Float';
                break;
            case Type::REAL:
                $type = 'Float';
                break;
            case Type::TEXT:
                $type = '';
                break;
            case Type::BOOL:
                $type = 'Boolean';
                break;
            case Type::DATE:
                $type = 'Date';
                break;
            case Type::DATE_TIME:
                $type = 'Date';
                break;
            case Type::TIME:
                $type = 'Time';
                break;
            case Type::TIMESTAMP:
                $type = 'Timestamp';
                break;
            default:
                $type = '';
                break;

        }

        return $type;
    }
}