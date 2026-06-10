<?php

// ============================================================================
// File:    FileLoader.php
// Author:  Recep Seymen Konuk <konukrecepseymen@gmail.com>
//
// Licensed under the terms of the LICENSE file in the project root directory.
// ============================================================================

namespace Seymenkonuk\Validator\Localization;


final class FileLoader implements Loader
{
    // --------------------------------------------------------------------------
    // PROPERTIES
    // --------------------------------------------------------------------------

    private string $path;

    // --------------------------------------------------------------------------
    // CONSTRUCTOR
    // --------------------------------------------------------------------------

    public function __construct(string|null $path = null)
    {
        if ($path === null) {
            $this->path = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "lang";
        } else {
            $this->path = $path;
        }
    }

    // --------------------------------------------------------------------------
    // METHODS
    // --------------------------------------------------------------------------

    /** @return array<string, string> */
    public function load(string $locale): array
    {
        $file = rtrim($this->path, "/") . "/" . ltrim($locale, "/") . ".php";

        if (!is_file($file)) {
            return [];
        }

        /** @var array<string, string> $value */
        $value = require $file;

        return $value;
    }
}
