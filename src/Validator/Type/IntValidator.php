<?php
// ============================================================================
// File:    IntValidator.php
// Author:  Recep Seymen Konuk <konukrecepseymen@gmail.com>
//
// Licensed under the terms of the LICENSE file in the project root directory.
// ============================================================================

namespace Seymenkonuk\Validator\Validator\Type;


use Seymenkonuk\Validator\Validator\BaseValidator;
use Seymenkonuk\Validator\Validator\ValidationResult;


class IntValidator extends BaseValidator
{
    // --------------------------------------------------------------------------
    // PROPERTIES
    // --------------------------------------------------------------------------

    private int|null $defaultValue = null;
    private bool $isRequired = false;
    private bool $isNullable = false;

    private int $min = PHP_INT_MIN;
    private int $max = PHP_INT_MAX;

    // --------------------------------------------------------------------------
    // METHODS
    // --------------------------------------------------------------------------

    public function min(int $min): self
    {
        $this->min = $min;
        return $this;
    }

    public function max(int $max): self
    {
        $this->max = $max;
        return $this;
    }

    // --------------------------------------------------------------------------
    // SHORTCUTS
    // --------------------------------------------------------------------------

    public function positive(): self
    {
        return $this->min(1)->max(PHP_INT_MAX);
    }

    public function negative(): self
    {
        return $this->min(PHP_INT_MIN)->max(-1);
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

    public function default(int $defaultValue): self
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

        // Data Değişkeni Bir Int Olmak Zorunda
        if (!is_int($data)) {
            return $this->error("integer");
        }

        // Veri Tam Olarak Bu Sayı Olmalı
        if ($this->min === $this->max && $data !== $this->min) {
            return $this->error("equals", [
                "value" => $this->min,
            ]);
        }

        // Veri Çok Küçük
        if ($data < $this->min) {
            return $this->error("min", [
                "value" => $this->min,
            ]);
        }

        // Veri Çok Büyük
        if ($data > $this->max) {
            return $this->error("max", [
                "value" => $this->max,
            ]);
        }

        return $this->success($data);
    }
}
