<?php

namespace Rjeny\Jira\Fields;

class DateTimeField extends AbstractField
{

    function __construct($id, \DateTime $value)
    {
        $value = $value->format('Y-m-d\TH-i-s.\0\0\0\Z');

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