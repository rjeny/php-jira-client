<?php

namespace Rjeny\Jira\Entities\Issue\Fields;

class CascadingSelectField extends Field
{

    function __construct($id, $parent, $child=null)
    {
        $value = null;
        if ($parent && $child) {
            $value = [$parent, $child];
        } elseif (is_array($parent)) {
           $value = $parent;
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
        return ['value' => $this->value[0], 'child' => ['value' => $this->value[1]]];
    }
}