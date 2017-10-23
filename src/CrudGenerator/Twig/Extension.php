<?php


namespace CrudGenerator\Twig;

use CrudGenerator\Table\Table;
use Stringy\Stringy;
use Twig_SimpleFilter;

class Extension extends \Twig_Extension
{

    /**
     * Returns the name of the extension.
     * @return string The extension name
     */
    public function getName()
    {
        return 'CrudGenerator';
    }

    /**
     * @inheritdoc
     */
    public function getFilters()
    {

        return [
            new Twig_SimpleFilter('at', [$this, 'at']),
            new Twig_SimpleFilter('camelize', [$this, 'camelize']),
            new Twig_SimpleFilter('chars', [$this, 'chars']),
            new Twig_SimpleFilter('collapseWhitespace', [$this, 'collapseWhitespace']),
            new Twig_SimpleFilter('contains', [$this, 'contains']),
            new Twig_SimpleFilter('countSubstr', [$this, 'countSubstr']),
            new Twig_SimpleFilter('create', [$this, 'create']),
            new Twig_SimpleFilter('dasherize', [$this, 'dasherize']),
            new Twig_SimpleFilter('endsWith', [$this, 'endsWith']),
            new Twig_SimpleFilter('ensureLeft', [$this, 'ensureLeft']),
            new Twig_SimpleFilter('ensureRight', [$this, 'ensureRight']),
//            new Twig_SimpleFilter('first', [$this, 'first']),
            new Twig_SimpleFilter('getEncoding', [$this, 'getEncoding']),
            new Twig_SimpleFilter('humanize', [$this, 'humanize']),
            new Twig_SimpleFilter('insert', [$this, 'insert']),
            new Twig_SimpleFilter('isAlpha', [$this, 'isAlpha']),
            new Twig_SimpleFilter('isAlphanumeric', [$this, 'isAlphanumeric']),
            new Twig_SimpleFilter('isBlank', [$this, 'isBlank']),
            new Twig_SimpleFilter('isHexadecimal', [$this, 'isHexadecimal']),
            new Twig_SimpleFilter('isJson', [$this, 'isJson']),
            new Twig_SimpleFilter('isLowerCase', [$this, 'isLowerCase']),
            new Twig_SimpleFilter('isSerialized', [$this, 'isSerialized']),
            new Twig_SimpleFilter('isUpperCase', [$this, 'isUpperCase']),
            new Twig_SimpleFilter('last', [$this, 'last']),
            //new Twig_SimpleFilter('length', [$this, 'length']),
            new Twig_SimpleFilter('longestCommonPrefix', [$this, 'longestCommonPrefix']),
            new Twig_SimpleFilter('longestCommonSuffix', [$this, 'longestCommonSuffix']),
            new Twig_SimpleFilter('longestCommonSubstring', [$this, 'longestCommonSubstring']),
            new Twig_SimpleFilter('lowerCaseFirst', [$this, 'lowerCaseFirst']),
            new Twig_SimpleFilter('pad', [$this, 'pad']),
            new Twig_SimpleFilter('padBoth', [$this, 'padBoth']),
            new Twig_SimpleFilter('padLeft', [$this, 'padLeft']),
            new Twig_SimpleFilter('padRight', [$this, 'padRight']),
            new Twig_SimpleFilter('regexReplace', [$this, 'regexReplace']),
            new Twig_SimpleFilter('removeLeft', [$this, 'removeLeft']),
            new Twig_SimpleFilter('removeRight', [$this, 'removeRight']),
//            new Twig_SimpleFilter('replace', [$this, 'replace']),
            new Twig_SimpleFilter('reverse', [$this, 'reverse']),
            new Twig_SimpleFilter('safeTruncate', [$this, 'safeTruncate']),
            new Twig_SimpleFilter('shuffle', [$this, 'shuffle']),
            new Twig_SimpleFilter('slugify', [$this, 'slugify']),
            new Twig_SimpleFilter('startsWith', [$this, 'startsWith']),
            new Twig_SimpleFilter('substr', [$this, 'substr']),
            new Twig_SimpleFilter('surround', [$this, 'surround']),
            new Twig_SimpleFilter('swapCase', [$this, 'swapCase']),
            new Twig_SimpleFilter('tidy', [$this, 'tidy']),
            new Twig_SimpleFilter('titleize', [$this, 'titleize']),
            new Twig_SimpleFilter('toAscii', [$this, 'toAscii']),
            new Twig_SimpleFilter('toLowerCase', [$this, 'toLowerCase']),
            new Twig_SimpleFilter('toSpaces', [$this, 'toSpaces']),
            new Twig_SimpleFilter('toTabs', [$this, 'toTabs']),
            new Twig_SimpleFilter('toUpperCase', [$this, 'toUpperCase']),
            new Twig_SimpleFilter('trim', [$this, 'trim']),
            new Twig_SimpleFilter('truncate', [$this, 'truncate']),
            new Twig_SimpleFilter('underscored', [$this, 'underscored']),
            new Twig_SimpleFilter('upperCamelize', [$this, 'upperCamelize']),
            new Twig_SimpleFilter('upperCaseFirst', [$this, 'upperCaseFirst']),

            new Twig_SimpleFilter('columns', [$this, 'columns']),
            new Twig_SimpleFilter('columnsWithoutPrimary', [$this, 'columnsWithoutPrimary']),
            new Twig_SimpleFilter('columnsNoAutoIncrement', [$this, 'columnsNoAutoIncrement']),
            new Twig_SimpleFilter('columnsPrimary', [$this, 'columnsPrimary']),
            new Twig_SimpleFilter('columnsForeign', [$this, 'columnsForeign']),

            new Twig_SimpleFilter('pluralize', [$this, 'pluralize']),
            new Twig_SimpleFilter('repeat', [$this, 'repeat']),
        ];
    }

    /**
     * @inheritdoc
     */
    public function getFunctions()
    {
        return [];
    }

    /**
     * @param $text
     * @return string
     */
    public function pluralize($text)
    {
        return $text . 's';
    }

    /**
     * @param $text
     * @param $times
     * @return array
     */
    public function repeat($text, $times)
    {
        $texts = [];

        for ($i = 0; $i < $times; $i++) {
            $texts[] = $text;
        }

        return $texts;
    }

    /**
     * @param Table $table
     * @return array
     */
    public function columns(Table $table)
    {
        $columns = [];
        foreach ($table->getFields() as $field) {
            $columns[] = $field->getName();
        }

        return $columns;
    }

    /**
     * @param Table $table
     * @return array
     */
    public function columnsWithoutPrimary(Table $table)
    {
        $columns = [];
        foreach ($table->getFields() as $field) {

            if ($field->isPrimary()) {
                continue;
            }

            $columns[] = $field->getName();
        }

        return $columns;
    }

    /**
     * @param Table $table
     * @return array
     */
    public function columnsNoAutoIncrement(Table $table)
    {
        $columns = [];
        foreach ($table->getFields() as $field) {

            if ($field->isAutoIncrement()) {
                continue;
            }

            $columns[] = $field->getName();
        }

        return $columns;
    }

    /**
     * @param Table $table
     * @return array
     */
    public function columnsPrimary(Table $table)
    {
        $columns = [];
        foreach ($table->getPrimaryFields() as $field) {
            $columns[] = $field->getName();
        }

        return $columns;
    }

    /**
     * @param Table $table
     * @return array
     */
    public function columnsForeign(Table $table)
    {
        $columns = [];
        foreach ($table->getForeignFields() as $field) {
            $columns[] = $field->getName();
        }

        return $columns;
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {

        $text = $arguments[0];
//        if ($name === 'upperCamelize') {
//            $text = strtolower(Stringy::create($text)->humanize());
//        } elseif ($name === 'camelize') {
//            $text = strtolower(Stringy::create($text)->humanize());
//
//        }
        return Stringy::create($text)->$name()->__toString();
    }
}
