<?php
// ============================================================================
// File:    DoubleValidator.php
// Author:  Recep Seymen Konuk <konukrecepseymen@gmail.com>
//
// Licensed under the terms of the LICENSE file in the project root directory.
// ============================================================================

namespace Seymenkonuk\Validator\Validator\Type;


use Seymenkonuk\Validator\Validator\BaseValidator;
use Seymenkonuk\Validator\Validator\ValidationResult;


class DoubleValidator extends BaseValidator
{
    // --------------------------------------------------------------------------
    // PROPERTIES
    // --------------------------------------------------------------------------

    private float|null $defaultValue = null;
    private bool $isRequired = false;
    private bool $isNullable = false;

    private float $min = PHP_FLOAT_MIN;
    private float $max = PHP_FLOAT_MAX;

    // --------------------------------------------------------------------------
    // METHODS
    // --------------------------------------------------------------------------

    public function min(float $min): self
    {
        $this->min = $min;
        return $this;
    }

    public function max(float $max): self
    {
        $this->max = $max;
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

    public function default(float $defaultValue): self
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

        // Data Değişkeni Bir Float Olmak Zorunda
        if (!is_float($data)) {
            return $this->error("float");
        }

        // Veri Tam Olarak Bu Değer Olmalı
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
