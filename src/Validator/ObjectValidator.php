<?php
// ============================================================================
// File:    ObjectValidator.php
// Author:  Recep Seymen Konuk <konukrecepseymen@gmail.com>
//
// Licensed under the terms of the LICENSE file in the project root directory.
// ============================================================================

namespace Seymenkonuk\Validator\Validator;


class ObjectValidator extends BaseValidator
{
    // --------------------------------------------------------------------------
    // PROPERTIES
    // --------------------------------------------------------------------------

    /** @var array<mixed, mixed> $defaultValue */
    private ?array $defaultValue = null;
    private bool $isRequired = false;
    private bool $isNullable = false;

    /** @var array<string, BaseValidator> */
    private array $rules = [];

    // --------------------------------------------------------------------------
    // METHODS
    // --------------------------------------------------------------------------

    /** @param array<string, BaseValidator> $array*/
    public function schema(array $array): self
    {
        $this->rules = $array;
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

    /** @param array<mixed, mixed> $defaultValue */
    public function default(array $defaultValue): self
    {
        $this->defaultValue = $defaultValue;
        return $this;
    }

    // --------------------------------------------------------------------------
    // INTERNAL HELPERS
    // --------------------------------------------------------------------------

    /** @param array<mixed, mixed> $array */
    private function isAssociativeArray(array $array): bool
    {
        return !empty($array) && array_keys($array) !== range(0, count($array) - 1);
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

        // Data Yanlış Formatta Geldi
        if (!is_array($data) || !$this->isAssociativeArray($data)) {
            $data = [];
        }

        // Hataları ve Validated Data'yı Oluştur
        $isValid = true;
        $errorMessages = [];
        $validated = [];

        // Kuralları Kontrol Et
        foreach ($this->rules as $key => $rule) {
            $result = $rule->validate($data[$key] ?? "", array_key_exists($key, $data));

            if ($result->failed()) {
                $errorMessages[$key] = $result->errors();
                $isValid = false;
            } else {
                $validated[$key] = $result->validated();
            }
        }

        // Geçersiz Alanları Kontrol Et
        /** @var array<string, mixed> $data */
        foreach ($data as $key => $value) {
            if (!array_key_exists($key, $this->rules)) {
                $errorMessages[$key] = $this->translator->get("invalid");
                $isValid = false;
            }
        }

        // En Az Bir Hatalı Alan
        if (!$isValid) {
            return $this->failure($errorMessages);
        }

        return $this->success($validated);
    }
}
