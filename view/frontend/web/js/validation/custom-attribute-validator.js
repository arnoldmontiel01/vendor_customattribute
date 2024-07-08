define([
    'jquery',
    'mage/translate',
    'jquery/validate'
], function ($, $t) {
    'use strict';

    // Add custom validation rule
    $.validator.addMethod(
        'validate-custom-attribute',
        function (value) {
            return value && value.length >= 3;
        },
        $t('Please enter at least 3 characters.')
    );

    return function (config, element) {
        $(document).ready(function () {
            let $element = $(element);

            // Ensure the element is validatable
            if ($element.length) {
                $element.rules('add', {
                    required: true,
                    'validate-custom-attribute': true,
                    messages: {
                        required: $t('This is a required field.'),
                        'validate-custom-attribute': $t('Please enter at least 3 characters.')
                    }
                });

                // Ensure validation is triggered on blur
                $element.on('blur', function () {
                    $element.valid();
                });

                // Ensure validation is triggered on form submit
                $element.closest('form').on('submit', function (e) {
                    if (!$element.valid()) {
                        e.preventDefault();
                    }
                });
            }
        });
    };
});
