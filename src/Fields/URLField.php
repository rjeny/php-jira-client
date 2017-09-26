<?php

namespace Rjeny\Jira\Fields;

class URLField extends BaseAbstractField
{
    function __construct($id, $value)
    {
        if (!preg_match('/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/', $value)){
            $value = null;
        }
        parent::__construct($id, $value);
    }

    /**
     * Returns field value for requests
     *
     * @return array
     */
    public function getField()
    {
        return $this->value;
    }
}