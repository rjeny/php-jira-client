<?php

namespace Rjeny\Jira\Entities\Issue;

use Rjeny\Jira\Entities\Issue;

class IssueAttachment
{
    private $id;

    private $filename;

    private $filePath;

    private $self;

    private $url;

    private $issue;

    function __construct(Issue $issue, $filePath)
    {
        if (!is_null($filePath)) {
            $this->issue = $issue;

            $this->filePath = $filePath;

            $this->filename = basename($filePath);
        }
    }

    public function upload()
    {
        if ($this->id) {
            return false;
        }

        $file = new \CURLFile($this->filePath);
        $file->setPostFilename($this->filename);

        $this->issue->client->sendRequest(
            'FILE',
            'issue/' . $this->issue->getID() . '/attachments/',
            ['file' => $file]
            );

        return true;
    }
}