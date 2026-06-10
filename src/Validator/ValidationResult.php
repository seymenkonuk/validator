<?php
// ============================================================================
// File:    ValidationResult.php
// Author:  Recep Seymen Konuk <konukrecepseymen@gmail.com>
//
// Licensed under the terms of the LICENSE file in the project root directory.
// ============================================================================

namespace Seymenkonuk\Validator\Validator;


class ValidationResult
{
    // --------------------------------------------------------------------------
    // CONSTRUCTOR
    // --------------------------------------------------------------------------

    /**
     * @param bool $isValid
     * @param array<string, mixed>|string $errorMessage
     * @param mixed $validatedData
     */
    private function __construct(
        private bool $isValid,
        private array|string $errorMessage,
        private mixed $validatedData,
    ) {}

    // --------------------------------------------------------------------------
    // FACTORY METHODS
    // --------------------------------------------------------------------------

    public static function success(mixed $data): self
    {
        return new ValidationResult(true, "", $data);
    }

    /** @param array<string, mixed>|string $errorMessage*/
    public static function failure(array|string $errorMessage): self
    {
        return new ValidationResult(false, $errorMessage, null);
    }

    // --------------------------------------------------------------------------
    // GETTERS
    // --------------------------------------------------------------------------

    public function passed(): bool
    {
        return $this->isValid;
    }

    public function failed(): bool
    {
        return !$this->isValid;
    }

    /** @return array<string, mixed>|string*/
    public function errors(): array|string
    {
        return $this->errorMessage;
    }

    public function validated(): mixed
    {
        return $this->validatedData;
    }
}
