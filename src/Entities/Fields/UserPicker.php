<?php

namespace Rjeny\Jira\Entities\Fields;

class UserPicker extends Field
{
    function __construct($id, $values)
    {
        if (is_array($values)) {
            $values = null;
        }

        parent::__construct($id, $values);
    }

    /**
     * Returns field value for requests
     *
     * @return array
     */
    public function getField()
    {
        return ['name' => (string) $this->value];
    }
}