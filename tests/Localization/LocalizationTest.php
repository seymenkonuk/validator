<?php
// ============================================================================
// File:    LocalizationTest.php
// Author:  Recep Seymen Konuk <konukrecepseymen@gmail.com>
//
// Licensed under the terms of the LICENSE file in the project root directory.
// ============================================================================

namespace Seymenkonuk\Validator\Tests\Language;


use PHPUnit\Framework\TestCase;

use Seymenkonuk\Validator\Localization\FileLoader;
use Seymenkonuk\Validator\Localization\Translator;


class LocalizationTest extends TestCase
{
    private Translator $translator;

    protected function setUp(): void
    {
        parent::setUp();
        // Translator Oluştur
        $this->translator = new Translator(
            new FileLoader(),
            "tr",
        );
    }

    public function test_tr_language_returns_turkish_text()
    {
        $this->assertEquals(
            "Bu alan zorunludur!",
            $this->translator->get("required"),
        );
    }

    public function test_en_language_returns_english_text()
    {
        $this->translator->setLocale("en");
        $this->assertEquals(
            "This field must be at least 13!",
            $this->translator->get("min", [
                "value" => 13,
            ]),
        );
    }

    public function test_unknown_language_defaults_to_turkish()
    {
        $this->translator->setLocale("xx");
        $this->assertEquals(
            "Bu dizi tam olarak 3 öğe içermelidir!",
            $this->translator->get("count", [
                "count" => 3,
            ]),
        );
    }
}
