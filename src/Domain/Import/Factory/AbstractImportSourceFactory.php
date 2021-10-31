<?php

declare(strict_types=1);

namespace PhpChallenge\Domain\Import\Factory;

use PhpChallenge\Domain\Import\ImportSource;

interface AbstractImportSourceFactory
{
    public function createSource(string $sourceType, string $dataSource): ImportSource;
}
