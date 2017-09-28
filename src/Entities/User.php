<?php

namespace Rjeny\Jira\Entities;

use Rjeny\Jira\Fields;
use Rjeny\Jira\Fields\BaseAbstractField;
use Rjeny\Jira\JiraException;
use Rjeny\Jira\JiraClient;
use Rjeny\Jira\Entities\Issue\IssueAttachment;

/**
 * Class for User entity
 *
 * @package Rjeny\Jira\Entities
 *
 */
class User extends BaseAbstractEntity
{
    protected $name = 'user';

    function __construct(JiraClient $client, $key=null)
    {
        parent::__construct($client);
    }

    /**
     * @return array
     */
    public function prepareRequestData()
    {
        return [];
    }

    public function getUrl()
    {
        // TODO: Implement getUrl() method.
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
        return false;
   }

   public function setData($key, $value)
   {
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
        $response   = $this->client->sendRequest('POST', $this->name, $this->prepareRequestData());

        $this->id   = $response['id'];
        $this->key  = $response['key'];
        $this->self = $response['self'];
   }

    /**
     * Set request for update
     */
    protected function update() {
        $this->client->sendRequest('POST', $this->name . ($this->key ? : (string) $this->id), $this->prepareRequestData());
    }

    /**
     * Get user
     *
     * @param JiraClient $client
     * @param            $key
     *
     * @return User
     */
    public static function getCurrent(JiraClient $client, $key)
    {
        $user = new User($client);

        $user->key=$key;
        $response = $client->sendRequest('GET', 'user', ['key' => $key]);

        return $response;
    }
}