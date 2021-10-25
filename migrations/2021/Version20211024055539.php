<?php

declare(strict_types=1);

namespace PhpChallenge\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211024055539 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create User';
    }

    public function up(Schema $schema): void
    {
        $users = $schema->createTable('users');
        $users->addColumn('id', 'guid');
        $users->addColumn('email', 'string');
        $users->addColumn('name', 'string');
        $users->addColumn('password', 'string');
        $users->addColumn('token', 'string');
        $users->addColumn('created_at', 'datetimetz_immutable');
        $users->addColumn('enabled', 'boolean');
        $users->setPrimaryKey(['id']);
        $users->addUniqueIndex(['id', 'email']);
        $users->addIndex(['enabled']);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
