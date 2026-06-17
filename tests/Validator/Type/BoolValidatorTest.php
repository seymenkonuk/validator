<?php
// ============================================================================
// File:    BoolValidatorTest.php
// Author:  Recep Seymen Konuk <konukrecepseymen@gmail.com>
//
// Licensed under the terms of the LICENSE file in the project root directory.
// ============================================================================

namespace Seymenkonuk\Validator\Tests\Validator\Type;


use Seymenkonuk\Validator\Tests\Abstract\ValidatorTest;


class BoolValidatorTest extends ValidatorTest
{
    public function test_bool_fails_when_str()
    {
        $result = $this->validator->field()
            ->bool()
            ->validate("merhaba");

        $this->assertTrue($result->failed());
        $this->assertEquals($this->translator->get("boolean"), $result->errors());
    }

    public function test_bool_fails_when_int()
    {
        $result = $this->validator->field()
            ->bool()
            ->validate(13);

        $this->assertTrue($result->failed());
        $this->assertEquals($this->translator->get("boolean"), $result->errors());
    }

    public function test_bool_pass_when_bool()
    {
        $result = $this->validator->field()
            ->bool()
            ->validate(true);

        $this->assertTrue($result->passed());
    }

    public function test_bool_default_value()
    {
        $result = $this->validator->field()
            ->bool()
            ->default(true)
            ->validate("", false);

        $this->assertTrue($result->passed());
        $this->assertEquals(true, $result->validated());
    }

    public function test_non_strict_bool_passes_when_boolean_string_is_given()
    {
        $result = $this->validator->field()
            ->bool(false)
            ->validate("true");

        $this->assertTrue($result->passed());
        $this->assertEquals(true, $result->validated());
    }
}
