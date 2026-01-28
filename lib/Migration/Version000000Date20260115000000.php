<?php

declare(strict_types=1);

namespace OCA\ClubSuiteCore\Migration;

use Closure;
use OCP\DB\ISchemaWrapper;
use OCP\Migration\IOutput;
use OCP\Migration\SimpleMigrationStep;

/**
 * Adds nextcloud_user_id field for Talk integration to members table.
 * © 2026 Stefan Schulz – Alle Rechte vorbehalten.
 */
class Version000000Date20260115000000 extends SimpleMigrationStep {

    public function changeSchema(IOutput $output, Closure $schemaClosure, array $options): ?ISchemaWrapper {
        /** @var ISchemaWrapper $schema */
        $schema = $schemaClosure();

        if ($schema->hasTable('clubsuite_core_members')) {
            $table = $schema->getTable('clubsuite_core_members');

            if (!$table->hasColumn('nextcloud_user_id')) {
                $table->addColumn('nextcloud_user_id', 'string', [
                    'notnull' => false,
                    'length' => 255,
                ]);
            }
        }

        return $schema;
    }
}
