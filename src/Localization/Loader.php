<?php

// ============================================================================
// File:    Loader.php
// Author:  Recep Seymen Konuk <konukrecepseymen@gmail.com>
//
// Licensed under the terms of the LICENSE file in the project root directory.
// ============================================================================

namespace Seymenkonuk\Validator\Localization;


interface Loader
{
    /** @return array<string, string> */
    public function load(string $locale): array;
}
