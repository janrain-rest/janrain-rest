<?php

namespace Janrain\core;

use Janrain\core\Request;
use Psr\Log\LoggerInterface;

class BaseCore
{
    public $captureServerUrl;
    public $configurationServerUrl;
    public $fullClientId;
    public $fullClientSecret;
    public $loginClientId;
    public $loginClientSecret;
    public $requestInstance;
    public $appId;

    /**
     * BaseCore constructor.
     *
     * @param string $captureServerUrl
     * @param string $configurationServerUrl
     * @param string $fullClientId
     * @param string $fullClientSecret
     * @param string $loginClientId
     * @param string $loginClientSecret
     * @param string $appId
     * @param LoggerInterface $logger
     */
    public function __construct(
        string $captureServerUrl,
        string $configurationServerUrl,
        string $fullClientId,
        string $fullClientSecret,
        string $loginClientId,
        string $loginClientSecret,
        string $appId,
        LoggerInterface $logger
    ) {

        $this->captureServerUrl       = $captureServerUrl;
        $this->configurationServerUrl = $configurationServerUrl;
        $this->fullClientId           = $fullClientId;
        $this->fullClientSecret       = $fullClientSecret;
        $this->loginClientId          = $loginClientId;
        $this->loginClientSecret      = $loginClientSecret;
        $this->appId                  = $appId;
        $this->requestInstance        = new Request($logger);
    }
}
