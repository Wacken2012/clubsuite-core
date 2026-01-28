<?php

declare(strict_types=1);

namespace OCA\ClubSuiteCore\Migration;

use Closure;
use OCP\DB\ISchemaWrapper;
use OCP\Migration\SimpleMigrationStep;
use OCP\Migration\IOutput;

class Version020000Date01 extends SimpleMigrationStep {

    public function changeSchema(IOutput $output, Closure $schemaClosure, array $options): ?ISchemaWrapper {
        $schema = $schemaClosure();

        if (!$schema->hasTable('clubsuite_members')) {
            $table = $schema->createTable('clubsuite_members');

            $table->addColumn('id', 'integer', [
                'autoincrement' => true,
                'notnull' => true,
            ]);
            $table->addColumn('user_id', 'string', [
                'notnull' => false,
                'length' => 255,
            ]);
            $table->addColumn('firstname', 'string', [
                'notnull' => true,
                'length' => 150,
            ]);
            $table->addColumn('lastname', 'string', [
                'notnull' => true,
                'length' => 150,
            ]);
            $table->addColumn('email', 'string', [
                'notnull' => false,
                'length' => 255,
            ]);
            $table->addColumn('address', 'text', [
                'notnull' => false,
            ]);
            $table->addColumn('iban', 'string', [
                'notnull' => false,
                'length' => 34,
            ]);
            $table->addColumn('status', 'string', [
                'notnull' => true,
                'length' => 20,
                'default' => 'active'
            ]);
            $table->addColumn('joined_at', 'date', [
                'notnull' => false,
            ]);
            $table->addColumn('created_at', 'datetime', [
                'notnull' => true,
            ]);
            $table->addColumn('updated_at', 'datetime', [
                'notnull' => true,
            ]);

            $table->setPrimaryKey(['id']);
            $table->addIndex(['user_id'], 'idx_cs_members_uid');
            $table->addIndex(['status'], 'idx_cs_members_status');
        }

        return $schema;
    }
}
