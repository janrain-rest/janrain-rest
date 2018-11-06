<?php

namespace Janrain\core;

/**
 * Class Configuration
 * @package Janrain\core
 *
 * Public documentation: https://docs.janrain.com/api/configuration-api/
 */
class Configuration
{
    private $baseCoreInstance;

    /**
     * Configuration constructor.
     *
     * @param BaseCore $baseCoreInstance
     */
    public function __construct(BaseCore $baseCoreInstance)
    {
        $this->baseCoreInstance = $baseCoreInstance;
    }

    /**
     * Returns a list of all versions for a particular flow, along with a change note for each version.
     *
     * Public documentation: https://docs.janrain.com/api/configuration-api/#config-app-flows-flow-versions
     *
     * Service path: /config/{app}/flows/{flow}/versions
     *
     * Response example:
     * [
     *      {
     *          "change": "Updated field: givenName",
     *          "version": "HEAD"
     *      },
     *      {
     *          "change": "Updated field: givenName",
     *          "version": "201601201956110829464"
     *      }
     * ]
     *
     * @param string $flowName The name of the flow.
     *
     * @return mixed
     */
    public function flowVersions(string $flowName)
    {
        $serverUrl   = $this->baseCoreInstance->configurationServerUrl;
        $serviceUrl = '/config/' .
            $this->baseCoreInstance->appId .
            '/flows/' .
            $flowName .
            '/versions';

        $data = [];

        $method       = 'get';
        $clientId     = $this->baseCoreInstance->fullClientId;
        $clientSecret = $this->baseCoreInstance->fullClientSecret;

        return $this->baseCoreInstance->requestInstance->request(
            $serverUrl,
            $serviceUrl,
            $data,
            $method,
            $clientId,
            $clientSecret
        );
    }

    /**
     * Returns a list of fields in a form.
     *
     * Public documentation: https://docs.janrain.com/api/configuration-api/#config-app-flows-flow-forms-form
     *
     * Service path: /config/{app}/flows/{flow}/forms/{form}
     *
     * Response example:
     * [
     *      "_self": "/config/v86cchggr5cdvbfh7ydk8s63zz/flows/myCoolFlow/forms/signInForm",
     *      "fields": [
     *          {
     *              "_self": "/config/v86cchggr5cdvbfh7ydk8s63zz/flows/myCoolFlow/fields/signInEmailAddress",
     *              "name": "signInEmailAddress",
     *              "required": false
     *          },
     *          {
     *              "_self": "/config/v86cchggr5cdvbfh7ydk8s63zz/flows/myCoolFlow/fields/currentPassword",
     *              "name": "currentPassword",
     *              "required": false
     *          }
     *      ]
     * ]
     *
     * @param string $formName The name of the form.
     * @param string $flowName The name of the flow.
     *
     * @return mixed
     */
    public function formConfiguration(string $formName, string $flowName)
    {
        $serverUrl   = $this->baseCoreInstance->configurationServerUrl;
        $serviceUrl = '/config/' .
            $this->baseCoreInstance->appId .
            '/flows/' .
            $flowName .
            '/forms/' .
            $formName;

        $data = [];

        $method       = 'get';
        $clientId     = $this->baseCoreInstance->fullClientId;
        $clientSecret = $this->baseCoreInstance->fullClientSecret;

        return $this->baseCoreInstance->requestInstance->request(
            $serverUrl,
            $serviceUrl,
            $data,
            $method,
            $clientId,
            $clientSecret
        );
    }

    /**
     * Returns a list of fields in a form.
     *
     * Public documentation: https://docs.janrain.com/api/configuration-api/#config-app-flows-flow-fields-field
     *
     * Service path: https://docs.janrain.com/api/configuration-api/#config-app-flows-flow-fields-field
     *
     * @param string $fieldName The name of the field.
     * @param string $flowName The anme of the flow.
     *
     * @return mixed
     */
    public function fieldConfiguration(string $fieldName, string $flowName)
    {
        $serverUrl   = $this->baseCoreInstance->configurationServerUrl;
        $serviceUrl = '/config/' .
            $this->baseCoreInstance->appId .
            '/flows/' .
            $flowName .
            '/fields/' .
            $fieldName;

        $data = [];

        $method       = 'get';
        $clientId     = $this->baseCoreInstance->fullClientId;
        $clientSecret = $this->baseCoreInstance->fullClientSecret;

        return $this->baseCoreInstance->requestInstance->request(
            $serverUrl,
            $serviceUrl,
            $data,
            $method,
            $clientId,
            $clientSecret
        );
    }
}
