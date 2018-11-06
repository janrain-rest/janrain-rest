<?php

namespace Janrain\core;

class FormConfiguration
{

    private $staticFlowInstance;

    public function __construct(StaticFlow $staticFLowInstance)
    {
        $this->staticFlowInstance = $staticFLowInstance;
    }

    /**
     * Load Form Configuration from Json file.
     *
     * @param string $formName The name of the form.
     *
     * @return array
     */
    public function loadFormConfiguration(string $formName)
    {
        $flowContent = $this->staticFlowInstance->getFlowContent();

        if (empty($flowContent) || empty($flowContent->fields->{$formName})) {
            return [
                'has_errors' => true,
            ];
        }

        $fieldsName = $flowContent->fields->{$formName}->fields;

        $fields = array();

        foreach ($fieldsName as $key => $fieldName) {
            $fields[$key] = $flowContent->fields->{$fieldName};
            $fields[$key]->name = $fieldName;
            unset($fields[$key]->forms);
        }

        return $fields;
    }
}
