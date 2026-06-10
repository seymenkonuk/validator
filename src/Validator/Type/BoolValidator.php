<?php
// ============================================================================
// File:    BoolValidator.php
// Author:  Recep Seymen Konuk <konukrecepseymen@gmail.com>
//
// Licensed under the terms of the LICENSE file in the project root directory.
// ============================================================================

namespace Seymenkonuk\Validator\Validator\Type;


use Seymenkonuk\Validator\Validator\BaseValidator;
use Seymenkonuk\Validator\Validator\ValidationResult;


class BoolValidator extends BaseValidator
{
    // --------------------------------------------------------------------------
    // PROPERTIES
    // --------------------------------------------------------------------------

    private ?bool $defaultValue = null;
    private bool $isRequired = false;
    private bool $isNullable = false;

    private ?bool $expected = null;

    // --------------------------------------------------------------------------
    // METHODS
    // --------------------------------------------------------------------------

    public function true(): self
    {
        $this->expected = true;
        return $this;
    }

    public function false(): self
    {
        $this->expected = false;
        return $this;
    }

    // --------------------------------------------------------------------------
    // REQUIRE
    // --------------------------------------------------------------------------

    public function required(): self
    {
        $this->isRequired = true;
        return $this;
    }

    public function nullable(): self
    {
        $this->isNullable = true;
        return $this;
    }

    public function default(bool $defaultValue): self
    {
        $this->defaultValue = $defaultValue;
        return $this;
    }

    // --------------------------------------------------------------------------
    // VALIDATE
    // --------------------------------------------------------------------------

    public function validate(mixed $data, bool $exists = true): ValidationResult
    {
        // Bu Alan Zorunlu
        if ($this->isRequired && !$exists) {
            return $this->error("required");
        }

        // Opsiyonel Alan Boşsa Varsayılan Değeri Alır
        if (!$this->isRequired && !$exists) {
            return $this->success($this->defaultValue);
        }

        // Bu Alan Null Olamaz
        if (!$this->isNullable && $data === null) {
            return $this->error("not_nullable");
        }

        // Bu Alan Null Olabilir
        if ($this->isNullable && $data === null) {
            return $this->success(null);
        }

        // Bu Alan Boolean Olmalı
        if (!is_bool($data)) {
            return $this->error("boolean");
        }

        // Bu Alan Expected Value Olmalı
        if ($this->expected !== null && $data !== $this->expected) {
            return $this->error("accepted", [
                "value" => $this->expected,
            ]);
        }

        return $this->success($data);
    }
}
