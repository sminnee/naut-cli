<?php

namespace SilverStripe\Deploynaut\Console;

/**
 * Represents an in-progress job that can be polled for output and status
 */
class NautAPIJob
{

    protected $apiClient;

    protected $suburl;


    public function __construct(NautAPIClient $apiClient, $suburl)
    {
        $this->apiClient = $apiClient;
        $this->suburl = $suburl;
    }

    public function getStatus()
    {
        return $this->apiClient->getJSON($this->suburl);
    }
}
