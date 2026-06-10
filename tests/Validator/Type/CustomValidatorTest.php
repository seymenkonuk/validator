<?php
// ============================================================================
// File:    CustomValidatorTest.php
// Author:  Recep Seymen Konuk <konukrecepseymen@gmail.com>
//
// Licensed under the terms of the LICENSE file in the project root directory.
// ============================================================================

namespace Seymenkonuk\Validator\Tests\Validator\Type;


use Seymenkonuk\Validator\Tests\Abstract\ValidatorTest;

use Seymenkonuk\Validator\Validator\ValidationResult;


class CustomValidatorTest extends ValidatorTest
{
    public function test_custom_fails()
    {
        $result = $this->validator->field()->custom(function (mixed $data) {
            if ($data === "seymen")
                return ValidationResult::success("seymen");
            return ValidationResult::failure("Hata!");
        })->validate(3);

        $this->assertTrue($result->failed());
        $this->assertEquals("Hata!", $result->errors());
    }

    public function test_custom_pass()
    {
        $result = $this->validator->field()->custom(function (mixed $data) {
            if ($data === "seymen")
                return ValidationResult::success("seymen");
            return ValidationResult::failure("Hata!");
        })->validate("seymen");

        $this->assertTrue($result->passed());
        $this->assertEquals("seymen", $result->validated());
    }
}
