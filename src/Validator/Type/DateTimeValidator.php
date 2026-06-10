<?php
// ============================================================================
// File:    DateTimeValidator.php
// Author:  Recep Seymen Konuk <konukrecepseymen@gmail.com>
//
// Licensed under the terms of the LICENSE file in the project root directory.
// ============================================================================

namespace Seymenkonuk\Validator\Validator\Type;


use DateTime;
use InvalidArgumentException;

use Seymenkonuk\Validator\Validator\BaseValidator;
use Seymenkonuk\Validator\Validator\ValidationResult;


class DateTimeValidator extends BaseValidator
{
    // --------------------------------------------------------------------------
    // PROPERTIES
    // --------------------------------------------------------------------------

    private ?DateTime $defaultValue = null;
    private bool $isRequired = false;
    private bool $isNullable = false;

    private string $min = "0001-01-01 00:00:00";
    private string $max = "9999-12-31 23:59:59";

    // --------------------------------------------------------------------------
    // METHODS
    // --------------------------------------------------------------------------

    public function min(string $datetime): self
    {
        if (!$this->isValidDateTime($datetime)) {
            throw new InvalidArgumentException("Argüman DateTime formatında string olmalıdır!");
        }
        $this->min = $datetime;
        return $this;
    }

    public function max(string $datetime): self
    {
        if (!$this->isValidDateTime($datetime)) {
            throw new InvalidArgumentException("Argüman DateTime formatında string olmalıdır!");
        }
        $this->max = $datetime;
        return $this;
    }

    // --------------------------------------------------------------------------
    // SHORTCUTS METHODS
    // --------------------------------------------------------------------------

    public function afterOrEqual(string $datetime): self
    {
        return $this->min($datetime);
    }

    public function beforeOrEqual(string $datetime): self
    {
        return $this->max($datetime);
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

    public function default(DateTime $defaultValue): self
    {
        $this->defaultValue = $defaultValue;
        return $this;
    }

    // --------------------------------------------------------------------------
    // INTERNAL HELPERS
    // --------------------------------------------------------------------------

    private function isValidDateTime(string $dateTimeString): bool
    {
        $date = DateTime::createFromFormat('Y-m-d H:i:s', $dateTimeString);
        $errors = DateTime::getLastErrors();
        return $date && (!$errors || ($errors['warning_count'] === 0 && $errors['error_count'] === 0));
    }

    private function isSameDate(string $date1String, string $date2String): bool
    {
        $date1 = DateTime::createFromFormat('Y-m-d H:i:s', $date1String);
        $date2 = DateTime::createFromFormat('Y-m-d H:i:s', $date2String);
        return $date1 == $date2;
    }

    private function isAfterDate(string $date1String, string $date2String): bool
    {
        $date1 = DateTime::createFromFormat('Y-m-d H:i:s', $date1String);
        $date2 = DateTime::createFromFormat('Y-m-d H:i:s', $date2String);
        return $date1 >= $date2;
    }

    private function isBeforeDate(string $date1String, string $date2String): bool
    {
        $date1 = DateTime::createFromFormat('Y-m-d H:i:s', $date1String);
        $date2 = DateTime::createFromFormat('Y-m-d H:i:s', $date2String);
        return $date1 <= $date2;
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

        // Data Değişkeni Bir Date Olmak Zorunda
        if (!is_string($data) || !$this->isValidDateTime($data)) {
            return $this->error("datetime");
        }

        // Tarih Şu Tarih Olmak Zorunda
        if ($this->isSameDate($this->min, $this->max) && !$this->isSameDate($data, $this->min)) {
            return $this->error("date_equals", [
                "datetime" => $this->min,
            ]);
        }

        // Tarih Şu Tarihten Sonra Olmalı
        if (!$this->isAfterDate($data, $this->min)) {
            return $this->error("date_after", [
                "datetime" => $this->min,
            ]);
        }

        // Tarih Şu Tarihten Önce Olmalı
        if (!$this->isBeforeDate($data, $this->max)) {
            return $this->error("date_before", [
                "datetime" => $this->max,
            ]);
        }

        return $this->success($data);
    }
}
