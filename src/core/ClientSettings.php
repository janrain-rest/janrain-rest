<?php

namespace Janrain\core;

class ClientSettings
{
    private $baseCoreInstance;

    /**
     * ClientSettings constructor.
     *
     * @param BaseCore $baseCoreInstance
     */
    public function __construct(BaseCore $baseCoreInstance)
    {
        $this->baseCoreInstance = $baseCoreInstance;
    }

    /**
     * Get a list of the clients in your application, optionally filtered by client feature.
     * Only the owner client can make this API call.
     *
     * Public documentation: https://docs.janrain.com/api/registration/clients/#clients-list
     *
     * Service path: /clients/list
     *
     * Response example:
     * {
     *      "results": [
     *          {
     *              "whitelist": [
     *                  "0.0.0.0/0"
     *              ],
     *              "features": [
     *                  "access_issuer",
     *                  "direct_access",
     *                  "owner"
     *              ],
     *              "description": "application owner",
     *              "client_id": "12345abcde12345abcde",
     *              "client_secret": "edcba54321edcba54321"
     *          }
     *      ],
     *      "stat": "ok"
     * }
     *
     * @return mixed
     */
    public function clientsList()
    {
        $captureServerUrl   = $this->baseCoreInstance->captureServerUrl;
        $serviceUrl = '/clients/list';

        $data = [];

        $method         = 'get';
        $clientId       = $this->baseCoreInstance->fullClientId;
        $clientSecret   = $this->baseCoreInstance->fullClientSecret;

        return $this->baseCoreInstance->requestInstance->request(
            $captureServerUrl,
            $serviceUrl,
            $data,
            $method,
            $clientId,
            $clientSecret
        );
    }

    /**
     * Get all settings for a particular client, including those from the application-wide default settings.
     * If a key is defined in both the client and application settings, only the client-specific value is returned.
     * Returns a JSON object of all key-value pairs.
     *
     * Public documentation: https://docs.janrain.com/api/registration/clients/#settings-items
     *
     * Service path: /settings/items
     *
     * Response example:
     * {
     *      "result": {
     *          "owner": "Jay",
     *          "public": "true",
     *          "level": "10"
     *      },
     *      "stat": "ok"
     *  }
     *
     * @param string $clientId Client Id.
     * @param string $clientSecret Client Secret.
     *
     * @return mixed
     */
    public function settingsItems(string $clientId, string $clientSecret)
    {
        $captureServerUrl   = $this->baseCoreInstance->captureServerUrl;
        $serviceUrl = '/settings/items';

        $data = [];

        $method  = 'get';

        return $this->baseCoreInstance->requestInstance->request(
            $captureServerUrl,
            $serviceUrl,
            $data,
            $method,
            $clientId,
            $clientSecret
        );
    }
}
