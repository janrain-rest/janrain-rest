<?php

namespace Janrain\tests;

use Janrain\Janrain;
use Janrain\tests\BaseCoreTest;
use Janrain\tests\Logger;
use PHPUnit\Framework\TestCase;

/**
 * Class JanrainTest
 * @package Tests
 */
class JanrainTest extends TestCase
{
    private $janrain;
    private $baseTest;
    private static $captureUser;
    private static $authorizationCode;
    private static $accessToken;

    public function setUp()
    {
        $this->baseTest = new BaseCoreTest();

        $this->janrain = new Janrain(
            $this->baseTest->captureServerUrl,
            $this->baseTest->configurationServerUrl,
            $this->baseTest->cdnUrl,
            $this->baseTest->fullClientId,
            $this->baseTest->fullClientSecret,
            $this->baseTest->loginClientId,
            $this->baseTest->loginClientSecret,
            $this->baseTest->appId,
            $this->baseTest->locale,
            $this->baseTest->flowName,
            new Logger()
        );
    }

    /**
     * @covers Janrain\Janrain::registerNativeTraditional
     */
    public function testRegisterNativeTraditional()
    {
        $clientId    = $this->baseTest->loginClientId;
        $flowVersion = $this->baseTest->flowVersion;
        $redirectUri = $this->baseTest->redirectUri;
        $formName    = 'registrationForm';
        $formFields  = $this->baseTest->getRegisterMock();

        $json = $this->janrain->registerNativeTraditional(
            $clientId,
            $flowVersion,
            $redirectUri,
            $formName,
            $formFields
        );

        if ($json['has_errors']) {
            $this->markTestSkipped("Could not register the user, skipping tests.");
        }

        $this->assertNotTrue($json['has_errors']);

        self::$captureUser = $json['capture_user'];
    }

    /**
     * @covers Janrain\Janrain::VerifyEmailNative
     * @depends testRegisterNativeTraditional
     */
    public function testVerifyEmailNative()
    {
        $clientId    = $this->baseTest->loginClientId;
        $flowVersion = $this->baseTest->flowVersion;
        $redirectUri = $this->baseTest->redirectUri;
        $formName    = 'resendVerificationForm';
        $formFields  = $this->baseTest->getVerifyEmailMock();

        $json = $this->janrain->verifyEmailNative(
            $clientId,
            $flowVersion,
            $redirectUri,
            $formName,
            $formFields
        );

        $this->assertNotTrue($json['has_errors']);
    }

    /**
     * @covers Janrain\Janrain::getVerificationCode
     * @covers Janrain\Janrain::useVerificationCode
     * @depends testRegisterNativeTraditional
     */
    public function testVerificationCode()
    {
        $uuid          = self::$captureUser->uuid;
        $typeName      = $this->baseTest->typeName;
        $attributeName = 'emailVerified';

        $json = $this->janrain->getVerificationCode($uuid, $typeName, $attributeName);

        $this->assertNotTrue($json['has_errors']);

        $json = $this->janrain->useVerificationCode($json['verificationCode']);

        $this->assertNotTrue($json['has_errors']);
    }

    /**
     * @covers Janrain\Janrain::forgotPasswordNative
     * @depends testRegisterNativeTraditional
     */
    public function testForgotPasswordNative()
    {
        $clientId    = $this->baseTest->loginClientId;
        $flowVersion = $this->baseTest->flowVersion;
        $redirectUri = $this->baseTest->redirectUri;
        $formName    = 'forgotPasswordForm';
        $formFields  = $this->baseTest->getVerifyEmailMock();

        $json = $this->janrain->forgotPasswordNative(
            $clientId,
            $flowVersion,
            $redirectUri,
            $formName,
            $formFields
        );

        $this->assertNotTrue($json['has_errors']);
    }

    /**
     * @covers Janrain\Janrain::authNativeTraditional
     * @depends testRegisterNativeTraditional
     */
    public function testAuthNativeTraditional()
    {
        $clientId    = $this->baseTest->loginClientId;
        $flowVersion = $this->baseTest->flowVersion;
        $redirectUri = $this->baseTest->redirectUri;
        $formName    = 'signInForm';
        $formFields  = $this->baseTest->getLoginMock();

        $json = $this->janrain->authNativeTraditional(
            $clientId,
            $flowVersion,
            $redirectUri,
            $formName,
            $formFields
        );

        $this->assertNotTrue($json['has_errors']);

        self::$authorizationCode = $json['authorization_code'];
    }

    /**
     * @covers Janrain\Janrain::token
     * @depends testAuthNativeTraditional
     */
    public function testToken()
    {
        $grantType         = 'authorization_code';
        $authorizationCode = self::$authorizationCode;
        $redirectUri       = $this->baseTest->redirectUri;

        $json = $this->janrain->token($grantType, $authorizationCode, $redirectUri);

        $this->assertNotTrue($json['has_errors']);

        $grantType         = 'refresh_token';
        $refreshToken      = $json['refresh_token'];

        $json = $this->janrain->token($grantType, null, null, $refreshToken);

        $this->assertNotTrue($json['has_errors']);

        self::$accessToken = $json['access_token'];
    }

    /**
     * @covers Janrain\Janrain::updateProfileNative
     * @covers Janrain\Janrain::entity
     * @depends testToken
     */
    public function testUpdateProfile()
    {
        $clientId    = $this->baseTest->loginClientId;
        $flowVersion = $this->baseTest->flowVersion;
        $formName    = 'editProfileForm';
        $accessToken = self::$accessToken;
        $formFields  = $this->baseTest->getUpdateProfileMock();
        $typeName    = $this->baseTest->typeName;

        $json = $this->janrain->updateProfileNative(
            $clientId,
            $flowVersion,
            $formName,
            $accessToken,
            $formFields
        );

        $this->assertNotTrue($json['has_errors']);

        $json = $this->janrain->entity($accessToken, $typeName);

        $this->assertNotTrue($json['has_errors']);
        $this->assertEquals('John Due', $json['result']['displayName']);
        $this->assertEquals('John', $json['result']['givenName']);
        $this->assertEquals('Due', $json['result']['familyName']);
    }

    /**
     * @covers Janrain\Janrain::accessToken
     * @depends testRegisterNativeTraditional
     */
    public function testAccessToken()
    {
        $uuid          = self::$captureUser->uuid;
        $typeName      = $this->baseTest->typeName;
        $loginClientId = $this->baseTest->loginClientId;

        $json = $this->janrain->getAccessToken($uuid, $typeName, $loginClientId);

        $this->assertNotTrue($json['has_errors']);
    }

    /**
     * @covers Janrain\Janrain::entityFind
     * @depends testRegisterNativeTraditional
     */
    public function testEntityFind()
    {
        $filter   = "uuid = '" . self::$captureUser->uuid . "'";
        $typeName = $this->baseTest->typeName;

        $json = $this->janrain->entityFind($filter, $typeName);

        $this->assertNotTrue($json['has_errors']);
    }

    /**
     * @covers Janrain\Janrain::entityUpdate
     * @depends testRegisterNativeTraditional
     */
    public function testEntityUpdate()
    {
        $uuid       = self::$captureUser->uuid;
        $attributes = json_encode($this->baseTest->getEntityUpdateMock());
        $typeName   = $this->baseTest->typeName;

        $json = $this->janrain->entityUpdate($uuid, $attributes, $typeName);

        $this->assertNotTrue($json['has_errors']);
    }

    /**
     * @covers Janrain\Janrain::entityDeleteAccess
     * @depends testRegisterNativeTraditional
     */
    public function testEntityDeleteAccess()
    {
        $uuid        = self::$captureUser->uuid;
        $typeName    = $this->baseTest->typeName;
        $accessToken = self::$accessToken;

        $json = $this->janrain->entityDeleteAccess($uuid, $typeName);

        $this->assertNotTrue($json['has_errors']);

        $json = $this->janrain->entity($accessToken, $typeName);

        $this->assertTrue($json['has_errors']);
    }

    /**
     * @covers Janrain\Janrain::entityDelete
     * @depends testRegisterNativeTraditional
     */
    public function testEntityDelete()
    {
        $uuid     = self::$captureUser->uuid;
        $typeName = $this->baseTest->typeName;

        $json = $this->janrain->entityDelete($uuid, $typeName);

        $this->assertNotTrue($json['has_errors']);
    }

    /**
     * @covers Janrain\Janrain::flowVersions
     */
    public function testFlowVersions()
    {
        $json = $this->janrain->flowVersions();

        $this->assertNotTrue($json['has_errors']);
    }

    /**
     * @covers Janrain\Janrain::loadFormConfiguration
     */
    public function testLoadFormConfiguration()
    {
        $json = $this->janrain->loadFormConfiguration('signInForm');

        $this->assertNotTrue($json['has_errors']);
    }

    /**
     * @covers Janrain\Janrain::loadTranslation
     */
    public function testLoadTranslation()
    {
        $json = $this->janrain->loadTranslation('poweredByJanrain');

        $this->assertNotTrue($json['has_errors']);
    }

    /**
     * @covers Janrain\Janrain::clientsList
     */
    public function testClientsList()
    {
        $json = $this->janrain->clientsList();

        $this->assertNotTrue($json['has_errors']);
    }

    /**
     * @covers Janrain\Janrain::settingsItems
     */
    public function testSettingsItems()
    {
        $clientId     = $this->baseTest->fullClientId;
        $clientSecret = $this->baseTest->fullClientSecret;

        $json = $this->janrain->settingsItems($clientId, $clientSecret);

        $this->assertNotTrue($json['has_errors']);
        $this->assertEquals('https://rpxnow.com', $json['result']['rpx_server']);
        $this->assertEquals('ses_sync', $json['result']['email_method']);
    }

    /**
     * @covers Janrain\Janrain::availableProviders
     */
    public function testAvailableProviders()
    {
        $providers = $this->janrain->availableProviders();

        $this->assertNotTrue($providers['has_errors']);
    }

    /**
     * @covers Janrain\Janrain::providers
     */
    public function testProviders()
    {
        $providers = $this->janrain->providers();

        $this->assertNotTrue($providers['has_errors']);
    }

    /**
     * @covers Janrain\Janrain::socialLoginUrl
     */
    public function testSocialLoginUrl()
    {
        $link = $this->janrain->socialLoginUrl(
            'facebook',
            $this->baseTest->redirectUri,
            $this->baseTest->locale
        );

        $this->assertEquals('https://fabiopulzi.rpxnow.com/facebook/start?language_preference=en-US&token_url=http%3A%2F%2Flocalhost&display=popup&applicationId=y6wckbnuxus97b3wknj4sy9kj3', $link);
    }

    /**
     * @covers Janrain\Janrain::getFlow
     */
    public function testgetFlow()
    {
        $flowVersion = $this->baseTest->flowVersion;
        $locale = $this->baseTest->locale;

        $flow = $this->janrain->getFlow($flowVersion, $locale);

        $this->assertNotNull($flow);
    }
}
