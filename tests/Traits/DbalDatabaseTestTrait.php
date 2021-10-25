<?php

declare(strict_types=1);

namespace PhpChallenge\Tests\Traits;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Statement;
use DomainException;
use Psr\Container\ContainerInterface;

/** @property ContainerInterface $container */
trait DbalDatabaseTestTrait
{
    protected function setupDatabase(): void
    {
        try {
            $this->getConnection()->connect();
        } catch (\Throwable $th) {
            $this->fail('Check database connection and/or run migrations');
        }
    }

    protected function getConnection(): Connection
    {
        return $this->container->get(Connection::class);
    }

    protected function truncate(string ...$tables): void
    {
        foreach ($tables as $table) {
            $this->getConnection()->executeStatement("TRUNCATE TABLE {$table}");
        }
    }

    /** @param array{table:string, records:array<string, mixed>}[] $fixtures */
    protected function insertFixtures(array $fixtures): void
    {
        foreach ($fixtures as $fixture) {
            foreach ($fixture['records'] as $row) {
                $this->insertFixture($fixture['table'], $row);
            }
        }
    }

    /** @param array<string, mixed> $row */
    protected function insertFixture(string $table, array $row): void
    {
        $fields = array_keys($row);

        array_walk(
            $fields,
            function (&$value) {
                $value = sprintf('%s=:%s', $value, $value);
            }
        );

        $statement = $this->createPreparedStatement(sprintf('INSERT INTO %s SET %s', $table, implode(',', $fields)));
        $statement->executeStatement($row);
    }

    private function createPreparedStatement(string $sql): Statement
    {
        return $this->getConnection()->prepare($sql);
    }

    /** 
     * @param array<string, mixed> $expectedRow
     * @param string[] $fields
     */
    protected function assertTableRow(
        array $expectedRow,
        string $table,
        string|int $id,
        array $fields = null,
        string $message = ''
    ): void {
        $this->assertSame(
            $expectedRow,
            $this->getTableRowById($table, $id, $fields ?: array_keys($expectedRow)),
            $message
        );
    }

    /**
     * @param string[] $fields
     * @return array<string, mixed>
     */
    protected function getTableRowById(string $table, string|int $id, array $fields = null): array
    {
        $sql = sprintf('SELECT * FROM %s WHERE id = :id', $table);
        $statement = $this->createPreparedStatement($sql);
        $row = $statement->executeQuery(['id' => $id])->fetchAssociative();

        if (empty($row)) {
            throw new DomainException(sprintf('Row not found: %s', $id));
        }

        if ($fields) {
            $row = array_intersect_key($row, array_flip($fields));
        }

        return $row;
    }

    protected function assertTableRowCount(int $expected, string $table, string $message = ''): void
    {
        $this->assertSame($expected, $this->getTableRowCount($table), $message);
    }

    protected function getTableRowCount(string $table): int
    {
        $sql = sprintf('SELECT COUNT(*) AS counter FROM %s;', $table);
        $row = $this->createPreparedStatement($sql)->executeQuery()->fetchAssociative() ?: [];

        return (int)($row['counter'] ?? 0);
    }

    protected function assertTableRowExists(string $table, string|int $id, string $message = ''): void
    {
        $this->assertTrue((bool)$this->findTableRowById($table, $id), $message);
    }

    /** @return array<string, mixed> */
    protected function findTableRowById(string $table, string|int $id): array
    {
        $sql = sprintf('SELECT * FROM %s WHERE id = :id', $table);
        $statement = $this->createPreparedStatement($sql);
        return $statement->executeQuery(['id' => $id])->fetchAssociative() ?: [];
    }

    protected function assertTableRowNotExists(string $table, string|int $id, string $message = ''): void
    {
        $this->assertFalse((bool)$this->findTableRowById($table, $id), $message);
    }
}
