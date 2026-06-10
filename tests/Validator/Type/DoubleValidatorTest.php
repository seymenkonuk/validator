<?php
// ============================================================================
// File:    DoubleValidatorTest.php
// Author:  Recep Seymen Konuk <konukrecepseymen@gmail.com>
//
// Licensed under the terms of the LICENSE file in the project root directory.
// ============================================================================

namespace Seymenkonuk\Validator\Tests\Validator\Type;


use Seymenkonuk\Validator\Tests\Abstract\ValidatorTest;


class DoubleValidatorTest extends ValidatorTest
{
    public function test_double_fails_when_string()
    {
        $result = $this->validator->field()
            ->double()
            ->validate("seymen");

        $this->assertTrue($result->failed());
        $this->assertEquals($this->translator->get("float"), $result->errors());
    }

    public function test_double_fails_when_bool()
    {
        $result = $this->validator->field()
            ->double()
            ->validate(true);

        $this->assertTrue($result->failed());
        $this->assertEquals($this->translator->get("float"), $result->errors());
    }

    public function test_double_pass_when_double()
    {
        $result = $this->validator->field()
            ->double()
            ->validate(123.45);

        $this->assertTrue($result->passed());
        $this->assertEquals(123.45, $result->validated());
    }
}
