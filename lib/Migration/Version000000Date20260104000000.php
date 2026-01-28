<?php

declare(strict_types=1);

namespace OCA\ClubSuiteCore\Migration;

use Closure;
use OCP\DB\ISchemaWrapper;
use OCP\Migration\IOutput;
use OCP\Migration\SimpleMigrationStep;

/**
 * Migration: Create table clubsuite_core_members
 */
class Version000000Date20260104000000 extends SimpleMigrationStep {
    public function changeSchema(IOutput $output, Closure $schemaClosure, array $options): ?ISchemaWrapper {
        /** @var ISchemaWrapper $schema */
        $schema = $schemaClosure();

        if (!$schema->hasTable('clubsuite_core_members')) {
            $table = $schema->createTable('clubsuite_core_members');
            
            $table->addColumn('id', 'integer', [
                'autoincrement' => true,
                'notnull' => true,
            ]);
            $table->addColumn('user_id', 'string', [
                'notnull' => true,
                'length' => 64,
            ]);
            $table->addColumn('mitgliedsnummer', 'string', [
                'notnull' => false,
                'length' => 64,
            ]);
            $table->addColumn('eintrittsdatum', 'date', [
                'notnull' => false,
            ]);
            $table->addColumn('status', 'string', [
                'notnull' => false,
                'length' => 32,
            ]);
            $table->addColumn('created_at', 'datetime', [
                'notnull' => false,
            ]);
            $table->addColumn('updated_at', 'datetime', [
                'notnull' => false,
            ]);
            
            $table->setPrimaryKey(['id']);
            $table->addUniqueIndex(['user_id'], 'clubsuite_core_members_uid');
            $table->addIndex(['mitgliedsnummer'], 'clubsuite_core_members_mnr');
            $table->addIndex(['status'], 'clubsuite_core_members_status');
        }

        return $schema;
    }
}
