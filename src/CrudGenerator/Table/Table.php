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
        return isset($fields[0]) ? $fields[0] : null;
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
    public function getForeignFields()
    {

        $foreignFields = array();

        foreach ($this->fields as $field) {

            if ($field->getKey() == Key::FOREIGN) {
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