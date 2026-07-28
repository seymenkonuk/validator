<?php
// ============================================================================
// File:    FileValidator.php
// Author:  Recep Seymen Konuk <konukrecepseymen@gmail.com>
//
// Licensed under the terms of the LICENSE file in the project root directory.
// ============================================================================

namespace Seymenkonuk\Validator\Validator\Type;


use Seymenkonuk\Validator\Validator\BaseValidator;
use Seymenkonuk\Validator\Validator\ValidationResult;


class FileValidator extends BaseValidator
{
    // --------------------------------------------------------------------------
    // PROPERTIES
    // --------------------------------------------------------------------------

    private bool $isRequired = false;
    private bool $isNullable = false;

    /** @var array<mixed>|null $allowedMimes */
    private ?array $allowedMimes = null;
    /** @var array<mixed>|null $allowedExtensions */
    private ?array $allowedExtensions = null;

    private int $min = PHP_INT_MIN;
    private int $max = PHP_INT_MAX;

    /** 
     * @var array<int, array{
     *      pattern: string,
     *      message: string,
     * }>
     * */
    private array $regexRules = [];

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

    /** @param array<mixed> $allowedExtensions */
    public function extensions(array $allowedExtensions): self
    {
        $this->allowedExtensions = $allowedExtensions;
        return $this;
    }

    /** @param array<mixed> $allowedMimes */
    public function mimes(array $allowedMimes): self
    {
        $this->allowedMimes = $allowedMimes;
        return $this;
    }

    public function regex(string $pattern, string $errorMessage): self
    {
        $this->regexRules[] = ["pattern" => $pattern, "message" => $errorMessage];
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
            return $this->success(null);
        }

        // Bu Alan Null Olamaz
        if (!$this->isNullable && $data === null) {
            return $this->error("not_nullable");
        }

        // Bu Alan Null Olabilir
        if ($this->isNullable && $data === null) {
            return $this->success(null);
        }

        // Dosya Türünde Olmalı
        if (!($data instanceof File)) {
            return $this->error("file");
        }

        // Dosya Geçerli Olmalı!
        if (!$data->isValid()) {
            return $this->error("file_error");
        }

        // Dosya Tam Olarak Bu Boyut Olmalı
        if ($this->min === $this->max && $data->getSize() !== $this->min) {
            return $this->error("file_size_equals", [
                "value" => $this->min,
            ]);
        }

        // Dosya Çok Küçük
        if ($data->getSize() < $this->min) {
            return $this->error("file_size_min", [
                "value" => $this->min,
            ]);
        }

        // Dosya Çok Büyük
        if ($data->getSize() > $this->max) {
            return $this->error("file_size_max", [
                "value" => $this->max,
            ]);
        }

        // Dosya Uzantısı
        if ($this->allowedExtensions !== null) {
            $extension = $data->getExtension();
            if (!in_array($extension, $this->allowedExtensions, true)) {
                return $this->error("file_extension", [
                    "values" => json_encode($this->allowedExtensions, JSON_UNESCAPED_UNICODE),
                ]);
            }
        }

        // MIME Türü
        if ($this->allowedMimes !== null) {
            $mime = $data->getMimeType();
            if (!in_array($mime, $this->allowedMimes, true)) {
                return $this->error("file_mime_type", [
                    "values" => json_encode($this->allowedMimes, JSON_UNESCAPED_UNICODE),
                ]);
            }
        }

        // Dosya İsmi için Regex Rule Kontrolü Yap
        foreach ($this->regexRules as $regexRule) {
            if (preg_match($regexRule["pattern"], $data->getName()) !== 1) {
                return $this->failure($regexRule["message"]);
            }
        }

        return $this->success($data);
    }
}
