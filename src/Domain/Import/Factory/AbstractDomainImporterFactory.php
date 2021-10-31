<?php

declare(strict_types=1);

namespace PhpChallenge\Domain\Import\Factory;

use PhpChallenge\Domain\Import\DomainImporter;

interface AbstractDomainImporterFactory
{
    public function createDomainImporter(string $sourceType): DomainImporter;
}
