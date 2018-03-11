<?php declare(strict_types = 1);

namespace WouterDeSchuyter\DropParty\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180311124202 extends AbstractMigration
{
    private const TABLE = 'user';

    public function up(Schema $schema)
    {
        $table = $schema->createTable(self::TABLE);
        $table->addColumn('id', 'uuid');
        $table->addColumn('dropbox_account_id', 'string')->setLength(64);
        $table->addColumn('dropbox_access_token', 'string')->setLength(64);
        $table->addColumn('first_name', 'string')->setLength(32)->setNotnull(false);
        $table->addColumn('name', 'string')->setLength(32)->setNotnull(false);
        $table->addColumn('email', 'string')->setLength(64);
        $table->addColumn('created_at', 'datetime')->setDefault('CURRENT_TIMESTAMP');
        $table->addColumn('updated_at', 'datetime')->setNotnull(false);
        $table->addColumn('deleted_at', 'datetime')->setNotnull(false);
        $table->setPrimaryKey(['id']);
        $table->addUniqueIndex(['dropbox_account_id']);
        $table->addUniqueIndex(['email']);
    }

    public function down(Schema $schema)
    {
        $schema->dropTable(self::TABLE);
    }
}
