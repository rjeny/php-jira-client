<?php

namespace Rjeny\Jira\Entities;

use Rjeny\Jira\Fields;
use Rjeny\Jira\Fields\AbstractField;
use Rjeny\Jira\JiraException;
use Rjeny\Jira\JiraClient;

class Issue extends BaseAbstractEntity
{
    private $cfs = [];

    function __construct(JiraClient $client)
    {
        $this->data = [
            'description' => new Fields\TextField('summary', ''),
            'environment' => new Fields\TextField('environment', ''),
            'project'     => new Fields\SelectList('project', ''),
            'issuetype'   => new Fields\SelectList('issuetype', ''),
            'priority'    => new Fields\SelectList('priority', ''),
            'security'    => new Fields\SelectList('security', ''),
            'components'  => new Fields\MultiSelect('components', ''),
            'assignee'    => new Fields\UserPicker('assignee', ''),
            'reporter'    => new Fields\UserPicker('reporter', ''),
            'labels'      => new Fields\Labels('labels', ''),
            'versions'    => new Fields\SingleVersionPicker('versions', ''),
            'fixVersions' => new Fields\SingleVersionPicker('duedate', ''),
            'duedate'     => new Fields\DatePickerField('duedate', new \DateTime('now')),
        ];
        parent::__construct($client);
    }

    public function prepareRequestData()
    {
        // TODO: Implement prepareRequestData() method.
    }

    public function getUrl()
    {
        // TODO: Implement getUrl() method.
    }

    /**
     * Generate from table like [...['type' => $type, 'id' => $id, 'value' => $value]...]
     * @param $table
     * @return bool
     */
    public function generateCfsFromTable($table)
    {
        if (!is_array($table)) {
            return false;
        }

        foreach ($table as $row) {
            if (isset($row['type']) && isset($row['id']) && isset($row['value'])) {
                $fieldClassName = 'Rjeny\Jira\Fields\\' . $row['type'];
                $this->data[$row['id']] = new $fieldClassName($row['id'], $row['value']);
            }
            // TODO: LOG FOR ROW NOT USED
        }

        return true;
    }

    /**
     * @param AbstractField $field
     */
    public function pushCfs(AbstractField $field)
    {
        $this->cfs[$field->getId()] = $field;
    }

    /**
     * Data setter
     * TODO: setValue для всех полей по человечески
     *
     * @param $key
     * @param $value
     * @return bool
     */
    function __set($key, $value)
   {
        if (isset($this->data[$key])) {
            $this->data[$key] = $this->data[$key]->setValue($value);
            return true;
        }
        return false;
   }

    /**
     * Saving object on Jira
     */
    public function save()
   {
       if ($this->key || $this->id) {
           $this->update();
       } else {
           $this->create();
       }
   }

    /**
     * Set request for create
     */
    protected function create() {
        $this->client->sendRequest('POST', $this->name, $this->prepareRequestData());
   }

    /**
     * Set request for update
     */
    protected function update() {
        $this->client->sendRequest('POST', $this->name . ($this->key ? : (string) $this->id), $this->prepareRequestData());
    }
}