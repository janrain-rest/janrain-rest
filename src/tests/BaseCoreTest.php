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
        $captureServerUrl       = 'https://fabiopulzi.us-eval.janraincapture.com';
        $configurationServerUrl = 'https://v1.api.us.janrain.com';
        $fullClientId           = '93xek4d93y4qs9hjkv9r7xu9u8n3kasj';
        $fullClientSecret       = 'scnjxpwjzv5zchem8puxh5z4g932mdju';
        $loginClientId          = 'szms9ruu37prezmfzrvu5qzs2spwrqz5';
        $loginClientSecret      = '2pn6v7n4jxywkvaprprrmju73k45y5xe';
        $flowName               = 'standard';
        $flowVersion            = '20180206131504078655';
        $locale                 = 'en-US';
        $typeName               = 'user';
        $appId                  = 'y6wckbnuxus97b3wknj4sy9kj3';
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
            "emailAddress" => "gmachado@ciandt.com",
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
            "signInEmailAddress" => "gmachado@ciandt.com",
            "currentPassword" => "Test.123",
        ];
    }

    /**
     * @doesNotPerformAssertions
     */
    public function getVerifyEmailMock() {
        return [
            "signInEmailAddress" => "gmachado@ciandt.com",
        ];
    }

    /**
     * @doesNotPerformAssertions
     */
    public function getUpdateProfileMock() {
        return [
            "emailAddress" => "gmachado@ciandt.com",
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
