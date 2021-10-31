<?php

declare(strict_types=1);

namespace PhpChallenge\Domain\Import;

interface DomainImporter
{
    public function canImport(ImportSource $source): bool;
}
