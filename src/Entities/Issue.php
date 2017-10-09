<?php

namespace Rjeny\Jira\Entities;

use Rjeny\Jira\Fields;
use Rjeny\Jira\Fields\BaseAbstractField;
use Rjeny\Jira\JiraException;
use Rjeny\Jira\JiraClient;
use Rjeny\Jira\Entities\Issue\IssueAttachment;

/**
 * Class for Issue entity
 *
 * @package Rjeny\Jira\Entities
 *
 * @property Fields\TextField title
 * @property Fields\TextField description
 * @property Fields\TextField environment
 * @property Fields\ProjectPicker project
 * @property Fields\SelectList type
 * @property Fields\SelectList priority
 * @property Fields\SelectList security
 */
class Issue extends BaseAbstractEntity
{
    protected $name = 'issue';

    private $cfs = [];

    function __construct(JiraClient $client, $key=null)
    {
        $this->data = [
            'title'       => new Fields\TextField('summary', '...'),
            'description' => new Fields\TextField('description', '...'),
            'environment' => new Fields\TextField('environment', ''),
            'project'     => new Fields\ProjectPicker('project', '...'),
            'type'        => new Fields\SelectList('issuetype', '...'),
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

    /**
     * @return array
     */
    public function prepareRequestData()
    {
        $data = [];
        foreach ($this->cfs as $cf) {
            $cf->addFieldToArray($data);
        }

        $this->data['title']->addFieldToArray($data);

        $this->data['description']->addFieldToArray($data);

        $this->data['project']->addFieldToArray($data);

        $this->data['type']->addFieldToArray($data);

        $request['fields'] = $data;

        return $request;
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
                $this->cfs['customfield_' . $row['id']] = new $fieldClassName('customfield_' . $row['id'], $row['value']);
            }
        }

        return true;
    }

    /**
     * @param BaseAbstractField $field
     */
    public function pushCfs($field)
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

   public function setData($key, $value)
   {
       if (isset($this->data[$key])) {
           $this->data[$key]->setValue($value);

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
           $response = $this->update();
       } else {
           $response = $this->create();
       }

       return $response;
   }

    /**
     * Set request for create
     */
    protected function create() {
        $response   = $this->client->sendRequest('POST', $this->name, $this->prepareRequestData());

        $this->id   = $response['id'];
        $this->key  = $response['key'];
        $this->self = $response['self'];

        return $response;
   }

    /**
     * Set request for update
     */
    protected function update() {
        $this->client->sendRequest('POST', $this->name . ($this->key ? : (string) $this->id), $this->prepareRequestData());
    }

    /**
     * Прикрепляет файл к issue
     *
     * @param $filePath
     *
     * @return IssueAttachment
     */
    public function addAttach($filePath) {
        $attachment = new IssueAttachment($this, $filePath);
        $attachment->upload();
        return $attachment;
    }

    /**
     * Create new issue
     *
     * @param JiraClient $client
     * @param            $title
     * @param            $description
     * @param            $project
     * @param            $type
     *
     * @return Issue
     */
    public static function createNew(JiraClient $client, $title, $description, $project, $type)
    {
        $issue = new Issue($client);

        $issue->title->setValue($title);
        $issue->description->setValue($description);
        $issue->project->setValue($project);
        $issue->type->setValue($type);

        $issue->save();

        return $issue;
    }

    /**
     * Get issue
     *
     * @param JiraClient $client
     * @param            $key
     *
     * @return Issue
     */
    public static function getCurrent(JiraClient $client, $key)
    {
        $issue = new Issue($client);

        $issue->key=$key;
        $response = $client->sendRequest('GET', 'issue/' . $key);

        echo print_r($response, true);

        return $issue;
    }
}