<?php
// ============================================================================
// File:    StringValidator.php
// Author:  Recep Seymen Konuk <konukrecepseymen@gmail.com>
//
// Licensed under the terms of the LICENSE file in the project root directory.
// ============================================================================

namespace Seymenkonuk\Validator\Validator\Type;


use Seymenkonuk\Validator\Validator\BaseValidator;
use Seymenkonuk\Validator\Validator\ValidationResult;


class StringValidator extends BaseValidator
{
    // --------------------------------------------------------------------------
    // PROPERTIES
    // --------------------------------------------------------------------------

    private string|null $defaultValue = null;
    private bool $isRequired = false;
    private bool $isNullable = false;

    private int $min = 0;
    private int $max = 255;

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

    public function min(int $minLength): self
    {
        $this->min = $minLength;
        return $this;
    }

    public function max(int $maxLength): self
    {
        $this->max = $maxLength;
        return $this;
    }

    public function regex(string $pattern, string $errorMessage): self
    {
        $this->regexRules[] = ["pattern" => $pattern, "message" => $errorMessage];
        return $this;
    }

    // --------------------------------------------------------------------------
    // REGEX SHORTCUTS METHODS
    // --------------------------------------------------------------------------

    public function email(): self
    {
        return $this->regex(
            "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/",
            $this->translator->get("email"),
        );
    }

    public function url(): self
    {
        return $this->regex(
            // http:// ya da https:// ile başla
            // istediğin kadar alt domain içersin: domain1.domain2.domain3.
            // en az iki karakterli TLD: com / tr vb.
            // isteğe bağlı port numarası: :80 gibi
            // issteğe bağlı path bilgisi: /path?query=value#section
            "/^https?:\/\/(?:[a-zA-Z0-9-]+\.)+[a-zA-Z]{2,}(?::\d+)?(?:\/[^\s]*)?$/",
            $this->translator->get("url"),
        );
    }

    public function uuid(): self
    {
        return $this->regex(
            "/^[0-9a-fA-F]{8}-[0-9a-fA-F]{4}-[1-5][0-9a-fA-F]{3}-[89abAB][0-9a-fA-F]{3}-[0-9a-fA-F]{12}$/",
            $this->translator->get("uuid"),
        );
    }

    public function slug(): self
    {
        return $this->regex(
            "/^[a-z0-9]+(?:-[a-z0-9]+)*$/",
            $this->translator->get("slug"),
        );
    }

    public function alpha(): self
    {
        return $this->regex(
            "/^\p{L}+$/u",
            $this->translator->get("alpha"),
        );
    }

    public function alphaNum(): self
    {
        return $this->regex(
            "/^[\p{L}\p{N}]+$/u",
            $this->translator->get("alphanumeric"),
        );
    }

    public function numeric(): self
    {
        return $this->regex(
            "/^\d+$/",
            $this->translator->get("numeric"),
        );
    }

    public function secure(): self
    {
        return $this->regex(
            "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).+$/",
            $this->translator->get("secure_password"),
        );
    }

    public function password(bool $strict = false): self
    {
        $this->min(8);

        if ($strict) {
            $this->secure();
        }

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

    public function default(string $defaultValue): self
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

        // Data Değişkeni Bir String Olmak Zorunda
        if (!is_string($data)) {
            return $this->error("string");
        }

        // Veri Şu Kadar Eleman İçermeli
        if ($this->min === $this->max && mb_strlen($data) !== $this->min) {
            return $this->error("length", [
                "length" => $this->min,
            ]);
        }

        // Veri Çok Küçük
        if (mb_strlen($data) < $this->min) {
            return $this->error("min_length", [
                "length" => $this->min,
            ]);
        }

        // Veri Çok Büyük
        if (mb_strlen($data) > $this->max) {
            return $this->error("max_length", [
                "length" => $this->max,
            ]);
        }

        // Regex Rule Kontrolü
        foreach ($this->regexRules as $regexRule) {
            if (preg_match($regexRule["pattern"], $data) !== 1) {
                return $this->failure($regexRule["message"]);
            }
        }

        return $this->success($data);
    }
}
