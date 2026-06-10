<?php
// ============================================================================
// File:    EnumValidator.php
// Author:  Recep Seymen Konuk <konukrecepseymen@gmail.com>
//
// Licensed under the terms of the LICENSE file in the project root directory.
// ============================================================================

namespace Seymenkonuk\Validator\Validator\Type;


use Seymenkonuk\Validator\Exception\MissingRuleException;

use Seymenkonuk\Validator\Validator\BaseValidator;
use Seymenkonuk\Validator\Validator\ValidationResult;


class EnumValidator extends BaseValidator
{
    // --------------------------------------------------------------------------
    // PROPERTIES
    // --------------------------------------------------------------------------

    private mixed $defaultValue = null;
    private bool $isRequired = false;
    private bool $isNullable = false;

    /** @var array<mixed>|null $allowed */
    private ?array $allowed = null;

    // --------------------------------------------------------------------------
    // METHODS
    // --------------------------------------------------------------------------

    /** @param array<mixed> $allowed */
    public function in(array $allowed): self
    {
        $this->allowed = $allowed;
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

    public function default(mixed $defaultValue): self
    {
        $this->defaultValue = $defaultValue;
        return $this;
    }

    // --------------------------------------------------------------------------
    // VALIDATE
    // --------------------------------------------------------------------------

    public function validate(mixed $data, bool $exists = true): ValidationResult
    {
        // Rule Olmak Zorunda
        if ($this->allowed === null) {
            throw new MissingRuleException();
        }

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

        // İzin Verilen Değerlerden Birisi Olmalı
        if (!in_array($data, $this->allowed, true)) {
            return $this->error("enum", [
                "values" => json_encode($this->allowed, JSON_UNESCAPED_UNICODE),
            ]);
        }

        return $this->success($data);
    }
}
