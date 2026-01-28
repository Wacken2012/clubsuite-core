<?php
namespace OCA\ClubSuiteCore\Job;

use OCP\BackgroundJob\QueuedJob;

class MemberReindexJob extends QueuedJob {
    public function __construct() {
        parent::__construct();
    }

    public function run($arg) {
        // Placeholder: process members in batches and rebuild indexes or caches
    }
}
