<?php

namespace CrudGenerator\Table;


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
     * @return Field|null
     */
    public function getPrimaryField()
    {
        $fields = $this->getPrimaryFields();
        if (isset($fields[0])) {
            $field = $fields[0];
        } else if (isset($this->fields[0])) {
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

        $primaryFields = array();

        foreach ($this->fields as $field) {

            if ($field->getKey() == Key::PRIMARY) {
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

        $uniqueFields = array();

        foreach ($this->fields as $field) {

            if ($field->getKey() == Key::UNIQUE) {
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

        $foreignFields = array();

        foreach ($this->fields as $field) {

            if (count($field->getReferences())>0) {
                $foreignFields[] = $field;

            }

        }

        return $foreignFields;
    }

    /**
     * @param \CrudGenerator\Table\Field[] $fields
     */
    public function setFields($fields)
    {
        $this->fields = $fields;
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
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

} 