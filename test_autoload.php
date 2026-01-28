<?php
// Test if the class can be loaded
require_once __DIR__ . '/lib/AppInfo/Application.php';
echo "Application class exists: " . (class_exists('OCA\ClubSuiteCore\AppInfo\Application') ? 'yes' : 'no') . "\n";
