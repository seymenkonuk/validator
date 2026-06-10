<?php
// ============================================================================
// File:    StringValidatorTest.php
// Author:  Recep Seymen Konuk <konukrecepseymen@gmail.com>
//
// Licensed under the terms of the LICENSE file in the project root directory.
// ============================================================================

namespace Seymenkonuk\Validator\Tests\Validator\Type;


use Seymenkonuk\Validator\Tests\Abstract\ValidatorTest;


class StringValidatorTest extends ValidatorTest
{
    public function test_str_fails_when_int()
    {
        $result = $this->validator->field()->string()->validate(13);

        $this->assertTrue($result->failed());
        $this->assertEquals($this->translator->get("string"), $result->errors());
    }

    public function test_str_fails_when_bool()
    {
        $result = $this->validator->field()->string()->validate(true);

        $this->assertTrue($result->failed());
        $this->assertEquals($this->translator->get("string"), $result->errors());
    }

    public function test_str_pass_when_str()
    {
        $result = $this->validator->field()->string()->validate("seymen");

        $this->assertTrue($result->passed());
    }
}
