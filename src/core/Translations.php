<?php

namespace Janrain\core;

class Translations
{
    private $staticFlowInstance;

    public function __construct(StaticFlow $staticFLowInstance)
    {
        $this->staticFlowInstance = $staticFLowInstance;
    }

    /**
     * Load Translations from Json file.
     *
     * @param string $translationName The name of the form.
     *
     * @return array
     */
    public function loadTranslation(string $translationName)
    {
        $flowContent = $this->staticFlowInstance->getFlowContent();

        if ((empty($flowContent) || empty($flowContent->fields->{$translationName}))
            && $flowContent->fields->{$translationName}->type != 'string') {
            return [
                'has_errors' => true,
            ];
        }

        return $flowContent->fields->{$translationName}->value;
    }
}
