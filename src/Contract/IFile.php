<?php
// ============================================================================
// File:    IFile.php
// Author:  Recep Seymen Konuk <konukrecepseymen@gmail.com>
//
// Licensed under the terms of the LICENSE file in the project root directory.
// ============================================================================

namespace Seymenkonuk\Validator\Contract;


interface IFile
{
    public function isValid(): bool;
    public function getName(): string;
    public function getTmpPath(): string;
    public function getSize(): int;
    public function getExtension(): string;
    public function getMimeType(): string;
}
