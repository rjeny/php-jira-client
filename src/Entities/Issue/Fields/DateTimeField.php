<?php

namespace Rjeny\Jira\Entities\Issue\Fields;

class DateTimeField extends Field
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