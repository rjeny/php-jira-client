<?php

namespace Rjeny\Jira;

/**
 * Jira REST API client
 *
 */

class JiraClient
{
    protected $auth;

    protected $baseUrl;

    protected $apiVer;

    protected $request;

    function __construct($auth, $configOrBaseUrl, $apiVer=null)
    {
        $this->auth = $auth;

        if (is_array($configOrBaseUrl)) {
            if (!isset($configOrBaseUrl['baseUrl'])) {
                throw new JiraException('No config');
            }
            $this->baseUrl = $configOrBaseUrl['baseUrl'];
            $this->apiVer = $configOrBaseUrl['apiVer'] ? : 'latest';
        } else {
            $this->baseUrl = $configOrBaseUrl;
            $this->apiVer = $apiVer ? : 'latest';
        }
    }

    public function sendRequest($method, $entity, $params=[])
    {
        $ch = curl_init();

        // Build url
        $url = $this->baseUrl . '/rest/api/' . $this->apiVer . '/' . $entity;

        echo $url;

        // Если будем работать методом get, то все параметры в ссылку
        if ($method == 'GET') {
            $url .= '?' . http_build_query($params);
        }

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FAILONERROR, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

        $this->auth->setAuthHead($ch);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);


        if ($method == 'POST' && $params) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        }

        if ($method == 'FILE' && $params) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['X-Atlassian-Token: no-check']);
        }

        echo print_r($params);

        $response = curl_exec($ch);
        $errno    = curl_errno($ch);
        $error    = curl_error($ch);

        if (!$response || $errno) {
            throw new JiraException('Запрос произвести не удалось: '.$error, $errno);
        }

        $response = json_decode($response, true);

        if (isset($response['errorMessages']) || isset($response['errors'])) {
            throw new JiraException(print_r($response['errors'], true) . print_r($params, true));
        }

        echo (print_r($response, true));

        curl_close($ch);

        return $response;
    }
}