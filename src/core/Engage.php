<?php

namespace Janrain\core;

class Engage
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
     * Returns the absolute social login url for a given social media.
     *
     * @param string $socialMedia The social media id.
     * @param string $tokenUrl Return URL.
     * @param string $language The chosen language.
     *
     * @param string $rpxUrl
     *
     * @return string
     *   Social login URL.
     */
    public function getSocialLoginUrl(string $rpxUrl, string $socialMedia, string $tokenUrl, string $language)
    {
        $urlParameters = http_build_query(
            [
                'language_preference' => $language,
                'token_url' => $tokenUrl,
                'display' => 'popup',
                'applicationId' => $this->baseCoreInstance->appId,
            ]
        );

        return "{$rpxUrl}/{$socialMedia}/start?{$urlParameters}";
    }
}
