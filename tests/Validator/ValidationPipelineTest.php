<?php
// ============================================================================
// File:    ValidationPipelineTest.php
// Author:  Recep Seymen Konuk <konukrecepseymen@gmail.com>
//
// Licensed under the terms of the LICENSE file in the project root directory.
// ============================================================================

namespace Seymenkonuk\Validator\Tests\Rules\Type;


use Seymenkonuk\Validator\Tests\Abstract\ValidatorTest;

use Seymenkonuk\Validator\Validator\BaseValidator;


class ValidationPipelineTest extends ValidatorTest
{
    private BaseValidator $schema;

    protected function setUp(): void
    {
        parent::setUp();
        // Test Schema
        $this->schema = $this->validator->object()->schema([
            "username" => $this->validator->field()->string()
                ->min(2)->max(10)
                ->required(),
            "name" => $this->validator->field()->string()
                ->min(2)->max(30)
                ->alpha()
                ->required(),
            "surname" => $this->validator->field()->string()
                ->min(2)->max(30)
                ->alpha()
                ->required(),
            "parent" => $this->validator->object()->schema([
                "name" => $this->validator->field()->string()
                    ->min(2)->max(30)
                    ->alpha()
                    ->required(),
                "surname" => $this->validator->field()->string()
                    ->min(2)->max(30)
                    ->alpha()
                    ->required(),
            ])->required(),
            "email" => $this->validator->field()->email()
                ->required(),
            "gender" => $this->validator->field()->in(["MALE", "FEMALE"])
                ->required(),
            "age" => $this->validator->field()->int()
                ->min(0)->max(150)
                ->default(0),
            "date_of_birth" => $this->validator->field()
                ->datetime()
                ->afterOrEqual("1850-01-01 00:00:00")
                ->beforeOrEqual("2050-01-01 00:00:00")
                ->required(),
            "hobbies" => $this->validator->array()
                ->items($this->validator->field()->string())
                ->minItems(0)
                ->maxItems(10)
                ->default([]),
            "is_agreed" => $this->validator->field()
                ->bool()
                ->true()
                ->required(),
        ]);
    }

    public function test_it_passes_when_all_fields_are_valid(): void
    {
        $result = $this->schema->validate([
            "username" => "Seymen",
            "name" => "Seymen",
            "surname" => "Konuk",
            "parent" => [
                "name" => "Nurdan",
                "surname" => "Konuk",
            ],
            "email" => "konukrecepseymen@gmail.com",
            "gender" => "MALE",
            "date_of_birth" => "2003-08-26 00:00:00",
            "hobbies" => ["Yazılım", "Algoritma"],
            "is_agreed" => true,
        ]);

        $this->assertTrue($result->passed());
    }

    public function test_it_fails_when_multiple_fields_are_invalid(): void
    {

        $result = $this->schema->validate([
            "unexcepted" => "value",
            "parent" => [],
        ]);

        $this->assertTrue($result->failed());
        $this->assertIsArray($result->errors());
        $this->assertNotEmpty($result->errors());
        $this->assertCount(9, $result->errors());
    }
}
