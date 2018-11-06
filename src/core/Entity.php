<?php

namespace Janrain\core;

/**
 * Class Entity
 * @package Janrain\core
 *
 * Public documentation: https://docs.janrain.com/api/registration/entity/
 */
class Entity
{
    private $baseCoreInstance;

    /**
     * Entity constructor.
     *
     * @param BaseCore $baseCoreInstance
     */
    public function __construct(BaseCore $baseCoreInstance)
    {
        $this->baseCoreInstance = $baseCoreInstance;
    }

    /**
     * Retrieve a single entity (and any nested objects).
     *
     * Public documentation: https://docs.janrain.com/api/registration/entity/#entity
     *
     * Service path: /entity
     *
     * Response example:
     *   {
     *      "result": {
     *          "birthday": null,
     *          "familyName": "Doe",
     *          "profiles": [],
     *          "id": 999,
     *          "middleName": null,
     *          "emailVerified": "2015-11-15 01:58:01 +0000",
     *          "gender": "male",
     *          "lastUpdated": "2016-03-13 19:39:17.856608 +0000",
     *          "password": null,
     *          "photos": [],
     *          "email": "johndoe@example.com",
     *          "givenName": "John",
     *          "currentLocation": null,
     *          "deactivateAccount": null,
     *          "lastLogin": "2016-03-13 19:39:17 +0000",
     *          "created": "2015-11-15 01:58:01.862312 +0000",
     *          "displayName": "John Doe",
     *          "uuid": "12345abc-1234-abcd-1234-12345abcde12",
     *          "aboutMe": null,
     *          "display": null,
     *          "statuses": []
     *      },
     *      "stat": "ok"
     *  }
     *
     * @param string $accessToken A Registration token, which will be returned after authentication or registration.
     * @param string $typeName The name of the entityType.
     *
     * @return mixed
     */
    public function entity(string $accessToken, string $typeName)
    {
        $captureServerUrl   = $this->baseCoreInstance->captureServerUrl;
        $serviceUrl         = '/entity';

        $data = [
            'type_name'    => $typeName,
            'access_token' => $accessToken,
        ];

        return $this->baseCoreInstance->requestInstance->request(
            $captureServerUrl,
            $serviceUrl,
            $data
        );
    }

    /**
     * Delete a single entity (and any nested objects) from an application, or delete an element of a plural.
     *
     * Public documentation: https://docs.janrain.com/api/registration/entity/#entity-delete
     *
     * Service path: /entity.delete
     *
     * Response example:
     * {
     *      "stat": "ok",
     * }
     *
     * @param string $uuid The unique identifier given to the user entity.
     * @param string $typeName The name of the entityType.
     *
     * @return mixed
     */
    public function entityDelete(string $uuid, string $typeName)
    {
        $captureServerUrl   = $this->baseCoreInstance->captureServerUrl;
        $serviceUrl = '/entity.delete';

        $data = [
            'type_name' => $typeName,
            'uuid'      => $uuid,
        ];

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
     * This API call removes all existing access grants associated with the selected entity from the Registration
     * service.This permanently removes all access tokens, all refresh tokens, and all refresh secrets associated with
     * the entity.
     *
     * Public documentation: https://docs.janrain.com/api/registration/entity/#entity-deleteaccess
     *
     * Service path: /entity.deleteAccess
     *
     * Response example:
     * {
     *      "stat": "ok",
     * }
     *
     * @param string $uuid The unique identifier given to the user entity.
     * @param string $typeName The name of the entityType.
     *
     * @return mixed
     */
    public function entityDeleteAccess(string $uuid, string $typeName)
    {
        $captureServerUrl   = $this->baseCoreInstance->captureServerUrl;
        $serviceUrl         = '/entity.deleteAccess';

        $data = [
            'type_name' => $typeName,
            'uuid'      => $uuid,
        ];

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
     * Retrieve user information from an application. These data entities are returned in JSON format.
     * This information may be filtered using the optional parameters provided.
     *
     * Public documentation: https://docs.janrain.com/api/registration/entity/#entity-find
     *
     * Service path: /entity.find
     *
     * Response example:
     * {
     *      "result_count": 6,
     *      "stat": "ok",
     *      "results": [
     *          {
     *              "displayName": "ian",
     *              "email": "ian@example.com"
     *          },
     *          {
     *              "displayName": "Rex",
     *              "email": "rex@example.com"
     *          },
     *          {
     *              "displayName": "sam",
     *              "email": "smann@example.com"
     *          },
     *      ]
     * }
     *
     * @param string $filter The expression used to filter the results. The default is to match all records.
     * @param string $typeName The name of the entityType.
     * @param array  $attributes A JSON array of attributes to return in the result set. The default is all attributes.
     *
     * @return mixed
     */
    public function entityFind(string $filter, string $typeName, $attributes = null)
    {
        $captureServerUrl   = $this->baseCoreInstance->captureServerUrl;
        $serviceUrl         = '/entity.find';

        $data = [
            'type_name' => $typeName,
            'filter'    => $filter,
        ];

        if (!is_null($attributes)) {
            $data['attributes'] = json_encode($attributes);
        }

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
     * Updates part of an existing entity by appending attributes with data.
     * This data is provided in a JSON object that specifies the path to the attribute, and the value to use.
     *
     * Public documentation: https://docs.janrain.com/api/registration/entity/#entity-update
     *
     * Service path: /entity.update
     *
     * Response example:
     * {
     *      "stat": "ok",
     * }
     *
     * @param string $uuid The unique identifier given the user entity.
     * @param string $attributes Attribute and values to be updated.
     * @param string $typeName The name of the entityType.
     *
     * @return mixed
     */
    public function entityUpdate(string $uuid, string $attributes, string $typeName)
    {
        $captureServerUrl   = $this->baseCoreInstance->captureServerUrl;
        $serviceUrl         = '/entity.update';

        $data = [
            'type_name'  => $typeName,
            'uuid'       => $uuid,
            'attributes' => $attributes,
        ];

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
}
