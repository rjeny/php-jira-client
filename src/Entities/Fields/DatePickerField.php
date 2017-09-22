<?php

namespace Rjeny\Jira\Entities\Fields;

class DatePickerField extends Field
{

    function __construct($id, \DateTime $value)
    {
        $value = $value->format('Y-m-d');

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