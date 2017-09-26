<?php
namespace Rjeny\Jira\Auth;

class Base implements AuthInterface
{
    private $username;

    private $password;

    function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function setAuthHead(&$ch)
    {
        curl_setopt($ch, CURLOPT_USERPWD, $this->username . ':' . $this->password);
    }
}