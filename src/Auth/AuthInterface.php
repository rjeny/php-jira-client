<?php

namespace Rjeny\Jira\Auth;

/**
 * Interface for auth
 */
interface AuthInterface
{
    public function setAuthHead(&$ch);
}