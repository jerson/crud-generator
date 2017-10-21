<?php

namespace CrudGenerator\Connector;

use CrudGenerator\Table\Key;
use CrudGenerator\Table\Type\Option;
use CrudGenerator\Table\Type\Special;
use CrudGenerator\Table\Type\Type;
use Stringy\Stringy;

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
        $options = [];
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
                //FIXME a veces no encuentra las opciones de enum
                $lengthParam = isset($matches['length']) ? $matches['length'] : '';
                $stringOptions = str_replace(['(', ')', '\''], '', $lengthParam);
                $options = explode(',', $stringOptions);

                $newOptions = [];
                foreach ($options as $value) {

                    $option = new Option();
                    $option->setName(Stringy::create($value)->slugify()->humanize()->titleize());
                    $option->setValue($value);
                    $newOptions[] = $option;
                }
                $options = $newOptions;

            } else {
                $length = isset($matches['length']) ? (int)str_replace(['(', ')'], '', $matches['length']) : 0;
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
     * @param string $comment
     * @return Special
     * @throws \Exception
     */
    protected function parseFieldSpecialType($comment)
    {
        $tableType = new Special();

        preg_match('|\[type:(?P<type>[a-zA-Z0-9\s]+)(, ?options:(?P<options>[\w\W}{]+))?]|', $comment, $matches);
        //  preg_match('|\[(?P<type>[a-zA-Z0-9]+):(?P<value>[a-zA-Z0-9]+)]|',$comment,$match);


        if (!empty($matches['type'])) {

            $matches['type'] = strtolower($matches['type']);

            switch ($matches['type']) {
                case 'email':
                    $name = Special::EMAIL;
                    break;
                case 'password':
                    $name = Special::PASSWORD;
                    break;
                case 'cellphone':
                    $name = Special::CELLPHONE;
                    break;
                case 'phone':
                    $name = Special::PHONE;
                    break;
                case 'week':
                    $name = Special::WEEK;
                    break;
                case 'url':
                    $name = Special::URL;
                    break;
                case 'month':
                    $name = Special::MONTH;
                    break;
                case 'range':
                    $name = Special::RANGE;
                    break;
                case 'html':
                    $name = Special::HTML;
                    break;
                case 'markdown':
                    $name = Special::MARKDOWN;
                    break;
                case 'options':
                    $name = Special::OPTIONS;
                    break;
                case 'file':
                    $name = Special::FILE;
                    break;
                case 'image':
                    $name = Special::IMAGE;
                    break;
                default:
                    $name = Special::UNKNOWN;
                    break;
            }

            $tableType->setName($name);

            if (isset($matches['options'])) {

                $options = @json_decode($matches['options'], true);
                $tableType->setLength(isset($options['length']) ? (int)$options['length'] : 0);

                $newOptions = [];
                foreach ($options as $value => $name) {

                    $option = new Option();
                    $option->setName(Stringy::create($name)->slugify()->humanize()->titleize());
                    $option->setValue($value);
                    $newOptions[] = $option;
                }
                $options = $newOptions;
                $tableType->setOptions($options);

            }


        }

        return $tableType;

    }

    /**
     * @param $comment
     * @return string
     */
    protected function parseFieldComment($comment)
    {
        return trim(preg_replace('|\[type:([a-zA-Z0-9\s]+)(, ?options:([\w\W}{]+))?]|', '', $comment));
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
