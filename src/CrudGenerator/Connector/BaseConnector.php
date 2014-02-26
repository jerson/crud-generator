<?php

namespace CrudGenerator\Connector;

use CrudGenerator\Table\Field;
use CrudGenerator\Table\Key;
use CrudGenerator\Table\SpecialType;
use CrudGenerator\Table\Table;
use CrudGenerator\Table\Type;
use Symfony\Component\Config\Definition\Exception\Exception;

class BaseConnector
{


    /**
     * @param $string
     * @return Type
     * @throws \Exception
     */
    protected function parseFieldType($string)
    {

        $tableType = new Type();
        $options = array();
        $length = 0;
        preg_match('|(?P<type>[A-Za-z0-9]+)(?P<length>\([0-9A-Za-z\\\'\\\'\,]+\))?|', $string, $matches);

        if (isset($matches['type']) && !empty($matches['type'])) {

            $matches['type'] = strtolower($matches['type']);

            switch ($matches['type']) {
                case 'tinyint':
                    $name = Type::TINYINT;
                    break;
                case 'int':
                    $name = Type::INTEGER;
                    break;
                case 'char':
                    $name = Type::CHAR;
                    break;
                case 'varchar':
                    $name = Type::VARCHAR;
                    break;
                case 'enum':
                    $name = Type::ENUM;
                    break;
                case 'double':
                    $name = Type::DOUBLE;
                    break;
                case 'float':
                    $name = Type::FLOAT;
                    break;
                case 'real':
                    $name = Type::REAL;
                    break;
                case 'text':
                    $name = Type::TEXT;
                    break;
                case 'bool':
                    $name = Type::BOOL;
                    break;
                case 'date':
                    $name = Type::DATE;
                    break;
                case 'datetime':
                    $name = Type::DATETIME;
                    break;
                case 'time':
                    $name = Type::TIME;
                    break;
                case 'timestamp':
                    $name = Type::TIMESTAMP;
                    break;
                default:
                    $name = Type::UNKNOWN;
                    break;

            }
            $tableType->setName($name);


            if ($name === Type::ENUM) {
                //TODO a veces no encuentra las opciones de enum
                $stringOptions = str_replace(array('(', ')', '\''), '', isset($matches['length']) ? $matches['length'] : '');
                $options = explode(',', $stringOptions);
            } else {
                $length = isset($matches['length']) ? (int)str_replace(array('(', ')'), '', $matches['length']) : 0;
            }

            $tableType->setLength($length);
            $tableType->setOptions($options);

        } else {
            throw new \Exception('Error al parsear el tipo de dato');
        }


        return $tableType;
    }

    /**
     * @param $string
     * @return bool
     */
    protected function parseFieldAllowNull($string)
    {
        return $string === 'NO' ? false : true;
    }

    /**
     * @param $string
     * @return bool
     */
    protected function parseFieldAutoIncrement($string)
    {
        return $string === 'auto_increment' ? true : false;
    }

    /**
     * @param $string
     * @return string
     */
    protected function parseFieldDefault($string)
    {
        return !empty($string) ? $string : '';
    }

    /**
     * @param $string
     * @return string
     */
    protected function parseFieldName($string)
    {
        return $string;
    }


    /**
     * @param $comment
     * @return string
     */
    protected  function parseFieldSpecialType($comment)
    {
        preg_match('|\[type:(?P<type>[a-zA-Z0-9]+)]|',$comment,$match);
      //  preg_match('|\[(?P<type>[a-zA-Z0-9]+):(?P<value>[a-zA-Z0-9]+)]|',$comment,$match);

        if(empty($match)){
            return;
        }

        $match['type'] = strtolower($match['type']);

        switch ($match['type']) {
            case 'email':
                return SpecialType::EMAIL;
                break;
            case 'password':
                return SpecialType::PASSWORD;
                break;
            case 'cellphone':
                return SpecialType::CELLPHONE;
                break;
            case 'phone':
                return SpecialType::PHONE;
                break;
            case 'document':
                return SpecialType::DOCUMENT;
                break;
            default:
                return SpecialType::UNKNOWN;
                break;
        }

    }

    /**
     * @param $comment
     * @return string
     */
    protected  function parseFieldComment($comment)
    {
        return preg_replace('(\[([a-zA-Z0-9]+):([a-zA-Z0-9]+)])','',$comment);
    }


    /**
     * @param $string
     * @return int
     */
    protected function parseFieldKey($string)
    {

        switch ($string) {
            case 'PRI':
                return Key::PRIMARY;
                break;
            case 'MUL':
                return Key::MULTIPLE;
                break;
            case 'UNI':
                return Key::UNIQUE;
                break;
            default:
                return Key::NO;
                break;
        }

    }


} 