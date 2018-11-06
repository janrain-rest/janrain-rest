<?php

namespace Janrain\core;

class Social
{
    private $baseCoreInstance;

    /**
     * Social constructor.
     *
     * @param BaseCore $baseCoreInstance
     */
    public function __construct(BaseCore $baseCoreInstance)
    {
        $this->baseCoreInstance = $baseCoreInstance;
    }

    /**
     * Returns a list of configured providers for an application.
     * The providers call is similar, but only returns providers configured for
     * an application. This call is used if you are using custom code for
     * Social Login instead of using the Janrain JavaScript implementation.
     *
     * Public documentation: https://docs.janrain.com/api/social/#get_available_providers
     *
     * Service path: /get_available_providers
     *
     * Response example:
     * {
     *      "stat": "ok",
     *      "signin": [
     *          "facebook",
     *          "linkedin",
     *          "twitter"
     *      ],
     *      "social": [
     *          "facebook",
     *          "twitter"
     *      ],
     *      "share": [
     *          "facebook",
     *          "twitter"
     *      ]
     * }
     *
     * @param string $rpxUrl
     *
     * @return mixed
     */
    public function getAvailableProviders(string $rpxUrl)
    {
        $serviceUrl = '/api/v2/get_available_providers';

        $data = [];

        $method       = 'post';
        $clientId     = '';
        $clientSecret = '';

        return $this->baseCoreInstance->requestInstance->request(
            $rpxUrl,
            $serviceUrl,
            $data,
            $method,
            $clientId,
            $clientSecret
        );
    }

    /**
     * This call returns a list of configured sign-in or social providers
     * configured for an application.
     *
     * Public documentation: https://docs.janrain.com/api/social/#providers
     *
     * Service path: /providers
     *
     * Response example:
     * {
     *      "stat": "ok",
     *      "signin": [
     *          "facebook",
     *          "google",
     *          "linkedin",
     *          "paypal",
     *          "twitter"
     *      ],
     *      "social": [
     *          "facebook",
     *          "linkedin",
     *          "twitter"
     *      ],
     *      "shareWidget": {
     *          "share": [
     *              "email",
     *              "facebook",
     *              "linkedin",
     *              "twitter"
     *        ],
     *          "email": [
     *              "google",
     *              "yahoo"
     *          ]
     *      }
     * }
     *
     * @param string $rpxUrl
     *
     * @return mixed
     */
    public function providers(string $rpxUrl)
    {
        $serviceUrl = '/api/v2/providers';

        $data = [];

        $method       = 'post';
        $clientId     = '';
        $clientSecret = '';

        return $this->baseCoreInstance->requestInstance->request(
            $rpxUrl,
            $serviceUrl,
            $data,
            $method,
            $clientId,
            $clientSecret
        );
    }
}
