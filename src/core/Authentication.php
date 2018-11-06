<?php

namespace Janrain\core;

/**
 * Class Authentication
 * @package Janrain\core
 *
 * Public documentation: https://docs.janrain.com/api/registration/authentication/
 */
class Authentication
{
    private $baseCoreInstance;

    /**
     * Authentication constructor.
     *
     * @param BaseCore $baseCoreInstance
     */
    public function __construct(BaseCore $baseCoreInstance)
    {
        $this->baseCoreInstance = $baseCoreInstance;
    }

    /**
     * This API call retrieves an accessToken for signing in to an application.
     *
     * Public documentation: https://docs.janrain.com/api/registration/authentication/#access-getaccesstoken
     *
     * Service path: /access/getAccessToken
     *
     * Response example:
     * {
     *      "accessToken": "tc7blahblah3tmaz",
     *      "stat": "ok"
     * }
     *
     * @param string $uuid The unique identifier given the user entity.
     * @param string $typeName The name of the entityType.
     * @param string $clientId The client_id for which to retrieve an accessToken.
     *
     * @return mixed
     */
    public function getAccessToken(string $uuid, string $typeName, string $clientId)
    {
        $captureServerUrl   = $this->baseCoreInstance->captureServerUrl;
        $serviceUrl         = '/access/getAccessToken';

        $data = [
            'uuid'          => $uuid,
            'type_name'     => $typeName,
            'for_client_id' => $clientId,
        ];

        $method       = 'get';
        $clientId     = $this->baseCoreInstance->fullClientId;
        $clientSecret = $this->baseCoreInstance->fullClientSecret;

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
     * Get an authorization code that can be exchanged for an access_token and a refresh_token.
     *
     * Public documentation: https://docs.janrain.com/api/registration/authentication/#access-getauthorizationcode
     *
     * Service path: /access/getAuthorizationCode
     *
     * Response example:
     * {
     *      "authorizationCode": "12345678912345",
     *      "stat": "ok"
     * }
     *
     * @param string $uuid The unique identifier given the user entity.
     * @param string $typeName The entityType of the entity.
     * @param string $clientId The client_id for which to retrieve an authorization code.
     * @param string $redirectUri The redirect URI. This is the address used by the UI to make the redirect.
     *
     * @return mixed
     */
    public function getAuthorizationCode(string $uuid, string $typeName, string $clientId, string $redirectUri)
    {
        $captureServerUrl   = $this->baseCoreInstance->captureServerUrl;
        $serviceUrl         = '/access/getAuthorizationCode';

        $data = [
            'uuid'          => $uuid,
            'type_name'     => $typeName,
            'redirect_uri'  => $redirectUri,
            'for_client_id' => $clientId,
        ];

        $method       = 'get';
        $clientId     = $this->baseCoreInstance->fullClientId;
        $clientSecret = $this->baseCoreInstance->fullClientSecret;

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
     * Gets a creation token which can be used to make entity.create calls without the use of a client id and secret.
     *
     * Public documentation: https://docs.janrain.com/api/registration/authentication/#access-getcreationtoken
     *
     * Service path: /access/getCreationToken
     *
     * Response example:
     * {
     *      "creation_token": "1234567891234567",
     *      "stat": "ok"
     * }
     *
     * @param string $typeName The entityType of the entity that will be created with this token.
     * @param string $lifetime The number of seconds for which this token is valid.
     * @param string $clientId The client id to which you wish to grant the creation token.
     *
     * @return mixed
     */
    public function getCreationToken(string $typeName, string $lifetime, string $clientId)
    {
        $captureServerUrl   = $this->baseCoreInstance->captureServerUrl;
        $serviceUrl         = '/access/getCreationToken';

        $data = [
            'type_name'     => $typeName,
            'lifetime'      => $lifetime,
            'for_client_id' => $clientId,
        ];

        $method       = 'get';
        $clientId     = $this->baseCoreInstance->fullClientId;
        $clientSecret = $this->baseCoreInstance->fullClientSecret;

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
     * Gets a verification code that can later be used with useVerificationCode.
     *
     * Public documentation: https://docs.janrain.com/api/registration/authentication/#access-getverificationcode
     *
     * Service path: /access/getVerificationCode
     *
     * Response example:
     * {
     *      "verification_code": "htjwg2uphwz5mqxrnqe4tuvpxkzaqrr5",
     *      "stat": "ok"
     * }
     *
     * @param string $uuid The unique identifier given the user entity.
     * @param string $typeName The entityType of the entity.
     * @param string $attributeName The name of the attribute to update when using the verification code.
     *
     * @return mixed
     */
    public function getVerificationCode(string $uuid, string $typeName, string $attributeName)
    {
        $captureServerUrl   = $this->baseCoreInstance->captureServerUrl;
        $serviceUrl         = '/access/getVerificationCode';

        $data = [
            'uuid'           => $uuid,
            'type_name'      => $typeName,
            'attribute_name' => $attributeName,
        ];

        $method       = 'get';
        $clientId     = $this->baseCoreInstance->fullClientId;
        $clientSecret = $this->baseCoreInstance->fullClientSecret;

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
     * Uses a verification code to set a time field to the current time.
     * Any particular verification code can only be used once. This is often used for items like email verification.
     *
     * Public documentation: https://docs.janrain.com/api/registration/authentication/#access-useverificationcode
     *
     * Service path: /access/useVerificationCode
     *
     * Response example:
     * {
     *      "uuid": "7d19b6f2-bba2-48ba-9442-19d396427d77"
     *      "stat": "ok"
     * }
     *
     * @param string $verificationCode The verification code obtained in a previous call to access/getVerificationCode.
     *
     * @return mixed
     */
    public function useVerificationCode(string $verificationCode)
    {
        $captureServerUrl   = $this->baseCoreInstance->captureServerUrl;
        $serviceUrl         = '/access/useVerificationCode';

        $data = [
            'verification_code' => $verificationCode,
        ];

        return $this->baseCoreInstance->requestInstance->request(
            $captureServerUrl,
            $serviceUrl,
            $data
        );
    }

    /**
     * This endpoint is used to complete social login.
     * To make this call, you must have a valid Social Login token received after a user successfully authenticates
     * through one of the identity providers you have enabled for your Social Login application.
     *
     * Public documentation: https://docs.janrain.com/api/registration/authentication/#oauth-auth_native
     *
     * Service path: /oauth/auth_native
     *
     * Response example:
     * {
     *      "capture_user": {
     *      "created": "2016-04-20 17:02:18.649505 +0000",
     *      "uuid": "67890def-6789-defg-6789-67890defgh67",
     *      // additional profile data...
     *      },
     *      "stat": "ok",
     *      "access_token": "z0y98xv76u5t4rs3"
     * }
     *
     * @param string $clientId The API client ID that will be used to authenticate the call.
     * @param string $flowName The name of the flow configured with the social login experience you want to use.
     * @param string $flowVersion The version number of the flow set in the flow parameter.
     * @param string $locale The code for the language you want to use for the social login experience.
     * @param string $redirectUri This parameter is required for legacy purposes.
     * @param string $formName The name of the form in your flow that you will use for social registration.
     * @param array $tokens Array of 'engageToken' and 'mergeToken'. A one-time token used for social authentication.
     *
     * @return mixed
     */
    public function authNative(
        string $clientId,
        string $flowName,
        string $flowVersion,
        string $locale,
        string $redirectUri,
        string $formName,
        array $tokens
    ) {

        $captureServerUrl   = $this->baseCoreInstance->captureServerUrl;
        $serviceUrl         = '/oauth/auth_native';

        $data = [
            'client_id'         => $clientId,
            'flow'              => $flowName,
            'flow_version'      => $flowVersion,
            'locale'            => $locale,
            'redirect_uri'      => $redirectUri,
            'response_type'     => 'code_and_token',
            'registration_form' => $formName,
            'token'             => $tokens['engageToken'],
        ];

        if ($tokens['mergeToken']) {
            $data['merge_token'] = $tokens['mergeToken'];
        }

        $method = 'post';

        return $this->baseCoreInstance->requestInstance->request(
            $captureServerUrl,
            $serviceUrl,
            $data,
            $method
        );
    }

    /**
     * This endpoint is used to complete traditional login using an email address or username along with a password.
     *
     * Public documentation: https://docs.janrain.com/api/registration/authentication/#oauth-auth_native_traditional
     *
     * Service path: /oauth/auth_native_traditional
     *
     * Response example:
     * {
     *      "capture_user": {
     *      "created": "2016-04-20 17:02:18.649505 +0000",
     *      "uuid": "67890def-6789-defg-6789-67890defgh67",
     *      // additional profile data...
     *      },
     *      "stat": "ok",
     *      "access_token": "z0y98xv76u5t4rs3"
     * }
     *
     * @param string $clientId The API client ID that will be used to authenticate the call.
     * @param string $flowName The name of the flow configured with the social login experience you want to use.
     * @param string $flowVersion The version number of the flow set in the flow parameter.
     * @param string $locale The code for the language you want to use for the social login experience.
     * @param string $redirectUri This parameter is required for legacy purposes.
     * @param string $formName The name of the form in your flow that you will use for social registration.
     * @param array  $formFields Array wuth fields filled by the user.
     *
     * @return mixed
     */
    public function authNativeTraditional(
        string $clientId,
        string $flowName,
        string $flowVersion,
        string $locale,
        string $redirectUri,
        string $formName,
        array $formFields
    ) {

        $captureServerUrl   = $this->baseCoreInstance->captureServerUrl;
        $serviceUrl         = '/oauth/auth_native_traditional';

        $data = [
            'client_id'     => $clientId,
            'flow'          => $flowName,
            'flow_version'  => $flowVersion,
            'locale'        => $locale,
            'redirect_uri'  => $redirectUri,
            'response_type' => 'code_and_token',
            'form'          => $formName,
        ];

        $data = array_merge($data, $formFields);

        $method = 'post';

        return $this->baseCoreInstance->requestInstance->request(
            $captureServerUrl,
            $serviceUrl,
            $data,
            $method
        );
    }

    /**
     * This endpoint is used to trigger an email that includes a link with a one-time authorization code a user can
     * click to set a new password.
     *
     * Public documentation: https://docs.janrain.com/api/registration/authentication/#oauth-forgot_password_native
     *
     * Service path: /oauth/forgot_password_native
     *
     * Response example:
     * {
     *      "stat": "ok",
     * }
     *
     * @param string $clientId The API client ID that will be used to authenticate the call.
     * @param string $flowName The name of the flow configured with the social login experience you want to use.
     * @param string $flowVersion The version number of the flow set in the flow parameter.
     * @param string $locale The code for the language you want to use for the social login experience.
     * @param string $redirectUri This parameter is required for legacy purposes.
     * @param string $formName The name of the form in your flow that you will use for social registration.
     * @param array  $formFields Array wuth fields filled by the user.
     *
     * @return mixed
     */
    public function forgotPasswordNative(
        string $clientId,
        string $flowName,
        string $flowVersion,
        string $locale,
        string $redirectUri,
        string $formName,
        array $formFields
    ) {

        $captureServerUrl   = $this->baseCoreInstance->captureServerUrl;
        $serviceUrl         = '/oauth/forgot_password_native';

        $data = [
            'client_id'     => $clientId,
            'flow'          => $flowName,
            'flow_version'  => $flowVersion,
            'locale'        => $locale,
            'redirect_uri'  => $redirectUri,
            'form'          => $formName,
        ];

        $data = array_merge($data, $formFields);

        $method  = 'post';

        return $this->baseCoreInstance->requestInstance->request(
            $captureServerUrl,
            $serviceUrl,
            $data,
            $method
        );
    }

    /**
     * This endpoint is used to link a new social identity to an existing user account.
     * Once linked, the new identity can be used to sign in to that account.
     * To make this call, you must have a valid Social Login token received after a user authenticates through the
     * social provider account to be linked, as well as a valid Registration access token for the user record to be
     * updated.
     *
     * Public documentation: https://docs.janrain.com/api/registration/authentication/#oauth-link_account_native
     *
     * Service path: /oauth/link_account_native
     *
     * Response example:
     * {
     *      "stat": "ok",
     * }
     *
     * @param string $clientId The API client ID that will be used to authenticate the call.
     * @param string $flowName The name of the flow configured with the social login experience you want to use.
     * @param string $flowVersion The version number of the flow set in the flow parameter.
     * @param string $locale The code for the language you want to use for the social login experience.
     * @param string $redirectUri This parameter is required for legacy purposes.
     * @param string $formName The name of the form in your flow that you will use for social registration.
     * @param string $token A one-time token used for social authentication.
     * @param string $accessToken A Registration token, which will be returned after authentication or registration.
     *
     * @return mixed
     */
    public function linkAccountNative(
        string $clientId,
        string $flowName,
        string $flowVersion,
        string $locale,
        string $redirectUri,
        string $formName,
        string $token,
        string $accessToken
    ) {

        $captureServerUrl   = $this->baseCoreInstance->captureServerUrl;
        $serviceUrl         = '/oauth/link_account_native';

        $data = [
            'client_id'     => $clientId,
            'flow'          => $flowName,
            'flow_version'  => $flowVersion,
            'locale'        => $locale,
            'redirect_uri'  => $redirectUri,
            'form'          => $formName,
            'token'         => $token,
            'access_token'  => $accessToken
        ];

        $method  = 'post';

        return $this->baseCoreInstance->requestInstance->request(
            $captureServerUrl,
            $serviceUrl,
            $data,
            $method
        );
    }

    /**
     * This endpoint is used to complete social registration.
     *
     * Public documentation: https://docs.janrain.com/api/registration/authentication/#oauth-register_native
     *
     * Service path: /oauth/register_native
     *
     * Response example:
     * {
     *      "capture_user": {
     *      "created": "2016-04-20 17:02:18.649505 +0000",
     *      "uuid": "67890def-6789-defg-6789-67890defgh67",
     *      // additional profile data...
     *      },
     *      "stat": "ok",
     *      "access_token": "z0y98xv76u5t4rs3"
     * }
     *
     * @param string $clientId The API client ID that will be used to authenticate the call.
     * @param string $flowName The name of the flow configured with the social login experience you want to use.
     * @param string $flowVersion The version number of the flow set in the flow parameter.
     * @param string $locale The code for the language you want to use for the social login experience.
     * @param string $redirectUri This parameter is required for legacy purposes.
     * @param string $formName The name of the form in your flow that you will use for social registration.
     * @param string $engageToken A one-time token used for social authentication.
     * @param array  $formFields  Array wuth fields filled by the user.
     *
     * @return mixed
     */
    public function registerNative(
        string $clientId,
        string $flowName,
        string $flowVersion,
        string $locale,
        string $redirectUri,
        string $formName,
        string $engageToken,
        array $formFields
    ) {

        $captureServerUrl   = $this->baseCoreInstance->captureServerUrl;
        $serviceUrl         = '/oauth/register_native';

        $data = [
            'client_id'     => $clientId,
            'flow'          => $flowName,
            'flow_version'  => $flowVersion,
            'locale'        => $locale,
            'redirect_uri'  => $redirectUri,
            'response_type' => 'code_and_token',
            'form'          => $formName,
            'token'         => $engageToken,
        ];

        $data = array_merge($data, $formFields);

        $method = 'post';

        return $this->baseCoreInstance->requestInstance->request(
            $captureServerUrl,
            $serviceUrl,
            $data,
            $method
        );
    }

    /**
     * This endpoint is used to complete traditional registration.
     * Once complete, a user will be able to authenticate using an email address or username along with a password.
     *
     * Public documentation: https://docs.janrain.com/api/registration/authentication/#oauth-register_native_traditional
     *
     * Service path: /oauth/register_native_traditional
     *
     * Response example:
     * {
     *      "capture_user": {
     *      "created": "2016-04-20 17:02:18.649505 +0000",
     *      "uuid": "67890def-6789-defg-6789-67890defgh67",
     *      // additional profile data...
     *      },
     *      "stat": "ok",
     *      "access_token": "z0y98xv76u5t4rs3"
     * }
     *
     * @param string $clientId The API client ID that will be used to authenticate the call.
     * @param string $flowName The name of the flow configured with the social login experience you want to use.
     * @param string $flowVersion The version number of the flow set in the flow parameter.
     * @param string $locale The code for the language you want to use for the social login experience.
     * @param string $redirectUri This parameter is required for legacy purposes.
     * @param string $formName The name of the form in your flow that you will use for social registration.
     * @param array  $formFields Array wuth fields filled by the user.
     *
     * @return mixed
     */
    public function registerNativeTraditional(
        string $clientId,
        string $flowName,
        string $flowVersion,
        string $locale,
        string $redirectUri,
        string $formName,
        array $formFields
    ) {

        $captureServerUrl   = $this->baseCoreInstance->captureServerUrl;
        $serviceUrl         = '/oauth/register_native_traditional';

        $data = [
            'client_id'      => $clientId,
            'flow'           => $flowName,
            'flow_version'   => $flowVersion,
            'locale'         => $locale,
            'redirect_uri'   => $redirectUri,
            'response_type'  => 'code_and_token',
            'form'           => $formName,
        ];

        $data = array_merge($data, $formFields);

        $method = 'post';

        return $this->baseCoreInstance->requestInstance->request(
            $captureServerUrl,
            $serviceUrl,
            $data,
            $method
        );
    }

    /**
     * This endpoint can be used to obtain a Registration access_token for an authenticated user.
     *
     * Public documentation: https://docs.janrain.com/api/registration/authentication/#oauth-token
     *
     * Service path: /oauth/token
     *
     * Response example:
     * {
     *      "access_token": "8r8v9ad6dajnbk5t",
     *      "expires_in": 3600,
     *      "refresh_token": "f4mrz7dzatqm272tpey2",
     *      "stat": "ok"
     * }
     *
     * @param string $grantType Available values are authorization_code and refresh_token.
     * @param string $code The authorization code received after a user has successfully authenticated.
     * @param string $redirectUri The same value as the redirect_uri that was passed into a previous API call.
     * @param string $refreshToken A refresh token received from a previous oauth/token call.
     *
     * @return mixed
     */
    public function token(string $grantType, $code = null, $redirectUri = null, $refreshToken = null)
    {
        $captureServerUrl   = $this->baseCoreInstance->captureServerUrl;
        $serviceUrl         = '/oauth/token';

        $data = [
            'grant_type' => $grantType,
        ];

        if ('refresh_token' == $grantType) {
            $data['refresh_token'] = $refreshToken;
        }

        if ('authorization_code' == $grantType) {
            $data['code']         = $code;
            $data['redirect_uri'] = $redirectUri;
        }

        $method       = 'post';
        $clientId     = $this->baseCoreInstance->loginClientId;
        $clientSecret = $this->baseCoreInstance->loginClientSecret;

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
     * This endpoint is used to unlink a social provider from a user account.
     *
     * Public documentation: https://docs.janrain.com/api/registration/authentication/#oauth-unlink_account_native
     *
     * Service path: /oauth/unlink_account_native
     *
     * Response example:
     * {
     *      "stat": "ok"
     * }
     *
     * @param string $clientId The API client ID that will be used to authenticate the call.
     * @param string $flowName The name of the flow configured with the social login experience you want to use.
     * @param string $flowVersion The version number of the flow set in the flow parameter.
     * @param string $locale The code for the language you want to use for the social login experience.
     * @param string $redirectUri This parameter is required for legacy purposes.
     * @param string $accessToken A Registration token, which will be returned after authentication or registration.
     *
     * @return mixed
     */
    public function unlinkAccountNative(
        string $clientId,
        string $flowName,
        string $flowVersion,
        string $locale,
        string $redirectUri,
        string $accessToken
    ) {

        $captureServerUrl   = $this->baseCoreInstance->captureServerUrl;
        $serviceUrl         = '/oauth/unlink_account_native';

        $data = [
            'access_token'          => $accessToken,
            'client_id'             => $clientId,
            'flow'                  => $flowName,
            'flow_version'          => $flowVersion,
            'locale'                => $locale,
            'identifier_to_remove'  => $redirectUri,
        ];

        $method = 'post';

        return $this->baseCoreInstance->requestInstance->request(
            $captureServerUrl,
            $serviceUrl,
            $data,
            $method
        );
    }

    /**
     * This endpoint is used to update profile data based on input from a user in an edit profile form.
     *
     * Public documentation: https://docs.janrain.com/api/registration/authentication/#oauth-update_profile_native
     *
     * Service path: /oauth/update_profile_native
     *
     * Response example:
     * {
     *      "stat": "ok"
     * }
     *
     * @param string $clientId The API client ID that will be used to authenticate the call.
     * @param string $flowName The name of the flow configured with the social login experience you want to use.
     * @param string $flowVersion The version number of the flow set in the flow parameter.
     * @param string $locale The code for the language you want to use for the social login experience.
     * @param string $accessToken A Registration access token.
     * @param string $formName The name of the form in your flow that you will use for social registration.
     * @param array  $formFields Array wuth fields filled by the user.
     *
     * @return mixed
     */
    public function updateProfileNative(
        string $clientId,
        string $flowName,
        string $flowVersion,
        string $locale,
        string $formName,
        string $accessToken,
        array $formFields
    ) {

        $captureServerUrl   = $this->baseCoreInstance->captureServerUrl;
        $serviceUrl         = '/oauth/update_profile_native';

        $data = [
            'client_id'     => $clientId,
            'flow'          => $flowName,
            'flow_version'  => $flowVersion,
            'locale'        => $locale,
            'form'          => $formName,
            'access_token'  => $accessToken,
        ];

        $data = array_merge($data, $formFields);

        $method       = 'post';
        $clientId     = $this->baseCoreInstance->loginClientId;
        $clientSecret = $this->baseCoreInstance->loginClientSecret;

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
     * This endpoint is used to trigger an email that includes a link with a one-time verification code a user can
     * click to complete the email verification process.
     *
     * Public documentation: https://docs.janrain.com/api/registration/authentication/#oauth-verify_email_native
     *
     * Service path: /oauth/verify_email_native
     *
     * Response example:
     * {
     *      "stat": "ok"
     * }
     *
     * @param string $clientId The API client ID that will be used to authenticate the call.
     * @param string $flowName The name of the flow configured with the social login experience you want to use.
     * @param string $flowVersion The version number of the flow set in the flow parameter.
     * @param string $locale The code for the language you want to use for the social login experience.
     * @param string $redirectUri The same value as the redirect_uri that was passed into a previous API call.
     * @param string $formName The name of the form in your flow that you will use for social registration.
     * @param array  $formFields Array wuth fields filled by the user.
     *
     * @return mixed
     */
    public function verifyEmailNative(
        string $clientId,
        string $flowName,
        string $flowVersion,
        string $locale,
        string $redirectUri,
        string $formName,
        array $formFields
    ) {

        $captureServerUrl   = $this->baseCoreInstance->captureServerUrl;
        $serviceUrl         = '/oauth/verify_email_native';

        $data = [
            'client_id'          => $clientId,
            'flow'               => $flowName,
            'flow_version'       => $flowVersion,
            'locale'             => $locale,
            'redirect_uri'       => $redirectUri,
            'form'               => $formName,
        ];

        $data = array_merge($data, $formFields);

        $method       = 'post';
        $clientId     = $this->baseCoreInstance->loginClientId;
        $clientSecret = $this->baseCoreInstance->loginClientSecret;

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
