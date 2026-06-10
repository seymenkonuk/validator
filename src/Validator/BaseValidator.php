<?php
// ============================================================================
// File:    BaseValidator.php
// Author:  Recep Seymen Konuk <konukrecepseymen@gmail.com>
//
// Licensed under the terms of the LICENSE file in the project root directory.
// ============================================================================

namespace Seymenkonuk\Validator\Validator;


use Seymenkonuk\Validator\Localization\Translator;


abstract class BaseValidator
{
    // --------------------------------------------------------------------------
    // DEPENDENCIES
    // --------------------------------------------------------------------------

    public function __construct(
        protected Translator $translator,
    ) {}

    // --------------------------------------------------------------------------
    // RESULT METHODS
    // --------------------------------------------------------------------------

    /** @param array<string, scalar> $params */
    protected function error(string $key, array $params = []): ValidationResult
    {
        return ValidationResult::failure(
            $this->translator->get($key, $params),
        );
    }

    /** @param array<string, mixed>|string $errorMessage */
    protected function failure(array|string $errorMessage): ValidationResult
    {
        return ValidationResult::failure($errorMessage);
    }

    protected function success(mixed $value): ValidationResult
    {
        return ValidationResult::success($value);
    }

    // --------------------------------------------------------------------------
    // VALIDATE
    // --------------------------------------------------------------------------

    abstract public function validate(mixed $data, bool $exists = true): ValidationResult;
}
