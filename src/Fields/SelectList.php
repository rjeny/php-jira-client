<?php

namespace Rjeny\Jira\Fields;

class SelectList extends AbstractField
{
    function __construct($id, $values)
    {
        parent::__construct($id, $values);
    }

    /**
     * Returns field value for requests
     *
     * @return array
     */
    public function getField()
    {
        if (is_int($this->value)){
            return ['id' => (string) $this->value];
        } else {
            return ['value' => $this->value];
        }
    }
}