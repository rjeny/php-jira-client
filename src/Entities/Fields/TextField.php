<?php

namespace Rjeny\Jira\Entities\Fields;

class TextField extends Field
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