<?php
// ============================================================================
// File:    DateTimeValidatorTest.php
// Author:  Recep Seymen Konuk <konukrecepseymen@gmail.com>
//
// Licensed under the terms of the LICENSE file in the project root directory.
// ============================================================================

namespace Seymenkonuk\Validator\Tests\Validator\Type;


use Seymenkonuk\Validator\Tests\Abstract\ValidatorTest;


class DateTimeValidatorTest extends ValidatorTest
{
    public function test_datetime_fails_when_int()
    {
        $result = $this->validator->field()
            ->datetime()
            ->validate(10);

        $this->assertTrue($result->failed());
        $this->assertEquals($this->translator->get("datetime"), $result->errors());
    }

    public function test_datetime_fails_when_invalid_datetime()
    {
        $result = $this->validator->field()
            ->datetime()
            ->validate("2020-13-13 00:00:00");

        $this->assertTrue($result->failed());
        $this->assertEquals($this->translator->get("datetime"), $result->errors());
    }

    public function test_datetime_pass_when_valid_datetime()
    {
        $result = $this->validator->field()
            ->datetime()
            ->validate("2026-06-10 18:15:00");

        $this->assertTrue($result->passed());
        // $this->assertEquals(true, $result->validated());
    }
}
