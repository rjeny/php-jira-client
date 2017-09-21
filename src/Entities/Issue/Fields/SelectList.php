<?php

namespace Rjeny\Jira\Entities\Issue\Fields;

class SelectList extends Field
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