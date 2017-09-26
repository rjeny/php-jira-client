<?php
require ('../vendor/autoload.php');

use Rjeny\Jira\JiraClient;
use Rjeny\Jira\Auth\Base;
use Rjeny\Jira\Entities\Issue;

$auth   = new Base('admin', 'qwerty12345');
$client = new JiraClient($auth, 'https://mama1tester.atlassian.net');
$issue  = Issue::getCurrent($client, 'TEST-24');
