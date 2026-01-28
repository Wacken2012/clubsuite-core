<?php

declare(strict_types=1);

namespace OCA\ClubSuiteCore\Migration;

use Closure;
use OCP\DB\ISchemaWrapper;
use OCP\Migration\IOutput;
use OCP\Migration\SimpleMigrationStep;

/**
 * Migration: Update table clubsuite_core_members to match Member entity
 */
class Version20260119103000 extends SimpleMigrationStep {
    public function changeSchema(IOutput $output, Closure $schemaClosure, array $options): ?ISchemaWrapper {
        /** @var ISchemaWrapper $schema */
        $schema = $schemaClosure();

        if ($schema->hasTable('clubsuite_core_members')) {
            $table = $schema->getTable('clubsuite_core_members');
            
            // Add missing columns
            if (!$table->hasColumn('firstname')) {
                $table->addColumn('firstname', 'string', [
                    'notnull' => true,
                    'default' => '',
                    'length' => 64,
                ]);
            }
            if (!$table->hasColumn('lastname')) {
                $table->addColumn('lastname', 'string', [
                    'notnull' => true,
                    'default' => '',
                    'length' => 64,
                ]);
            }
            if (!$table->hasColumn('email')) {
                $table->addColumn('email', 'string', [
                    'notnull' => false,
                    'length' => 255,
                ]);
            }
            if (!$table->hasColumn('address')) {
                $table->addColumn('address', 'text', [
                    'notnull' => false,
                ]);
            }
            if (!$table->hasColumn('iban')) {
                $table->addColumn('iban', 'string', [
                    'notnull' => false,
                    'length' => 34,
                ]);
            }
            
            // Handle join date mapping
            if (!$table->hasColumn('joined_at')) {
                if ($table->hasColumn('eintrittsdatum')) {
                    // In a real migration we might want to migrate data, 
                    // but for this dev fix we just ensure the column exists.
                    // We can rename if the DB platform supports it, but add is safer.
                    $table->addColumn('joined_at', 'datetime', [
                        'notnull' => false,
                    ]);
                } else {
                    $table->addColumn('joined_at', 'datetime', [
                        'notnull' => false,
                    ]);
                }
            }

            // Fix user_id nullable
            if ($table->hasColumn('user_id')) {
                $table->changeColumn('user_id', [
                    'notnull' => false,
                ]);
            }
            
            return $schema;
        }
        
        return null;
    }
}
