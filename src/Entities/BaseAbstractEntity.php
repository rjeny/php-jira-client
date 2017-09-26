<?php
namespace Rjeny\Jira\Entities;

use \Rjeny\Jira\JiraClient;

/**
 * Class Entity
 * @package Rjeny\Jira\Entities
 */
abstract class BaseAbstractEntity
{
    /**
     * Name. Used in URI
     * @var string
     */
    protected $name;

    /**
     * Jira Client
     * @var JiraClient
     */
    protected $client;

    /**
     * @var string
     */
    protected $key;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var mixed
     */
    protected $data;

    function __construct(JiraClient $client)
    {
        $this->client = $client;
    }

    /**
     * Return url for use in browsers?
     *
     * @return mixed
     */
    abstract public function getUrl();

    /**
     * Preparing request data
     *
     * @return mixed
     */
    abstract public function prepareRequestData();

    public function getID(){
        if ($this->key){
            return $this->key;
        } elseif ($this->id) {
            return $this->id;
        } else {
            return false;
        }
    }

    /**
     * Getter return class params or data info
     *
     * @param $name
     * @return null
     */
    public function __get($name)
    {
        if (isset($this->$$name)) {
            return $this->$$name;
        }

        if (isset($this->data[$name])){
            return $this->data[$name];
        }

        return null;
    }
}