<?php

declare(strict_types=1);

namespace PhpChallenge\Tests\TestCase\Functional;

use Fig\Http\Message\StatusCodeInterface;
use Nyholm\Psr7\UploadedFile;
use PhpChallenge\Tests\Traits\AppTestTrait;
use PhpChallenge\Tests\Traits\DbalDatabaseTestTrait;
use PHPUnit\Framework\TestCase;

/** @coversNothing */
class ImportFileActionTest extends TestCase
{
    use AppTestTrait;
    use DbalDatabaseTestTrait;

    /** @test */
    public function itShouldImportProductDataFromCsvFile(): void
    {
        $fixturesPath = $this->container->get('settings.fixtures');
        /** @var string */
        $csv = fopen("{$fixturesPath}/import/products_contracted.csv", 'r');

        $request = $this->createRequest('POST', '/api/import')
            ->withUploadedFiles([
                new UploadedFile(
                    $csv,
                    (int)filesize("{$fixturesPath}/import/products_contracted.csv"),
                    UPLOAD_ERR_OK,
                    'products_contracted',
                    'text/csv'
                )
            ])->withParsedBody([
                'importDomain' => 'ContractedProducts'
            ]);

        $response = $this->app->handle($request);
        $this->assertSame(StatusCodeInterface::STATUS_CREATED, $response->getStatusCode());
        $this->assertJsonContentType($response);

        $responsePayload = $this->getJsonData($response);
        $this->assertArrayHasKey('id', $responsePayload);
        $this->assertNotEmpty($responsePayload['id']);

        $this->assertTableRowCount(1, 'imports');
        $this->assertTableRowExists('imports', $responsePayload['id']);
    }
}
