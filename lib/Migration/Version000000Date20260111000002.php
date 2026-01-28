<?php

declare(strict_types=1);

namespace OCA\ClubSuiteCore\Migration;

use Closure;
use OCP\DB\ISchemaWrapper;
use OCP\Migration\IOutput;
use OCP\Migration\SimpleMigrationStep;

/**
 * Adds extended member fields to clubsuite_core_members table.
 * © 2026 Stefan Schulz – Alle Rechte vorbehalten.
 */
class Version000000Date20260111000002 extends SimpleMigrationStep {

    public function changeSchema(IOutput $output, Closure $schemaClosure, array $options): ?ISchemaWrapper {
        /** @var ISchemaWrapper $schema */
        $schema = $schemaClosure();

        if ($schema->hasTable('clubsuite_core_members')) {
            $table = $schema->getTable('clubsuite_core_members');

            if (!$table->hasColumn('firstname')) {
                $table->addColumn('firstname', 'string', [
                    'notnull' => false,
                    'length' => 100,
                ]);
            }
            if (!$table->hasColumn('lastname')) {
                $table->addColumn('lastname', 'string', [
                    'notnull' => false,
                    'length' => 100,
                ]);
            }
            if (!$table->hasColumn('email')) {
                $table->addColumn('email', 'string', [
                    'notnull' => false,
                    'length' => 150,
                ]);
            }
            if (!$table->hasColumn('phone')) {
                $table->addColumn('phone', 'string', [
                    'notnull' => false,
                    'length' => 50,
                ]);
            }
            if (!$table->hasColumn('street')) {
                $table->addColumn('street', 'string', [
                    'notnull' => false,
                    'length' => 150,
                ]);
            }
            if (!$table->hasColumn('zip')) {
                $table->addColumn('zip', 'string', [
                    'notnull' => false,
                    'length' => 20,
                ]);
            }
            if (!$table->hasColumn('city')) {
                $table->addColumn('city', 'string', [
                    'notnull' => false,
                    'length' => 100,
                ]);
            }
        }

        return $schema;
    }
}
