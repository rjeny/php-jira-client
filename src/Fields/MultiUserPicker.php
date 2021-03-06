<?php

namespace Rjeny\Jira\Fields;

class MultiUserPicker extends BaseAbstractField
{
    function __construct($id, $values)
    {
        if (!is_array($values)) {
            $values = [$values];
        } else {
            $values = array_values($values);
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
        $field = [];
        foreach ($this->value as $value) {
            $field[] = ['name' => (string) $value];
        }

        return $field;
    }
}