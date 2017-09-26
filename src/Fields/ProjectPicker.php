<?php

namespace Rjeny\Jira\Fields;

class ProjectPicker extends BaseAbstractField
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
        if (is_int($this->value)) {
            return ['id' => (string)$this->value];
        } else {
            return ['key' => $this->value];
        }
    }
}