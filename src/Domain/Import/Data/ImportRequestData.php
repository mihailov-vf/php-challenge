<?php

declare(strict_types=1);

namespace PhpChallenge\Domain\Import\Data;

use PhpChallenge\Common\Data\Data;

/**
 * @codeCoverageIgnore
 */
class ImportRequestData extends Data
{
    public string $importDomain;
    public string $dataSource;
    public string $sourceType;
}
