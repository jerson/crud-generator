<?php

namespace CrudGenerator\Connector;

use CrudGenerator\Table\Table;
use CrudGenerator\Table\TableType;
use Symfony\Component\Config\Definition\Exception\Exception;

class BaseConnector
{


    /**
     * @param $string
     * @return TableType
     * @throws \Exception
     */
    protected function parseType($string)
    {

        $tableType = new TableType();
        $options = array();
        $length = 0;
        preg_match('|(?P<type>[A-Za-z0-9]+)(?P<length>\([0-9A-Za-z]+\))?|', $string, $matches);

        if (isset($matches['type']) && !empty($matches['type'])) {

            $matches['type'] = strtolower($matches['type']);

            switch ($matches['type']) {
                case 'int':
                    $type = TableType::INTEGER;
                    break;
                case 'char':
                    $type = TableType::CHAR;
                    break;
                case 'varchar':
                    $type = TableType::VARCHAR;
                    break;
                case 'enum':
                    $type = TableType::ENUM;
                    break;
                case 'double':
                    $type = TableType::DOUBLE;
                    break;
                case 'float':
                    $type = TableType::FLOAT;
                    break;
                case 'real':
                    $type = TableType::FLOAT;
                    break;
                case 'text':
                    $type = TableType::TEXT;
                    break;
                case 'bool':
                    $type = TableType::BOOL;
                    break;
                case 'date':
                    $type = TableType::DATE;
                    break;
                case 'datetime':
                    $type = TableType::DATE_TIME;
                    break;
                case 'time':
                    $type = TableType::TIME;
                    break;
                case 'timestamp':
                    $type = TableType::TIMESTAMP;
                    break;
                default:
                    $type = TableType::UNKNOWN;
                    break;

            }
            $tableType->setType($type);


            if ($type === TableType::ENUM) {
                $stringOptions = str_replace(array('(', ')', '\''), '', $matches['length']);
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
    protected function parseAllowNull($string)
    {
        return $string === 'NO' ? false : true;
    }

    /**
     * @param $string
     * @return bool
     */
    protected function parseAutoIncrement($string)
    {
        return $string === 'auto_increment' ? true : false;
    }

    /**
     * @param $string
     * @return string
     */
    protected function parseDefault($string)
    {
        return !empty($string) ? $string : '';
    }

    /**
     * @param $string
     * @return mixed
     */
    protected function parseField($string)
    {
        return $string;
    }

    /**
     * @param $string
     * @return int
     */
    protected function parseKey($string)
    {

        switch ($string) {
            case 'PRI':
                return Table::PRIMARY_KEY;
                break;
            case 'MUL':
                return Table::FOREIGN_KEY;
                break;
            default:
                return Table::NO_KEY;
                break;
        }

    }


} 