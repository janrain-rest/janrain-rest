<?php

namespace Janrain\tests;

use PHPUnit\Framework\TestCase;

class BaseCoreTest extends TestCase
{
    public $captureServerUrl;
    public $configurationServerUrl;
    public $fullClientId;
    public $fullClientSecret;
    public $loginClientId;
    public $loginClientSecret;
    public $flowName;
    public $flowVersion;
    public $locale;
    public $appId;
    public $cdnUrl;
    public $typeName;
    public $redirectUri;

    /**
     * BaseCore constructor.
     */
    public function __construct() {
        $captureServerUrl       = '';
        $configurationServerUrl = 'https://v1.api.us.janrain.com';
        $fullClientId           = '';
        $fullClientSecret       = '';
        $loginClientId          = '';
        $loginClientSecret      = '';
        $flowName               = 'standard';
        $flowVersion            = '';
        $locale                 = 'en-US';
        $typeName               = 'user';
        $appId                  = '';
        $redirectUri            = 'http://localhost';
        $cdnUrl                 = 'https://ssl-static.janraincapture.com/widget_data/flow.js';

        $this->captureServerUrl         = $captureServerUrl;
        $this->configurationServerUrl   = $configurationServerUrl;
        $this->fullClientId             = $fullClientId;
        $this->fullClientSecret         = $fullClientSecret;
        $this->loginClientId            = $loginClientId;
        $this->loginClientSecret        = $loginClientSecret;
        $this->flowName                 = $flowName;
        $this->flowVersion              = $flowVersion;
        $this->locale                   = $locale;
        $this->typeName                 = $typeName;
        $this->appId                    = $appId;
        $this->redirectUri              = $redirectUri;
        $this->cdnUrl                   = $cdnUrl;
    }

    /**
     * @doesNotPerformAssertions
     */
    public function getRegisterMock() {
        return [
            "emailAddress" => "gmachado@example.com",
            "displayName" => "Gabriel",
            "firstName" => "Gabriel",
            "lastName" => "Machado Santos",
            "newPassword" => "Test.123",
            "newPasswordConfirm" => "Test.123",
        ];
    }

    /**
     * @doesNotPerformAssertions
     */
    public function getLoginMock() {
        return [
            "signInEmailAddress" => "gmachado@example.com",
            "currentPassword" => "Test.123",
        ];
    }

    /**
     * @doesNotPerformAssertions
     */
    public function getVerifyEmailMock() {
        return [
            "signInEmailAddress" => "gmachado@example.com",
        ];
    }

    /**
     * @doesNotPerformAssertions
     */
    public function getUpdateProfileMock() {
        return [
            "emailAddress" => "gmachado@example.com",
            "displayName" => "John Due",
            "firstName" => "John",
            "lastName" => "Due",
        ];
    }

    /**
     * @doesNotPerformAssertions
     */
    public function getEntityUpdateMock() {
        return [
            "displayName" => "John Travolta",
            "givenName" => "John",
            "familyName" => "Travolta",
        ];
    }
}
