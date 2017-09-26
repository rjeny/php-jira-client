<?php

namespace Rjeny\Jira\Fields;

class TextField extends AbstractField
{
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