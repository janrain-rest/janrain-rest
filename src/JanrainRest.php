<?php

namespace JanrainRest;

use JanrainRest\core\Authentication;
use JanrainRest\core\BaseCore;
use JanrainRest\core\ClientSettings;
use JanrainRest\core\Configuration;
use JanrainRest\core\Engage;
use JanrainRest\core\Entity;
use JanrainRest\core\FormConfiguration;
use JanrainRest\core\Social;
use JanrainRest\core\StaticFlow;
use JanrainRest\core\Translations;
use Psr\Log\LoggerInterface;

class JanrainRest
{
    private $baseCoreInstance;
    private $authenticationInstance;
    private $engageInstance;
    private $entityInstance;
    private $configurationInstance;
    private $staticFlowInstance;
    private $formConfigurationInstance;
    private $socialInstance;
    private $translationsInstance;
    private $clientsSettingsInstance;
    private $captureServerUrl;
    private $configurationServerUrl;
    private $fullClientId;
    private $fullClientSecret;
    private $loginClientId;
    private $loginClientSecret;
    private $appId;
    private $cdnUrl;
    private $locale;
    private $flowName;
    private $logger;

    /**
     * BaseCore constructor.
     *
     * @param string $captureServerUrl
     * @param string $configurationServerUrl
     * @param string $cdnUrl
     * @param string $fullClientId
     * @param string $fullClientSecret
     * @param string $loginClientId
     * @param string $loginClientSecret
     * @param string $appId
     * @param string $locale
     * @param string $flowName
     * @param LoggerInterface $logger
     */
    public function __construct(
        string $captureServerUrl,
        string $configurationServerUrl,
        string $cdnUrl,
        string $fullClientId,
        string $fullClientSecret,
        string $loginClientId,
        string $loginClientSecret,
        string $appId,
        string $locale,
        string $flowName,
        LoggerInterface $logger
    ) {

        $this->captureServerUrl       = $captureServerUrl;
        $this->configurationServerUrl = $configurationServerUrl;
        $this->cdnUrl                 = $cdnUrl;
        $this->fullClientId           = $fullClientId;
        $this->fullClientSecret       = $fullClientSecret;
        $this->loginClientId          = $loginClientId;
        $this->loginClientSecret      = $loginClientSecret;
        $this->appId                  = $appId;
        $this->locale                 = $locale;
        $this->flowName               = $flowName;
        $this->logger                 = $logger;

        $this->baseCoreInstance = new BaseCore(
            $captureServerUrl,
            $configurationServerUrl,
            $fullClientId,
            $fullClientSecret,
            $loginClientId,
            $loginClientSecret,
            $appId,
            $logger
        );

        $this->authenticationInstance   = new Authentication($this->baseCoreInstance);
        $this->entityInstance           = new Entity($this->baseCoreInstance);
        $this->configurationInstance    = new Configuration($this->baseCoreInstance);
        $this->clientsSettingsInstance  = new ClientSettings($this->baseCoreInstance);
        $this->socialInstance           = new Social($this->baseCoreInstance);
        $this->engageInstance           = new Engage($this->baseCoreInstance);

        $this->staticFlowInstance = new StaticFlow($cdnUrl, $appId, $locale, $flowName, $logger);

        $this->formConfigurationInstance = new FormConfiguration($this->staticFlowInstance);
        $this->translationsInstance      = new Translations($this->staticFlowInstance);
    }

    /**
     * Register user on Janrain using Register Native Tradicional service.
     *
     * @param string $clientId The API client ID that will be used to authenticate the call.
     * @param string $flowVersion The version number of the flow set in the flow parameter.
     * @param string $redirectUri This parameter is required for legacy purposes.
     * @param string $formName The name of the form in your flow that you will use for social registration.
     * @param array  $formFields Array wuth fields filled by the user.
     *
     * @return array
     */
    public function registerNativeTraditional(
        string $clientId,
        string $flowVersion,
        string $redirectUri,
        string $formName,
        array $formFields
    ) {

        $idpResponse = $this->authenticationInstance->registerNativeTraditional(
            $clientId,
            $this->flowName,
            $flowVersion,
            $this->locale,
            $redirectUri,
            $formName,
            $formFields
        );

        if ($idpResponse->stat == 'ok') {
            // @codingStandardsIgnoreStart
            return [
                'has_errors'    => false,
                'capture_user'  => $idpResponse->capture_user,
                'access_token'  => $idpResponse->access_token,
            ];
            // @codingStandardsIgnoreEnd
        }

        return $this->returnErrors($idpResponse);
    }

    /**
     * Delete user from Janrain using Entity.Delete method.
     *
     * @param string $uuid The unique identifier given to the user entity.
     * @param string $typeName The name of the entityType.
     *
     * @return array
     */
    public function entityDelete(string $uuid, string $typeName)
    {
        $idpResponse = $this->entityInstance->entityDelete($uuid, $typeName);

        if ($idpResponse->stat == 'ok') {
            return [
                'has_errors' => false,
            ];
        }

        return $this->returnErrors($idpResponse);
    }

    /**
     * Get user Access Token from service /access/getAccessToken.
     *
     * @param string $uuid The unique identifier given the user entity.
     * @param string $typeName The name of the entityType.
     * @param string $clientId The client_id for which to retrieve an accessToken.
     *
     * @return array
     */
    public function getAccessToken(string $uuid, string $typeName, string $clientId = NULL)
    {
        $idpResponse = $this->authenticationInstance->getAccessToken($uuid, $typeName, $clientId);

        if ($idpResponse->stat == 'ok') {
            return [
                'has_errors' => false,
                'accessToken' => $idpResponse->accessToken,
            ];
        }

        return $this->returnErrors($idpResponse);
    }

    /**
     * Login User with /oauth/auth_native_traditional service.
     *
     * @param string $clientId The API client ID that will be used to authenticate the call.
     * @param string $flowVersion The version number of the flow set in the flow parameter.
     * @param string $redirectUri This parameter is required for legacy purposes.
     * @param string $formName The name of the form in your flow that you will use for social registration.
     * @param array  $formFields Array wuth fields filled by the user.
     *
     * @return array
     */
    public function authNativeTraditional(
        string $clientId,
        string $flowVersion,
        string $redirectUri,
        string $formName,
        array $formFields
    ) {
        $idpResponse = $this->authenticationInstance->authNativeTraditional(
            $clientId,
            $this->flowName,
            $flowVersion,
            $this->locale,
            $redirectUri,
            $formName,
            $formFields
        );

        if ($idpResponse->stat == 'ok') {
            // @codingStandardsIgnoreStart
            return [
                'has_errors'         => false,
                'capture_user'       => $idpResponse->capture_user,
                'access_token'       => $idpResponse->access_token,
                'authorization_code' => $idpResponse->authorization_code,
            ];
            // @codingStandardsIgnoreEnd
        }

        return $this->returnErrors($idpResponse);
    }

    /**
     * Login User with /oauth/auth_native service.
     *
     * @param string $clientId The API client ID that will be used to authenticate the call.
     * @param string $flowVersion The version number of the flow set in the flow parameter.
     * @param string $redirectUri This parameter is required for legacy purposes.
     * @param string $formName The name of the form in your flow that you will use for social registration.
     * @param string $engageToken Social media engage token.
     *
     * @return array
     */
    public function authNative(
        string $clientId,
        string $flowVersion,
        string $redirectUri,
        string $formName,
        string $engageToken,
        string $mergeToken = ''
    ) {
        $data = [
            'engageToken' => $engageToken,
            'mergeToken' => $mergeToken,
        ];

        $idpResponse = $this->authenticationInstance->authNative(
            $clientId,
            $this->flowName,
            $flowVersion,
            $this->locale,
            $redirectUri,
            $formName,
            $data
        );

        if ($idpResponse->stat == 'ok') {
            // @codingStandardsIgnoreStart
            return [
                'has_errors'         => false,
                'capture_user'       => $idpResponse->capture_user,
                'access_token'       => $idpResponse->access_token,
                'authorization_code' => $idpResponse->authorization_code,
            ];
            // @codingStandardsIgnoreEnd
        }

        $userData = [];
        $requestId = '';
        $existingProvider = '';
        if (property_exists($idpResponse, 'prereg_fields')) {
            $userData = $idpResponse->prereg_fields;
        }
        if (property_exists($idpResponse, 'request_id')) {
            $requestId = $idpResponse->request_id;
        }
        if (property_exists($idpResponse, 'existing_provider')) {
            $existingProvider = $idpResponse->existing_provider;
        }

        // @codingStandardsIgnoreStart
        return [
            'has_errors'        => true,
            'code'              => $idpResponse->code,
            'error_description' => $idpResponse->error_description,
            'user_data'         => $userData,
            'request_id'        => $requestId,
            'existing_provider' => $existingProvider,
        ];
        // @codingStandardsIgnoreEnd
    }

    /**
     * Register User with /oauth/register_native.
     *
     * @param string $clientId The API client ID that will be used to authenticate the call.
     * @param string $flowVersion The version number of the flow set in the flow parameter.
     * @param string $redirectUri This parameter is required for legacy purposes.
     * @param string $formName The name of the form in your flow that you will use for social registration.
     * @param string $engageToken Social media engage token.
     * @param array  $data User registration data.
     *
     * @return array
     */
    public function registerNative(
        string $clientId,
        string $flowVersion,
        string $redirectUri,
        string $formName,
        string $engageToken,
        array $data
    ) {
        $idpResponse = $this->authenticationInstance->registerNative(
            $clientId,
            $this->flowName,
            $flowVersion,
            $this->locale,
            $redirectUri,
            $formName,
            $engageToken,
            $data
        );

        if ($idpResponse->stat == 'ok') {
            // @codingStandardsIgnoreStart
            return [
                'has_errors'         => false,
                'capture_user'       => $idpResponse->capture_user,
                'access_token'       => $idpResponse->access_token,
                'authorization_code' => $idpResponse->authorization_code,
            ];
            // @codingStandardsIgnoreEnd
        }

        return $this->returnErrors($idpResponse);
    }

    /**
     * Get verification code.
     *
     * @param string $uuid The unique identifier given the user entity.
     * @param string $typeName The entityType of the entity.
     * @param string $attributeName The name of the attribute to update when using the verification code.
     *
     * @return array
     */
    public function getVerificationCode(string $uuid, string $typeName, string $attributeName)
    {
        $idpResponse = $this->authenticationInstance->getVerificationCode($uuid, $typeName, $attributeName);

        if ($idpResponse->stat == 'ok') {
            return [
                'has_errors' => false,
                'verificationCode' => $idpResponse->verification_code,
            ];
        }

        return $this->returnErrors($idpResponse);
    }

    /**
     * Use Verification code.
     *
     * @param string $verificationCode The verification code obtained in a previous call to access/getVerificationCode.
     *
     * @return array
     */
    public function useVerificationCode(string $verificationCode)
    {
        $idpResponse = $this->authenticationInstance->useVerificationCode($verificationCode);

        if ($idpResponse->stat == 'ok') {
            return [
                'has_errors' => false,
                'uuid' => $idpResponse->uuid,
            ];
        }

        return $this->returnErrors($idpResponse);
    }

    /**
     * Get Tokens.
     *
     * @param string $grantType Available values are authorization_code and refresh_token.
     * @param string $code The authorization code received after a user has successfully authenticated.
     * @param string $redirectUri The same value as the redirect_uri that was passed into a previous API call.
     * @param string $refreshToken A refresh token received from a previous oauth/token call.
     *
     * @return array
     */
    public function token(string $grantType, $code = null, $redirectUri = null, $refreshToken = null)
    {
        $idpResponse = $this->authenticationInstance->token($grantType, $code, $redirectUri, $refreshToken);

        if ($idpResponse->stat == 'ok') {
            return [
                'has_errors'    => false,
                'access_token'  => $idpResponse->access_token,
                'expires_in'    => $idpResponse->expires_in,
                'refresh_token' => $idpResponse->refresh_token,
            ];
        }

        return $this->returnErrors($idpResponse);
    }

    /**
     * Update user profile.
     *
     * @param string $clientId The API client ID that will be used to authenticate the call.
     * @param string $flowVersion The version number of the flow set in the flow parameter.
     * @param string $accessToken A Registration access token.
     * @param string $formName The name of the form in your flow that you will use for social registration.
     * @param array  $formFields Array wuth fields filled by the user.
     * @param string $flowName OPTIONAL: In case you want to use another flow name.
     * @param string $locale OPTIONAL: In case you want to use another locale.
     *
     * @return array
     */
    public function updateProfileNative(
        string $clientId,
        string $flowVersion,
        string $formName,
        string $accessToken,
        array $formFields,
        string $flowName = NULL,
        string $locale = NUll
    ) {
        $idpResponse = $this->authenticationInstance->updateProfileNative(
          $clientId,
          isset($flowName) ? $flowName : $this->flowName,
          $flowVersion,
          isset($locale) ? $locale : $this->locale,
          $formName,
          $accessToken,
          $formFields
        );

        if ($idpResponse->stat == 'ok') {
            return [
                'has_errors' => false,
            ];
        }

        return $this->returnErrors($idpResponse);
    }

    /**
     * Gerenic Custom Call.
     *
     * @param string $clientId The API client ID that will be used to authenticate the call.
     * @param string $flowVersion The version number of the flow set in the flow parameter.
     * @param string $redirectUri The same value as the redirect_uri that was passed into a previous API call.
     * @param string $formName The name of the form in your flow that you will use for social registration.
     * @param array  $formFields Array wuth fields filled by the user.
     *
     * @return mixed
     */
    public function gerenicCustomCall(
        string $clientId,
        string $flowVersion,
        string $redirectUri,
        string $formName,
        array $formFields,
        string $serviceUrl
    ) {
        $idpResponse = $this->authenticationInstance->genericCustomCall(
            $clientId,
            $this->flowName,
            $flowVersion,
            $this->locale,
            $redirectUri,
            $formName,
            $formFields,
            $serviceUrl
        );

        if ($idpResponse->stat == 'ok') {
            return [
                'has_errors' => false,
            ];
        }

        $invalid_fields = [];
        if (!empty($idpResponse->invalid_fields)) {
            $invalid_fields = (array) $idpResponse->invalid_fields;
        }
        if (!empty($idpResponse->message)) {
            if (empty($invalid_fields)) {
                $invalid_fields[$formName] = (array) $idpResponse->message;
            }
        }

        $idpResponse->invalid_fields = $invalid_fields;

        return $this->returnErrors($idpResponse);
    }

    /**
     * Send verify email.
     *
     * @param string $clientId The API client ID that will be used to authenticate the call.
     * @param string $flowVersion The version number of the flow set in the flow parameter.
     * @param string $redirectUri The same value as the redirect_uri that was passed into a previous API call.
     * @param string $formName The name of the form in your flow that you will use for social registration.
     * @param array  $formFields Array wuth fields filled by the user.
     * @param string $flowName OPTIONAL: In case you want to use another flow name.
     * @param string $locale OPTIONAL: In case you want to use another locale.
     *
     * @return array
     */
    public function verifyEmailNative(
        string $clientId,
        string $flowVersion,
        string $redirectUri,
        string $formName,
        array $formFields,
        string $flowName = NULL,
        string $locale = NUll
    ) {
        $idpResponse = $this->authenticationInstance->verifyEmailNative(
          $clientId,
          isset($flowName) ? $flowName : $this->flowName,
          $flowVersion,
          isset($locale) ? $locale : $this->locale,
          $redirectUri,
          $formName,
          $formFields
        );

        if ($idpResponse->stat == 'ok') {
            return [
                'has_errors' => false,
            ];
        }

        $invalid_fields = [];
        if (!empty($idpResponse->invalid_fields)) {
            $invalid_fields = (array) $idpResponse->invalid_fields;
        }
        if (!empty($idpResponse->message)) {
            if (empty($invalid_fields)) {
                $invalid_fields[$formName] = (array) $idpResponse->message;
            }
        }

        $idpResponse->invalid_fields = $invalid_fields;

        return $this->returnErrors($idpResponse);
    }

    /**
     * Send an email with a link to reset password.
     *
     * @param string $clientId The API client ID that will be used to authenticate the call.
     * @param string $flowVersion The version number of the flow set in the flow parameter.
     * @param string $redirectUri This parameter is required for legacy purposes.
     * @param string $formName The name of the form in your flow that you will use for social registration.
     * @param array  $formFields Array wuth fields filled by the user.
     * @param string $flowName OPTIONAL: In case you want to use another flow name.
     * @param string $locale OPTIONAL: In case you want to use another locale.
     *
     * @return array
     */
    public function forgotPasswordNative(
        string $clientId,
        string $flowVersion,
        string $redirectUri,
        string $formName,
        array $formFields,
        string $flowName = NULL,
        string $locale = NUll
    ) {
        $idpResponse = $this->authenticationInstance->forgotPasswordNative(
            $clientId,
            isset($flowName) ? $flowName : $this->flowName,
            $flowVersion,
            isset($locale) ? $locale : $this->locale,
            $redirectUri,
            $formName,
            $formFields
        );

        if ($idpResponse->stat == 'ok') {
            return [
                'has_errors' => false,
            ];
        }

        return $this->returnErrors($idpResponse);
    }

    /**
     * Get User Details.
     *
     * @param string $accessToken A Registration token, which will be returned after authentication or registration.
     * @param string $typeName The name of the entityType.
     * @param string $id The id.
     * @param string $method The method.
     * @param string $clientId The client id.
     * @param string $clientSecret The client secret.
     *
     * @return array
     */
    public function entity(string $accessToken, string $typeName, string $id = '', string $method = 'get', string $clientId = null, string $clientSecret = null)
    {
        $idpResponse = $this->entityInstance->entity($accessToken, $typeName, $id, $method, $clientId, $clientSecret);

        if ($idpResponse->stat == 'ok') {
            return [
                'has_errors'    => false,
                'result'        => (array) $idpResponse->result,
            ];
        }

        return $this->returnErrors($idpResponse);
    }

    /**
     * Invalidate the access token generated.
     *
     * @param string $uuid The unique identifier given to the user entity.
     * @param string $typeName The name of the entityType.
     *
     * @return array
     */
    public function entityDeleteAccess(string $uuid, string $typeName)
    {
        $idpResponse = $this->entityInstance->entityDeleteAccess($uuid, $typeName);

        if ($idpResponse->stat == 'ok') {
            return [
                'has_errors'    => false,
            ];
        }

        return $this->returnErrors($idpResponse);
    }

    /**
     * Find Users.
     *
     * @param string $filter The expression used to filter the results. The default is to match all records.
     * @param string $typeName The name of the entityType.
     * @param array  $attributes A JSON array of attributes to return in the result set. The default is all attributes.
     *
     * @return array
     */
    public function entityFind(string $filter, string $typeName, $attributes = null, $clientId = null, $clientSecret = null)
    {
        $idpResponse = $this->entityInstance->entityFind($filter, $typeName, $attributes, $clientId, $clientSecret);

        if ($idpResponse->stat == 'ok') {
            return [
                'has_errors'    => false,
                'result_count'  => $idpResponse->result_count,
                'results'       => (array) $idpResponse->results,
            ];
        }

        return $this->returnErrors($idpResponse);
    }

    /**
     * Update user information.
     *
     * @param string $uuid The unique identifier given the user entity.
     * @param string $attributes Attribute and values to be updated.
     * @param string $typeName The name of the entityType.
     *
     * @return array
     */
    public function entityUpdate(string $uuid = '', string $attributes = '', string $typeName = '', $email = FALSE, $value = FALSE, $clientId = FALSE, $clientSecret = FALSE)
    {
        $idpResponse = $this->entityInstance->entityUpdate($uuid, $attributes, $typeName, $email, $value, $clientId, $clientSecret);

        if ($idpResponse->stat == 'ok') {
            return [
                'has_errors'    => false,
            ];
        }

        return $this->returnErrors($idpResponse);
    }

    /**
     * Creates an entity.
     *
     * @param string $attributes Attribute and values to be created.
     * @param string $typeName The name of the entityType.
     * @param string $clientId The client id.
     * @param string $clientSecret The client secret.
     *
     * @return array
     */
    public function entityCreate(string $attributes = '', string $typeName = '', $clientId = FALSE, $clientSecret = FALSE)
    {
        $idpResponse = $this->entityInstance->entityCreate($attributes, $typeName, $clientId, $clientSecret);

        if ($idpResponse->stat == 'ok') {
            return [
                'has_errors' => false,
            ];
        }

        return $this->returnErrors($idpResponse);
    }

    /**
     * Get flow versions.
     *
     * @return array
     */
    public function flowVersions()
    {
        $idpResponse = $this->configurationInstance->flowVersions($this->flowName);

        if (!isset($idpResponse->errors)) {
            return [
                'has_errors'    => false,
                'versiond'      => (array) $idpResponse,
            ];
        }

        return $this->returnErrors($idpResponse);
    }

    /**
     * Load Form configurations.
     *
     * @param string $formName Form Name.
     *
     * @return array
     */
    public function loadFormConfiguration(string $formName)
    {
        $idpResponse = $this->formConfigurationInstance->loadFormConfiguration($formName);

        if (isset($idpResponse['has_errors'])) {
            return [
                'has_errors' => true,
            ];
        }

        return [
            'has_errors' => false,
            'results'    => $idpResponse,
        ];
    }

    /**
     * Load translation.
     *
     * @param string $translationName Translation name.
     *
     * @return array
     */
    public function loadTranslation(string $translationName)
    {
        $idpResponse = $this->translationsInstance->loadTranslation($translationName);

        if (isset($idpResponse['has_errors'])) {
            return [
                'has_errors' => true,
            ];
        }

        return [
            'has_errors' => false,
            'result'     => $idpResponse,
        ];
    }

    /**
     * Get Clients List.
     *
     * @return array
     */
    public function clientsList()
    {
        $idpResponse = $this->clientsSettingsInstance->clientsList();

        if ($idpResponse->stat == 'ok') {
            return [
                'has_errors'    => false,
                'results'       => (array) $idpResponse->results,
            ];
        }

        return $this->returnErrors($idpResponse);
    }

    /**
     * Get Client Settings.
     *
     * @param string $clientId
     * @param string $clientSecret
     *
     * @return array
     */
    public function settingsItems(string $clientId, string $clientSecret)
    {
        $idpResponse = $this->clientsSettingsInstance->settingsItems($clientId, $clientSecret);

        if ($idpResponse->stat == 'ok') {
            return [
                'has_errors'    => false,
                'result'        => (array) $idpResponse->result,
            ];
        }

        return $this->returnErrors($idpResponse);
    }

    /**
     * Get Client Settings item.
     *
     * @param string $name
     * @param string $clientId
     * @param string $clientSecret
     *
     * @return string|null
     */
    public function getSettingsItem(string $name, string $clientId, string $clientSecret)
    {
        $settings = $this->settingsItems($clientId, $clientSecret);

        if ($settings['has_errors']) {
            return null;
        }

        return $settings['result'][$name] ?? null;
    }

    /**
     * Get Enabled Social Providers.
     *
     * @return array
     */
    public function availableProviders()
    {
        $rpxRealm = $this->getSettingsItem('rpx_realm', $this->loginClientId, $this->loginClientSecret);
        $rpxUrl = "https://{$rpxRealm}.rpxnow.com";

        $providers = $this->socialInstance->getAvailableProviders($rpxUrl);

        if ($providers->stat == 'ok') {
            // @codingStandardsIgnoreStart
            return [
                'has_errors' => false,
                'providers'  => $providers->signin,
            ];
            // @codingStandardsIgnoreEnd
        }
    }

    /**
     * Get Enabled Social Providers.
     *
     * @return array
     */
    public function providers()
    {
        $rpxRealm = $this->getSettingsItem('rpx_realm', $this->loginClientId, $this->loginClientSecret);
        $rpxUrl = "https://{$rpxRealm}.rpxnow.com";

        $providers = $this->socialInstance->providers($rpxUrl);

        if ($providers->stat == 'ok') {
            // @codingStandardsIgnoreStart
            return [
                'has_errors' => false,
                'providers'  => $providers->signin,
            ];
            // @codingStandardsIgnoreEnd
        }

        return [];
    }

    /**
     * Get Enabled Social Providers.
     *
     * @param string $socialMedia The social media id.
     * @param string $language The chosen language.
     * @param string $tokenUrl Return URL.
     *
     * @return string
     *   Social login URL.
     */
    public function socialLoginUrl(string $socialMedia, string $tokenUrl, string $language = '')
    {
        if (!$language) {
            $language = $this->locale;
        }

        $rpxRealm = $this->getSettingsItem('rpx_realm', $this->loginClientId, $this->loginClientSecret);
        $rpxUrl = "https://{$rpxRealm}.rpxnow.com";

        return $this->engageInstance->getSocialLoginUrl($rpxUrl, $socialMedia, $tokenUrl, $language);
    }

    /**
     * Get Client Settings item.
     *
     * @param string $flowVersion
     * @param string $locale
     *
     * @return object with flow information.
     */
    public function getFlow(string $flowVersion = 'HEAD', string $locale = '')
    {
        if ($locale === '') {
            $locale = $this->locale;
        }

        return $this->staticFlowInstance->getFlowByVersionAndLocale($flowVersion, $locale);
    }

  /**
   * Return errors.
   *
   * @param object $idpResponse
   *
   * @return array errors.
   */
    private function returnErrors($idpResponse)
    {
        return [
            'has_errors'        => true,
            'error_description' => isset($idpResponse->error_description) ? $idpResponse->error_description : '',
            'code'              => isset($idpResponse->code) ? $idpResponse->code : '',
            'error'             => isset($idpResponse->error) ? $idpResponse->error : '',
            'invalid_fields'    => isset($idpResponse->invalid_fields) ? (array) $idpResponse->invalid_fields : '',
        ];
    }
}
