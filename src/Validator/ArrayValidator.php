<?php
// ============================================================================
// File:    ArrayValidator.php
// Author:  Recep Seymen Konuk <konukrecepseymen@gmail.com>
//
// Licensed under the terms of the LICENSE file in the project root directory.
// ============================================================================

namespace Seymenkonuk\Validator\Validator;


use Seymenkonuk\Validator\Exception\MissingRuleException;


class ArrayValidator extends BaseValidator
{
    // --------------------------------------------------------------------------
    // PROPERTIES
    // --------------------------------------------------------------------------

    /** @var array<mixed> $defaultValue */
    private ?array $defaultValue = null;
    private bool $isRequired = false;
    private bool $isNullable = false;

    private int $min = 0;
    private int $max = -1;

    private bool $isDistinct = false;

    private ?BaseValidator $rule = null;

    // --------------------------------------------------------------------------
    // METHODS
    // --------------------------------------------------------------------------

    public function items(BaseValidator $validator): self
    {
        $this->rule = $validator;
        return $this;
    }

    public function minItems(int $min): self
    {
        $this->min = $min;
        return $this;
    }

    public function maxItems(int $max): self
    {
        $this->max = $max;
        return $this;
    }

    public function infinite(): self
    {
        return $this->maxItems(-1);
    }

    public function distinct(): self
    {
        $this->isDistinct = true;
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

    /** @param array<mixed> $defaultValue */
    public function default(array $defaultValue): self
    {
        $this->defaultValue = $defaultValue;
        return $this;
    }

    // --------------------------------------------------------------------------
    // INTERNAL HELPER
    // --------------------------------------------------------------------------

    /** @param array<mixed, mixed> $array */
    private function isAssociativeArray(array $array): bool
    {
        return !empty($array) && array_keys($array) !== range(0, count($array) - 1);
    }

    /** @param array<mixed> $array */
    private function isDistinctArray(array $array): bool
    {
        return count($array) === count(array_unique($array, SORT_REGULAR));
    }

    // --------------------------------------------------------------------------
    // VALIDATE
    // --------------------------------------------------------------------------

    public function validate(mixed $data, bool $exists = true): ValidationResult
    {
        // Rule Olmak Zorunda
        if ($this->rule === null) {
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

        // Data Değişkeni Bir Dizi Olmak Zorunda
        if (!is_array($data) || $this->isAssociativeArray($data)) {
            return $this->error("array");
        }

        // Veri Şu Kadar Eleman İçermeli
        if ($this->min === $this->max && count($data) != $this->min) {
            return $this->error("count", [
                "count" => $this->min,
            ]);
        }

        // Veri Yetersiz Uzunlukta
        if (count($data) < $this->min) {
            return $this->error("min_count", [
                "count" => $this->min,
            ]);
        }

        // Veri Çok Büyük Uzunlukta
        if ($this->max !== -1 && count($data) > $this->max) {
            return $this->error("max_count", [
                "count" => $this->max,
            ]);
        }

        // Veri Benzersiz Olmak Zorunda
        if ($this->isDistinct && !$this->isDistinctArray($data)) {
            return $this->error("distinct");
        }

        // Dizinin Her Elemanı Kurala Uymak Zorunda
        foreach ($data as $item) {
            $result = $this->rule->validate($item);
            if ($result->failed()) {
                /** @var string $error */
                $error = $result->errors();
                return $this->error("items", [
                    "message" => $error,
                ]);
            }
        }

        return $this->success($data);
    }
}
