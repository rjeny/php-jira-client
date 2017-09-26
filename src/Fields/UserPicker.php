<?php

namespace Rjeny\Jira\Fields;

class UserPicker extends BaseAbstractField
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