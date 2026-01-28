<?php

declare(strict_types=1);

namespace OCA\ClubSuiteCore\Migration;

use Closure;
use OCP\DB\ISchemaWrapper;
use OCP\Migration\IOutput;
use OCP\Migration\SimpleMigrationStep;

class Version000000Date20260111000000 extends SimpleMigrationStep {

	public function changeSchema(IOutput $output, Closure $schemaClosure, array $options): ?ISchemaWrapper {
		/** @var ISchemaWrapper $schema */
		$schema = $schemaClosure();

		if ($schema->hasTable('clubsuite_core_members')) {
			$table = $schema->getTable('clubsuite_core_members');

			if (!$table->hasColumn('firstname')) {
				$table->addColumn('firstname', 'string', [
					'notnull' => false,
					'length' => 64,
				]);
			}
			if (!$table->hasColumn('lastname')) {
				$table->addColumn('lastname', 'string', [
					'notnull' => false,
					'length' => 64,
				]);
			}
			if (!$table->hasColumn('email')) {
				$table->addColumn('email', 'string', [
					'notnull' => false,
					'length' => 255,
				]);
			}
			if (!$table->hasColumn('phone')) {
				$table->addColumn('phone', 'string', [
					'notnull' => false,
					'length' => 32,
				]);
			}
			if (!$table->hasColumn('address')) {
				$table->addColumn('address', 'string', [
					'notnull' => false,
					'length' => 255,
				]);
			}
			if (!$table->hasColumn('zip')) {
				$table->addColumn('zip', 'string', [
					'notnull' => false,
					'length' => 16,
				]);
			}
			if (!$table->hasColumn('city')) {
				$table->addColumn('city', 'string', [
					'notnull' => false,
					'length' => 64,
				]);
			}
		}
		return $schema;
	}
}
