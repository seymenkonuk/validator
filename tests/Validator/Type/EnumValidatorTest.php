<?php
// ============================================================================
// File:    EnumValidatorTest.php
// Author:  Recep Seymen Konuk <konukrecepseymen@gmail.com>
//
// Licensed under the terms of the LICENSE file in the project root directory.
// ============================================================================

namespace Seymenkonuk\Validator\Tests\Validator\Type;


use Seymenkonuk\Validator\Tests\Abstract\ValidatorTest;


class EnumValidatorTest extends ValidatorTest
{
    public function test_enum_fails_when_not_allowed_value()
    {
        $result = $this->validator->field()
            ->in(["MALE", "FEMALE"])
            ->validate(10);

        $this->assertTrue($result->failed());
        $this->assertEquals(
            $this->translator->get("enum", [
                "values" => '["MALE","FEMALE"]',
            ]),
            $result->errors(),
        );
    }

    public function test_enum_pass_when_allowed_value()
    {
        $result = $this->validator->field()
            ->in(["MALE", "FEMALE"])
            ->validate("MALE");

        $this->assertTrue($result->passed());
        $this->assertEquals("MALE", $result->validated());
    }
}
