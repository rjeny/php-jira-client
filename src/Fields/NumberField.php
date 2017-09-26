<?php

namespace Rjeny\Jira\Fields;

class NumberField extends AbstractField
{
    function __construct($id, $value)
    {
        $value = floatval($value);

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