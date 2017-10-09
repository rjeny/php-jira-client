<?php
require ('../vendor/autoload.php');

use Rjeny\Jira\JiraClient;
use Rjeny\Jira\Auth\Base;
use Rjeny\Jira\Entities\Issue;
use Rjeny\Jira\Entities\User;

$auth   = new Base('admin', 'qwerty12345');
$client = new JiraClient($auth, 'https://mama1tester.atlassian.net');
$issue  = new Issue($client);

$issue->title->setValue('Тестовая заявка');
$issue->description->setValue('Тестовая заявка');
$issue->project->setValue(10000);
$issue->type->setValue(10002);
$meta = $issue->getCreateMETA();

//$table = [
//    ['id' => 10041, 'type' => 'TextField', 'value' => 'xaxaxa']
//];
//$issue->generateCfsFromTable($table);
//
//$issue->save();