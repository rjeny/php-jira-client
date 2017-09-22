<?php

namespace Rjeny\Jira\Entities\Fields;

use Rjeny\Jira\JiraException;

abstract class Field
{
    protected $type = 'SomeField';

    protected $value;

    protected $id;

    /**
     * Return field implementation
     *
     * @return mixed
     */
    abstract public function getField();

    /**
     * Field constructor.
     * @param $id
     * @throws JiraException
     * @param $value
     */
    function __construct($id, $value)
    {
        if (!$id) {
            throw new JiraException('Trying create Field without id!');
        }
        $this->id  = $id;
        $this->value = $value;
    }

    /**
     * Add field to Fields array
     *
     * @param $array
     * @throws JiraException
     * @return void
     */
    public function addFieldToArray(&$array) {
        if(!is_array($array)){
            throw new JiraException('Trying to add field not to the Array!' . print_r($array, true));
        }
        $array[$this->id] = $this->getField();
    }

    /**
     * Get Value
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set Value
     *
     * @param $value
     * @return bool
     */
    public function setValue($value)
    {
        $this->value = $value;
        return true;
    }

    /**
     * Get Field Name
     *
     * @return string
     */
    public function getFieldName()
    {
        return static::class;
    }

    /**
     * Getting ID
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }
}