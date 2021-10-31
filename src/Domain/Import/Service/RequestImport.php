<?php

declare(strict_types=1);

namespace PhpChallenge\Domain\Import\Service;

use PhpChallenge\Domain\Import\Data\ImportRequestData;
use PhpChallenge\Domain\Import\Data\RequestedImportData;
use PhpChallenge\Domain\Import\Factory\AbstractDomainImporterFactory;
use PhpChallenge\Domain\Import\Factory\AbstractImportSourceFactory;
use RuntimeException;

class RequestImport
{
    public function __construct(
        private AbstractDomainImporterFactory $importerFactory,
        private AbstractImportSourceFactory $sourceFactory
    ) {
    }

    public function execute(ImportRequestData $importRequest): RequestedImportData
    {
        $importer = $this->importerFactory->createDomainImporter($importRequest->importDomain);
        $source = $this->sourceFactory->createSource($importRequest->sourceType, $importRequest->dataSource);
        //Check domain can import source
        // if (!$importer->canImport($source)) {
        //     throw new RuntimeException(sprintf(
        //         "Cannot import %s from %s",
        //         $importer->getDomainName(),
        //         $source->getType()
        //     ));
        // }
        //Register Import
        //Dispatch ImportRequested Event

        return new RequestedImportData();
    }
}
