<?php

namespace Rjeny\Jira\Entities\Fields;

class Labels extends Field
{
    function __construct($id, $value)
    {
        if (!is_array($value)) {
            $value = [$value];
        }

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