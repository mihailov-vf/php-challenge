<?php

declare(strict_types=1);

namespace PhpChallenge\Tests\TestCase\Integration\Import;

use PhpChallenge\Domain\Import\Data\ImportRequestData;
use PhpChallenge\Domain\Import\Service\RequestImport;
use PhpChallenge\Tests\Traits\DbalDatabaseTestTrait;
use PhpChallenge\Tests\Traits\IntegrationTestTrait;
use PHPUnit\Framework\TestCase;

/** @coversNothing */
class RequestImportTest extends TestCase
{
    use IntegrationTestTrait {
        IntegrationTestTrait::setUp as integrationSetup;
    }
    use DbalDatabaseTestTrait;

    private RequestImport $requestImport;

    protected function setUp(): void
    {
        $this->integrationSetup();
        $this->requestImport = $this->container->get(RequestImport::class);
    }

    /** @test */
    public function itShouldRegisterAnImportRequest(): void
    {
        $fixturesPath = $this->container->get('settings.fixtures');
        $importRequest = new ImportRequestData([
            'importDomain' => 'ContractedProducts',
            'dataSource' => "{$fixturesPath}/import/products_contracted.csv",
            'sourceType' => 'csv',
        ]);

        $requestedImport = $this->requestImport->execute($importRequest);

        //Assert Import id returned
        $this->assertObjectHasAttribute('id', $requestedImport);
        $this->assertNotEmpty($requestedImport->id);
        //Assert Import registered
        $this->assertTableRowExists('imports', $requestedImport->id);
        //Assert ImportRequested event dispatched
    }
}
