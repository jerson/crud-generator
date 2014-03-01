<?php


namespace CrudGenerator\Twig;

use CrudGenerator\Table\Table;
use Stringy\Stringy;

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

        return array(
            'at' => new \Twig_Filter_Method($this, 'at'),
            'camelize' => new \Twig_Filter_Method($this, 'camelize'),
            'chars' => new \Twig_Filter_Method($this, 'chars'),
            'collapseWhitespace' => new \Twig_Filter_Method($this, 'collapseWhitespace'),
            'contains' => new \Twig_Filter_Method($this, 'contains'),
            'countSubstr' => new \Twig_Filter_Method($this, 'countSubstr'),
            'create' => new \Twig_Filter_Method($this, 'create'),
            'dasherize' => new \Twig_Filter_Method($this, 'dasherize'),
            'endsWith' => new \Twig_Filter_Method($this, 'endsWith'),
            'ensureLeft' => new \Twig_Filter_Method($this, 'ensureLeft'),
            'ensureRight' => new \Twig_Filter_Method($this, 'ensureRight'),
            'first' => new \Twig_Filter_Method($this, 'first'),
            'getEncoding' => new \Twig_Filter_Method($this, 'getEncoding'),
            'humanize' => new \Twig_Filter_Method($this, 'humanize'),
            'insert' => new \Twig_Filter_Method($this, 'insert'),
            'isAlpha' => new \Twig_Filter_Method($this, 'isAlpha'),
            'isAlphanumeric' => new \Twig_Filter_Method($this, 'isAlphanumeric'),
            'isBlank' => new \Twig_Filter_Method($this, 'isBlank'),
            'isHexadecimal' => new \Twig_Filter_Method($this, 'isHexadecimal'),
            'isJson' => new \Twig_Filter_Method($this, 'isJson'),
            'isLowerCase' => new \Twig_Filter_Method($this, 'isLowerCase'),
            'isSerialized' => new \Twig_Filter_Method($this, 'isSerialized'),
            'isUpperCase' => new \Twig_Filter_Method($this, 'isUpperCase'),
            'last' => new \Twig_Filter_Method($this, 'last'),
            //'length' => new \Twig_Filter_Method($this, 'length'),
            'longestCommonPrefix' => new \Twig_Filter_Method($this, 'longestCommonPrefix'),
            'longestCommonSuffix' => new \Twig_Filter_Method($this, 'longestCommonSuffix'),
            'longestCommonSubstring' => new \Twig_Filter_Method($this, 'longestCommonSubstring'),
            'lowerCaseFirst' => new \Twig_Filter_Method($this, 'lowerCaseFirst'),
            'pad' => new \Twig_Filter_Method($this, 'pad'),
            'padBoth' => new \Twig_Filter_Method($this, 'padBoth'),
            'padLeft' => new \Twig_Filter_Method($this, 'padLeft'),
            'padRight' => new \Twig_Filter_Method($this, 'padRight'),
            'regexReplace' => new \Twig_Filter_Method($this, 'regexReplace'),
            'removeLeft' => new \Twig_Filter_Method($this, 'removeLeft'),
            'removeRight' => new \Twig_Filter_Method($this, 'removeRight'),
            'replace' => new \Twig_Filter_Method($this, 'replace'),
            'reverse' => new \Twig_Filter_Method($this, 'reverse'),
            'safeTruncate' => new \Twig_Filter_Method($this, 'safeTruncate'),
            'shuffle' => new \Twig_Filter_Method($this, 'shuffle'),
            'slugify' => new \Twig_Filter_Method($this, 'slugify'),
            'startsWith' => new \Twig_Filter_Method($this, 'startsWith'),
            'substr' => new \Twig_Filter_Method($this, 'substr'),
            'surround' => new \Twig_Filter_Method($this, 'surround'),
            'swapCase' => new \Twig_Filter_Method($this, 'swapCase'),
            'tidy' => new \Twig_Filter_Method($this, 'tidy'),
            'titleize' => new \Twig_Filter_Method($this, 'titleize'),
            'toAscii' => new \Twig_Filter_Method($this, 'toAscii'),
            'toLowerCase' => new \Twig_Filter_Method($this, 'toLowerCase'),
            'toSpaces' => new \Twig_Filter_Method($this, 'toSpaces'),
            'toTabs' => new \Twig_Filter_Method($this, 'toTabs'),
            'toUpperCase' => new \Twig_Filter_Method($this, 'toUpperCase'),
            'trim' => new \Twig_Filter_Method($this, 'trim'),
            'truncate' => new \Twig_Filter_Method($this, 'truncate'),
            'underscored' => new \Twig_Filter_Method($this, 'underscored'),
            'upperCamelize' => new \Twig_Filter_Method($this, 'upperCamelize'),
            'upperCaseFirst' => new \Twig_Filter_Method($this, 'upperCaseFirst'),

            'columns' => new \Twig_Filter_Method($this, 'columnsToString'),
            'columnsWithoutPrimary' => new \Twig_Filter_Method($this, 'columnsWithoutPrimaryToString'),
            'columnsNoAutoIncrement' => new \Twig_Filter_Method($this, 'columnsNoAutoIncrementToString'),
            'columnsPrimary' => new \Twig_Filter_Method($this, 'columnsPrimaryToString'),
            'columnsForeign' => new \Twig_Filter_Method($this, 'columnsForeignToString'),

            'pluralize' => new \Twig_Filter_Method($this, 'pluralize'),
            'repeat' => new \Twig_Filter_Method($this, 'repeat')
        );
    }

    /**
     * @inheritdoc
     */
    public function getFunctions()
    {
        return array( //'i_range' => new \Twig_Function_Method($this, 'iRange'),
        );
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
        $texts = array();

        for ($i = 0; $i < $times; $i++) {
            $texts[] = $text;
        }

        return $texts;
    }

    /**
     * @param Table $table
     * @return array
     */
    public function columnsToString(Table $table)
    {
        $columns = array();
        foreach ($table->getFields() as $field) {
            $columns[] = $field->getName();
        }

        return $columns;
    }

    /**
     * @param Table $table
     * @return array
     */
    public function columnsWithoutPrimaryToString(Table $table)
    {
        $columns = array();
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
    public function columnsNoAutoIncrementToString(Table $table)
    {
        $columns = array();
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
    public function columnsPrimaryToString(Table $table)
    {
        $columns = array();
        foreach ($table->getPrimaryFields() as $field) {
            $columns[] = $field->getName();
        }

        return $columns;
    }

    /**
     * @param Table $table
     * @return array
     */
    public function columnsForeignToString(Table $table)
    {
        $columns = array();
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
        if ($name == 'upperCamelize') {
            $text = strtolower(Stringy::create($text)->humanize());
        } elseif ($name == 'camelize') {
            $text = strtolower(Stringy::create($text)->humanize());

        }

        return Stringy::create($text)->$name();
    }
}
