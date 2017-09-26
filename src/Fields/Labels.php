<?php

namespace Rjeny\Jira\Fields;

class Labels extends AbstractField
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