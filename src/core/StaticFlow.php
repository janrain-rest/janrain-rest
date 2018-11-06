<?php

namespace Janrain\core;

use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;

class StaticFlow
{
    public $cdnUrl;
    public $appId;
    public $locale;
    public $flowName;
    private $flowContent = null;
    private $requestInstance;

    /**
     * StaticFlow constructor.
     *
     * @param string $cdnUrl
     * @param string $appId
     * @param string $locale
     * @param string $flowName
     * @param LoggerInterface $logger
     */
    public function __construct(
        string $cdnUrl,
        string $appId,
        string $locale,
        string $flowName,
        LoggerInterface $logger
    ) {

        $this->cdnUrl          = $cdnUrl;
        $this->appId           = $appId;
        $this->locale          = $locale;
        $this->flowName        = $flowName;
        $this->requestInstance = new Request($logger);
    }

    /**
     * Get Flow content from Janrain.
     *
     * @return object with flow information.
     */
    public function getFlowContent()
    {
        if (empty($this->flowContent)) {
            $this->flowContent = $this->getFile('HEAD', $this->locale);
        }

        return $this->flowContent;
    }

    /**
     * Get Flow content from Json file.
     *
     * @param string $flowVersion The version number of the flow.
     * @param string $locale The code for the language you want to use.
     *
     * @return null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function getFile($flowVersion, $locale)
    {
        $jsonFileUrl = $this->cdnUrl . ':' . $this->appId . ':' . $locale . ':' . $flowVersion . ':' . $this->flowName;

        $client = new Client();

        $flowContent = $client->request('get', $jsonFileUrl);

        $flowContent = $flowContent->getBody()->getContents();

        // Get flow status.
        $flowStatus = strstr($flowContent, 'function () { janrain.capture.ui.render(', true);
        $flowStatus = str_replace('janrain.capture.ui.handleCaptureResponse(', '', $flowStatus);
        $flowStatus = substr($flowStatus, 0, -1);

        $flowStatus = json_decode($flowStatus);

        if ($flowStatus->stat != 'ok') {
            return null;
        }

        // Get flow data.
        $flowData = strstr($flowContent, 'function () { janrain.capture.ui.render(');
        $flowData = str_replace('function () { janrain.capture.ui.render(', '', $flowData);
        $flowData = trim($flowData);
        $flowData = substr($flowData, 0, -6);

        return json_decode($flowData);
    }

    /**
     * Get Flow content from Json file.
     *
     * @param string $flowVersion The version number of the flow.
     * @param string $locale The code for the language you want to use.
     *
     * @return object with flow information.
     */
    public function getFlowByVersionAndLocale($flowVersion, $locale)
    {
        return $this->getFile($flowVersion, $locale);
    }
}
