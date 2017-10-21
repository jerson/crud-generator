<?php

namespace CrudGenerator\Table;


use CrudGenerator\Table\Type\Type;

class Table
{

    /**
     * @var string
     */
    private $name;

    /**
     * @var Field[]
     */
    private $fields;

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }


    /**
     * @return Field|null
     */
    public function getPrimaryField()
    {
        $fields = $this->getPrimaryFields();
        if (isset($fields[0])) {
            $field = $fields[0];
        } elseif (isset($this->fields[0])) {
            $field = $this->fields[0];
        } else {
            $field = new Field();
            $field->setName('error');

            $fieldType = new Type();
            $fieldType->setName(Type::UNKNOWN);
            $field->setType($fieldType);
        }
        return $field;
    }

    /**
     * @return Field[]|array
     */
    public function getPrimaryFields()
    {

        $primaryFields = [];

        foreach ($this->fields as $field) {

            if ($field->getKey() === Key::PRIMARY) {
                $primaryFields[] = $field;

            }

        }

        return $primaryFields;
    }

    /**
     * @return Field[]|array
     */
    public function getUniqueFields()
    {

        $uniqueFields = [];

        foreach ($this->fields as $field) {

            if ($field->getKey() === Key::UNIQUE) {
                $uniqueFields[] = $field;

            }

        }

        return $uniqueFields;
    }

    /**
     * @return Field[]|array
     */
    public function getForeignFields()
    {

        $foreignFields = [];

        foreach ($this->fields as $field) {

            if (count($field->getReferences()) > 0) {
                $foreignFields[] = $field;

            }

        }

        return $foreignFields;
    }

    /**
     * @param Field $field
     */
    public function addField(Field $field)
    {
        $this->fields[] = $field;
    }

    /**
     * @return \CrudGenerator\Table\Field[]
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param \CrudGenerator\Table\Field[] $fields
     */
    public function setFields($fields)
    {
        $this->fields = $fields;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
}
