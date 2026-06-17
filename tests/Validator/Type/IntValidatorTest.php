<?php
// ============================================================================
// File:    IntValidatorTest.php
// Author:  Recep Seymen Konuk <konukrecepseymen@gmail.com>
//
// Licensed under the terms of the LICENSE file in the project root directory.
// ============================================================================

namespace Seymenkonuk\Validator\Tests\Validator\Type;


use Seymenkonuk\Validator\Tests\Abstract\ValidatorTest;


class IntValidatorTest extends ValidatorTest
{
    public function test_int_fails_when_string()
    {
        $result = $this->validator->field()
            ->int()
            ->validate("seymen");

        $this->assertTrue($result->failed());
        $this->assertEquals($this->translator->get("integer"), $result->errors());
    }

    public function test_int_fails_when_float()
    {
        $result = $this->validator->field()
            ->int()
            ->validate(123.45);

        $this->assertTrue($result->failed());
        $this->assertEquals($this->translator->get("integer"), $result->errors());
    }

    public function test_int_pass_when_integer()
    {
        $result = $this->validator->field()
            ->int()
            ->validate(10);

        $this->assertTrue($result->passed());
        $this->assertEquals(10, $result->validated());
    }

    public function test_non_strict_int_passes_when_numeric_string_is_given()
    {
        $result = $this->validator->field()
            ->int(false)
            ->validate("10");

        $this->assertTrue($result->passed());
        $this->assertEquals(10, $result->validated());
    }
}
