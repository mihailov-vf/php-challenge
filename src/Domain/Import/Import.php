<?php

declare(strict_types=1);

namespace PhpChallenge\Domain;

use PhpChallenge\Common\Object\Entity;
use PhpChallenge\Common\Object\Uuid;
use PhpChallenge\Common\Traits\CreatedAtTimestampableTrait;

class Import extends Entity
{
    use CreatedAtTimestampableTrait;

    private string $importDomain;
    private string $dataSource;
    private string $sourceType;

    public function __construct(string|Uuid $id, string $importDomain, string $dataSource, string $sourceType)
    {
        parent::__construct($id);
        $this->importDomain = $importDomain;
        $this->dataSource = $dataSource;
        $this->sourceType = $sourceType;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getImportDomain(): string
    {
        return $this->importDomain;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDataSource(): string
    {
        return $this->dataSource;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getSourceType(): string
    {
        return $this->sourceType;
    }
}
