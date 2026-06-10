<?php

// ============================================================================
// File:    Translator.php
// Author:  Recep Seymen Konuk <konukrecepseymen@gmail.com>
//
// Licensed under the terms of the LICENSE file in the project root directory.
// ============================================================================

namespace Seymenkonuk\Validator\Localization;


final class Translator
{
    // --------------------------------------------------------------------------
    // CACHE
    // --------------------------------------------------------------------------

    /** @var array<string, array<string, string>> */
    private array $cache = [];

    // --------------------------------------------------------------------------
    // CONSTRUCTOR
    // --------------------------------------------------------------------------

    public function __construct(
        private Loader $loader,
        private string $locale,
        private string $fallback = 'tr',
    ) {}

    // --------------------------------------------------------------------------
    // METHODS
    // --------------------------------------------------------------------------

    public function locale(): string
    {
        return $this->locale;
    }

    public function setLocale(string $locale): void
    {
        $this->locale = $locale;
    }

    /** @param array<string, scalar> $replace */
    public function get(string $key, array $replace = []): string
    {
        $text =
            $this->resolve($this->locale, $key)
            ?? $this->resolve($this->fallback, $key)
            ?? $key;

        return $this->replace($text, $replace);
    }

    // --------------------------------------------------------------------------
    // INTERNAL HELPERS
    // --------------------------------------------------------------------------

    private function resolve(string $locale, string $key): ?string
    {
        $messages = $this->load($locale);

        return $messages[$key] ?? null;
    }

    /** @return array<string, string> */
    private function load(string $locale): array
    {
        return $this->cache[$locale]
            ??= $this->loader->load($locale);
    }

    /** @param array<string, scalar> $replace */
    private function replace(string $text, array $replace): string
    {
        foreach ($replace as $key => $value) {
            $text = str_replace("{" . $key . "}", strval($value), $text);
        }

        return $text;
    }
}
