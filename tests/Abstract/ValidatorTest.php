<?php
// ============================================================================
// File:    ValidatorTest.php
// Author:  Recep Seymen Konuk <konukrecepseymen@gmail.com>
//
// Licensed under the terms of the LICENSE file in the project root directory.
// ============================================================================

namespace Seymenkonuk\Validator\Tests\Abstract;


use PHPUnit\Framework\TestCase;

use Seymenkonuk\Validator\Localization\FileLoader;
use Seymenkonuk\Validator\Localization\Translator;

use Seymenkonuk\Validator\Validator\Validator;


abstract class ValidatorTest extends TestCase
{
    protected Validator $validator;
    protected Translator $translator;

    protected function setUp(): void
    {
        parent::setUp();
        // Translator Oluştur
        $this->translator = new Translator(
            new FileLoader(),
            "tr",
        );
        // Validator Oluştur
        $this->validator = new Validator($this->translator);
    }
}
