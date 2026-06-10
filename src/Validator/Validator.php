<?php
// ============================================================================
// File:    Validator.php
// Author:  Recep Seymen Konuk <konukrecepseymen@gmail.com>
//
// Licensed under the terms of the LICENSE file in the project root directory.
// ============================================================================

namespace Seymenkonuk\Validator\Validator;


use Seymenkonuk\Validator\Localization\Translator;


class Validator
{
    // --------------------------------------------------------------------------
    // DEPENDENCIES
    // --------------------------------------------------------------------------

    public function __construct(
        private Translator $translator,
    ) {}

    // --------------------------------------------------------------------------
    // METHODS
    // --------------------------------------------------------------------------

    public function field(): FieldValidator
    {
        return new FieldValidator($this->translator);
    }

    public function array(): ArrayValidator
    {
        return new ArrayValidator($this->translator);
    }

    public function object(): ObjectValidator
    {
        return new ObjectValidator($this->translator);
    }
}
