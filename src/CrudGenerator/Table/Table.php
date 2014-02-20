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