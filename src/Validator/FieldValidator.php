<?php
// ============================================================================
// File:    FieldValidator.php
// Author:  Recep Seymen Konuk <konukrecepseymen@gmail.com>
//
// Licensed under the terms of the LICENSE file in the project root directory.
// ============================================================================

namespace Seymenkonuk\Validator\Validator;


use Seymenkonuk\Validator\Localization\Translator;

use Seymenkonuk\Validator\Validator\Type\BoolValidator;
use Seymenkonuk\Validator\Validator\Type\CustomValidator;
use Seymenkonuk\Validator\Validator\Type\DateTimeValidator;
use Seymenkonuk\Validator\Validator\Type\DoubleValidator;
use Seymenkonuk\Validator\Validator\Type\EnumValidator;
use Seymenkonuk\Validator\Validator\Type\IntValidator;
use Seymenkonuk\Validator\Validator\Type\StringValidator;


class FieldValidator
{
    // --------------------------------------------------------------------------
    // DEPENDENCIES
    // --------------------------------------------------------------------------

    public function __construct(
        private Translator $translator,
    ) {}

    // --------------------------------------------------------------------------
    // TYPE VALIDATORS
    // --------------------------------------------------------------------------

    public function int(bool $strict = true): IntValidator
    {
        $validator = new IntValidator($this->translator);

        if (!$strict) {
            return $validator;
        }

        return $validator->strict();
    }

    public function double(bool $strict = true): DoubleValidator
    {
        $validator = new DoubleValidator($this->translator);

        if (!$strict) {
            return $validator;
        }

        return $validator->strict();
    }

    public function bool(bool $strict = true): BoolValidator
    {
        $validator = new BoolValidator($this->translator);

        if (!$strict) {
            return $validator;
        }

        return $validator->strict();
    }

    public function datetime(): DateTimeValidator
    {
        return new DateTimeValidator($this->translator);
    }

    public function string(): StringValidator
    {
        return new StringValidator($this->translator);
    }

    public function enum(): EnumValidator
    {
        return new EnumValidator($this->translator);
    }

    private function _custom(): CustomValidator
    {
        return new CustomValidator($this->translator);
    }

    // --------------------------------------------------------------------------
    // CUSTOM SHORTCUTS
    // --------------------------------------------------------------------------

    /** @param callable(mixed): ValidationResult $callback */
    public function custom(callable $callback): CustomValidator
    {
        return $this->_custom()->rule($callback);
    }

    // --------------------------------------------------------------------------
    // ENUM SHORTCUTS
    // --------------------------------------------------------------------------

    /** @param array<mixed> $array */
    public function in(array $array): EnumValidator
    {
        return $this->enum()->in($array);
    }

    // --------------------------------------------------------------------------
    // STRING SHORTCUTS
    // --------------------------------------------------------------------------

    public function email(): StringValidator
    {
        return $this->string()->email();
    }

    public function url(): StringValidator
    {
        return $this->string()->url();
    }

    public function uuid(): StringValidator
    {
        return $this->string()->uuid();
    }

    public function slug(): StringValidator
    {
        return $this->string()->slug();
    }

    public function alpha(): StringValidator
    {
        return $this->string()->alpha();
    }

    public function alphaNum(): StringValidator
    {
        return $this->string()->alphaNum();
    }

    public function numeric(): StringValidator
    {
        return $this->string()->numeric();
    }

    public function password(bool $strict = false): StringValidator
    {
        return $this->string()->password($strict);
    }
}
